<?php
// 檔案位置：app/Entity/Patient.php

namespace App\Entity;
use Illuminate\Database\Eloquent\Model; 


class Patient extends Model {
    // 資料表名稱
    protected $table = 'patient';

    protected $primaryKey = 'patient_id';
    // 主鍵名稱
    protected $fillable = [
        "patient_id",
        "birthday",
        "phone"

    ];
}