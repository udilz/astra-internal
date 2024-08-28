<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class prosesstnk extends Model
{
    use HasFactory;

    protected $primaryKey = 'plat_nomor';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = ['dataunit_no_faktur', 'plat_nomor', 'dokumen'];

    public function dataunit()
    {
        return $this->belongsTo(dataunit::class, 'dataunit_no_faktur', 'no_faktur');
    }

    public function statuses()
    {
        return $this->belongsToMany(Status::class, 'prosesstnk_status', 'prosesstnk_plat_nomor', 'status_id')->withPivot('tanggal_status_prosesstnk', 'keterangan');
    }

    public function getStatusStyleAttribute()
    {
        $prosesstnkStatus = $this->statuses()->orderBy('prosesstnk_status.tanggal_status_prosesstnk', 'DESC')->first();

        if ($prosesstnkStatus) {
            switch ($prosesstnkStatus->nama) {
                case 'On Progress':
                    return 'warning';
                default:
                    return 'success';
            }
        }

        return 'success'; // Default style if no status is found
    }
}
