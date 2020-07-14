<?php

use yii\db\Migration;

/**
 * Class m200713_130410_add_type
 */
class m200713_130410_add_type extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('files',[
           'id'=>$this->primaryKey(),
           'name'=>$this->text()
        ]);
        $this->addColumn('org_docs','id_file',$this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200713_130410_add_type cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200713_130410_add_type cannot be reverted.\n";

        return false;
    }
    */
}
