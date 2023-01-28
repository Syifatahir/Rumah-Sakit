<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rekammedis extends Model
{
    protected $fillable = array('jenis_pendaftaran', 'surat_rujukan', 'tgl_pendaftaran', 'pasien_id');

    public $timestamps = true;
}