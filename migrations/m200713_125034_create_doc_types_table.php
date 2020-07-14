<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%doc_types}}`.
 */
class m200713_125034_create_doc_types_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%doc_types}}', [
            'id' => $this->primaryKey(),
            'desc'=>$this->string(),
            'label'=>$this->text(),
        ]);
        $this->createTable('{{%org_docs}}', [
            'id' => $this->primaryKey(),
            'id_desc'=>$this->integer(),
            'id_org'=>$this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%doc_types}}');
    }
}
