<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Negocios extends Model
{
    use HasFactory;
    protected $table ='negocios';
    protected $fillable = [
    'usuario_id',
    'nombre',
    'imagen',
    'descripcion',
    'estado',
    ];

    //relacion con usuario
    public function usuario(){
        return $this->belongsTo(User::class,'usuario_id');
    }
    //obtener la imagen
    public function getImagenUrl(){
        if($this->imagen && $this->imagen != 'default.png' && $this->imagen!=null){
            return asset('imagenes/negocios/'.$this->imagen);
        }else{
            return asset('default.png');
        }
    }

}
