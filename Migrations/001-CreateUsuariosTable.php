<?php

class CreateUsuariosTable extends Migration
{
    public function up()
    {
        $this->createTable('usuarios', [
            '`id` INT AUTO_INCREMENT PRIMARY KEY',
            '`name` VARCHAR(255) NOT NULL',
            '`email` VARCHAR(255) NOT NULL UNIQUE',
            '`password` VARCHAR(255) NOT NULL',
            '`status` ENUM("active", "inactive") NOT NULL DEFAULT "active"',
            '`role` ENUM("admin", "user") NOT NULL DEFAULT "user"',
            '`created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
            '`updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'
        ]);

        // Adicionando índices para melhor performance
        $this->addIndex('usuarios', 'email_index', 'email');
        $this->addIndex('usuarios', 'status_index', 'status');
    }

    public function down()
    {
        $this->dropTable('usuarios');
    }
} 