<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//Instanciar el uso de logs activity
use Spatie\Activitylog\Traits\LogsActivity;


class Customer extends Model
{
    use LogsActivity;

    protected $table="customers";
    protected $fillable=['customer_name','customer_address','customer_email','customer_mobile'];

    /** Laravel-activitylog Parametros */
    protected static $logFillable = true;
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected static $logName = 'Customers';

    protected $appends = ['log_name'];

    public function getLogNameAttribute()
    {
        return self::$logName;
    }

    
}
