<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pilihan extends Model
{
    protected $table = 'pilihans';
    protected $guarded = ['id_pilihan'];

    public function jurusansekolah()
    {
        return $this->belongsTo(JurusanSekolah::class, 'id_sekolah');
    }

    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'id_prodi');
    }
}
