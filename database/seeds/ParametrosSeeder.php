<?php

use App\Models\Parametros;
use Illuminate\Database\Seeder;

class ParametrosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tablas = array(
            ['codigo' => 'P_OGE', 'descripcion' => 'Director de OGE', 'activo' => '1'],
            ['codigo' => 'P_SGE', 'descripcion' => 'Director de SGE', 'activo' => '1']
        );
        foreach($tablas as $t){
            Parametros::create($t);
        }
    }
}
