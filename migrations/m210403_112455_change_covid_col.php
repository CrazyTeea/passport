<?php

use yii\db\Migration;

/**
 * Class m210403_112455_change_covid_col
 */
class m210403_112455_change_covid_col extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn(\app\models\Organizations::tableName(), 'covid_var2', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210403_112455_change_covid_col cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210403_112455_change_covid_col cannot be reverted.\n";

        return false;
    }
    */
}
