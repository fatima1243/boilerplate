<?php

namespace App\Repositories;

use App\Models\City;
use App\Models\Driver;
use App\Models\LegalDocument;
use App\Models\Otp;
use App\Models\State;
use App\Models\User;
use App\Models\UserDevice;
use App\Models\UserMeta;
use App\Models\Vehicle;
use App\Models\WorkingHour;
use App\Services\StripeService;
use App\Utilities\Constants;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use PHPUnit\TextUI\XmlConfiguration\Constant;

use function App\Helpers\storeBase64Image;
use function App\Helpers\storeFiles;

class UserAuthRepository
{

    public function createUser($request)
    {
        $driverData = [
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'slug' => Str::slug($request->first_name . $request->last_name, '-') . '-' . Str::random(5),
            'email' => $request->email,
            'contact_no' => $request->input('contact_no'),
            'address' => $request->input('address'),
            'role' => $request->role,
            'city_id' => $request->city_id,
            'state_id' => $request->state_id,
            // 'email_verified_at' => now(),
            'social_login_id' => $request->social_login_id ?? null,
            'social_network' => $request->social_network ?? null,
        ];

        // If a password is provided, hash it and add it to the user data
        if ($request->has('password')) {
            $driverData['password'] = bcrypt($request->input('password'));
        }
        // if ($request->role != Constant::USER_ROLE['pro']) {
        //     $userData['account_status'] = 1;
        //     $userData['admin_approved'] = 1;
        // }

        $driver = Driver::create($driverData);
        $driver->save();


        // $strip_user = $this->stripeService->createStripeUser($user);

        // $user->userMeta()->create([
        //     'is_email_notification' => true,
        //     'is_push_notification' => true,
        //     // 'stripe_id' => $strip_user['id'],
        //     'driving_experience' => $request->input('drivingExperience') ?? 0,
        // ]);

        return $driver;
    }

    public function createVehicle($id, $input)
    {
        if ($input['vehicle_insurance']) {
            $file = storeBase64Image($input['vehicle_insurance'],'driver/legal-document', );
        }
        $vehicle = Vehicle::create([
            'driver_id' => $id,
            'vehicle_insurance' => $file,
            'vehicle_type' => $input['vehicleType'],
            'vehicle_make_model' => $input['vehicleMakeModel'],
            'year_of_production' => $input['yearOfProduction'],
            'vehicle_color' => $input['vehicleColor'],
            'vehicle_plates' => $input['vehiclePlates'],
            'traffic_accidents' => $input['trafficAccidents'] == true ? 1 : 0,
        ]);

        return $vehicle;
    }

    public function createLegalDocuments(array $data)
    {
        return LegalDocument::create($data);
    }

}