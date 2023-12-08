<?php

namespace App\Models;

use CodeIgniter\Model;

class DaftarPasienModel extends Model
{
    protected $table            = 'pasien';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = [
        'nik',
        'nama',
        'id_jekel',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'telp'
    ];

    public function getPasienPerID($id)
    {
        return $this->db->table('pasien')
            ->join('jeniskelamin', 'jeniskelamin.id=pasien.id_jekel')
            ->where('pasien.id', $id)
            ->get()->getResultArray();
    }
}
