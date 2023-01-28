<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    protected $fillable = array('email', 'nama', 'NIK', 'alamat', 'tempat_lahir', 'umur', 'jk');

    public $timestamps = true;
}