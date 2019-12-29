<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class everyFiveMinitue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:deleteDoctor';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will clean record in every 5 minitue compare with TTL value';

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
     * @return mixed
     */
    public function handle()
    {
        DB::table('doctors')->delete();
        //DB::table('doctors')->where('TTL', '<', Carbon::now()->subSeconds(10))->delete();
    }
}
