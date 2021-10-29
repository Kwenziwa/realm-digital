<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Wish;
use App\Mail\SendMail;
use GuzzleHttp\Client;
use App\Helpers\Helpers;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class WishController extends Controller
{



    public function DonwloadEmployee(){

        Employee::truncate();

        $clientdatas =  Helpers::GetApi('https://interview-assessment-1.realmdigital.co.za/employees');

       foreach($clientdatas as $clientdata) {
            $employee = new Employee();
            $employee->employee_id = $clientdata['id'];
            $employee->name = $clientdata['name'];
            $employee->lastname = $clientdata['lastname'];
            $employee->dateOfBirth = $clientdata['dateOfBirth'];
            $employee->employmentStartDate = $clientdata['employmentStartDate'];
            $employee->employmentEndDate = $clientdata['employmentEndDate'];

            if(isset($clientdata['lastNotification'])) {
                $employee->lastNotification = $clientdata['lastNotification'];
            }
            $employee->save();

         }
    }


    public function SendWish(){

        $wish_type = 0;

        $exclusions =  Helpers::GetApi('https://interview-assessment-1.realmdigital.co.za/do-not-send-birthday-wishes');
        $leap_year = Helpers::is_leap_year(now()->year);
        $wish_type_col  = collect(['dateOfBirth','employmentStartDate']);
        $wish_col  = collect(['birthday_wishes','work_anniversary']);

        $mployees_list = Employee::query();
        $mployees_list = $mployees_list->wherenotIn('employee_id', $exclusions)->whereNotNull('employmentStartDate')
                    ->whereNull('employmentEndDate');
         if($leap_year){
                $mployees_list = $mployees_list ->whereMonth($wish_type_col[$wish_type], '=', Carbon::now()->format('m'))
                ->whereDay($wish_type_col[$wish_type], '=', Carbon::now()->format('d'))->whereMonth($wish_type_col[$wish_type], '02')
                ->whereDay($wish_type_col[$wish_type],'29');
         }else{

                $mployees_list = $mployees_list ->whereMonth($wish_type_col[$wish_type], '=', Carbon::now()->format('m'))
                ->whereDay($wish_type_col[$wish_type], '=', Carbon::now()->format('d'));
         }
         $mployees_list = $mployees_list->get()->toArray();

         $names = null;
         foreach($mployees_list as $name) {

            $check = Wish::where('employee_id',$name['employee_id'])->whereNull($wish_col[$wish_type])->first();

            if (!$check) {
                // Do stuff if it doesn't exist.
                $names .= $name['name'].' '.$name['lastname'].',';

                $wish = new Wish();
                $wish->employee_id = $name['employee_id'];
                if($wish_type_col[$wish_type]=='dateOfBirth'){
                        $wish->birthday_wishes = 'sent';
                }else{
                        $wish->work_anniversary = 'sent';
                }
                $wish->save();
             }

         }

         $details = [ 'names' => $names, 'wishes_type' => Helpers::wishTitleTypeArray($wish_type), 'body' => Helper::wishBodyTypeArray($wish_type)];

        \Mail::to('kwenziwa@live.com')->send(new SendMail($details));

        Log::info("==================================");
        Log::info("Email Is Sent.");
        Log::info($names);
        Log::info("==================================");
    }

}
