<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class Users extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            abort_if(! Auth::user()->status, 403, 'You are not authorized user.');

            return $next($request);
        });
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('admin/users');
    }

    public function add_user(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email:rfc,dns',
            'password' => 'required|size:8',
        ]);

        $user = new User([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password'))
        ]);

        if($user->save()) {
            return redirect()->route('users')->with('success', 'User Added Successfully');
        }
        else
        {
            return redirect()->route('users')->with('error', 'Error Occurred While adding user');
        }
    }

    public function list_users()
    {
        $data = User::all();
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('created_at', function($row){
                $date = date("F j, Y, g:i a", strtotime($row->created_at));
                return $date;
            })
            ->addColumn('action', function($row){
                if($row->status)
                {
                    $btn = '<div class="form-check form-switch">
                              <input class="form-check-input" type="checkbox" role="switch" id="statusSwitch" name="statusSwitch" data-user-id="'.$row->id.'" checked onchange="change_status(this)">
                            </div>';
                }
                else
                {
                    $btn = '<div class="form-check form-switch">
                              <input class="form-check-input" type="checkbox" role="switch" id="statusSwitch" name="statusSwitch" data-user-id="'.$row->id.'" onchange="change_status(this)">
                            </div>';
                }
                return $btn;
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    public function user_status_change(Request $req)
    {
        $user_id = $req->input('user_id');
        $status = $req->input('status');
        $userdata = User::find($user_id);
        $userdata->status = $status;
        if($userdata->save())
        {
            return response()->json(['status' => true]);
        }
        else
        {
            return response()->json(['status' => false]);
        }
    }
}
