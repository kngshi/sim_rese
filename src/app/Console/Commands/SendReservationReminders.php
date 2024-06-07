<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Reservation;
use App\Notifications\ReservationReminder;
use Carbon\Carbon;

class SendReservationReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:reservation-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reservation reminders for today\'s reservations';

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
        $today = Carbon::today()->toDateString();

        $reservations = Reservation::whereDate('date', $today)->get();

        foreach ($reservations as $reservation) {
            $reservation->user->notify(new ReservationReminder($reservation));
        }

        $this->info('Reservation reminders have been sent.');
    }
}
