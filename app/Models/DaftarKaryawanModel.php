<?php

namespace App\Models;

use CodeIgniter\Model;

class DaftarKaryawanModel extends Model
{
    protected $table = 'karyawan';
    protected $primaryKey = 'id_karyawan';
    protected $useAutoIncrement = true;
    protected $allowedFields = [
        'id_karyawan',
        'nik',
        'nama_karyawan'
    ];

    public function getKaryawan()
    {
        return $this->db->table('karyawan')
            ->get()->getResultArray();
    }
}
