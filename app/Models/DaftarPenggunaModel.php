<?php

namespace App\Models;

use CodeIgniter\Model;

class DaftarPenggunaModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $allowedFields = [
        'nik',
        'id_role',
        'email',
        'username',
        'password',
        'password_hash',
        'active',
        'force_pass_reset',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function getUsers()
    {
        return $this->db->table('users')
            ->orderBy('id', 'ASC')
            ->get()->getResultArray();
    }

    public function getPengguna()
    {
        return $this->db->table('users')
            ->join('auth_groups', 'auth_groups.id=users.id_role')
            ->join('karyawan', 'karyawan.nik=users.nik')
            ->get()->getResultArray();
    }

    public function getPenggunaPerID($id_pengguna)
    {
        return $this->db->table('users')
            ->join('auth_groups', 'auth_groups.id=users.id_role')
            ->join('karyawan', 'karyawan.nik=users.nik')
            ->where('users.nik', $id_pengguna)
            ->get()->getResultArray();
    }

    function getLevel()
    {
        $query = $this->db->query('SELECT * FROM auth_groups');
        return $query->getResultArray();
    }

    function getKaryawan()
    {
        $query = $this->db->query('SELECT * FROM karyawan');
        return $query->getResultArray();
    }
}
