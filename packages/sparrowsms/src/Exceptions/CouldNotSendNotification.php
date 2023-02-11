<?php

namespace NotificationChannels\SparrowSMS\Exceptions;

class CouldNotSendNotification extends \Exception
{
    public static function serviceRespondedWithAnError($response)
    {
        return new static($response['response_code'].':'.$response['response']);
    }
}
