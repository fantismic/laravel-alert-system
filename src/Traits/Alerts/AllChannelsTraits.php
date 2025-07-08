<?php

namespace Fantismic\AlertSystem\Traits\Alerts;

use Fantismic\AlertSystem\Traits\Alerts\Channels\MailNotification;
use Fantismic\AlertSystem\Traits\Alerts\Channels\TelegramNotification;
use Fantismic\AlertSystem\Traits\Alerts\Channels\DiscordNotification;

trait AllChannelsTraits
{
    use MailNotification;
    use TelegramNotification;
    use DiscordNotification;

}
