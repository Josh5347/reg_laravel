<?php
// 檔案位置：app/Http/Controllers/RegisterController.php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller; 
use App\Entity\Schedule; 
use App\Entity\Patient; 
use App\Entity\RoomInfo; 

use DB;
use Validator;  // 驗證器
use Illuminate\Http\Request;


class RegisterController extends Controller {
    // 註冊
    public function indexPage(){
        $binding = [
       
            'title' => '依日期及科別查詢門診表',
            'registerDay' => '',
            'registerDate' => '',

        ];
        return view('reg.deptDaySelect', $binding);

    }

    public function deptDaySelectProcess(){
        $input = request()->all();

        $rules = [
            //暱稱
            'dept'=> [
                'string',
            ],
            'registerDay' => [
                'in:1,2,3,4,5,6',
            ],
        ];
        
        $validator = Validator::make($input, $rules);

        if ($validator->fails()){
            return redirect('/')
                ->withErrors($validator)
                ->withInput();
        }

        //以科別為key撈取門診資料表
        $Schedule = Schedule::where('department', $input['dept'] )
            ->where( 'week_day', $input['registerDay'] )
            ->get();
        
        //門診資料表新增一欄「已掛人數」
        $Schedule = $Schedule->map(function($item){
            $item['patient_num'] = 0;
            return $item;
        });

        //遍歷$Schedule，讀取room_info資料表，並改變欄位patient_num的值
        foreach($Schedule as &$schedule){

            $schedule->patient_num = DB::table('room_info')
                ->where('am_pm', $schedule->am_pm)
                ->where('room', $schedule->room)
                ->where('date', $input['registerDate'])
                ->count();
                //->get();
            
            //$schedule->patient_num = $Room_info->count();

            //var_dump($Room_info);
    
        }
 
        //以科別，週日數為key撈取門診資料表並與掛號表做連結，已取得「已掛人數」資料
        /* $Schedule = DB::table('clinic_hour')
            ->where('department', $input['dept'] )
            ->where('week_day',$input['registerDay'])        
            ->join('room_info',function($join){
                $join
                    ->on('clinic_hour.room','=','room_info.room')
                    ->on('clinic_hour.am_pm','=','room_info.am_pm');
            })
            ->get(); */

        switch ($input['registerDay'])	
        {
        case 1 : 
            $week_day_c = "一";    
            break;
        case 2 : 
            $week_day_c = "二";    
            break;
        case 3 : 
            $week_day_c = "三";    
            break;
        case 4 : 
            $week_day_c = "四";    
            break;
        case 5 : 
            $week_day_c = "五";    
            break;
        case 6 : 
            $week_day_c = "六";    
            break;
        }

        //var_dump($Schedule);
        $binding = [
    
            'title' => '依科別及日期查詢門診表',
            'scheduleTable' => $Schedule,
            'registerDate' => $input['registerDate'],
            'registerDay' => $input['registerDay'],
            'registerDept' => $input['dept'],
            'week_day_c' => $week_day_c,
            'formNo'   => 0,               // form "registerInfo" 之編號
        ];                  

        //session()->put('count',0);
        return view('reg.deptDaySelect',$binding );
            
    }
    public function registerProcess(Request $request){

        $Patient = Patient::where('patient_id', $request->id )->first();

        //無此病患，patient資料表新增此筆病患
        if (!isset($Patient->patient_id)){
            $patient = new Patient();
            $patient->patient_id = $request->id;
            $patient->birthday = $request->birthday;
        
            $patient->save();
            $status = 'success';
            $msg = '初診掛號';
        }elseif ( $Patient->birthday != $request->birthday ) {
            $status = 'error';
            $msg = '生日有誤';
            
        }else{
            $status = 'success';
        }

        //新增此筆掛號資料
        if ($status == 'success'){

            //讀取掛號資料，讀取成功為1，失敗為0
            $isRoomInfo = RoomInfo::where('date',$request->registerDate)
                                ->where('am_pm',$request->am_pm)
                                ->where('room',$request->room)
                                ->where('patient_id',$request->id)
                                ->count();
            //取得已掛人數
            $register_no = RoomInfo::where('date',$request->registerDate)
                                ->where('am_pm',$request->am_pm)
                                ->where('room',$request->room)
                                ->count();

            //已有此筆掛號資料
            if ($isRoomInfo==1){
                $status = 'error';
                $msg = '重複掛號';
            }else{
                $roomInfo = new RoomInfo();
                $roomInfo->date         = $request->registerDate;
                $roomInfo->room         = $request->room;
                $roomInfo->am_pm        = $request->am_pm;
                $roomInfo->doctor       = $request->doctor;
                $roomInfo->patient_id   = $request->id;
                $roomInfo->register_no  = $register_no + 1;
                $roomInfo->save();

                $status = 'success';
                $msg = '掛號成功';
                
                session()->put('patient_id', $request->id);
                session()->put('birthday', $request->birthday);

            }
        }

        $response = array(
            'status' => $status,
            'msg' => $msg,
        );

        return response()->json($response);
    }



 
}