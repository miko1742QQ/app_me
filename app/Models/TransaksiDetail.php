<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiDetail extends Model
{
    protected $table = 'transaksi_detail';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_transaksi', 'id_obat', 'jumlah_obat', 'total_harga'];


    // Tambahkan metode lain sesuai kebutuhan
    public function getTransactionDetails($transactionId)
    {
        return $this->where('id_transaksi', $transactionId)
            ->findAll();
    }
}
