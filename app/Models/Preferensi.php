<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Preferensi extends Model
{
    use HasFactory;
    protected $table = 'preferensi';
    protected $guarded = ['id'];

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class, 'kriteria_1', 'id');
    }
    public function kriteria_two()
    {
        return $this->belongsTo(Kriteria::class, 'kriteria_2', 'id');
    }
}
