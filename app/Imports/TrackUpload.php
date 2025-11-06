<?php

namespace App\Imports;

use App\Enums\ActivationStatus;
use App\Enums\BinaryYesNo;
use App\Enums\Countries;
use App\Enums\ProductCategories;
use App\Enums\Syllabus;
use App\Models\OrderActivationTrack;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Facades\Excel;
use Propaganistas\LaravelPhone\PhoneNumber;

class TrackUpload implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows
{
    private string $batch_no;

    public function __construct($batch_no)
    {
        $this->batch_no = $batch_no;
    }

//    public function prepareForValidation($data, $index)
//    {
//        //Fix that Excel's numeric date (counting in days since 1900-01-01)
//        $data['order_punched_date'] = is_numeric($data['order_punched_date']) ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($data['order_punched_date'])->format('Y-m-d') : null;
//        $data['order_confirmed_date'] = is_numeric($data['order_confirmed_date']) ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($data['order_confirmed_date'])->format('Y-m-d'): null;
//        //...
//    }

    public function rules(): array
    {
        return [
            // Above is alias for as it always validates in batches
            //'*.order_number' => ['required'],
            '*.order_number' => Rule::unique('order_activation_tracks')->where(fn (Builder $query) => $query->where('siblings', "=","No")),
            '*.primary_email' => ['required'],
            '*.primary_mobile' => ['required'],
            '*.order_punched_date' => ['required'],
            '*.order_confirmed_date' => ['required'],
            '*.country' => [new Enum(Countries::class)],
            '*.student_name' => ['required'],
            '*.siblings' => ['required'],
            '*.category' => [new Enum(ProductCategories::class)],
            '*.syllabus' => [new Enum(Syllabus::class)],
            '*.activation_status' => [new Enum(ActivationStatus::class)],
            '*.delivery_marked' => [new Enum(BinaryYesNo::class)],
        ];
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row): \Illuminate\Database\Eloquent\Model|OrderActivationTrack|null
    {
//        dd($row);
        if(is_numeric($row['order_punched_date']))
        {
            $order_p_date = intval($row['order_punched_date']);
            $order_punched_date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($order_p_date)->format('Y-m-d');
        }
        else
        {
            $order_punched_date = Carbon::parse($row['order_punched_date'])->format('Y-m-d');
        }

        if(is_numeric($row['order_confirmed_date']))
        {
            $order_c_date = intval($row['order_confirmed_date']);
            $order_confirmed_date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($order_c_date)->format('Y-m-d');
        }
        else
        {
            $order_confirmed_date = Carbon::parse($row['order_confirmed_date'])->format('Y-m-d');
        }

//        $order_punched_date = $row['order_punched_date'];
//        $order_confirmed_date = $row['order_confirmed_date'];

        $country_get = $row['country'];
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
        elseif ($country_get === 'Saudi Arabia')
        {
            $country_code = 'SA';
        }
        elseif ($country_get === 'Kuwait')
        {
            $country_code = 'KW';
        }
        elseif ($country_get === 'India')
        {
            $country_code = 'IN';
        }
        else
        {
            $country_code = 'AE';
        }
        $phone = new PhoneNumber($row['primary_mobile'], $country_code);
        $phone_formatted = $phone->formatE164();
        //$batch_no = bin2hex(random_bytes(8));
        //dd($order_punched_date);
        return new OrderActivationTrack([
            'order_number' => $row['order_number'],
            'order_punched_date' => $order_punched_date,
            'order_confirmed_date' => $order_confirmed_date,
            'student_name' => $row['student_name'],
            'primary_email_id' => $row['primary_email'],
            'primary_mobile_no' => $phone_formatted,
            'country' => $country_get,
            'oh_number' => $row['oh_no'],
            'premium_id' => $row['premium_id'],
            'siblings' => $row['siblings'],
            'sales_user' => $row['sales_user'],
            'lead_details' => "Auto Created",
            'category' => $row['category'],
            'syllabus' => $row['syllabus'],
            'activation_status' => $row['activation_status'],
            'delivered_marked' => $row['delivered_marked'],
            'mail_sent' => "No",
            'task_creation_sent_to_india' => $row['task_creation'],
            'remarks' => $row['remarks'],
            'batch_no' => $this->batch_no,
            'created_by' => auth()->user()->name
        ]);
    }

//    public function importToDatabase($track_file)
//    {
//            // Create a new row in the batch_table for this batch
//            DB::table('order_tracker_batch_table')->insert([
//                'batch_no' => $this->batch_no,
//            ]);
//
//            // Import the tracks from the file using the ToModel importer
//            Excel::import($this, $track_file);
//    }
}
