<?php
// 檔案位置：app/Entity/ClinicJoinRoom.php

namespace App\Entity;
use Illuminate\Database\Eloquent\Model; 


class ClinicJoinRoom extends Model {
    // 資料表名稱
    protected $table = 'clinic_hour';

    protected $primaryKey = 'invalid_login_id';
    // 主鍵名稱
    protected $fillable = [
        "week_day",
        "am_pm",
        "room",
        "department",
        "doctor",
    ];

    public function RoomInfo(){
        return $this->hasOne('App\Entity\RoomInfo', 'am_pm', 'am_pm')->where('room',$this->room);
    }
}