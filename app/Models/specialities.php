<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class specialities extends Model
{
    use HasFactory;
    protected $table='specialities';
    protected $primaryKey='sid';
    public $timestamps=false;
    protected $fillable=['sid','sname'];
    public function doctor()
    {
        return $this->hasMany(doctor::class,'docspecialitie','sid');
    }
}
