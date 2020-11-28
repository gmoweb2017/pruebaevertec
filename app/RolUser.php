<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//Instanciar el uso de logs activity
use Spatie\Activitylog\Traits\LogsActivity;

class RolUser extends Model
{
    use LogsActivity;

    protected $table="rol_user";
    protected $fillable=['rol_id','user_id'];

    /** Laravel-activitylog Parametros */
    protected static $logFillable = true;
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected static $logName = 'Rol_Users';

    protected $appends = ['log_name'];

    public function getLogNameAttribute()
    {
        return self::$logName;
    }
}
