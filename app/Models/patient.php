<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class patient extends Model
{
    use HasFactory;

    public $primaryKey='pid';
    public $timestamps = false;
    protected $fillable = [
        'pemail', 'pname', 'ppassword', 'paddress', 'pnic', 'pdob', 'ptel'
    ];
    public function appointment()
    {
        return $this->hasMany(appointment::class ,'pid','pid');
    }
}
