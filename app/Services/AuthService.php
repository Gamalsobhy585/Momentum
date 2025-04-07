<?php

namespace app\Services;


use app\Repositories\Interface\IUser;

use app\Traits\ResponseTrait;
use app\Http\Resources\UserResource;
use app\Services\Interface\IAuthService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class AuthService implements IAuthService
{
    use  ResponseTrait;

    private IUser $userRepo;

    public function __construct(  IUser $user)
    {
        $this->userRepo = $user;
    }

    public function register($request)
    {
        try {
            DB::beginTransaction();
          
            $user = [
                "name" => $request->name,
                "email" => $request->email,
                "password" => Hash::make($request->password),
            ];
            $storedUser = $this->userRepo->store($user);
           
            DB::commit();
            return $storedUser;
        } catch (\Exception $e) {
            echo $e->getMessage();
            DB::rollBack();
        }
    }

    public function login($request)
    {
        $user = $this->userRepo->getByEmail($request->email);
        if (!$user) {
            $this->returnError(__('messages.login.invalid_credentials'), 401);
        }

        if (!Hash::check($request->password, $user->password)) {
            $this->returnError(__('messages.login.invalid_credentials'), 401);
        }
        $this->userRepo->update($user);

        $token = $user->createToken('default_token');
        $user->token = $token->plainTextToken;

       

        return $this->returnData(
            __('messages.login.success'),
            200,
            [
                'token' => $user->token,
                'user_data' => new UserResource($user),
            ]);
    }



    public function logout($request)
    {
        $user = $request->user();
        if ($user) {
            $user->currentAccessToken()->delete();
            return true;
        }
        return false;
    }

 
    public function updateoldPassword($email, $oldPassword, $newPassword)
    {
        $user = $this->userRepo->getByEmail($email);
        if (!$user)
            $this->returnError(__('messages.renew.user_not_found'), 404);

        if (!Hash::check($oldPassword, $user->password))
            $this->returnError(__('messages.renew.failed'), 401);

        $user->password = Hash::make($newPassword);
        $user->save();

        return $this->success(__('messages.renew.success'), 200);
    }



}



