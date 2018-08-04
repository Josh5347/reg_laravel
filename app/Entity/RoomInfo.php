<?php
// 檔案位置：app/Entity/RoomInfo.php

namespace App\Entity;
use Illuminate\Database\Eloquent\Model; 


class RoomInfo extends Model {
    // 資料表名稱
    protected $table = 'room_info';

    protected $primaryKey = 'invalid_login_id';
    // 主鍵名稱
    protected $fillable = [
        "date",
        "am_pm",
        "room",
        "doctor",
        "patient_id",
        "register_no",
    ];
}