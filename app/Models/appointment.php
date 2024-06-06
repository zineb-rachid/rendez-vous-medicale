<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class appointment extends Model
{
    use HasFactory;
    protected $table="appointment";
    protected $primaryKey="appid";
    public $timestamps=false;
    public function patient()
    {
        return $this->belongsTo(patient::class ,'pid','pid');
    }
    public function schedule()
    {
        return $this->belongsTo(schedule::class ,'scheduleid','scheduleid');
    }
}
