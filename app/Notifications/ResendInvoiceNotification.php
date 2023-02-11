<?php

namespace App\Notifications;

use App\Models\UserPackagePayment;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResendInvoiceNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /** @var pdf */
    protected $pdf;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(
        protected int $paymentId
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
                    ->subject(setting('resend_invoice_notification_subject', 'Payment Invoice'))
                    ->view('emails.template', [
                        'template' => 'resend_invoice_notification_message',
                        'data' => [
                            'name' => $notifiable->name,
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

    /**
     * Generate pdf output
     *
     * @return void
     */
    protected function makePdf(): void
    {
        $payment = UserPackagePayment::with(['userPackage:id,user_id,package_id,number_of_trekkers,start_date,end_date,total_amount'])
            ->where('id', $this->paymentId)
            ->first()
            ->toArray();

        $this->pdf = PDF::loadview('pdf.payment_invoice', $payment)->setWarnings(false)->output();
    }
}
