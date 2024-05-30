<?php

namespace App\Models;

use App\Models\appointment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class schedule extends Model
{
    use HasFactory;
    protected $table='schedule';
    protected $primaryKey="scheduleid";
    public function appointment()
    {
        return $this->hasMany(appointment::class ,'scheduleid','scheduleid');
    }
}
