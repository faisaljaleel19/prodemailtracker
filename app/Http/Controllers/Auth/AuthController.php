<?php

namespace App\Http\Controllers\Auth;

use App\Models\LoginLogs;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use App\Models\User;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login()
    {
        redirect('/');
    }

    public function redirectToMS()
    {
        return Socialite::driver('azure')->redirect();
    }

    public function handleMSCallback()
    {
        $user = Socialite::driver('azure')->stateless()->user();
        //dd($user->user);
        $localuser = User::where('email', $user->user['mail'])->first();
        $save_log = LoginLogs::create([
            'name' => $user->name,
            'email' => $user->email,
            'microsoft_id' => $user->id
        ]);
        $save_log->save();
        if(!$localuser)
        {
            $user_values = [
                'name' => $user->name,
                'email' => $user->email,
                'password' => '',
                'microsoft_id' => $user->id,
            ];
            $job_title = $user->user['jobTitle'];
            if(($job_title === 'Senior Executive - Order Management Services') || ($job_title === 'Operations - Executive') || ($job_title === 'Sr. Operations Executive') || ($job_title === 'Operations Executive'))
            {
                $addUser = User::create($user_values);
                Auth::login($addUser);
                $role = 3;
                $role = Role::findById($role);
                $addUser->assignRole($role);
                $role->syncPermissions(['view-dashboard', 'create-tracker', 'upload-tracker', 'view-tracker', 'send-activation-mail']);
            }
            elseif(($job_title === 'Assistant Manager Customer Happiness') || ($job_title === 'Manager - Customer Happiness'))
            {
                $addUser = User::create($user_values);
                Auth::login($addUser);
                $role = 2;
                $role = Role::findById($role);
                $addUser->assignRole($role);
                $role->syncPermissions(['view-dashboard', 'view-tracker']);
            }
            elseif(($job_title === 'Head of IT') || ($job_title === 'Sr. Web Developer') || ($job_title === 'Web Developer'))
            {
                $addUser = User::create($user_values);
                Auth::login($addUser);
                $role = 1;
                $role = Role::findById($role);
                $addUser->assignRole($role);
                $role->syncPermissions(['create-users', 'edit-users', 'delete-users', 'view-dashboard', 'create-tracker', 'upload-tracker', 'view-tracker', 'send-activation-mail']);
            }
            else
            {
                return redirect()->route('forbidden');
            }
            return redirect()->route('dashboard');
        }
        else
        {
            $updateUser = User::where('email', $user->user['mail'])->update(['updated_at' => Carbon::now('Asia/Dubai')]);
            $getUser = User::where('email', $user->user['mail'])->first();
            if($updateUser)
            {
                Auth::login($getUser);
                return redirect()->route('dashboard');
            }
        }
        return redirect('/');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('https://login.microsoftonline.com/common/oauth2/v2.0/logout');
    }

    public function forbidden()
    {
        return view('admin/forbidden');
    }
}
