<?php

namespace App\Controllers;

use App\Controllers\BaseController;
// Untuk QR Code
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;

use Myth\Auth\Password;

// UNtuk View Database
use App\Models\DaftarKaryawanModel;
use App\Models\DaftarPasienModel;
use App\Models\DaftarJenisKelaminModel;
use CodeIgniter\HTTP\Header;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\AutoFilter\Column;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class DaftarPasienController extends BaseController
{
    protected $pasienModel;
    protected $karyawanModel;
    protected $jenkelModel;

    public function __construct()
    {
        $this->karyawanModel = new DaftarKaryawanModel();
        $this->pasienModel = new DaftarPasienModel();
        $this->jenkelModel = new DaftarJenisKelaminModel();
    }

    public function index()
    {
        $data['title'] = 'Daftar Pasien SISPUS';
        $data['datauser'] = $this->karyawanModel->where(['nik' => user()->nik])->first();
        $data['pasien'] = $this->pasienModel->findAll();

        return view('daftar_pasien', $data);
    }

    public function create_pasien()
    {
        $data['title'] = 'Tambah Data Pasien SISPUS';
        $data['datauser'] = $this->karyawanModel->where(['nik' => user()->nik])->first();
        $data['jeniskelamin'] = $this->jenkelModel->findall();
        return view('create_pasien', $data);
    }

    public function edit_pasien($id = null)
    {
        $data['title'] = 'Edit Pasien SISPUS';
        $data['datauser'] = $this->karyawanModel->where(['nik' => user()->nik])->first();
        $data['datapasien'] = $this->pasienModel->where(['id' => $id])->first();
        $data['jeniskelamin'] = $this->jenkelModel->findall();
        return view('edit_pasien', $data);
    }

    public function save_pasien()
    {
        // validation input
        if (!$this->validate([
            'nik' => [
                'rules' => 'required|is_unique[pasien.nik]|numeric|max_length[16]|min_length[16]',
                'errors' => [
                    'required' => 'NIK Tidak Boleh Kosong',
                    'is_unique' => 'NIK Sudah Ada Di Dalam Database',
                    'max_length' => 'Maximal NIK 16 Karakter',
                    'min_length' => 'Minimal NIK 16 Karakter',
                    'numeric' => 'NIK Hanya Bisa Diinputkan Dengan Angka',
                ],
            ],
            'nama' => [
                'rules' => 'required|max_length[100]',
                'errors' => [
                    'required' => 'Nama Tidak Boleh Kosong',
                    'max_length' => 'Nama Maksimal 100 Karakter',
                ],
            ],

            'jenkel' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Jenis Kelamin Tidak Boleh Kosong',
                ],
            ],

            'tempat_lahir' => [
                'rules' => 'required|alpha_space|max_length[100]',
                'errors' => [
                    'required' => 'Tempat Lahir Tidak Boleh Kosong',
                    'max_length' => 'Tempat Lahir Maksimal 100 Karakter',
                    'alpha_space' => 'Tempat Lahir Hanya Bisa Diinputkan Dengan Huruf'
                ],
            ],

            'tanggal_lahir' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tanggal Lahir Tidak Boleh Kosong',
                ],
            ],

            'alamat' => [
                'rules' => 'required|max_length[100]',
                'errors' => [
                    'required' => 'Alamat Tidak Boleh Kosong',
                    'max_length' => 'Alamat Maksimal 100 Karakter',
                ],
            ],

            'no_telp' => [
                'rules' => 'required|numeric|max_length[15]|min_length[8]',
                'errors' => [
                    'required' => 'No Hp Tidak Boleh Kosong',
                    'max_length' => 'No Hp Maksimal 15 Karakter',
                    'min_length' => 'No Hp Maksimal 8 Karakter',
                    'numeric' => 'No Hp Hanya Bisa Diinputkan Dengan Angka',
                ],
            ],
        ])) {
            $validation = \Config\Services::validation();
            return redirect()->back()->withInput()->with('validation', $this->validator->getErrors());
        }

        $nik            = $this->request->getVar('nik');
        $nama           = $this->request->getVar('nama');
        $jenis_kelamin  = $this->request->getVar('jenkel');
        $tempat_lahir   = $this->request->getVar('tempat_lahir');
        $tanggal_lahir  = $this->request->getVar('tanggal_lahir');
        $alamat         = $this->request->getVar('alamat');
        $no_telp        = $this->request->getVar('no_telp');

        $data = [
            'nik' => $nik,
            'nama' => $nama,
            'id_jekel' => $jenis_kelamin,
            'tempat_lahir' => $tempat_lahir,
            'tanggal_lahir' => $tanggal_lahir,
            'alamat' => $alamat,
            'telp' => $no_telp
        ];

        // dd($data);
        if ($this->pasienModel->save($data) == true) {
            return redirect()->to(base_url('daftar_pasien'))->with('success', 'Data Pasien Berhasil Disimpan');
        } else {
            return redirect()->back()->with('error', 'Data Pasien Gagal Disimpan');
        }
    }

    public function update_pasien($id = null)
    {
        // validation input
        if (!$this->validate([
            'nik' => [
                'rules' => 'is_unique[pasien.nik]|numeric|max_length[16]|min_length[16]|permit_empty',
                'errors' => [
                    'is_unique' => 'NIK Sudah Ada Di Dalam Database',
                    'max_length' => 'Maximal NIK 16 Karakter',
                    'min_length' => 'Minimal NIK 16 Karakter',
                    'numeric' => 'NIK Hanya Bisa Diinputkan Dengan Angka',
                ],
            ],
            'nama' => [
                'rules' => 'max_length[100]|permit_empty',
                'errors' => [
                    'max_length' => 'Nama Maksimal 100 Karakter',
                ],
            ],

            'tempat_lahir' => [
                'rules' => 'alpha_space|max_length[100]|permit_empty',
                'errors' => [
                    'max_length' => 'Tempat Lahir Maksimal 100 Karakter',
                    'alpha_space' => 'Tempat Lahir Hanya Bisa Diinputkan Dengan Huruf'
                ],
            ],

            'alamat' => [
                'rules' => 'max_length[100]|permit_empty',
                'errors' => [
                    'max_length' => 'Alamat Maksimal 100 Karakter',
                ],
            ],

            'no_telp' => [
                'rules' => 'numeric|max_length[15]|min_length[8]|permit_empty',
                'errors' => [
                    'max_length' => 'No Hp Maksimal 15 Karakter',
                    'min_length' => 'No Hp Maksimal 8 Karakter',
                    'numeric' => 'No Hp Hanya Bisa Diinputkan Dengan Angka',
                ],
            ],
        ])) {
            $validation = \Config\Services::validation();
            return redirect()->back()->withInput()->with('validation', $this->validator->getErrors());
        }

        $nik            = $this->request->getVar('nik');
        if ($nik == null) {
            $dataNik = $this->request->getVar('nikLama');
        } else {
            $dataNik = $this->request->getVar('nik');
        }

        $nama           = $this->request->getVar('nama');
        if ($nama == null) {
            $dataNama = $this->request->getVar('namaLama');
        } else {
            $dataNama = $this->request->getVar('nama');
        }

        $jenis_kelamin  = $this->request->getVar('jenkel');
        if ($jenis_kelamin == null) {
            $dataJekel = $this->request->getVar('jenkelLama');
        } else {
            $dataJekel = $this->request->getVar('jenkel');
        }

        $tempat_lahir   = $this->request->getVar('tempat_lahir');
        if ($tempat_lahir == null) {
            $dataTempatLahir = $this->request->getVar('tempat_lahirLama');
        } else {
            $dataTempatLahir = $this->request->getVar('tempat_lahir');
        }

        $tanggal_lahir  = $this->request->getVar('tanggal_lahir');
        if ($tanggal_lahir == null) {
            $dataTanggalLahir = $this->request->getVar('tanggal_lahirLama');
        } else {
            $dataTanggalLahir = $this->request->getVar('tanggal_lahir');
        }

        $alamat         = $this->request->getVar('alamat');
        if ($alamat == null) {
            $dataAlamat = $this->request->getVar('alamatLama');
        } else {
            $dataAlamat = $this->request->getVar('alamat');
        }

        $no_telp        = $this->request->getVar('no_telp');
        if ($no_telp == null) {
            $dataNoHp = $this->request->getVar('no_telpLama');
        } else {
            $dataNoHp = $this->request->getVar('no_telp');
        }

        $data = [
            'nik' => $dataNik,
            'nama' => $dataNama,
            'id_jekel' => $dataJekel,
            'tempat_lahir' => $dataTempatLahir,
            'tanggal_lahir' => $dataTanggalLahir,
            'alamat' => $dataAlamat,
            'telp' => $dataNoHp,
        ];

        if ($this->pasienModel->update($id, $data) == true) {
            return redirect()->to(base_url('daftar_pasien'))->with('success', 'Data Pasien Berhasil Diperbaharui');
        } else {
            return redirect()->back()->with('error', 'Data Pasien Gagal Diperbaharui');
        }
    }

    public function delete_pasien($id = null)
    {
        if ($this->pasienModel->delete($id) == true) {
            return redirect()->to(base_url('daftar_pasien'))->with('success', 'Data Pasien Berhasil Dihapus');
        } else {
            return redirect()->back()->with('error', 'Data Pasien Gagal Dihapus');
        }
    }

    public function view_pasien()
    {
    }

    // public function export_pasien()
    // {
    //     $filename = "daftar_pasien_daposis_" . date('d_M_Y') . ".xlsx";
    //     $data = $this->pasienModel->findAll();

    //     $spreadsheet = new Spreadsheet();
    //     $sheet = $spreadsheet->getActiveSheet();

    //     $sheet->setCellValue('A1', 'No');
    //     $sheet->setCellValue('B1', 'Nama Sekolah');
    //     $sheet->setCellValue('C1', 'Nama pasien');
    //     $sheet->setCellValue('D1', 'NIK');
    //     $sheet->setCellValue('E1', 'NISN');
    //     $sheet->setCellValue('F1', 'No BP');
    //     $sheet->setCellValue('G1', 'JK');
    //     $sheet->setCellValue('H1', 'Tempat Lahir');
    //     $sheet->setCellValue('I1', 'Tanggal Lahir');
    //     $sheet->setCellValue('J1', 'Agama');
    //     $sheet->setCellValue('K1', 'Alamat');
    //     $sheet->setCellValue('L1', 'RT');
    //     $sheet->setCellValue('M1', 'RW');
    //     $sheet->setCellValue('N1', 'Provinsi');
    //     $sheet->setCellValue('O1', 'Kota');
    //     $sheet->setCellValue('P1', 'Kecamatan');
    //     $sheet->setCellValue('Q1', 'Kelurahan');
    //     $sheet->setCellValue('R1', 'Kode Pos');
    //     $sheet->setCellValue('S1', 'No. Telp');

    //     $column = 2;
    //     foreach ($data as $value) {
    //         $sheet->setCellValue('A' . $column, ($column - 1));
    //         $sheet->setCellValue('B' . $column, $value['npsn']);
    //         $sheet->setCellValue('C' . $column, $value['nama_pasien']);
    //         $sheet->setCellValue('D' . $column, $value['nik']);
    //         $sheet->setCellValue('E' . $column, $value['nisn']);
    //         $sheet->setCellValue('F' . $column, $value['no_bp']);
    //         $sheet->setCellValue('G' . $column, $value['jekel']);
    //         $sheet->setCellValue('H' . $column, $value['tempat_lahir']);
    //         $sheet->setCellValue('I' . $column, $value['tanggal_lahir']);
    //         $sheet->setCellValue('J' . $column, $value['agama']);
    //         $sheet->setCellValue('K' . $column, $value['alamat']);
    //         $sheet->setCellValue('L' . $column, $value['rt']);
    //         $sheet->setCellValue('M' . $column, $value['rw']);
    //         $sheet->setCellValue('N' . $column, $value['id_provinsi']);
    //         $sheet->setCellValue('O' . $column, $value['id_kabupatenkota']);
    //         $sheet->setCellValue('P' . $column, $value['id_kecamatan']);
    //         $sheet->setCellValue('Q' . $column, $value['id_kelurahan']);
    //         $sheet->setCellValue('R' . $column, $value['kode_pos']);
    //         $sheet->setCellValue('S' . $column, $value['telp']);
    //         $column++;
    //     }

    //     $sheet->getStyle('A1:S1')->getFont()->setBold(true);
    //     $sheet->getStyle('A1:S1')->getFill()
    //         ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    //         ->getStartColor()->setARGB('FFFFFFFF');

    //     $styleArray = [
    //         'borders' => [
    //             'allBorders' => [
    //                 'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
    //                 'color' => ['argb' => 'FF000000']
    //             ],
    //         ],
    //     ];

    //     $sheet->getStyle('A1:s' . ($column - 1))->applyFromArray($styleArray);

    //     $sheet->getColumnDimension('A')->setAutoSize(true);
    //     $sheet->getColumnDimension('B')->setAutoSize(true);
    //     $sheet->getColumnDimension('C')->setAutoSize(true);
    //     $sheet->getColumnDimension('D')->setAutoSize(true);
    //     $sheet->getColumnDimension('E')->setAutoSize(true);
    //     $sheet->getColumnDimension('F')->setAutoSize(true);
    //     $sheet->getColumnDimension('G')->setAutoSize(true);
    //     $sheet->getColumnDimension('H')->setAutoSize(true);
    //     $sheet->getColumnDimension('I')->setAutoSize(true);
    //     $sheet->getColumnDimension('J')->setAutoSize(true);
    //     $sheet->getColumnDimension('K')->setAutoSize(true);
    //     $sheet->getColumnDimension('L')->setAutoSize(true);
    //     $sheet->getColumnDimension('M')->setAutoSize(true);
    //     $sheet->getColumnDimension('N')->setAutoSize(true);
    //     $sheet->getColumnDimension('O')->setAutoSize(true);
    //     $sheet->getColumnDimension('P')->setAutoSize(true);
    //     $sheet->getColumnDimension('Q')->setAutoSize(true);
    //     $sheet->getColumnDimension('R')->setAutoSize(true);

    //     $writer = new Xlsx($spreadsheet);
    //     header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    //     header('Content-Disposition: attachment;filename=' . $filename);
    //     header('Cache-Control: max-age=0');
    //     $writer->save('php://output');
    //     exit();
    // }

    // public function import_pasien()
    // {
    //     $file = $this->request->getFile('import_pasien');
    //     $extension = $file->getClientExtension();
    //     if ($extension == 'xlsx' || $extension == 'xls') {
    //         if ($extension == 'xls') {
    //             $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
    //         } else {
    //             $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
    //         }

    //         $spreadsheet = $reader->load($file);
    //         $import = $spreadsheet->getActiveSheet()->toArray();
    //         foreach ($import as $key => $value) {
    //             if ($key == 0) {
    //                 continue;
    //             } else {
    //                 $data = [
    //                     'npsn' => $value[1],
    //                     'nama_pasien' => $value[2],
    //                     'nik' => $value[3],
    //                     'nisn' => $value[4],
    //                     'no_bp' => $value[5],
    //                     'jekel' => $value[6],
    //                     'tempat_lahir' => $value[7],
    //                     'tanggal_lahir' => $value[8],
    //                     'agama' => $value[9],
    //                     'alamat' => $value[10],
    //                     'rt' => $value[11],
    //                     'rw' => $value[12],
    //                     'id_provinsi' => $value[13],
    //                     'id_kabupatenkota' => $value[14],
    //                     'id_kecamatan' => $value[15],
    //                     'id_kelurahan' => $value[16],
    //                     'kode_pos' => $value[17],
    //                     'telp' => $value[18],
    //                 ];
    //                 $this->pasienModel->insert($data);
    //             }
    //         }
    //         return redirect()->to(base_url('daftar_pasien'))->with('success', 'Data pasien Berhasil Diimport');
    //     } else {
    //         return redirect()->back()->with('error', 'Format file tidak sesuai dengan yang ditentukan');
    //     }
    // }
}
