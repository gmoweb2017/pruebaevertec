<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//Instanciar el uso de logs activity
use Spatie\Activitylog\Traits\LogsActivity;

class Permiso extends Model
{
  use LogsActivity;

  protected $table="permisos";
  protected $fillable=['idrol','idmodulo','consultar','crear','editar','eliminar'];

  /** Laravel-activitylog Parametros */
  protected static $logFillable = true;
  protected static $logOnlyDirty = true;
  protected static $submitEmptyLogs = false;
  protected static $logName = 'Permisos';

  protected $appends = ['log_name'];

  public function getLogNameAttribute()
  {
      return self::$logName;
  }
}
