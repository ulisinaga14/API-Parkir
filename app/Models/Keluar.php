<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keluar extends Model
{
    use HasFactory;

    protected $table = 'keluar';
    protected $guarded = ['id'];

    public function parkir(){
        return $this->belongsTo(Parkir::class);}
}
