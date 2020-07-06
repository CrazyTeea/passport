<?php

use phpDocumentor\Reflection\Types\Integer;
use yii\db\Migration;

/**
 * Handles the creation of table `{{%org_info}}`.
 */
class m200706_065011_create_org_info_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%org_info}}', [
            'id' => $this->primaryKey(),
            'id_org'=>$this->integer(),
            

            'stud_type'=>$this->boolean()->defaultValue(0),

            's_f_b_spo'=>$this->integer()->defaultValue(0),
            's_f_b_bak'=>$this->integer()->defaultValue(0),
            's_f_b_spec'=>$this->integer()->defaultValue(0),
            's_f_b_mag'=>$this->integer()->defaultValue(0),
            's_f_b_asp'=>$this->integer()->defaultValue(0),
            's_f_b_ord'=>$this->integer()->defaultValue(0),
            's_f_b_in'=>$this->integer()->defaultValue(0),

            's_b_s_spo'=>$this->integer()->defaultValue(0),
            's_b_s_bak'=>$this->integer()->defaultValue(0),
            's_b_s_spec'=>$this->integer()->defaultValue(0),
            's_b_s_mag'=>$this->integer()->defaultValue(0),
            's_b_s_asp'=>$this->integer()->defaultValue(0),
            's_b_s_ord'=>$this->integer()->defaultValue(0),
            's_b_s_in'=>$this->integer()->defaultValue(0),

            's_m_b_spo'=>$this->integer()->defaultValue(0),
            's_m_b_bak'=>$this->integer()->defaultValue(0),
            's_m_b_spec'=>$this->integer()->defaultValue(0),
            's_m_b_mag'=>$this->integer()->defaultValue(0),
            's_m_b_asp'=>$this->integer()->defaultValue(0),
            's_m_b_ord'=>$this->integer()->defaultValue(0),
            's_m_b_in'=>$this->integer()->defaultValue(0),

            's_p_u_spo'=>$this->integer()->defaultValue(0),
            's_p_u_bak'=>$this->integer()->defaultValue(0),
            's_p_u_spec'=>$this->integer()->defaultValue(0),
            's_p_u_mag'=>$this->integer()->defaultValue(0),
            's_p_u_asp'=>$this->integer()->defaultValue(0),
            's_p_u_ord'=>$this->integer()->defaultValue(0),
            's_p_u_in'=>$this->integer()->defaultValue(0),


        ]);

        $this->addForeignKey('fk-org_info-id_org','org_info','id_org','organizations','id','CASCADE','CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%org_info}}');
    }
}
