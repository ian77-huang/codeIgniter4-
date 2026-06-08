<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MessagesSeeder extends Seeder
{
    public function run(): void
    {
        $user = $this->db
            ->table('users')
            ->where('account', 'test')
            ->get()
            ->getRowArray();

        if (! $user) {
            return;
        }

        $messages = [
            '這是第一則測試留言。',
            '登入後可以在首頁新增留言。',
        ];

        $builder = $this->db->table('messages');

        foreach ($messages as $content) {
            $exists = $builder
                ->where('user_id', $user['id'])
                ->where('content', $content)
                ->get()
                ->getRowArray();

            if ($exists) {
                continue;
            }

            $builder->insert([
                'user_id' => $user['id'],
                'content' => $content,
                'ip_address' => '127.0.0.1',
                'user_agent' => 'Seeder',
                'is_deleted' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
