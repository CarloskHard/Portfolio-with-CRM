<?php

namespace App\Services\Notifications;

use App\Models\Message;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class WhatsAppNotifier
{
    public function sendNewMessageAlert(Message $message): void
    {
        $config = config('services.callmebot_whatsapp');

        $phone = preg_replace('/\D+/', '', (string) ($config['phone'] ?? '')) ?? '';
        $apiKey = (string) ($config['api_key'] ?? '');

        if ($phone === '' || $apiKey === '') {
            throw new RuntimeException('CallMeBot WhatsApp no está configurado.');
        }

        $response = Http::get('https://api.callmebot.com/whatsapp.php', [
            'phone' => $phone,
            'text' => $this->buildBody($message),
            'apikey' => $apiKey,
        ]);

        if (! $response->successful()) {
            throw new RuntimeException(
                'Error enviando WhatsApp (CallMeBot): '.$response->status().' '.$response->body()
            );
        }
    }

    private function buildBody(Message $message): string
    {
        $unreadCount = Message::query()
            ->where('is_read', false)
            ->count();

        $panelUrl = rtrim((string) config('app.url'), '/').'/messages';

        return implode("\n", [
            '🔔 *Nuevo mensaje desde tu web*',
            '',
            '👤 *Contacto:* '.$message->sender_name,
            '📧 *Email:* '.$message->sender_email,
            '🕒 *Fecha:* '.($message->created_at?->format('d/m/Y H:i') ?? now()->format('d/m/Y H:i')),
            '',
            '💬 *Mensaje:*',
            $message->content,
            '',
            '📌 *Recordatorio:* tienes '.$unreadCount.' mensaje(s) sin leer.',
            '➡️ Panel: '.$panelUrl,
        ]);
    }
}
