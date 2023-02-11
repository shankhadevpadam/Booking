<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\SparrowSMS\SparrowSMSMessage;

class AdminUserArrivalNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(
        protected $data
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
                    ->subject(setting('notify_admin_user_arrival_subject', 'Notify admin user arrival'))
                    ->view('emails.notify_admin_user_arrival', [
                        'data' => $this->data,
                    ]);
    }

    public function toSparrowSMS($notifiable)
    {
        return new SparrowSMSMessage("Client: {$this->data->user->name} arrived in {$this->data->arrival_date->toDateString()} at {$this->data->arrival_time->toTimeString()} on flight number {$this->data->flight_number} with pickup {$this->data->airport_pickup}");
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
