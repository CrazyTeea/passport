<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%org_living}}`.
 */
class m200707_075416_create_org_living_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%org_living}}', [
            'id' => $this->primaryKey(),
            'id_org'=>$this->integer()->notNull(),
            'cnt_stud'=>$this->integer(),
            'cnt_stud_obuch'=>$this->integer(),
            'cnt_stug_step'=>$this->integer(),
            'prozh_is_person'=>$this->integer(),
            'rab_p'=>$this->integer(),
            'rab_s'=>$this->integer(),
            'nauch_p'=>$this->integer(),
            'nauch_s'=>$this->integer(),
            'prof_p'=>$this->integer(),
            'prof_s'=>$this->integer(),
            'in_p'=>$this->integer(),
            'inie_pr'=>$this->integer(),

        ]);
        $this->addForeignKey('fk-org_liv-id_org','org_living','id_org','organizations','id','CASCADE','CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%org_living}}');
    }


}
