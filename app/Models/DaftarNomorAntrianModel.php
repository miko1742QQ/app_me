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
        'nomor_antrian',
        'status'
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

    public function getData1()
    {
        return $this->db->table('poli')
            ->get()
            ->getResultArray();
    }


    public function getDataByJenisPoli($jenisPoli)
    {
        return $this->db->table('no_antrian')
            ->distinct()
            ->select('no_antrian.tanggal, no_antrian.nomor_antrian, poli.id, poli.nama_poli, poli.kode_poli, poli.antrian_end, poli.antrian_proses, poli.antrian_waiting')
            ->join('poli', 'poli.id=no_antrian.id_poli')
            ->where('poli.kode_poli', $jenisPoli)
            ->where('no_antrian.status', 'waiting')
            ->orderBy('no_antrian.nomor_antrian', 'ASC')
            ->get()
            ->getResultArray();
    }

    public function getLastProcessedQueueNumber($id_poli)
    {
        $result = $this->db->table('no_antrian')
            ->selectMax('nomor_antrian')
            ->where('id_poli', $id_poli)
            ->where('status', 'end')
            ->get()
            ->getRow();

        // Pastikan result tidak NULL, jika NULL, kembalikan nilai default atau sesuai kebutuhan Anda
        return $result !== null ? $result->nomor_antrian : 0; // Mengembalikan 0 jika NULL, sesuaikan dengan kebutuhan Anda
    }
}
