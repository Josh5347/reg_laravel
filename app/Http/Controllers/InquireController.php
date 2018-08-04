<?php
// 檔案位置：app/Http/Controllers/InquireController.php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller; 
use App\Entity\Schedule; 
use App\Entity\Patient; 
use App\Entity\RoomInfo; 

use DB;
use Validator;  // 驗證器
use Illuminate\Http\Request;


class InquireController extends Controller {
    
    // 輸入掛號資料
    public function patientDataInputPage(){

        $binding = [
       
            'title' => '查詢預約掛號',
            'id' => session()->get('patient_id'),
            'birthday' => session()->get('birthday'),
            'dialogOpen' => true

        ];
        return view('inq.patientDataInput', $binding);

    }
    public function patientDataValidator(){

        $input = request()->all();

        $rules = [
            //暱稱
            'id'=> [
                'required',
            ],
            'birthday' => [
                'required',
            ],
        ];
        
        $validator = Validator::make($input, $rules);

        if ($validator->fails()){
            //將$validator轉成陣列
            return response()->json($validator->messages());
        }else{
            return response()->json();
        }
    }
    public function dataListProcess(){

        $input = request()->all();

        $rules = [
            //暱稱
            'id'=> [
                'required',
            ],
            'birthday' => [
                'required',
            ],
        ];
        
        $validator = Validator::make($input, $rules);

        if ($validator->fails()){
            return redirect('/inquire')
                ->withErrors($validator)
                ->with('dialogOpen',true)
                ->withInput();
        }

        $binding = [
       
            'title' => '刪除預約掛號',
            'id' => $input['id'],
            'birthday' => $input['birthday'],
            'dialogOpen' => false

        ];
        return view('inq.patientDataInput', $binding);

    }
}