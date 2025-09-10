<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Jobs\SendDailyReminderEmail;
use App\Models\Client;

class Kernel extends ConsoleKernel
{
    /**
     * Agendamento de tarefas do sistema.
     * Aqui é feito o envio diário de lembretes para todos os clientes elegíveis.
     */
    protected function schedule(Schedule $schedule)
    {
        // Envia lembrete diário para todos os clientes
        $schedule->call(function () {
            $clients = Client::all();
            foreach ($clients as $client) {
                dispatch(new SendDailyReminderEmail($client));
            }
        })->daily();
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}
