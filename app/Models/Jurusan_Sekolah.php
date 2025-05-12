<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurusan_Sekolah extends Model
{
    use HasFactory;
    protected $table = 'jurusan_sekolahs';
    protected $guarded = ['id'];

    public function pilihan()
    {
        return $this->hasMany(Pilihan::class, 'id_sekolah');
    }
}
