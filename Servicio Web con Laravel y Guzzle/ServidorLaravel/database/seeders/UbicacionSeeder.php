<?php

namespace Database\Seeders;

use App\Models\Taller;
use App\Models\Ubicacion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UbicacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Ubicacion::where('nombre','Palacio de congresos')->count()==0)
        {
            //$ubicacion1 = new Ubicacion;

            $ubicacion1 = Ubicacion::create(['nombre'=>'Palacio de congresos', 'descripcion'=>'Av. Alcalde Luis Uruñuela, 1', 'dias'=>'L,M,X']);

            $diasValidosUb1 = explode(',', $ubicacion1->dias);

            $taller1 = new Taller;
            $taller1->nombre = 'Prueba 1';
            $taller1->descripcion = 'Prueba 1';
            $taller1->dia_semana = 'L';
            $taller1->hora_inicio = '10:00';
            $taller1->hora_fin = '11:30';
            $taller1->cupo_maximo = 8;
            $taller1->ubicacion_id = $ubicacion1->id;

            if (in_array($taller1->dia_semana, $diasValidosUb1)) {
                $taller1->save();
            }
        }
        

        if (Ubicacion::where('nombre','Centro cultural 2')->count()==0)
        {
           // $ubicacion2 = new Ubicacion;

            $ubicacion2 = Ubicacion::create(['nombre'=>'Centro cultural 2', 'descripcion'=>'Centro cultural de la avenida República Argentina numero 37', 'dias'=>'M,X']);

            $diasValidosUb2 = explode(',', $ubicacion2->dias);

            $taller2 = new Taller;
            $taller2->nombre = 'Inmigración';
            $taller2->descripcion = 'Integración de inmigrantes';
            $taller2->dia_semana = 'M';
            $taller2->hora_inicio = '12:00';
            $taller2->hora_fin = '14:00';
            $taller2->cupo_maximo = 9;
            $taller2->ubicacion_id = $ubicacion2->id;

            if (in_array($taller2->dia_semana, $diasValidosUb2)) {
                $taller2->save();
            }
        }

        if (Ubicacion::where('nombre','Asociación Respira 2')->count()==0)
        {
            //$ubicacion3 = new Ubicacion;

            $ubicacion3 = Ubicacion::create(['nombre'=>'Asociación Respira 2', 'descripcion'=>'Asociación Respira, calle Alfareria 25', 'dias'=>'J,V']);

            $diasValidosUb3 = explode(',', $ubicacion3->dias);

            $taller3 = new Taller;
            $taller3->nombre = 'Formación Laboral';
            $taller3->descripcion = 'Integración al trabajo';
            $taller3->dia_semana = 'J';
            $taller3->hora_inicio = '08:00';
            $taller3->hora_fin = '14:00';
            $taller3->cupo_maximo = 6;
            $taller3->ubicacion_id = $ubicacion3->id;

            if (in_array($taller3->dia_semana, $diasValidosUb3)) {
                $taller3->save();
            }
        }
        
        // crear un taller para una ubicación concreta.
       if (Ubicacion::where('nombre','Asociación Respira 2')->count()==1)
       {
            $ubicacion = Ubicacion::where('nombre', 'Asociación Respira 2')->first();

            $diasValidos = explode(',', $ubicacion->dias);

            $taller = new Taller;
            $taller->nombre = 'Formación Laboral (Jardinería)';
            $taller->descripcion = 'Integración al trabajo';
            $taller->dia_semana = 'V';
            $taller->hora_inicio = '08:00';
            $taller->hora_fin = '14:00';
            $taller->cupo_maximo = 10;
            $taller->ubicacion_id = $ubicacion->id;

            if (in_array($taller->dia_semana, $diasValidos)) {
                $taller->save();
            }
       }

    }
}
