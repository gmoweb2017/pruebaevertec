<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//Instanciar el uso de logs activity
use Spatie\Activitylog\Traits\LogsActivity;

class OrderDetail extends Model
{
    use LogsActivity;

    protected $table="order_details";
    protected $fillable=['order_id','product_id','quantity','value','total'];

    /** Laravel-activitylog Parametros */
    protected static $logFillable = true;
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected static $logName = 'OrderDetails';

    protected $appends = ['log_name'];

    public function getLogNameAttribute()
    {
        return self::$logName;
    }

    public function product()
    {
        return $this->BelongsTo(Product::class,'product_id','id');
    }
}
