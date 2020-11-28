<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//Instanciar el uso de logs activity
use Spatie\Activitylog\Traits\LogsActivity;

class Modulo extends Model
{
  use LogsActivity;
  
  protected $table="modulos";
  protected $fillable=['modulo','activo'];

  /** Laravel-activitylog Parametros */
  protected static $logFillable = true;
  protected static $logOnlyDirty = true;
  protected static $submitEmptyLogs = false;
  protected static $logName = 'Modulos';

  protected $appends = ['log_name'];

  public function getLogNameAttribute()
  {
      return self::$logName;
  }

}
