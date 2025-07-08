<?php

namespace Fantismic\AlertSystem\Traits\Alerts;

use Fantismic\AlertSystem\Traits\Alerts\Channels\MailNotification;
use Fantismic\AlertSystem\Traits\Alerts\Channels\TelegramNotification;

trait AllChannelsTraits
{
    use MailNotification;
    use TelegramNotification;

}
