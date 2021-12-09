<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\User;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Validator;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
     */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = 'admin';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
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
            'name'     => 'required|max:255',
            'email'    => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    /**
     * Authentication
     *
     * @param AuthRequest $request
     * @return void
     */
    protected function login(AuthRequest $request)
    {
        if (!$this->verifyGoogleReCaptcha()) {
            return redirect()
                ->back()
                ->withInput()
                ->with('recaptchaVerifyError', 'reCaptcha kodu Google tarafından doğrulanamadı!');
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->intended('admin');
        }

        return redirect()
            ->back()
            ->withInput()
            ->with('authError', 'Lütfen geçerli bir E-Posta ve Şifre girin!');
    }

    /**
     * Google reCaptcha Verify (only production)
     *
     * @return bool
     */
    protected function verifyGoogleReCaptcha()
    {
        if (env('APP_ENV') == 'local') {
            return true;
        }

        $response = request('g-recaptcha-response');
        $secret   = '6LfpwL0UAAAAABXS6NwrbCrTSdCzAeAXWwJL9LON';
        $remoteip = request()->ip();

        $verifyUrlWithParams = "https://www.google.com/recaptcha/api/siteverify?" . http_build_query([
            'secret'   => $secret,
            'response' => $response,
            'remoteip' => $remoteip,
        ]);

        try {
            $ch = curl_init($verifyUrlWithParams);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);

            $verify = @json_decode($response);
        } catch (\Throwable $th) {
            throw $th;
        }

        return (isset($verify->success) && $verify->success === true);
    }
}
