<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
//Instanciar el uso de logs activity
use Spatie\Activitylog\Traits\LogsActivity;

class User extends Authenticatable
{
    use Notifiable,LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','surname','username','email','email_verified_at','password','activo'
    ];

    /** Laravel-activitylog Parametros */
    protected static $logFillable = true;
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected static $logName = 'Users';

    protected $appends = ['log_name','rolname'];

    public function getLogNameAttribute()
    {
        return self::$logName;
    }

    public function getRolnameAttribute() 
    {  
        if($this->attributes['idrol'] == 0)
        {
            return '';
        }else{
            $nombre = Rol::where('id',$this->attributes['idrol'])->select('rol_descripcion')->first();
            return $nombre->rol_descripcion;
        }        
    }
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles()
    {
        return $this->belongsToMany('App\Rol')
        ->withTimestamps();
    }

    public function authorizeRoles($roles)
    {
        
        if ($this->hasAnyRole($roles)) {
            return true;
        }else{
            return false;
        }
    }

    public function hasAnyRole($roles)
    {
        
        if (is_array($roles)) {
            foreach ($roles as $role) {
                if ($this->hasRole($role)) {
                    return true;
                }
            }
        } else {
            if ($this->hasRole($roles)) {
                return true;
            }
        }
        return false;
    }

    public function hasRole($role)
    {
        
        if ($this->roles()->where('rol_descripcion', $role)->first()) {

            if($this->permisoRol($this->roles()->where('rol_descripcion', $role)->first()->id,1)){
                return true;
            }else{
                
                return false;
            }            
        }
        return false;
    }

    public function permisoRol($role,$modulo)
    {        
        $consulta=\App\Permiso::where([['idrol', $role],['idmodulo',$modulo]])->select('consultar')->first();
        
        if ($consulta->consultar==1) {            
            return true;
        }else{
            //abort(401, 'Esta acción no está autorizada.');
            return false;
        }        
    }

    public function permisoArreglo($role,$modulo,$accion)
    {   
        $arreglo = ['accion'=>0,'permisos'=>0]     ;
        $consulta=\App\Permiso::where([['idrol', $role],['idmodulo',$modulo]])->select($accion)->first();        
        
        if ($consulta->$accion==1) {     
            $consultaPermiso=\App\Permiso::where([['idrol', $role],['idmodulo',$modulo]])->first();
            $arreglo = ['accion'=>true,'permisos'=>$consultaPermiso];            
            return $arreglo;
        }else{
            return false;
        }        
    }


    //Buscadores
    public function scopeNombre($q,$value)
    {
        if(isset($value)){
            $q->where('name','LIKE','%'.$value.'%');
        }
    }

    public function scopeApellido($q,$value)
    {
        if(isset($value)){
            $q->where('surname','LIKE','%'.$value.'%');
        }
    }

    public function scopeRol($q,$value)
    {
        if(isset($value)){
            $q->where('idrol','=',$value);
        }
    }

    public function scopeUsuario($q,$value)
    {
        if(isset($value)){
            $q->where('username','LIKE','%'.$value.'%');
        }
    }

    
}
