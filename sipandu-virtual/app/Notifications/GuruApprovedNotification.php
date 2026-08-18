<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class GuruApprovedNotification extends Notification
{
    use Queueable;

    public function __construct()
    {
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Akun SiPANDU VIRTUAL Disetujui')
            ->greeting('Halo ' . $notifiable->name . ',')
            ->line('Akun Anda di SiPANDU VIRTUAL telah disetujui oleh admin.')
            ->line('Anda sekarang bisa login dan mulai mengisi instrumen triwulan.')
            ->action('Login ke SiPANDU', url('/login'))
            ->salutation('Terima kasih, Tim SiPANDU VIRTUAL');
    }
}