<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Habitacion;

class LimpiezaCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'limpieza:iniciar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cambia el estado de la limpieza a cero cada día.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()    {
      $habitaciones = Habitacion::get();
      foreach ($habitaciones as $habitacion) {
        $habitacion->limpieza = 1;
        $habitacion->update();
      }
    }
}
