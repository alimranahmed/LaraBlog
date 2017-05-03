<?php

namespace App\Console\Commands;

use App\Helpers\HttpClient;
use App\Models\Address;
use Illuminate\Console\Command;

class GetLocationByIP extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get-ip-location';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $httpClient = new HttpClient();
        $addresses = Address::where('country_name', null)->get();
        foreach ($addresses as $address){
            $ip = $address->ip;
            $response = $httpClient->send("http://freegeoip.net/json/$ip");
            $location = json_decode($response->body);
            if(!empty($location)){
                $address->update([
                    'country_code' => $location->country_code,
                    'country_name' => $location->country_name,
                    'region_name' => $location->region_name,
                    'city' => $location->city,
                    'zip_code' => $location->zip_code,
                    'extra' => isset($location->extray) ? $location->extra : '',
                    'timezone' => $location->time_zone,
                    'latitude' => $location->latitude,
                    'longitude' => $location->longitude,
                    'metro_code' => $location->metro_code,
                ]);
            }
        }
    }
}
