<?php

use yii\db\Migration;

/**
 * Class m210319_084209_add_fk
 */
class m210319_084209_add_fk extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $sql = "delete FROM org_docs where id_file not in (select id from files)";
        $this->execute($sql);
        \app\models\OrgDocs::deleteAll(['is','id_file',null]);
        $this->addForeignKey(
            'fk-org_docs-id_file',
            'org_docs',
            'id_file',
            'files',
            'id',
            'CASCADE',
            'CASCADE');
        $this->addForeignKey(
            'fk-org_docs_id_org',
            'org_docs',
            'id_org',
            'organizations',
            'id',
            'CASCADE',
            'CASCADE');
        $this->addForeignKey(
            'fk-org_docs_id_desc',
            'org_docs',
            'id_desc',
            'doc_types',
            'id',
            'CASCADE',
            'CASCADE');
    }


    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210319_084209_add_fk cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210319_084209_add_fk cannot be reverted.\n";

        return false;
    }
    */
}
