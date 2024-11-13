<?php

namespace Database\Seeders;

use App\Models\State;
use GuzzleHttp\Client;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        State::truncate();
        Schema::enableForeignKeyConstraints();

        // States Array
        $states = array(
            'Alaska' => 'AK',
            'Alabama' => 'AL',
            'Arkansas' => 'AR',
            'Arizona' => 'AZ',
            'California' => 'CA',
            'Colorado' => 'CO',
            'Connecticut' => 'CT',
            'District of Columbia ' => 'DC',
            'Delaware' => 'DE',
            'Florida' => 'FL',
            'Georgia' => 'GA',
            'Hawaii' => 'HI',
            'Iowa' => 'IA',
            'Idaho' => 'ID',
            'Illinois' => 'IL',
            'Indiana' => 'IN',
            'Kansas' => 'KS',
            'Kentucky' => 'KY',
            'Louisiana' => 'LA',
            'Massachusetts' => 'MA',
            'Maryland' => 'MD',
            'Maine' => 'ME',
            'Michigan' => 'MI',
            'Minnesota' => 'MN',
            'Missouri' => 'MO',
            'Mississippi' => 'MS',
            'Montana' => 'MT',
            'North Carolina' => 'NC',
            'North Dakota' => 'ND',
            'Nebraska' => 'NE',
            'New Hampshire' => 'NH',
            'New Jersey' => 'NJ',
            'New Mexico' => 'NM',
            'Nevada' => 'NV',
            'New York' => 'NY',
            'Ohio' => 'OH',
            'Oklahoma' => 'OK',
            'Oregon' => 'OR',
            'Pennsylvania' => 'PA',
            'Rhode Island' => 'RI',
            'South Carolina' => 'SC',
            'South Dakota' => 'SD',
            'Tennessee' => 'TN',
            'Texas' => 'TX',
            'Utah' => 'UT',
            'Virginia' => 'VA',
            'Vermont' => 'VT',
            'Washington' => 'WA',
            'Wisconsin' => 'WI',
            'West Virginia' => 'WV',
            'Wyoming' => 'WY',
            'Guam' => 'GY',
            'Puerto Rico' => 'PR',
            'Virgin Islands' => 'VUV',
        );

        $client = new Client();

        foreach ($states as $state => $abv) {
            // Insert the state into the states table and get the state ID
            $stateId = DB::table('states')->insertGetId([
                'name' => $state,
            ]);

            // Make a request to get cities for each state
            $response = $client->post('https://countriesnow.space/api/v0.1/countries/states', [
                'json' => [
                    'country' => 'United States',
                    'state' => $state
                ]
            ]);

            // Decode the response and check if the cities data is valid
            $responseBody = json_decode($response->getBody()->getContents(), true);
            
            if (isset($responseBody['data']) && is_array($responseBody['data'])) {
                $cities = $responseBody['data'];

                // Insert cities into the cities table
                foreach ($cities as $city) {
                    if (is_string($city)) {  // Ensure that city is a string
                        DB::table('cities')->insert([
                            'name' => $city,
                            'state_id' => $stateId,
                        ]);
                    }
                }
            } else {
                // Log or handle the case where the cities data is not valid
                error_log("No valid cities data for state: " . $state);
            }
        }
    }
}
