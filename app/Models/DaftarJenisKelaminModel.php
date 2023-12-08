<?php

namespace App\Models;

use CodeIgniter\Model;

class DaftarJenisKelaminModel extends Model
{
    protected $table = 'jeniskelamin';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = [
        'id',
        'nama_jenis'
    ];
}
