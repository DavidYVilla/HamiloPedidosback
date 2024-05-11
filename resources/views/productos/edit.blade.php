@extends('layouts.app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Productos</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                        <li class="breadcrumb-item active">Productos</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Actualizacion de Producto</div>

                        <div class="card-body">
                            <form action="{{ url('/productos/actualizar/' . $producto->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @method('PUT')
                                @csrf
                                <div class="form-group">
                                    <label for="negocio_id">Negocio</label>
                                    <select class="form-control" name="negocio_id">
                                        <option value="">Seleccione...</option>
                                        @foreach ($negocios as $item)
                                            <option value="{{ $item->id }}"
                                                @if ($item->id == $producto->negocios_id) select @endif>{{ $item->nombre }}</option>
                                        @endforeach
                                    </select>
                                    @error('negocio_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="nombre">Nombre</label>
                                    <input type="text" name="nombre" class="form-control"
                                        value="{{ $producto->nombre }}">
                                    @error('nombre')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="costo">Costo</label>
                                    <input type="number" name="costo" class="form-control"
                                        value="{{ $producto->costo }}">
                                    @error('costo')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <img src="{{ $producto->getimagenUrl() }}" height="80px">
                                <div class="form-group">
                                    <label for="nombre">Imagen</label>
                                    <input type="file" class="form-control" accept="image/*" name="imagen">
                                    @error('imagen')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="descripcion">Descripcion</label>
                                    <textarea cols="30" rows="3" class="form-control" name="descripcion">{{ $producto->descripcion }}"</textarea>
                                    @error('descripcion')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <a href="{{ url('/productos') }}" type="button" class="btn btn-primary">Volver al
                                    listado</a>
                                <button type="submit" class="btn btn-primary">Actualizar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
