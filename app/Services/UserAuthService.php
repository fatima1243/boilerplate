<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Card;
use App\Models\User;
use App\Mail\OTPMail;
use App\Mail\CustomEmail;
use App\Jobs\SendEmailJob;
use App\Utilities\Constants;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Repositories\UserAuthRepository;

use function App\Helpers\storeBase64Image;
use function App\Helpers\storeFiles;

class UserAuthService
{
    private $userAuthRepository;

    public function __construct(UserAuthRepository $userAuthRepository)
    {
        $this->userAuthRepository = $userAuthRepository;
    }

    public function driverRegister($request)
    {
        $user = $this->userAuthRepository->createUser($request);
        $this->userAuthRepository->createVehicle($user->id, $request->all());
        $this->uploadLegalDocuments($user->id, $request->all());
        return $user;
    }

    public function uploadLegalDocuments($userId, $data)
    {
        $data['cnic_front'] = storeBase64Image($data['cnic_front'],'legal_documents/cnic_front');
        $data['cnic_back'] = storeBase64Image($data['cnic_back'],'legal_documents/cnic_back');
        $data['driving_license'] = storeBase64Image( $data['driving_license'],'legal_documents/driving_license');
        $data['vehicle_insurance'] = storeBase64Image($data['vehicle_insurance'],'legal_documents/vehicle_insurance');
        $data['driver_id'] = $userId;
        return $this->userAuthRepository->createLegalDocuments($data);
    }

}