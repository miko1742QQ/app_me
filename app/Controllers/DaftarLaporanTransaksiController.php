<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TransaksiModel;
use App\Models\TransaksiDetail;
use App\Models\DaftarKaryawanModel;

class DaftarLaporanTransaksiController extends BaseController
{
    protected $transaksiModel;
    protected $transaksiDetailModel;
    protected $karyawanModel;

    public function __construct()
    {
        $this->transaksiModel = new TransaksiModel();
        $this->transaksiDetailModel = new TransaksiDetail();
        $this->karyawanModel = new DaftarKaryawanModel();
    }

    public function index()
    {
        $data['title'] = 'Transaksi SISPUS';
        $data['datauser'] = $this->karyawanModel->where(['nik' => user()->nik])->first();
        $data['report'] = $this->transaksiModel->getReportData();

        // Debugging: Tampilkan data untuk pengecekan
        return view('laporan_transaksi', $data);
    }

    public function detail_laporan($id = null)
    {
        $data['title'] = 'Edit Pasien SISPUS';
        $data['datauser'] = $this->karyawanModel->where(['nik' => user()->nik])->first();
        $data['detailreport'] = $this->transaksiModel->getReportDataPerID($id);
        $data['detailpasien'] = $this->transaksiModel->getReportDataPeridTransaksi($id);

        return view('detail_laporan', $data);
    }

    public function laporanTransaksi($id = null)
    {
        $data['title'] = 'Edit Pasien SISPUS';
        $data['datauser'] = $this->karyawanModel->where(['nik' => user()->nik])->first();
        $data['detailreport'] = $this->transaksiModel->getReportDataPerID($id);
        $data['detailpasien'] = $this->transaksiModel->getReportDataPeridTransaksi($id);

        return view('laporanTransaksi', $data);
    }

    public function generateReport()
    {
        $startDate = $this->request->getPost('start_date');
        $endDate = $this->request->getPost('end_date');

        $transactions = $this->transaksiModel->getTransactionsByDateRange($startDate, $endDate);
        $reportData = $this->transaksiModel->getReportData();

        $data['report'] = $reportData;

        foreach ($transactions as $transaction) {
            $transactionDetails = $this->transaksiDetailModel->getTransactionDetails($transaction['id']);
            $data['report'][] = [
                'transaction' => $transaction,
                'details' => $transactionDetails,
            ];
        }

        return view('laporan_transaksi', $data);
    }
}
