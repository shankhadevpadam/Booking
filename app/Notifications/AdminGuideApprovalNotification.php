<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class AdminGuideApprovalNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(protected array $data)
    {
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
        return (new MailMessage)
                    ->subject(setting('admin_guide_approval_notification_subject', 'Guide Approval Notification'))
                    ->view('emails.template', [
                        'template' => 'admin_guide_approval_notification_message',
                        'data' => [
                            'name' => $this->data['name'],
                            'email' => $this->data['email'],
                            'approval_link' => '<a href="'.URL::signedRoute('guide.approval', ['id' => $this->data['id']]).'">'.URL::signedRoute('guide.approval', ['id' => $this->data['id']]).'</a>',
                        ]
                    ]);
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
