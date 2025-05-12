<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prodi extends Model
{
    use HasFactory;
    protected $tabel = 'prodis';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];


    public function pilihan()
    {
        return $this->hasMany(Pilihan::class);
    }

    public function pertanyaan()
    {
        return $this->belongsTo(Pertanyaan::class, 'id_prodi', 'id');
    }
}
