<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class prosespenagihan extends Model
{
    use HasFactory;
    protected $primaryKey = 'no_tagihan';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = [
        'no_tagihan',
        'jatuh_tempo',
        'dataunit_no_faktur',
        'payment_type',
        'dokumen',
    ];

    public function dataunit()
    {
        return $this->belongsTo(dataunit::class, 'dataunit_no_faktur', 'no_faktur');
    }

    public function statuses()
    {
        return $this->belongsToMany(Status::class, 'prosespenagihan_status', 'prosespenagihan_no_tagihan', 'status_id')->withPivot('tanggal_status_penagihan', 'keterangan');
    }

    public function getStatusStyleAttribute()
    {
        $prosespenagihanStatus = $this->statuses()->orderBy('prosespenagihan_status.tanggal_status_penagihan', 'DESC')->first();

        if ($prosespenagihanStatus) {
            switch ($prosespenagihanStatus->nama) {
                case 'On Progress':
                    return 'warning';
                default:
                    return 'success';
            }
        }

        return 'success'; // Default style if no status is found
    }
}
