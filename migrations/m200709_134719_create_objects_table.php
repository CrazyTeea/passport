<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%objects}}`.
 */
class m200709_134719_create_objects_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%objects}}', [
            'id' => $this->primaryKey(),
            'id_org'=>$this->integer()->notNull(),
            'name'=>$this->text(),
            'address'=>$this->text(),
            'id_region'=>$this->integer()->notNull(),
            'kad_number'=>$this->text(),
            'osn_isp'=>"ENUM('pou','da','dbp','sob','inoe')",
            'reg_zap'=>$this->string(),
            'doc_number'=>$this->string(),
            'flat_plan'=>"ENUM('kor','bloch','kvar','gost')",
            'flat_type'=>"ENUM('odn','dvuh','treh','smesh')",
            'prib_type'=>"ENUM('ind','obsh','ots')",
            'smet'=>$this->decimal(22,3),
            'stroy_date_start'=>$this->date(),
            'stroy_date_end'=>$this->date(),
            'exp_date'=>$this->date(),
            'ob_fin_stroy'=>$this->date(),
            'money_faip'=>$this->decimal(22,3),
            'money_bud_sub'=>$this->decimal(22,3),
            'money_vneb'=>$this->decimal(22,3),
            'reconstruct'=>$this->boolean(),
            'ustav_dey'=>$this->boolean(),
        ]);
        $this->addForeignKey('fk-objects-id_org','objects','id_org','organizations','id','CASCADE','CASCADE');
        $this->addForeignKey('fk-objects-id_region','objects','id_region','regions','id','CASCADE','CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%objects}}');
    }
}
