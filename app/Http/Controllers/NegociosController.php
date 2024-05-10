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
            $nombreImagen = uniqid('negocio_') . '.png';
            if(!is_dir(public_path('/imagenes/negocios/'))){
                File::makeDirectory(public_path().'/imagenes/negocios/',0777,true);
            }
            $subido = $imagen->move(public_path().'/imagenes/negocios/', $nombreImagen);
        } else {
            $nombreImagen = 'default.png';
        }
        $negocio = new Negocios();
        $negocio->nombre=$request->nombre;
        $negocio->imagen=$nombreImagen;
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
        return view('negocios.edit',compact('negocio'));
    }
    public function update(Request $request, $id){
        $this->validate($request,[
            'nombre'=>'required|exists:negocios,nombre',
            'imagen'=>'nullable|image|mimes:png,jpg,jpg,jpeg',
            'descripcion'=>'nullable|string|min:10|max:500',
        ]);
        $negocio=Negocios::find($id);
        if($request->file('imagen')){
            // eliminar la imagen anterior
            if($negocio->imagen != 'default.png'){
                if(file_exists(public_path().'/imagenes/negocios/'.$negocio->imagen)){
                    unlink(public_path().'/imagenes/negocios/'.$negocio->imagen);
                }
            }

            $imagen = $request->file('imagen');
            $nombreImagen = uniqid('negocio_') . '.png';
            if(!is_dir(public_path('/imagenes/negocios/'))){
                File::makeDirectory(public_path().'/imagenes/negocios/',0777,true);
            }
            $subido = $imagen->move(public_path().'/imagenes/negocios/', $nombreImagen);

            $negocio->imagen = $nombreImagen;
        }
        $negocio->nombre=$request->nombre;
        $negocio->descripcion=$request->descripcion;
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

    public function show($id){
        $negocio=Negocios::find($id);
        return view('negocios.show',compact('negocio'));
    }
}
