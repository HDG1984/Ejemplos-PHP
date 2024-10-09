<html xmlns="http://www.w3.org/1999/xhtml" lang="es">
  <head>
    <meta charset="utf-8" />
    <title>@yield('titulo')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
  </head>
  <body>
    <div class="div_detallesubicacion">
        <form action="/ubicaciones">
            @csrf 
            <input type="submit" value="Lista de ubicaciones">
        </form>
        
        <form action="/ubicaciones/create">
            @csrf 
            <input type="submit" value="Crear nueva Ubicación">
        </form>
    </div>

    @yield('content')


  </body>
</html>