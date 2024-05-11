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
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Listado de Productos</div>
                    <div class="card-body">
                        @include('includes.alertas')
                        <div class="row">
                            <div class="col-md-6"></div>
                            <div class="col-md-6 text-end mb-2">
                                <a href="{{ url('/productos/registrar') }}" class="btn btn-primary">Nuevo</a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>IMAGENES</th>
                                                <th>NOMBRE</th>
                                                <th>DESCRIPCION</th>
                                                <th>COSTO</th>
                                                <th>ESTADO</th>
                                                <th>NEGOCIO</th>
                                                <th>ACCIONES</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($productos as $item)
                                                <tr>
                                                    <td>{{ $item->id }}</td>
                                                    <td>
                                                        <img src="{{ $item->getimagenUrl() }}" height="40px"
                                                            alt="imagen">
                                                    </td>
                                                    <td>{{ $item->nombre }}</td>
                                                    <td>{{ $item->descripcion }}</td>
                                                    <td>{{ $item->costo }}</td>
                                                    <td>
                                                        @if ($item->estado == true)
                                                            <span class="badge badge-success">Activo</span>
                                                        @else
                                                            <span class="badge badge-danger">Inactivo</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ url('/negocios/ver/' . $item->negocio->id) }}"
                                                            class="btn btn-link">{{ $item->negocio->nombre }}</a>
                                                    </td>
                                                    <td>
                                                        <a href="{{ url('/productos/actualizar/' . $item->id) }}"
                                                            class="btn btn-warning"><i class="fa fa-edit"></i></a>
                                                        @if ($item->estado == true)
                                                            <a href="{{ url('/productos/estado/' . $item->id) }}"
                                                                class="btn btn-danger"><i class="fa fa-ban"></i></a>
                                                        @else
                                                            <a href="{{ url('/productos/estado/' . $item->id) }}"
                                                                class="btn btn-success"><i class="fa fa-check"></i></a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    {{ $productos->links('pagination::bootstrap-5') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
