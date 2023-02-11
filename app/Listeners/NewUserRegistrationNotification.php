<?php

namespace App\Listeners;

use App\Events\Registered;
use App\Models\Bank;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class NewUserRegistrationNotification implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param  Registered  $event
     * @return void
     */
    public function handle(Registered $event)
    {
        $user = $this->toArray($event->user);

        Mail::send('emails.registration_notification', $user, function ($message) use ($user) {
            $pdf = PDF::loadview('pdf.initial_payment_invoice', $user)
                ->setWarnings(false)
                ->output();

            $message->to($user['email']);
            $message->subject(setting('user_registration_notification_subject', 'User Registration'));
            $message->attachData($pdf, 'initial_payment.pdf', [
                'mime' => 'application/pdf',
            ]);
        });
    }

    private function toArray($user): array
    {
        $user->load([
            'country:id,name',
            'latestUserPackage:user_packages.id,user_packages.user_id,package_id,departure_id,number_of_trekkers,total_amount,arrival_date,arrival_time,flight_number,airport_pickup',
            'latestUserPackage.package:id,name',
            'latestUserPackage.departure:id,start_date,end_date',
            'latestUserPackage.latestPayment:user_package_payments.id,user_package_payments.user_package_id,user_package_payments.amount,user_package_payments.bank_charge,user_package_payments.payment_method',
        ]);
        
        $user = $user->toArray();

        if ($bank = Bank::find(setting('bank_id'))) {
            $user['bank_charge'] = $bank->charge;
        } else {
            $user['bank_charge'] = 0;
        }

        return $user;
    }
}
