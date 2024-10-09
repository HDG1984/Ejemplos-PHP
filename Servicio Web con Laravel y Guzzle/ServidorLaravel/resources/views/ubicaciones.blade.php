@extends('layouts.base')
@section('titulo','Lista de ubicaciones')

@section('content')

    @if(session('ok'))
        <div class="correcto">
            {{ session('ok') }}
        </div>
        <hr>
    @endif
    
    <h2>Listado de ubicaciones</h2>
    <table>
        <thead>
            <tr>
                <th>Id</th><th>Nombre</th><th>Descripcion</th><th>Días</th><th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($ubicaciones as $ubicacion)
            <tr>
                <td>{{$ubicacion->id}}</td>
                <td>{{$ubicacion->nombre}}</td>
                <td>{{$ubicacion->descripcion}}</td>
                <td>{{$ubicacion->dias}}</td>
                <td>
                    <div class="div_enlaces">
                        <a class="enlace_form" href="/ubicaciones/{{$ubicacion->id}}">Detalle ubicación</a>
                        <a class="enlace_form" href="/ubicaciones/{{$ubicacion->id}}/edit">Editar ubicación</a>
                        <a class="enlace_form" href="/ubicaciones/{{$ubicacion->id}}/destroyconfirm">Borrar ubicación</a>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection