<?php

namespace App\Console\Commands;

use App\Encuesta;
use Carbon\Carbon;
use Carbon\Traits\Creator;
use Illuminate\Console\Command;

class CerrarEncuesta extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'encuesta:cerrar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verificar la fecha de vencimiento de una encuesta activa y cerrar en caso ya haya llegado la fecha';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $encuesta = Encuesta::where('estado', 1)->first();
        $hoy = Carbon::now();
        $fecha_vencimiento = new Carbon($encuesta->fecha_vence);
        if ($fecha_vencimiento <= $hoy) {
            $encuesta->update(['estado' => 0]);
        }
    }
}
