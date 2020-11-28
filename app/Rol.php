<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//Instanciar el uso de logs activity
use Spatie\Activitylog\Traits\LogsActivity;

class Rol extends Model
{

  use LogsActivity;

  protected $table="roles";
  protected $fillable=['rol_descripcion','rol_activo'];

  public function users()
  {
      return $this
          ->belongsToMany('App\User')
          ->withTimestamps();
  }

  /** Laravel-activitylog Parametros */
  protected static $logFillable = true;
  protected static $logOnlyDirty = true;
  protected static $submitEmptyLogs = false;
  protected static $logName = 'Roles';

  protected $appends = ['log_name'];

  public function getLogNameAttribute()
  {
      return self::$logName;
  }

}
