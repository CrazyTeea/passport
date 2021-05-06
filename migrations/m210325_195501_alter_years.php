<?php

use yii\db\Migration;

/**
 * Class m210325_195501_alter_years
 */
class m210325_195501_alter_years extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $objects = \app\models\Objects::find()->all();

        $this->alterColumn('objects', 'stroy_date_start', $this->integer(4));
        $this->alterColumn('objects', 'stroy_date_end', $this->integer(4));
        $this->alterColumn('objects', 'exp_date', $this->integer(4));

        foreach ($objects as $obj) {
            $obj->stroy_date_start = ($obj->stroy_date_start ? date('Y', strtotime($obj->stroy_date_start)) : null);
            $obj->stroy_date_end = ($obj->stroy_date_end ? date('Y', strtotime($obj->stroy_date_end)) : null);
            $obj->exp_date = ($obj->exp_date ? date('Y', strtotime($obj->exp_date)) : null);
            $obj->save(false);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210325_195501_alter_years cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210325_195501_alter_years cannot be reverted.\n";

        return false;
    }
    */
}
