<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%obj_doc_types}}`.
 */
class m210329_072027_create_obj_doc_types_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%obj_doc_types}}', [
            'id' => $this->primaryKey(),
            'desc' => $this->string(),
            'label' => $this->text()
        ]);
        $this->createTable('{{%obj_docs}}', [
            'id' => $this->primaryKey(),
            'id_obj_desc' => $this->integer(),
            'id_obj' => $this->integer(),
            'id_obj_file' => $this->integer(),
        ]);
        $this->createTable('{{%obj_files}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()
        ]);

        $this->addForeignKey(
            'fk-obj_docs-id_obj_desc',
            'obj_docs',
            'id_obj_desc',
            'obj_doc_types',
            'id',
            'CASCADE',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-obj_docs-id_obj',
            'obj_docs',
            'id_obj',
            'objects',
            'id',
            'CASCADE',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-obj_docs-id_obj_file',
            'obj_docs',
            'id_obj_file',
            'obj_files',
            'id',
            'CASCADE',
            'CASCADE'
        );


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%obj_doc_types}}');
    }
}
