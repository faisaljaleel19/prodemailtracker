<?php

namespace App\Http\Controllers;

use App\Imports\TrackUpload;
use App\Mail\AakashLiveClass;
use App\Mail\K10StreamingAndK10PlusTablet;
use App\Mail\K10StreamingPlusNeoClass;
use App\Mail\NeoClassOnly;
use App\Models\OrderActivationTrack;
use App\Models\OrderTrackBatch;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Propaganistas\LaravelPhone\PhoneNumber;
use Symfony\Component\Mailer\Exception\TransportException;
use Yajra\DataTables\Facades\DataTables;

class SendActivationEmail extends Controller
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
        return view('admin/send_activation_email');
    }

    public function mail_send_activation(Request $request)
    {
        $all_checked = $request->input('all_checked');
        $template = null;
        $message = '';
        $sent = [];
        $total_selected = count($all_checked);
        foreach($all_checked as $a)
        {
            $getTrackDetails = OrderActivationTrack::find($a);
            $product_category = $getTrackDetails->category;
            $getEmailSubject = DB::table('product_category')->where('product_category_name', '=', $product_category)->get();
            $student_name = $getTrackDetails->student_name;
            $order_number = $getTrackDetails->oh_number;
            $email = $getTrackDetails->primary_email_id;
            $phone_no = $getTrackDetails->primary_mobile_no;
            $country_get = $getTrackDetails->country;
            $modified_phone = $this->format_phone_number($phone_no, $country_get);
            $subject = $getEmailSubject[0]->email_subject_line . ' '.$student_name;
            if(($product_category == 'K10 Streaming') || ($product_category == 'K10 Streaming + Tablet')) {
                //Mail::to($email)->send(new K10StreamingAndK10PlusTablet($subject, $order_number, $student_name, $email, $phone_no));
                $template = new K10StreamingAndK10PlusTablet($subject, $order_number, $student_name, $email, $modified_phone);
            }
            else if($product_category == 'Neo class Only') {
                //Mail::to($email)->send(new NeoClassOnly($subject, $order_number, $student_name, $email, $phone_no));
                $template = new NeoClassOnly($subject, $order_number, $student_name, $email, $modified_phone);
            }
            else if($product_category == 'Aakash Live Class') {
                //Mail::to($email)->send(new NeoClassOnly($subject, $order_number, $student_name, $email, $phone_no));
                $template = new AakashLiveClass($subject, $order_number, $student_name, $email, $modified_phone);
            }
            else if($product_category == 'K10 streaming + Neo class') {
                //Mail::to($email)->send(new NeoClassOnly($subject, $order_number, $student_name, $email, $phone_no));
                $template = new K10StreamingPlusNeoClass($subject, $order_number, $student_name, $email, $modified_phone);
            }
            else {
                //Mail::to($email)->send(new K10StreamingAndK10PlusTablet($subject, $order_number, $student_name, $email, $phone_no));
                $template = new K10StreamingAndK10PlusTablet($subject, $order_number, $student_name, $email, $modified_phone);
            }
            try{
                Mail::to($email)->send($template);
                $sent[] = true;
                $getTrackDetails->mail_sent = "Yes";
                $getTrackDetails->mail_sent_date = Carbon::now('Asia/Dubai')->format('Y-m-d H:i:s');
                $getTrackDetails->save();
            } catch(TransportException $e) {
                $sent[] = false;
                $getTrackDetails->mail_sent = "No";
                $getTrackDetails->save();
                $message = $e;
            }
        }
        $total_sent = count(array_filter($sent));
        if($total_selected == $total_sent)
        {
            $status = true;
        }
        else
        {
            $status = false;
        }
        $data = [
            "status" => $status,
            "message" => $message,
            "total_sent" => $total_sent,
            "total_selected" => $total_selected
        ];
        return response()->json($data);
    }

    public function list_trackers_in_send_email()
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
                return date("F j, Y, g:i a", strtotime($row->created_at));
            })
            ->addColumn('sent_date', function($row){
                if(isset($row->mail_sent_date)) {
                    $date = date("F j, Y, g:i a", strtotime($row->mail_sent_date));
                }
                else
                {
                    $date = 'Not Yet Sent';
                }
                return $date;
            })
            ->toJson();
    }

    public function view_email_template(Request $request)
    {
        $tracker_id = $request->input('tracker_id');
        $getTrackDetails = OrderActivationTrack::find($tracker_id);
        $product_category = $getTrackDetails->category;
        $getEmailSubject = DB::table('product_category')->where('product_category_name', '=', $product_category)->get();
        $student_name = $getTrackDetails->student_name;
        $order_number = $getTrackDetails->oh_number;
        $email = $getTrackDetails->primary_email_id;
        $phone_no = $getTrackDetails->primary_mobile_no;
        $country_get = $getTrackDetails->country;
        $modified_phone = $this->format_phone_number($phone_no, $country_get);
        if(isset($getEmailSubject[0])) {
            $subject = $getEmailSubject[0]->email_subject_line . ' ' . $student_name;
            if (($product_category == 'K10 Streaming') || ($product_category == 'K10 Streaming + Tablet')) {
                return new K10StreamingAndK10PlusTablet($subject, $order_number, $student_name, $email, $modified_phone);
            } else if ($product_category == 'Neo class Only') {
                return new NeoClassOnly($subject, $order_number, $student_name, $email, $modified_phone);
            } else if ($product_category == 'Aakash Live Class') {
                return new AakashLiveClass($subject, $order_number, $student_name, $email, $modified_phone);
            } else if ($product_category == 'K10 streaming + Neo class') {
                return new K10StreamingPlusNeoClass($subject, $order_number, $student_name, $email, $modified_phone);
            } else {
                return new K10StreamingAndK10PlusTablet($subject, $order_number, $student_name, $email, $modified_phone);
            }
        }
        else
        {
            return "<h1 style='text-align: center; padding: 20px; background-color: #EEEEEE'>There is no Email Template for this Product Category</h1>";
        }
    }

    public function removeHyphens($string, $sequence)
    {
        $lastOccurrence = strrpos($string, $sequence);

        if ($lastOccurrence !== false) {
            $modifiedString = substr_replace($string, '', $lastOccurrence, strlen($sequence));
        } else {
            $modifiedString = $string;
        }

        return $modifiedString;
    }

    public function format_phone_number($phone_no, $country)
    {
        if($country === 'United Arab Emirates')
        {
            $country_code = 'AE';
            $phone = new PhoneNumber($phone_no, $country_code);
            $phone_formatted = str_replace('tel:','', $phone->formatRFC3966());
            $final = $this->removeHyphens($phone_formatted, '-');
        }
        elseif($country === 'Qatar')
        {
            $country_code = 'QA';
            $phone = new PhoneNumber($phone_no, $country_code);
            $phone_formatted = str_replace('tel:','', $phone->formatRFC3966());
            $final = $this->removeHyphens($phone_formatted, '-');
        }
        elseif ($country === 'Bahrain')
        {
            $country_code = 'BH';
            $phone = new PhoneNumber($phone_no, $country_code);
            $phone_formatted = str_replace('tel:','', $phone->formatRFC3966());
            $final = $this->removeHyphens($phone_formatted, '-');
        }
        elseif ($country === 'Oman')
        {
            $country_code = 'OM';
            $phone = new PhoneNumber($phone_no, $country_code);
            $phone_formatted = str_replace('tel:','', $phone->formatRFC3966());
            $final = $phone_formatted;
        }
        elseif ($country === 'Saudi Arabia')
        {
            $country_code = 'SA';
            $phone = new PhoneNumber($phone_no, $country_code);
            $phone_formatted = str_replace('tel:','', $phone->formatRFC3966());
            $final = $phone_formatted;
        }
        elseif ($country === 'Kuwait')
        {
            $country_code = 'KW';
            $phone = new PhoneNumber($phone_no, $country_code);
            $phone_formatted = str_replace('tel:','', $phone->formatRFC3966());
            $final = $phone_formatted;
        }
        else
        {
            $country_code = 'AE';
            $phone = new PhoneNumber($phone_no, $country_code);
            $phone_formatted = str_replace('tel:','', $phone->formatRFC3966());
            $final = $this->removeHyphens($phone_formatted, '-');
        }

        return $final;
    }
}
