<?php
// 檔案位置：app/Entity/Schedule.php

namespace App\Entity;
use Illuminate\Database\Eloquent\Model; 


class Schedule extends Model {
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
}