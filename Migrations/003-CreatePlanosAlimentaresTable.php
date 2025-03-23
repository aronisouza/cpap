<?php

class CreatePlanosAlimentaresTable extends Migration
{
    public function up()
    {
        $this->createTable('planos_alimentares', [
            '`id` INT AUTO_INCREMENT PRIMARY KEY',
            '`usuario_id` INT NOT NULL',
            '`calorias_diarias` INT',
            '`data_criacao` DATE',
            '`created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
            '`updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
            'FOREIGN KEY (`usuario_id`) REFERENCES `usuarios`(`id`)'
        ]);
        
        // Adicionando índices para melhor performance
        $this->addIndex('planos_alimentares', 'usuario_id_index', 'usuario_id');
    }

    public function down()
    {
        $this->dropTable('planos_alimentares');
    }
} 