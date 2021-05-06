<?php

use yii\db\Migration;

/**
 * Class m210402_190645_add_colls
 */
class m210402_190645_add_colls extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\app\models\Organizations::tableName(), 'covid_var1', $this->boolean()
            ->comment('Наличие мер поддержки обучающихся, проживающих в общежитиях, 
            в связи с распространением новой коронавирусной инфекции (COVID-19)'));
        $this->addColumn(\app\models\Organizations::tableName(), 'covid_var2', $this->integer()
            ->comment('Описание мер поддержки обучающихся, проживающих в общежитиях,
             в связи с распространением новой коронавирусной инфекции (COVID-19)'));
        $this->addColumn(\app\models\Organizations::tableName(), 'covid_var3', $this->decimal(22, 2)
            ->comment('Объем средств, направленных на 
            осуществление мер поддержки обучающихся, проживающих в общежитиях, 
            в связи с распространением новой коронавирусной инфекции (COVID-19)'));
        $this->addColumn(\app\models\Organizations::tableName(), 'covid_var4', $this->decimal(22, 2)
            ->comment('Объем недополученных доходов в связи со снижением платы за проживание, платы за коммунальные услуги и т.д.,
             в рамках оказания мер поддержки обучающихся в связи с распространением новой коронавирусной инфекции (COVID-19)'));
        $this->addColumn(\app\models\Organizations::tableName(), 'covid_var5', $this->decimal(22, 2)
            ->comment('Объем средств, 
            затраченных на противоэпидемиологические мероприятия (в соответствии с рекомендациями Роспотребнадзора)'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210402_190645_add_colls cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210402_190645_add_colls cannot be reverted.\n";

        return false;
    }
    */
}
