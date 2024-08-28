<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kirimunit extends Model
{
    use HasFactory;

    protected $primaryKey = 'no_rangka';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = ['dataunit_no_faktur', 'no_rangka', 'no_mesin', 'lokasi_tujuan', 'dokumen'];

    public function dataunit()
    {
        return $this->belongsTo(dataunit::class, 'dataunit_no_faktur', 'no_faktur');
    }

    public function statuses()
    {
        return $this->belongsToMany(Status::class, 'kirimunit_status', 'kirimunit_no_rangka', 'status_id')->withPivot('tanggal_status_kirimunit', 'keterangan');
    }

    public function getStatusStyleAttribute()
    {
        $kirimunitStatus = $this->statuses()->orderBy('kirimunit_status.tanggal_status_kirimunit', 'DESC')->first();

        if ($kirimunitStatus) {
            switch ($kirimunitStatus->nama) {
                case 'Shipped':
                    return 'warning';
                case 'Delivered':
                    return 'success';
                case 'On Progress':
                    return 'warning';
                default:
                    return 'success';
            }
        }

        return 'success'; // Default style if no status is found
    }
}
