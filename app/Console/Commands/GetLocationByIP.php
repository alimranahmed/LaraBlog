<?php

namespace App\Console\Commands;

use App\Models\Address;
use App\Services\GeoIp\GeoIp;
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
    protected $description = 'Fetch geo location by ip';

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
        $geoIp = app(GeoIp::class);

        $addresses = Address::where('country_name', null)->get();

        $this->info("Fetching location of " . $addresses->count() . " addresses");

        foreach ($addresses as $index => $address) {
            $ip = $address->ip;
            $location = $geoIp->getGeo($ip);

            $this->info(
                ($index + 1) . "/" . $addresses->count() . " {$ip} => Country: " . ($location->country_name ?? '')
            );

            if (!empty($location)) {
                $address->update([
                    'country_code' => $location->country_code,
                    'country_name' => $location->country_name,
                    'region_name' => $location->region_name,
                    'city' => $location->city ?? '',
                    'zip_code' => $location->zip ?? '',
                    'extra' => $location->extray ?? '',
                    'timezone' => $location->time_zone ?? '',
                    'latitude' => $location->latitude ?? '',
                    'longitude' => $location->longitude ?? '',
                    'metro_code' => $location->metro_code ?? '',
                ]);
            }
        }

        $this->info('Done!');
    }
}
