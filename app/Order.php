<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//Instanciar el uso de logs activity
use Spatie\Activitylog\Traits\LogsActivity;

class Order extends Model
{
    use LogsActivity;

    protected $table="orders";
    protected $fillable=['customer_id','value_order','order_date','status'];

    /** Laravel-activitylog Parametros */
    protected static $logFillable = true;
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected static $logName = 'Orders';

    protected $appends = ['log_name'];

    public function getLogNameAttribute()
    {
        return self::$logName;
    }

    public function order_details()
    {
        return $this->hasMany(OrderDetail::class);
    }
    
    public function customer()
    {
        return $this->belongsTo(Customer::class,'customer_id','id');
    }
    
}
