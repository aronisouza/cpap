<?php

class CreateDadosUsuariosTable extends Migration
{
    public function up()
    {
        $this->createTable('dados_usuarios', [
            '`id` INT AUTO_INCREMENT PRIMARY KEY',
            '`usuario_id` INT NOT NULL',
            '`peso` DECIMAL(5,2)',
            '`altura` DECIMAL(3,2)',
            '`idade` TINYINT',
            '`atividade_fisica` ENUM("sedentario", "leve", "moderado", "ativo", "muito_ativo")',
            '`objetivo` ENUM("emagrecimento", "ganho_massa", "manutencao")',
            '`created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
            '`updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
            'FOREIGN KEY (`usuario_id`) REFERENCES `usuarios`(`id`)'
        ]);
        
        // Adicionando índices para melhor performance
        $this->addIndex('dados_usuarios', 'usuario_id_index', 'usuario_id');
    }

    public function down()
    {
        $this->dropTable('dados_usuarios');
    }
} 