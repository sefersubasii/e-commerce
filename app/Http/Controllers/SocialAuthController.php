<?php

namespace App\Http\Controllers;

use App\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Socialite;

class SocialAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('facebook')
            ->with(['auth_type' => 'rerequest'])
            ->redirect();
    }

    public function callback(Request $request)
    {
        if ($request->has('error')) {
            return redirect('/uye-girisi');
        }

        // when facebook call us a with token
        try {
            $user = Socialite::driver('facebook')->user();
        } catch (\Throwable $th) {
            return redirect('/uye-girisi');
        }

        // check email scope
        if(!isset($user->user["email"])){
            return redirect('/uye-girisi')
                ->with('facebook_email_error', 'Facebook ile giriş yapabilmek için E-Posta adresinize izin vermeniz gerekmektedir.');
        }

        $user->user["email"]      = $user->user["email"];
        $user->user["first_name"] = explode(" ", $user->user["name"])[0];
        $user->user["last_name"]  = @explode(" ", $user->user["name"])[1];

        $getUser = $this->firstOrCreate($user);

        Auth::guard('members')->login($getUser, true);

        if(!auth()->check()){
            return redirect('/uye-girisi');
        }
        
        $member = Member::where('email', $user->user["email"])
            ->select('id', 'name')
            ->first();
        
        Session::put("member", $member);
        
        return redirect('/');
    }

    public function redirectGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callbackGoogle(Request $request)
    {
        if ($request->has('error')) {
            return redirect('/uye-girisi');
        }

        $user = Socialite::driver('google')->user();

        $user->user["first_name"] = $user->user["given_name"];
        $user->user["last_name"]  = $user->user["family_name"];

        $getUser                = $this->firstOrCreate($user);
        
        Auth::guard('members')->login($getUser, true);

        if(!auth()->check()){
            return redirect('/uye-girisi');
        }

        $member = Member::where('email', $user->email)
            ->select('id', 'name')
            ->first();

        Session::put("member", $member);

        return redirect('/');
    }

    public function firstOrCreate($user)
    {
        $checkUser = Member::where('email', $user->user['email'])->first();

        if (is_null($checkUser)) {
            // register user
            $checkUser = Member::create([
                "name"     => $user->user['first_name'],
                "surname"  => $user->user['last_name'],
                "email"    => $user->user['email'],
                "password" => bcrypt(str_random(8)),
                "group_id" => 2,
                "status"   => 1,
            ]);
        }

        return $checkUser;
    }
}
