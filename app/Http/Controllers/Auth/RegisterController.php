<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Associate;
use App\Models\User;
use Exception;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'type' => ['required', 'in:legal,physical'],
            'document' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        DB::beginTransaction();
        try {
            $associate = new Associate();
            $associate->uuid                    = Str::uuid()->toString();
            $associate->type                    = $data['type'];
            $associate->document                = $data['document'];
            $associate->corporate_name          = $data['company_name'] ?? null;
            $associate->fantasy_name            = $data['company_name'] ?? null;
            $associate->responsible_first_name  = $data['responsible_name'] ?? null;
            $associate->first_name              = $data['first_name'] ?? null;
            $associate->last_name               = $data['last_name'] ?? null;
            $associate->email                   = $data['email'] ?? null;
            $associate->save();

            $user = User::create([
                'associate_id'  => $associate->id,
                'uuid'          => Str::uuid()->toString(),
                'name'          => $data['type'] == 'legal' ? $data['responsible_name'] : $data['first_name'] . " " . $data['last_name'],
                'email'         => $data['email'],
                'password'      => Hash::make($data['password']),
            ]);
            DB::commit();
            return $user;
        } catch (Exception $ex) {
            DB::rollback();
            throw $ex;
        }
    }
}
