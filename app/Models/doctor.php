<?php

namespace App\Models;

use App\Models\specialities;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class doctor extends Model
{
    use HasFactory;
    protected $fillable = [
        'docemail', 'docname', 'docpassword', 'docnic', 'doctel', 'specialities'
    ];
    protected $table="doctor";
    protected $primaryKey="docid";
    public function specialities()
    {
        return $this->belongsTo(specialities::class,'docspecialitie','sid');
    }
    public function schedule()
    {
        return $this->hasMany(schedule::class ,'docid','docid');
    }
}
