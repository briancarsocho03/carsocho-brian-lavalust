<?php

class Add_missing_user_auth_columns {

    private $_lava;

    public function __construct()
    {
        $this->_lava = lava_instance();
        $this->_lava->call->dbforge();
    }

    public function up()
    {
        if (!$this->_lava->dbforge->table_exists('users')) {
            throw new RuntimeException('Cannot add user authentication columns because the users table does not exist.');
        }

        foreach (['firstname', 'lastname'] as $column) {
            if ($this->_lava->dbforge->column_exists('users', $column)) {
                $this->_lava->dbforge->modify_column('users', [
                    $column => [
                        'type'       => 'VARCHAR',
                        'constraint' => 100,
                        'null'       => FALSE,
                        'default'    => '',
                    ],
                ]);
            }
        }

        if (!$this->_lava->dbforge->column_exists('users', 'password')) {
            $this->_lava->dbforge->add_column('users', [
                'password' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                    'null'       => FALSE,
                    'default'    => '',
                ],
            ]);
        }

        if (!$this->_lava->dbforge->column_exists('users', 'is_active')) {
            $this->_lava->dbforge->add_column('users', [
                'is_active' => [
                    'type'       => 'TINYINT',
                    'constraint' => 1,
                    'unsigned'   => TRUE,
                    'null'       => FALSE,
                    'default'    => 1,
                ],
            ]);
        }
    }

    public function down()
    {
        // Keep authentication columns to avoid deleting stored password hashes.
    }
}
