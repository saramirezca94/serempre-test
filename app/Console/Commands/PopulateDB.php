<?php

namespace App\Console\Commands;

use App\Models\City;
use App\Models\User;
use App\Models\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;

class PopulateDB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:populate-db';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will populate the DB with predefined data from clients and cities';

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
        // Will run the migrations
        
        Artisan::call('migrate');
        
        //insert the admin user

        $admin = new User();
        $admin->name = 'admin';
        $admin->email = 'admin@email.com';
        $admin->email_verified_at = now();
        $admin->password = Hash::make('admin1234');
        $admin->save();
        
        //predefined cities are inserted

        $cities = ['Manizales', 'Medellín', 'Bogotá'];

        foreach ($cities as $city) {
            
            $newCity = new City();
            $newCity->name = $city;
            $newCity->save();

        }

        //predefined clients are inserted

        $clients = ['directv', 'poker', 'BBC'];

        foreach ($clients as $client) {
            
            $newClient = new Client();
            $newClient->name = $client;
            $newClient->city_id = City::all()->random(1)->first()->id;
            $newClient->save();

        }

        echo("Insert was success");

    }
}
