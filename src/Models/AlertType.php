<?php

namespace Fantismic\AlertSystem\Models;

use Illuminate\Database\Eloquent\Model;

class AlertType extends Model
{
    protected $fillable = ['name'];

    public function recipients()
    {
        return $this->hasMany(AlertRecipient::class, 'alert_type_id');
    }
}
