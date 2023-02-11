<?php

namespace App\Notifications;

use App\Services\Email\EmailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\SparrowSMS\SparrowSMSMessage;

class NewUserRegistrationNotification extends Notification
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
        $data = $this->toWith();

        return (new MailMessage)
                    ->subject(EmailTemplate::from(setting('user_registration_admin_notification_subject', 'New User Registered'), [
                        'trip_name' => $data->latestUserPackage->package->name,
                    ])->parse())
                    ->view('emails.template', [
                        'template' => 'user_registration_admin_notification_message',
                        'data' => [
                            'name' => $data->name,
                            'trip_name' => $data->latestUserPackage->package->name,
                            'trek_date' => $data->latestUserPackage->departure->start_date,
                            'arrival_date' => $data->latestUserPackage->arrival_date,
                            'arrival_time' => $data->latestUserPackage->arrival_time,
                            'flight_number' => $data->latestUserPackage->flight_number,
                            'airport_pickup' => $data->latestUserPackage->airport_pickup,
                            'total_payment' => number_format($data->latestUserPackage->latestPayment->amount, 2),
                            'remaining_payment' => $this->totalDueAmount(),
                        ],
                    ]);
    }

    public function toSparrowSMS($notifiable)
    {
        $data = $this->toWith();

        return new SparrowSMSMessage("New Booking: {$data->name} Total Amount: {$data->latestUserPackage->total_amount} Advanced: {$data->latestUserPackage->latestPayment->amount} Due: {$this->totalDueAmount()}");
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

    private function toWith()
    {
        return $this->data->load([
            'latestUserPackage:user_packages.id,user_packages.user_id,package_id,departure_id,total_amount,arrival_date,arrival_time,flight_number,airport_pickup',
            'latestUserPackage.package:id,name',
            'latestUserPackage.departure:id,start_date,end_date',
            'latestUserPackage.latestPayment:user_package_payments.id,user_package_payments.user_package_id,user_package_payments.amount',
        ]);
    }

    private function totalDueAmount()
    {
        $data = $this->toWith();
        $dueAmount = $data->latestUserPackage->total_amount - $data->latestUserPackage->latestPayment->amount;

        return number_format($dueAmount, 2);
    }
}
