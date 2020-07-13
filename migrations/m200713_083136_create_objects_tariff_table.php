<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%objects_tariff}}`.
 */
class m200713_083136_create_objects_tariff_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%objects_tariff}}', [
            'id' => $this->primaryKey(),
            'id_object'=>$this->integer()->notNull(),

            'u_t_b'=>$this->decimal(22,3),
            'k_u_b'=>$this->decimal(22,3),
            'p_p_b'=>$this->decimal(22,3),
            'd_u_b'=>$this->decimal(22,3),

            'u_t_p'=>$this->decimal(22,3),
            'k_u_p'=>$this->decimal(22,3),
            'p_p_p'=>$this->decimal(22,3),
            'd_u_p'=>$this->decimal(22,3),

            'u_t_nr'=>$this->decimal(22,3),
            'k_u_nr'=>$this->decimal(22,3),
            'p_p_nr'=>$this->decimal(22,3),
            'd_u_nr'=>$this->decimal(22,3),

            'u_t_do'=>$this->decimal(22,3),
            'k_u_do'=>$this->decimal(22,3),
            'p_p_do'=>$this->decimal(22,3),
            'd_u_do'=>$this->decimal(22,3),

            'u_t_in'=>$this->decimal(22,3),
            'k_u_in'=>$this->decimal(22,3),
            'p_p_in'=>$this->decimal(22,3),
            'd_u_in'=>$this->decimal(22,3),
        ]);
        $this->addForeignKey('fk-objects_tariff_id_object','objects_tariff','id_object','objects','id','CASCADE','CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%objects_tariff}}');
    }
}
