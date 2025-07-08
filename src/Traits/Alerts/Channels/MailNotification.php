<?php

namespace Fantismic\AlertSystem\Traits\Alerts\Channels;

use Illuminate\Support\Facades\Mail;
use Fantismic\AlertSystem\Mail\ErrorAlertMail;

trait MailNotification
{
    public function mailAlert($recipient, $type, $message, $details = [], $subject = null) {
        Mail::to($recipient->address)->send(new ErrorAlertMail($type, $message, $details, $subject));
    }
}
