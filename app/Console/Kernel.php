<?php
/**
 * Console Kernel
 *
 * Define o agendamento diário para envio de lembretes a clientes com saldo
 * suficiente para o prêmio de maior valor.
 */

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Jobs\SendDailyReminderEmail;
use App\Models\Client;
use App\Models\Reward;

class Kernel extends ConsoleKernel
{
    /**
     * Agendamento de tarefas do sistema.
     * Aqui é feito o envio diário de lembretes para todos os clientes elegíveis.
     */
    protected function schedule(Schedule $schedule)
    {
        // Envia lembrete diário APENAS para clientes com saldo >= prêmio de maior valor
        $schedule->call(function () {
            $maxRequired = Reward::max('points_required');
            if (!$maxRequired) {
                return; // Sem prêmios cadastrados
            }
            Client::chunk(200, function ($clients) use ($maxRequired) {
                foreach ($clients as $client) {
                    $balance = optional($client->points()->first())->amount ?? 0;
                    if ($balance >= $maxRequired) {
                        dispatch(new SendDailyReminderEmail($client));
                    }
                }
            });
        })->daily();
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}
