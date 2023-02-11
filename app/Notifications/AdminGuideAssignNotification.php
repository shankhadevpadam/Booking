<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\SparrowSMS\SparrowSMSMessage;

class AdminGuideAssignNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(
        private array $data
    ) {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'sparrowsms'];
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
                    ->subject(setting('admin_guide_assign_notification_subject', 'Admin Guide Assign'))
                    ->view('emails.template', [
                        'template' => 'admin_guide_assign_notification_message',
                        'data' => [
                            'name' => $this->data['name'],
                            'deposit' => $this->data['deposit'],
                            'remaining_amount' => $this->data['remaining_amount'],
                        ]
                    ]);
    }

    public function toSparrowSMS($notifiable)
    {
        return new SparrowSMSMessage("Name: {$this->data['name']} paid: {$this->data['deposit']} remaining: {$this->data['remaining_amount']}");
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
