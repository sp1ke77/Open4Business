<?php
declare(strict_types=1);

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendSubmissionConfirmationEmail extends Notification
{
    use Queueable;

    private $submission;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($submission)
    {
        $this->submission = $submission;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = url('/single_submission/validate_token/'.$this->submission->validation_token);
        return (new MailMessage)
        ->subject('Open4Business - Nova Submissão')
        ->greeting('Olá! Recebemos a tua submissão!')
        ->line('A tua submissão só será validada após clicares no link que te enviámos por e-mail')
        ->action('Valida a submissão!', $url)
        ->line('Se não criaste nenhuma submissão ignora este email')
        ->salutation('Até já!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
