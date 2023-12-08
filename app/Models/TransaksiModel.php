<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiModel extends Model
{
    protected $table = 'transaksi';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_pasien', 'total_biaya', 'metode_pembayaran', 'kode_transaksi'];

    public function getReportData()
    {
        return $this->db->table('transaksi')
            ->distinct()
            ->select('transaksi.id, transaksi.metode_pembayaran, transaksi.kode_transaksi, transaksi.created_at, pasien.nama, transaksi.total_biaya')
            ->join('pasien', 'pasien.id=transaksi.id_pasien')
            ->join('transaksi_detail', 'transaksi_detail.id_transaksi=transaksi.id')
            ->get()
            ->getResultArray();
    }

    public function getReportDataPeridTransaksi($id)
    {
        return $this->db->table('transaksi')
            ->join('pasien', 'pasien.id=transaksi.id_pasien')
            ->where('transaksi.id', $id)
            ->get()->getResultArray();
    }

    // Tambahkan metode lain sesuai kebutuhan
    public function getLatestTransactionCode()
    {
        $query = $this->db->query("SELECT kode_transaksi FROM transaksi ORDER BY id DESC LIMIT 1");
        $result = $query->getRow();

        return $result ? $result->kode_transaksi : null;
    }

    public function getTransactionsByDateRange($startDate, $endDate)
    {
        return $this->where('created_at >=', $startDate)
            ->where('created_at <=', $endDate)
            ->findAll();
    }

    public function getReportDataPerID($id)
    {
        return $this->db->table('transaksi')
            ->join('transaksi_detail', 'transaksi_detail.id_transaksi=transaksi.id')
            ->join('obat', 'obat.id=transaksi_detail.id_obat')
            ->where('transaksi.id', $id)
            ->get()->getResultArray();
    }
}
