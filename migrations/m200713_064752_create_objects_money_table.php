<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%objects_money}}`.
 */
class m200713_064752_create_objects_money_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%objects_money}}', [
            'id' => $this->primaryKey(),
            'id_object'=>$this->integer(),
            'money_prozh_bez_dop'=>$this->decimal(22,3),
            'money_prozh_dop'=>$this->decimal(22,3),
            'money_aren'=>$this->decimal(22,3),
            'money_cel_sred'=>$this->decimal(22,3),
            'voda'=>$this->decimal(22,3),
            'tep'=>$this->decimal(22,3),
            'gaz'=>$this->decimal(22,3),
            'elect'=>$this->decimal(22,3),
            'uborka_ter'=>$this->decimal(22,3),
            'uborka_pom'=>$this->decimal(22,3),
            'tech_obs'=>$this->decimal(22,3),
            'derivation'=>$this->decimal(22,3),
            'tbo'=>$this->decimal(22,3),
            'gos_prov'=>$this->decimal(22,3),
            'attest'=>$this->decimal(22,3),
            'prot_pozhar'=>$this->decimal(22,3),
            'inie_rash'=>$this->decimal(22,3),
            'ohrana'=>$this->decimal(22,3),
            'anti_ter'=>$this->decimal(22,3),
            'inie_rash_ohrana'=>$this->decimal(22,3),
            'nalog_imush'=>$this->decimal(22,3),
            'zem_nalog'=>$this->decimal(22,3),
            'svaz'=>$this->decimal(22,3),
            'kap_rem'=>$this->decimal(22,3),
            'tek_rem'=>$this->decimal(22,3),
            'mygk_inv'=>$this->decimal(22,3),
            'osn_sred'=>$this->decimal(22,3),
            'opla_trud'=>$this->decimal(22,3),
        ]);
        $this->addForeignKey('fk-objects_money_id_object','objects_money','id_object','objects','id','CASCADE','CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%objects_money}}');
    }
}
