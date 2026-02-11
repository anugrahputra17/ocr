<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateInvoicesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'filename' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'invoice_number' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'invoice_date' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => true,
            ],
            'supplier' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'total_amount' => [
                'type'       => 'DECIMAL',
                'constraint' => '18,2',
                'null'       => true,
            ],
            'currency' => [
                'type'       => 'VARCHAR',
                'constraint' => '10',
                'null'       => true,
            ],
            'raw_text' => [
                'type' => 'LONGTEXT',
                'null' => true,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['processing', 'completed', 'failed'],
                'default'    => 'processing',
            ],
            'created_at DATETIME default current_timestamp',
            'updated_at DATETIME default current_timestamp on update current_timestamp'
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('invoices');
    }

    public function down()
    {
        $this->forge->dropTable('invoices');
    }
}
