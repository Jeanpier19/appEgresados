<?php

namespace App\Console\Commands;

use App\Convenio;
use App\Entidad;
use App\Mail\ConveniosPorFinalizar;
use Carbon\Carbon;
use Carbon\Traits\Creator;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class VerificarConvenios extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'convenios:verificar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verificar que convenios están por finalizar (<30 dias antes de la fecha de vencimiento) y enviar un correo electrónico';

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
        $convenios = Convenio::where('estado','VIGENTE')
            ->join('tipo_convenio','convenios.tipo_convenio_id','tipo_convenio.id')
            ->select('convenios.*','tipo_convenio.descripcion as tipo_convenio')
            ->get();
        $hoy = Carbon::now();
        foreach ($convenios as $convenio){
            $fecha_vencimiento = new Carbon($convenio->fecha_vencimiento);
            $dias_restantes = $hoy->diffInDays($fecha_vencimiento);
            if($hoy < $fecha_vencimiento){
                $convenio->update(['dias_restantes'=>$dias_restantes]);
                if($dias_restantes <= 30){
                    $entidad = Entidad::find($convenio->entidad_id);
                    if($entidad->correo){
                        $subject = 'Convenio por finalizar';
                        $mailer = new ConveniosPorFinalizar($entidad->correo, $subject, $convenio, $entidad);
                        Mail::send($mailer);
                    }
                }
            }else{
                $convenio->update(['dias_restantes'=>-$dias_restantes,'estado'=>'NO VIGENTE']);
            }
        }
    }
}
