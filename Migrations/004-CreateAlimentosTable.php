<?php

class CreateAlimentosTable extends Migration
{
    public function up()
    {
        $this->createTable('alimentos', [
            '`id` INT AUTO_INCREMENT PRIMARY KEY',
            '`nome` VARCHAR(255) NOT NULL',
            '`calorias` INT NOT NULL',
            '`proteinas` DECIMAL(5,2)',
            '`carboidratos` DECIMAL(5,2)',
            '`gorduras` DECIMAL(5,2)',
            '`categoria` ENUM("proteina", "carboidrato", "gordura", "vegetal", "fruta")',
            '`created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
            '`updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'
        ]);
        
        // Utilizando nomes únicos para índices para evitar duplicação
        $this->addIndex('alimentos', 'alimentos_nome_idx', 'nome');
        $this->addIndex('alimentos', 'alimentos_categoria_idx', 'categoria');
    }

    public function down()
    {
        $this->dropTable('alimentos');
    }
} 