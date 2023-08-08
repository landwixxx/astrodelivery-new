<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Database\Seeders\OrderStatusSeeder;
use Database\Seeders\RolesAndPermissionsSeeder;

class RunMigrations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run-migrations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run the migrations, seeders permissions, seeders';

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
        $this->call('migrate:fresh');
        $this->call('db:seed', ['--class' => RolesAndPermissionsSeeder::class]);
        $this->call('db:seed', ['--class' => OrderStatusSeeder::class]);
    }
}
