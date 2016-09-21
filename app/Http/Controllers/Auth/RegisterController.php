<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\confirmation_code;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;

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
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

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
        $rules = [
          'email' => 'required|numeric|unique:users',
          'password' => 'required|min:4|confirmed',
          'name' => 'required|max:255',
        ];
        $attribute = [
          'email' => '學號',
          'password' => '密碼',
          'name' => 'Name',
        ];

        $validator = Validator::make($data, $rules);
        $validator->setAttributeNames($attribute);

        return $validator;
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data, $code)
    {
        Confirmation_code::where('code', $code)->delete();

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'] . '@ntunhs.edu.tw',
            'password' => bcrypt($data['password']),
            'department' => $data['department'],
        ]);
    }
}
