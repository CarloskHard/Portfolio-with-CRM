<?php

namespace App\Jobs;

use App\Models\Message;
use App\Services\Notifications\TelegramNotifier;
use App\Services\Notifications\WhatsAppNotifier;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use RuntimeException;
use Throwable;

class SendNewContactAlert implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;

    public array $backoff = [10, 60, 180];

    public function __construct(
        public Message $message
    ) {
    }

    public function handle(WhatsAppNotifier $whatsAppNotifier, TelegramNotifier $telegramNotifier): void
    {
        $channels = config('services.contact_alerts.channels', []);

        if (! is_array($channels) || empty($channels)) {
            Log::info('Alerta de contacto omitida: no hay canales configurados.', [
                'message_id' => $this->message->id,
            ]);
            return;
        }

        $normalizedChannels = array_values(array_filter(array_map(
            static fn ($channel) => strtolower(trim((string) $channel)),
            $channels
        )));

        $failedChannels = [];

        foreach ($normalizedChannels as $channel) {
            try {
                match ($channel) {
                    'whatsapp' => $whatsAppNotifier->sendNewMessageAlert($this->message),
                    'telegram' => $telegramNotifier->sendNewMessageAlert($this->message),
                    default => throw new RuntimeException('Canal de alerta no soportado: '.$channel),
                };
            } catch (Throwable $exception) {
                $failedChannels[] = $channel;

                Log::error('Falló un canal de alerta de contacto.', [
                    'message_id' => $this->message->id,
                    'channel' => $channel,
                    'exception' => $exception->getMessage(),
                ]);
            }
        }

        Log::info('Alerta de contacto enviada correctamente.', [
            'message_id' => $this->message->id,
            'channels' => $normalizedChannels,
            'failed_channels' => $failedChannels,
        ]);
    }

    public function failed(Throwable $exception): void
    {
        Log::error('No se pudo enviar alerta de nuevo mensaje de contacto.', [
            'message_id' => $this->message->id,
            'sender_email' => $this->message->sender_email,
            'exception' => $exception->getMessage(),
        ]);
    }
}
