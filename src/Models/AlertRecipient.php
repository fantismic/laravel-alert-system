<?php

namespace VendorName\AlertSystem\Models;

use Illuminate\Database\Eloquent\Model;

class AlertRecipient extends Model
{
    protected $fillable = ['alert_type_id', 'alert_channel_id', 'address'];

    public function type()
    {
        return $this->belongsTo(AlertType::class);
    }

    public function channel()
    {
        return $this->belongsTo(AlertChannel::class);
    }
}
