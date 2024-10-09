@extends('layouts.base')
@section('titulo','Crear nueva ubicación')
@section('content')

    @if ($errors->any())
        <div class="error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
        <hr>
    @endif

    <h2>Crear nueva ubicación</h2>
    <form action="/ubicaciones/store" method="post" class="formulario">
        @csrf 
        Nombre: <input type="text" name="nombre"><br>
        Descripción: <input type="text" name="descripcion"><br>
        Días en los que está disponible:<br>
        @foreach (['L','M','X','J','V','S','D'] as $dia)
            {{$dia}} <input type="checkbox" name='dias[]' value={{$dia}}>
        @endforeach
        <br>
        <input type="submit" value="Crear nueva Ubicación">
    </form>

@endsection