<?php

namespace App\Http\Controllers;

use App\Imports\TrackUpload;
use App\Mail\ProductActivation;
use App\Mail\send_tracker;
use App\Models\OrderActivationTrack;
use App\Models\OrderTrackBatch;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class UploadTrackerController extends Controller
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
        return view('admin/upload_tracker');
    }

    public function upload_track(Request $request): \Illuminate\Http\RedirectResponse
    {
        request()->validate([
            'track_file' => 'required|mimes:xlsx,xls'
        ]);

        $batch_no = Str::random(10); // or any other method to generate a unique batch number

        $track_file = $request->file('track_file');
        // Import the tracks from the file using the ToModel importer
        $import = new TrackUpload($batch_no); // pass the batch number to the import class constructor
        try {
            Excel::import($import, $track_file);
            OrderTrackBatch::create([
                'batch_no' => $batch_no,
                'uploaded_by' => auth()->user()->name
            ]);
            return back()->with('success', 'Tracker Imported Successfully');
        }
        catch(\Exception $e){
            return back()->withErrors('Error occurred: '.$e->getMessage());
        }
    }

    public function list_batch_trackers()
    {
        $model = OrderTrackBatch::query();

        return DataTables::of($model)
            ->addColumn('action', function($row){
                //$btn = '<button class="btn btn-info btn-sm edit" data-eid="'.$row->id.'"><i class="fa fa-edit"></i></button>';
                return '<button class="btn btn-danger btn-sm delete" data-batch="'.$row->batch_no.'"><i class="fa fa-trash"></i></button>';
            })
            ->addColumn('created_at', function($row){
                $date = date("F j, Y, g:i a", strtotime($row->created_at));
                return $date;
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    public function batch_delete(Request $request)
    {
        $delete_batch = OrderTrackBatch::where('batch_no', $request->input('batch_no'));
        $delete_tracker = OrderActivationTrack::where('batch_no', $request->input('batch_no'));
//        dd($delete_batch);
        if($delete_tracker->delete())
        {
            if($delete_batch->delete())
            {
                return response()->json(['status' => true, 'batch_deleted' => $delete_batch]);
            }
            else
            {
                return response()->json(['status' => false, 'batch_deleted' => $delete_batch]);
            }
        }
        else
        {
            return response()->json(['status' => false, 'batch_deleted' => $delete_batch]);
        }
    }

    public function send_track_email()
    {
        Mail::to('faisal.zalil@moreideas.ae')->send(new ProductActivation());

        return redirect()->route('upload_tracker');
    }
}
