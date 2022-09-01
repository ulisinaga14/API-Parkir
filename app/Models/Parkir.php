<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parkir extends Model
{
    use HasFactory;

    protected $table = 'parkir';
    protected $guarded = ['id'];

    public function masuk(){
        return $this->hasMany(Masuk::class);
    }
    public function keluar(){
        return $this->hasMany(Keluar::class);
    }
}
