<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'template_doc',
        'pengajuan_doc',
        'status',
        'artist_id',
    ];

    public $timestamps = false;
}
