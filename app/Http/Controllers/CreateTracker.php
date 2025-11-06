<?php

namespace App\Http\Controllers;

use App\Enums\Countries;
use App\Imports\TrackUpload;
use App\Models\OrderActivationTrack;
use App\Models\OrderTrackBatch;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Maatwebsite\Excel\Facades\Excel;
use Propaganistas\LaravelPhone\PhoneNumber;
use Yajra\DataTables\Facades\DataTables;

class CreateTracker extends Controller
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
        $category = DB::table('product_category')->get();
        $syllabus = DB::table('syllabus')->get();
        $activation_status = DB::table('order_activation_status')->get();
        return view('admin/create_tracker', compact('category', 'syllabus', 'activation_status'));
    }

    public function add_tracker(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'order_number' => Rule::unique('order_activation_tracks')->where(fn (Builder $query) => $query->where('siblings', "=","No")),
            'order_punched_date' => 'required',
            'order_confirmed_date' => 'required',
            'student_name' => 'required',
            'primary_email_id' => 'required|email:rfc,dns',
            'primary_mobile_no_full' => 'required',
            'country' => [new Enum(Countries::class)],
            'siblings' => 'required'
        ]);

        $country_get = $request->input('country');
        if($country_get === 'United Arab Emirates')
        {
            $country_code = 'AE';
        }
        elseif($country_get === 'Qatar')
        {
            $country_code = 'QA';
        }
        elseif ($country_get === 'Bahrain')
        {
            $country_code = 'BH';
        }
        elseif ($country_get === 'Oman')
        {
            $country_code = 'OM';
        }
        else
        {
            $country_code = 'AE';
        }

        $phone = new PhoneNumber($request->input('primary_mobile_no_full'), $country_code);
        $phone_formatted = $phone->formatE164();

        $tracker = new OrderActivationTrack([
            'order_number' => $request->input('order_number'),
            'order_punched_date' => $request->input('order_punched_date'),
            'order_confirmed_date' => $request->input('order_confirmed_date'),
            'student_name' => $request->input('student_name'),
            'primary_email_id' => $request->input('primary_email_id'),
            'primary_mobile_no' => $phone_formatted,
            'country' => $request->input('country'),
            'oh_number' => $request->input('oh_number'),
            'premium_id' => $request->input('premium_id'),
            'sales_user' => $request->input('sales_user'),
            'lead_details' => $request->input('lead_details'),
            'category' => $request->input('category'),
            'syllabus' => $request->input('syllabus'),
            'siblings' => $request->input('siblings'),
            'activation_status' => $request->input('activation_status'),
            'delivered_marked' => $request->input('delivery_marked'),
            'mail_sent' => "No",
            'task_creation_sent_to_india' => $request->input('task_created_sent_to_india'),
            'remarks' => $request->input('remarks'),
            'created_by' => auth()->user()->name
        ]);

        if($tracker->save()) {
            return redirect()->route('create_tracker')->with('success', 'Tracker Added Successfully');
        }
        else
        {
            return redirect()->route('create_tracker')->with('error', 'Error Occurred While adding tracker');
        }
    }
}
