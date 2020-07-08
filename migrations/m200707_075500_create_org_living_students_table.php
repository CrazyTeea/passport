<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%org_living_students}}`.
 */
class m200707_075500_create_org_living_students_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%org_living_students}}', [
            'id' => $this->primaryKey(),
            'id_org'=>$this->integer(),
            'id_living'=>$this->integer(),
            'type'=>"ENUM('rf_och','in_och','rf_zaoch','in_zaoch','rf_ochzaoch','in_ochzaoch','inv')",
            'name'=>$this->text(),
            'spo'=>$this->integer(),
            'bak'=>$this->integer(),
            'spec'=>$this->integer(),
            'mag'=>$this->integer(),
            'asp'=>$this->integer(),
            'ord'=>$this->integer(),
            'in'=>$this->integer()
        ]);
        $this->addForeignKey('fk-org_liv_students-id_org','org_living_students','id_org','organizations','id','CASCADE','CASCADE');
        $this->addForeignKey('fk-org_liv_students-id_living','org_living_students','id_living','org_living','id','CASCADE','CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%org_living_students}}');
    }
}
