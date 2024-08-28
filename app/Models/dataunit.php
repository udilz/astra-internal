<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dataunit extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'no_faktur';
    public $incrementing = false;
    protected $fillable = [
        'nama_sales',
        'nama_customer',
        'nama_supervisor',
        'no_faktur',
        'material_type',
        'tanggal_faktur',
        'alur_proses_penjualan',
        'warna_plat',
        'nama_leasing',
    ];

    public function kirimunit()
    {
        return $this->belongsTo(kirimunit::class, 'dataunit_no_faktur', 'no_faktur');
    }

    public function prosesstnk()
    {
        return $this->belongsTo(prosesstnk::class, 'dataunit_no_faktur', 'no_faktur');
    }
}
