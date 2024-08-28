<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'nama', 'description'];


    public function kirimunit()
    {
        return $this->belongsToMany(kirimunit::class)->withPivot('tanggal_status_kirimunit');
    }

    public function prosesstnk()
    {
        return $this->belongsToMany(prosesstnk::class)->withPivot('tanggal_status_prosesstnk');
    }

    public function prosespenagihan()
    {
        return $this->belongsToMany(prosespenagihan::class)->withPivot('tanggal');
    }
}
