<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customers'; // Nama tabel di database

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    //  timestamps untuk kolom created_at dan updated_at
    public $timestamps = true;

    // Jika tidak
    // public $timestamps = false;
}
