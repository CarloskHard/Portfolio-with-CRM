<?php

namespace App\Services\Notifications;

use App\Models\Message;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class TelegramNotifier
{
    public function sendNewMessageAlert(Message $message): void
    {
        $config = config('services.telegram');

        $botToken = (string) ($config['bot_token'] ?? '');
        $chatId = (string) ($config['chat_id'] ?? '');

        if ($botToken === '' || $chatId === '') {
            throw new RuntimeException('Telegram no está configurado.');
        }

        $endpoint = sprintf('https://api.telegram.org/bot%s/sendMessage', $botToken);

        $response = Http::post($endpoint, [
            'chat_id' => $chatId,
            'text' => $this->buildBody($message),
            'parse_mode' => 'HTML',
            'disable_web_page_preview' => true,
        ]);

        if (! $response->successful()) {
            throw new RuntimeException(
                'Error enviando Telegram: '.$response->status().' '.$response->body()
            );
        }
    }

    private function buildBody(Message $message): string
    {
        $unreadCount = Message::query()
            ->where('is_read', false)
            ->count();

        $panelUrl = rtrim((string) config('app.url'), '/').'/messages';

        $senderName = $this->escape((string) $message->sender_name);
        $senderEmail = $this->escape((string) $message->sender_email);
        $content = $this->escape((string) $message->content);
        $createdAt = $this->escape(
            $message->created_at?->format('d/m/Y H:i') ?? now()->format('d/m/Y H:i')
        );

        return implode("\n", [
            '🔔 <b>Nuevo mensaje desde tu web</b>',
            '',
            '👤 <b>Contacto:</b> '.$senderName,
            '📧 <b>Email:</b> '.$senderEmail,
            '🕒 <b>Fecha:</b> '.$createdAt,
            '',
            '💬 <b>Mensaje:</b>',
            '<blockquote>'.$content.'</blockquote>',
            '',
            '📌 <b>Recordatorio:</b> tienes <b>'.$unreadCount.'</b> mensaje(s) sin leer.',
            '➡️ <a href="'.$panelUrl.'">Abrir panel de mensajes</a>',
        ]);
    }

    private function escape(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
}
