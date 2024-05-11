@extends('layouts.app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Negocios</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                        <li class="breadcrumb-item active">Negocios</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-4">
                    <div class="card">
                        <div class="card-header">Listado de Negocios</div>
                        <div class="card-body">
                            <div>
                                <img src="{{ $negocio->getimagenUrl() }}" height="100px">
                            </div>
                            <div class="mt-2">
                                <h3>{{ $negocio->nombre }}</h3>
                            </div>
                            <div>
                                <p>
                                    {{ $negocio->descripcion }}
                                </p>
                                <div class="m-2">
                                    @if ($negocio->estado == true)
                                        <span class="badge badge-success">Activo</span>
                                    @else
                                        <span class="badge badge-danger">Inactivo</span>
                                    @endif
                                </div>
                                <div class="m-2">
                                    <b>Fecha de Creación</b>
                                    {{ $negocio->created_at }}
                                </div>
                            </div>
                            <div class="text-center mt-3">
                                <a href="{{ url('/negocios') }}" class="btn-btn-primary">Volver al Listado</a>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-8">
                    <div class="card">
                        <div class="card-header">Listado de Productos</div>
                        <div class="card-body">
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
