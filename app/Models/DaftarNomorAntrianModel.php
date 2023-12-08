<?php

namespace App\Models;

use CodeIgniter\Model;

class DaftarNomorAntrianModel extends Model
{
    protected $table = 'no_antrian';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = [
        'tanggal',
        'id_poli',
        'nomor_antrian'
    ];

    public function getData()
    {
        return $this->db->table('no_antrian')
            ->distinct()
            ->select('no_antrian.id, no_antrian.tanggal, no_antrian.nomor_antrian, poli.nama_poli, poli.kode_poli')
            ->join('poli', 'poli.id=no_antrian.id_poli')
            ->get()
            ->getResultArray();
    }
}
