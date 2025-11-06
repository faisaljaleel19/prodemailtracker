<?php

namespace App\Http\Controllers;

use App\Models\OrderActivationTrack;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class HomeController extends Controller
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
        $trackers = OrderActivationTrack::all();
        $countTrackers = count($trackers);
        return view('admin/home', compact('countTrackers'));
    }

    public function get_all_months()
    {
        $all_months = [];
        for($i=1; $i<= 12; $i++) {
            $all_months[] = count(OrderActivationTrack::whereMonth('created_at', $i)->get());
            $all_months_activated[] = count(OrderActivationTrack::whereMonth('created_at', $i)->where('activation_status', 'Activated')->get());
            $all_months_mail_sent[] = count(OrderActivationTrack::whereMonth('created_at', $i)->where('mail_sent', 'Yes')->get());
        }
        $total_trackers = count(OrderActivationTrack::all());
        $total_trackers_activated = count(OrderActivationTrack::where('activation_status', 'Activated')->get());
        $total_trackers_not_activated = count(OrderActivationTrack::whereNot('activation_status', 'Activated')->get());
        $data = [
            "all_months" => $all_months,
            "all_months_activated" => $all_months_activated,
            "all_months_mail_sent" => $all_months_mail_sent,
            "total_trackers" => $total_trackers,
            "total_trackers_activated" => $total_trackers_activated,
            "total_trackers_not_activated" => $total_trackers_not_activated
        ];

        return response()->json($data);
    }
}
