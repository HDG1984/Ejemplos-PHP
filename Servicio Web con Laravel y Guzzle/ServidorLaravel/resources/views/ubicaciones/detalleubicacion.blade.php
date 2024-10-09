@extends('layouts.base')
@section('titulo','Detalles de ubicación')
@section('content')
   
    <p><strong>Nombre: </strong>{{$ubicacion->nombre}}</p>
    <p><strong>Descripción: </strong>{{$ubicacion->descripcion}}</p>
    <p><strong>Días disponibles: </strong>{{$ubicacion->dias}}</p>
    <br>
    <h3>Listado de talleres</h3>
    @if ($talleres->isEmpty())
        <p>No existen talleres para esta ubicación</p>
    @else
        <table class="tabla_talleres">
            <thead>
                <tr>
                    <th>Nombre</th><th>Descripción</th><th>Día de la semana</th><th>Hora de inicio</th><th>Hora de fin</th><th>Cupo</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($talleres as $taller)
                <tr>
                    <td>{{$taller->nombre}}</td>
                    <td>{{$taller->descripcion}}</td>
                    <td>{{$taller->dia_semana}}</td>
                    <td>{{$taller->hora_inicio}}</td>
                    <td>{{$taller->hora_fin}}</td>
                    <td>{{$taller->cupo_maximo}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
@endsection