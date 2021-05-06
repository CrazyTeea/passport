<?php

use app\models\Organizations;
use yii\db\Migration;

/**
 * Class m210409_112439_add_last_updated_at
 */
class m210409_112439_add_last_updated_at extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(Organizations::tableName(), 'last_updated_at', $this->timestamp());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210409_112439_add_last_updated_at cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210409_112439_add_last_updated_at cannot be reverted.\n";

        return false;
    }
    */
}
