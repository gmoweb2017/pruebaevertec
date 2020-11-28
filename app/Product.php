<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//Instanciar el uso de logs activity
use Spatie\Activitylog\Traits\LogsActivity;

class Product extends Model
{
    use LogsActivity;

    protected $table="products";
    protected $fillable=['nombreProducto','precio','activo'];

    /** Laravel-activitylog Parametros */
    protected static $logFillable = true;
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected static $logName = 'Products';

    protected $appends = ['log_name'];

    public function getLogNameAttribute()
    {
        return self::$logName;
    }
}
