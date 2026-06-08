<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'account' => 'demo',
                'password' => password_hash('1234', PASSWORD_DEFAULT),
            ],
        ];

        $builder = $this->db->table('users');

        foreach ($users as $user) {
            $exists = $builder
                ->where('account', $user['account'])
                ->get()
                ->getRowArray();

            if ($exists) {
                $builder
                    ->where('id', $exists['id'])
                    ->update([
                        'password' => $user['password'],
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);

                continue;
            }

            $builder->insert([
                'account' => $user['account'],
                'password' => $user['password'],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
