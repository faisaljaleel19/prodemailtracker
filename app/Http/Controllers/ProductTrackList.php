<?php

namespace App\Http\Controllers;

use App\Imports\TrackUpload;
use App\Models\OrderActivationTrack;
use App\Models\OrderTrackBatch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class ProductTrackList extends Controller
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
        return view('admin/product_track_list');
    }

    public function list_product_track()
    {
        $model = OrderActivationTrack::query();

        return DataTables::of($model)
            ->addColumn('order_punched_date', function($row){
                return date("F j, Y", strtotime($row->order_punched_date));
            })
            ->addColumn('order_confirmed_date', function($row){
                return date("F j, Y", strtotime($row->order_confirmed_date));
            })
            ->addColumn('created_at', function($row){
                $date = date("F j, Y, g:i a", strtotime($row->created_at));
                return $date;
            })
            ->toJson();
    }

    public function getAllTrackers(Request $request)
    {
        $model = OrderActivationTrack::query();

        return DataTables::of($model)
            ->addColumn('order_punched_date', function($row){
                return date("F j, Y", strtotime($row->order_punched_date));
            })
            ->addColumn('order_confirmed_date', function($row){
                return date("F j, Y", strtotime($row->order_confirmed_date));
            })
            ->addColumn('created_at', function($row){
                $date = date("F j, Y, g:i a", strtotime($row->created_at));
                return $date;
            })
            ->toJson();
    }

    public function filter(Request $request)
    {
        $query = OrderActivationTrack::query();
        if($request->filled('order_no'))
        {
            $order_no = $request->order_no;
            $query->where('order_number', '=', $order_no);
        }
        if($request->filled('from_date'))
        {
            $from_date = $request->from_date;
            $query->whereDate('created_at', '>=', $from_date);
        }
        if($request->filled('to_date'))
        {
            $to_date = $request->to_date;
            $query->whereDate('created_at', '<=', $to_date);
        }

        $model = $query->get();
        return DataTables::of($model)
            ->addIndexColumn()
            ->addColumn('created_at', function($row){
                $date = date("F j, Y, g:i a", strtotime($row->created_at));
                return $date;
            })
            ->toJson();
    }

    public function get_tracker(Request $request)
    {
        $tracker_id = $request->tracker_id;
        $order_tracker = OrderActivationTrack::find($tracker_id);
        $data = [
            "status" => true,
            "data" => $order_tracker,
        ];
        return response()->json($data);
    }

    public function update_tracker(Request $request)
    {
        $tracker_id = $request->tracker_id;
        $order_punched_date = $request->order_punched_date;
        $order_confirmed_date = $request->order_confirmed_date;
        $student_name = $request->student_name;
        $primary_email = $request->primary_email;
        $primary_mobile_no = $request->primary_mobile_no;
        $siblings = $request->siblings;
        $oh_number = $request->oh_number;
        $category = $request->category;

        $order_tracker = OrderActivationTrack::find($tracker_id);

        $order_tracker->order_punched_date = $order_punched_date;
        $order_tracker->order_confirmed_date = $order_confirmed_date;
        $order_tracker->student_name = $student_name;
        $order_tracker->primary_email_id = $primary_email;
        $order_tracker->primary_mobile_no = $primary_mobile_no;
        $order_tracker->siblings = $siblings;
        $order_tracker->oh_number = $oh_number;
        $order_tracker->category = $category;

        $update_status = $order_tracker->save();

        $data = [
            "status" => $update_status,
        ];
        return response()->json($data);
    }

    function get_product_categories()
    {
        $product_category = DB::table('product_category')->get();
        $res = [
            'status' => true,
            'data' => $product_category
        ];
        return response()->json($res);
    }
}
