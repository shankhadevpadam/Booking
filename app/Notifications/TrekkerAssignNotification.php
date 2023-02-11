<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\SparrowSMS\SparrowSMSMessage;

class TrekkerAssignNotification extends Notification implements ShouldQueue
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
                    ->subject(setting('trekker_assign_notification_subject', 'Trekker Assign'))
                    ->view('emails.template', [
                        'template' => 'trekker_assign_notification_message',
                        'data' => [
                            'name' => $this->data['name'],
                            'number_of_trekkers' => $this->data['number_of_trekkers'],
                            'trip_name' => $this->data['trip_name'],
                            'trek_date' => $this->data['trek_date'],
                            'addons' => $this->data['addons'],
                        ]
                    ]);
    }

    public function toSparrowSMS($notifiable)
    {
        return new SparrowSMSMessage("Client: {$this->data['name']} Number of Pax: {$this->data['number_of_trekkers']} Trip Name: {$this->data['trip_name']} from {$this->data['trek_date']} {$this->data['addons']}");
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
