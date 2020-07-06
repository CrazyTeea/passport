<?php

use yii\db\Migration;

/**
 * Class m200706_085431_change_org_table
 */
class m200706_085431_change_org_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        /*
        'stud_cnt'=>$this->integer()->defaultValue(0),
            'stud_cnt_rus'=>$this->integer()->defaultValue(0),
            'stud_cnt_inos'=>$this->integer()->defaultValue(0),
        */

        

        $this->addColumn('organizations','stud_cnt',$this->integer()->defaultValue(0));
        $this->addColumn('organizations','stud_cnt_rus',$this->integer()->defaultValue(0));
        $this->addColumn('organizations','stud_cnt_inos',$this->integer()->defaultValue(0));


        $this->dropColumn('org_info','stud_cnt');
        $this->dropColumn('org_info','stud_cnt_rus');
        $this->dropColumn('org_info','stud_cnt_inos');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200706_085431_change_org_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200706_085431_change_org_table cannot be reverted.\n";

        return false;
    }
    */
}
