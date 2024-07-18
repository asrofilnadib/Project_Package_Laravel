<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    use HasFactory;

    protected $table = 'info_pendaftaran';

    public function lowongan()
    {
        return $this->belongsTo(Lowongan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
