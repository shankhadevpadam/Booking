<?php

namespace App\Notifications;

use App\Concerns\InteractsWithPdf;
use App\Models\UserPackage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OverduePaidNotification extends Notification implements ShouldQueue
{
    use InteractsWithPdf, Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(
        protected UserPackage $userPackage,
        protected string $paymentMethod,
        protected float $amount
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
        $this->makePdf();

        return (new MailMessage)
                    ->subject(setting('overdue_paid_notification_subject', 'Paid Overdue'))
                    ->view('emails.template', [
                        'template' => 'overdue_paid_notification_message',
                        'data' => [
                            'name' => $notifiable->name,
                            'total_payment' => number_format($this->amount, 2),
                        ]
                    ])
                    ->attachData($this->pdf, 'invoice.pdf', [
                        'mime' => 'application/pdf',
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
