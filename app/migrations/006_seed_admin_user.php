<?php

class Seed_admin_user {

    private $_lava;

    public function __construct()
    {
        $this->_lava = lava_instance();
        $this->_lava->call->database();
    }

    public function up()
    {
        if (!$this->_lava->db->query("SHOW TABLES LIKE 'users'")->rowCount()) {
            throw new RuntimeException('Cannot seed the admin user because the users table does not exist.');
        }

        $adminUsername = 'admin';
        $adminEmail = 'admin@gmail.com';
        $adminPassword = password_hash('admin123', PASSWORD_DEFAULT);

        $this->_lava->db->raw(
            'DELETE FROM users WHERE username != ? OR email != ?',
            [$adminUsername, $adminEmail]
        );

        $existing = $this->_lava->db->raw(
            'SELECT id FROM users WHERE username = ? AND email = ? LIMIT 1',
            [$adminUsername, $adminEmail]
        )->fetch(PDO::FETCH_ASSOC);

        if ($existing) {
            $this->_lava->db->raw(
                'UPDATE users SET username = ?, email = ?, password = ?, role = ?, is_active = 1 WHERE username = ? AND email = ?',
                [$adminUsername, $adminEmail, $adminPassword, 'admin', $adminUsername, $adminEmail]
            );

            return;
        }

        $this->_lava->db->table('users')->insert([
            'username' => $adminUsername,
            'email' => $adminEmail,
            'password' => $adminPassword,
            'role' => 'admin',
            'is_active' => 1,
        ]);
    }

    public function down()
    {
        $this->_lava->db->raw(
            'DELETE FROM users WHERE username = ? AND email = ?',
            ['admin', 'admin@gmail.com']
        );
    }
}
