<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class GuruRejectedNotification extends Notification
{
    use Queueable;

    protected $alasan;

    public function __construct($alasan)
    {
        $this->alasan = $alasan;
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Akun SiPANDU VIRTUAL Ditolak')
            ->greeting('Halo ' . $notifiable->name . ',')
            ->line('Maaf, akun Anda di SiPANDU VIRTUAL ditolak oleh admin.')
            ->line('Alasan: ' . $this->alasan)
            ->line('Silakan hubungi admin jika ada pertanyaan.')
            ->salutation('Tim SiPANDU VIRTUAL');
    }
}