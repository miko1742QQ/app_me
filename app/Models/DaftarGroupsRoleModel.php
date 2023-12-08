<?php

namespace App\Models;

use CodeIgniter\Model;

class DaftarGroupsRoleModel extends Model
{
    protected $table = 'auth_groups_users';

    protected $primaryKey = 'user_id';

    protected $useAutoIncrement = true;
    protected $allowedFields = [
        'group_id',
        'user_id',
    ];

    public function getGroupsRolePerID($id = null)
    {
        return $this->db->table('auth_groups_users')
            ->join('users', 'users.id=auth_groups_users.user_id')
            ->where('auth_groups_users.user_id', $id)
            ->get()->getResultArray();
    }
}
