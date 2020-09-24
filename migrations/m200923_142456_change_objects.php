<?php

use yii\db\Migration;

/**
 * Class m200923_142456_change_objects
 */
class m200923_142456_change_objects extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        foreach (\app\models\Objects::find()->all() as $obj){
            $obj->reg_zap = null;
            $obj->osn_isp = null;
            $obj->save(false);
        }
        $this->alterColumn(\app\models\Objects::tableName(),'reg_zap',$this->date());
        $this->alterColumn(\app\models\Objects::tableName(),'osn_isp',$this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200923_142456_change_objects cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200923_142456_change_objects cannot be reverted.\n";

        return false;
    }
    */
}
