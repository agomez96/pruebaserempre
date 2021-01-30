<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use App\VerifyUser;
use App\Mail\VerifyMail;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
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
    protected $redirectTo = RouteServiceProvider::HOME;

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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $verifyUser = VerifyUser::create([
            'user_id' => $user->id,
            'token' => Str::random(40)
        ]);

        Mail::to($user->email)->send(new VerifyMail($user));
        return $user;
    }

    public function verifyUser($token)
    {
        $verifyUser = VerifyUser::where('token', $token)->first();
        if(isset($verifyUser) ){
            $user = $verifyUser->user;
            if(isset($user->verified) ){
                if(!$user->verified) {
                    return view("auth.passwords.change")->withMensaje("Para verificar tu cuenta, es necesario que cambies tu contraseña.")->withToken($token);
                }else{
                    $status = "Tu e-mail ya esta verificado. Inicia sesion.";
                }
            }else{
                return redirect('/login')->with('warning', "Tu e-mail no pudo ser verificado.");
            }
            
        }else{
            return redirect('/login')->with('warning', "Tu e-mail no pudo ser verificado.");
        }

        return redirect('/login')->with('status', $status);
    }

    public function verifyUserT(Request $request)
    {
        $verifyUser = VerifyUser::where('token', $request->token)->first();
        if(isset($verifyUser) ){
        $this->validate(request(), [
            'password' => 'confirmed|min:8',
        ], [
            'password.min' => 'La contraseña debe tener minimo 8 caracteres!',
            'password.confirmed' => 'Las contraseñas no concuerdan!'
        ]);
        $user = $verifyUser->user;
        $verifyUser->user->verified = 1;
        $verifyUser->user->password = Hash::make($request->password);
        $verifyUser->user->save();
        $status = "Tu e-mail fue verificado exitosamente. Ya puedes iniciar sesion.";
        }else{
            return redirect('/login')->with('warning', "Tu e-mail no pudo ser verificado,intenta nuevamente.");    
        }  
        return redirect('/login')->with('status', $status);
    }

    protected function registered(Request $request, $user)
    {
        $this->guard()->logout();
        return redirect('/login')->with('status', 'Necesitamos verificar tu correo. Revisa tu correo y da click para verificarlo.');
    }
}
