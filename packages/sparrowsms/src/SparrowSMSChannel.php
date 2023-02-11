<?php

namespace NotificationChannels\SparrowSMS;

use Illuminate\Notifications\Notification;

class SparrowSMSChannel
{
    public string $endpoint;

    public string $token;

    public string $from;

    public function __construct(array $config = [])
    {
        $this->endpoint = $config['endpoint'];

        $this->token = $config['token'];

        $this->from = $config['from'];
    }

    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     *
     * @throws \NotificationChannels\SparrowSMS\Exceptions\CouldNotSendNotification
     */
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toSparrowSMS($notifiable);

        if (is_string($message)) {
            $message = new SparrowSMSMessage($message);
        }

        $args = http_build_query([
                'token' => $this->token,
                'from' => $this->from,
                'to' => $notifiable->routeNotificationFor('sparrowsms'),
                'text' => $message->content,
            ]);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->endpoint);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $args);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    
        // Response
        $response = curl_exec($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return true;
    }
}
