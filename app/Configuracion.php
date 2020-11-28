<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//Instanciar el uso de logs activity
use Spatie\Activitylog\Traits\LogsActivity;

class Configuracion extends Model
{
  use LogsActivity;

  protected $table="configuraciones";
  protected $guarded = [];
  protected $fillable=['variable','valor'];

  /** Laravel-activitylog Parametros */
  protected static $logFillable = true;
  protected static $logOnlyDirty = true;
  protected static $submitEmptyLogs = false;
  protected static $logName = 'Configuraciones';

  protected $appends = ['log_name'];

  public function getLogNameAttribute()
  {
      return self::$logName;
  }
}
