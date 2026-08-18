<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Submission;

class SubmissionReviewedNotification extends Notification
{
    use Queueable;

    protected $submission;

    public function __construct(Submission $submission)
    {
        $this->submission = $submission;
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $status = $this->submission->status_review === 'lengkap' ? 'disetujui' : 'perlu revisi';

        return (new MailMessage)
            ->subject('Submission Triwulan ' . ucfirst($status))
            ->greeting('Halo ' . $notifiable->nama_lengkap . ',')
            ->line('Submission Triwulan ' . $this->submission->periode->nomor . ' Anda telah ' . $status . ' oleh admin.')
            ->line('Feedback: ' . ($this->submission->feedback_admin ?? 'Tidak ada feedback'))
            ->action('Lihat Submission', url('/guru/triwulan/' . $this->submission->periode_id))
            ->salutation('Tim SiPANDU VIRTUAL');
    }
}