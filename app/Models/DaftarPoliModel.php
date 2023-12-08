<?php

namespace App\Models;

use CodeIgniter\Model;

class DaftarPoliModel extends Model
{
    protected $table = 'poli';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = [
        'kode_poli',
        'nama_poli',
        'kapasitas',
    ];
}
