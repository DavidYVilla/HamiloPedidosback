<?php

namespace App\Http\Controllers;

use App\Models\Negocios;
use App\Models\Productos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //opcion1
        // $productos=Productos::with('negocio')
        //                     ->whereHas('negocio', function($query){
        //                         $query=>where('usuario_id',auth()->user()->id)
        //                     })
        //                     ->orderBy('id','DESC')
        //                     ->paginate(10);

        //opcion2
        // $negocios=Negocios::where('usuario_id',auth()->user()->id)->get();
        // $arrayNegocios = [];
        // foreach($negocios as $value){
        //     $arrayNegocios[]=$value->id;
        // }
        // $productos = Productos::whereIn('negocio_id', $arrayNegocios)->orderBy('id','DESC');->paginate(10)

        //opcion3
        $arrayNeg=Negocios::where('usuario_id',auth()->user()->id)->get()->pluck('id');
        $productos=Productos::whereIn('negocios_id', $arrayNeg)->orderBy('id','DESC')->paginate(10);

        return view('productos.index',compact('productos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $negocios=Negocios::where('usuario_id',auth()->user()->id)->get();
        // $productos=Productos::whereIn('negocios_id', $arrayNeg)->orderBy('id','DESC')->paginate(10);

             return view('productos.create',compact('negocios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $this->validate($request,[
            'nombre'=>'required',
            'imagen'=>'nullable|image|mimes:png,jpg,jpg,jpeg',
            'costo'=>'required|numeric',
            'descripcion'=>'nullable|string|min:10|max:500',
            'negocio_id'=>'required|exists:negocios,id'
        ]);
        if($request->hasfile('imagen')){
            $imagen = $request->file('imagen');
            $nombreImagen = uniqid('producto_') . '.png';
            if(!is_dir(public_path('/imagenes/productos/'))){
                File::makeDirectory(public_path().'/imagenes/productos/',0777,true);
            }
            $imagen->move(public_path().'/imagenes/productos/', $nombreImagen);
        } else {
            $nombreImagen = 'default.png';
        }
        $producto = new Productos();
        $producto->nombre=$request->nombre;
        $producto->imagen=$nombreImagen;
        $producto->descripcion= $request->descripcion;
        $producto->costo=$request->costo;
        $producto->estado=true;
        $producto->negocios_id=$request->negocio_id;
    if($producto->save()){
        return redirect('/productos')->with('success', 'Registro agregado correctamente!');
    }else{
        return back()->with('error','El registro no fue realizado!');
    }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //

        $producto=Productos::find($id);

        return view('productos.show',compact('producto'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function estado($id){
        $producto=Productos::find($id);
        $producto->estado = !$producto->estado;
        if($producto->save()){
            return redirect('/productos')->with('success','Estado actualizado correctamente');
        }else{
            return back()->with('eror','Estado no ha sido actualizado');
        }
        }
    public function edit(Productos $productos,$id)
    {
        //
       $producto=Productos::find($id);
       $negocios=Negocios::where('usuario_id',auth()->user()->id)->get();
        return view('productos.edit',compact('producto','negocios'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
         $this->validate($request,[
            'nombre'=>'required',
            'imagen'=>'nullable|image|mimes:png,jpg,jpg,jpeg',
            'costo'=>'required|numeric',
            'descripcion'=>'nullable|string|min:10|max:500',
            'negocio_id'=>'required|exists:negocios,id'

        ]);
        $producto=Productos::find($id);
        if($request->file('imagen')){
            // eliminar la imagen anterior
            if($producto->imagen != 'default.png'){
                if(file_exists(public_path().'/imagenes/productos/'.$negocio->imagen)){
                    unlink(public_path().'/imagenes/productos/'.$negocio->imagen);
                }
            }

            $imagen = $request->file('imagen');
            $nombreImagen = uniqid('producto_') . '.png';
            if(!is_dir(public_path('/imagenes/productos/'))){
                File::makeDirectory(public_path().'/imagenes/productos/',0777,true);
            }
            $subido = $imagen->move(public_path().'/imagenes/productos/', $nombreImagen);

            $producto->imagen = $nombreImagen;
        }
        $producto->nombre=$request->nombre;
        // $producto->imagen=$nombreImagen;
        $producto->descripcion= $request->descripcion;
        $producto->costo=$request->costo;
        $producto->negocios_id=$request->negocio_id;

    if($producto->save()){
        return redirect('/productos')->with('success', 'Registro agregado correctamente!');
    }else{
        return back()->with('error','El registro no fue realizado!');
    }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Productos $productos)
    {
        //
    }
}
