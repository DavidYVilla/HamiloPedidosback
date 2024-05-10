<?php

namespace App\Http\Controllers;

use App\Models\Negocios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class NegociosController extends Controller
{
    //
    public function index(){
        $negocios=Negocios::orderBy('id','DESC')
                            ->paginate(10);
        return view('negocios.index',compact('negocios'));
    }
    public function create(){
        return view('negocios.create');
    }
    public function store(Request $request){
        $this->validate($request,[
            'nombre'=>'required|unique:negocios',
            'imagen'=>'nullable|image|mimes:png,jpg,jpg,jpeg',
            'descripcion'=>'nullable|string|min:10|max:500',
        ]);
        if($request->file('imagen')){
            $imagen = $request->file('imagen');
            $nombreImagen = uniqid('post_') . '.png';
            if(!is_dir(public_path('/imagenes/posts/'))){
                File::makeDirectory(public_path().'/imagenes/posts/',0777,true);
            }
            $subido = $imagen->move(public_path().'/imagenes/posts/', $nombreImagen);
        } else {
            $nombreImagen = 'default.png';
        }
        $negocio = new Negocios();
        $negocio->nombre=$request->nombre;
        $negocio->imagen=$nombreImagen->imagen;
        $negocio->descripcion= $request->descripcion;
        $negocio->estado=true;
        $negocio->usuario_id=auth()->user()->id;
    if($negocio->save()){
        return redirect('/negocios')->with('success', 'Registro agregado correctamente!');
    }else{
        return back()->with('error','El registro no fue realizado!');
    }


}
    public function edit($id){
        $negocio=Negocios::find($id);
        return view('negocios.edit',compact('negocios'));
    }
    public function update(){
        $this->validate($request,[
            'nombre'=>'required|unique:negocios',
            'imagen'=>'nullable|image|mimes:png,jpg,jpg,jpeg',
            'descripcion'=>'nullable|string|min:10|max:500',
        ]);
        $negocio=Negocio::find($id);
        if($request->file('imagen')){
            // eliminar la imagen anterior
            if($post->imagen != 'default.png'){
                if(file_exists(public_path().'/imagenes/posts/'.$post->imagen)){
                    unlink(public_path().'/imagenes/posts/'.$post->imagen);
                }
            }

            $imagen = $request->file('imagen');
            $nombreImagen = uniqid('post_') . '.png';
            if(!is_dir(public_path('/imagenes/posts/'))){
                File::makeDirectory(public_path().'/imagenes/posts/',0777,true);
            }
            $subido = $imagen->move(public_path().'/imagenes/posts/', $nombreImagen);

            $negocio->imagen = $nombreImagen;
        }
        $negocio->nombre=$request->nombre;
        $negocio->descripcion=$post->descripcion;
        if ($negocio->save()) {
            return redirect('/negocios')->with('success', 'Registro actualizado correctamente!');
        } else {
            return back()->with('error', 'El registro no fué actualizado!');
        }
    }
    public function estado($id){
        $negocio=Negocios::find($id);
            $negocio->estado = !$negocio->estado;
            if($negocio->save()){
                return redirect('/negocios')->with('success','Estado actualizado correctamente');
            }else{
                return back()->with('eror','Estado no ha sido actualizado');
            }
        }

    public function show(){
        $negocio=Negocio::find($id);
        return view('negocios.show',compact('negocio'));
    }
}
