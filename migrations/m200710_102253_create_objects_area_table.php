<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%objects_area}}`.
 */
class m200710_102253_create_objects_area_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%objects_area}}', [
            'id' => $this->primaryKey(),
            'id_object'=>$this->integer()->notNull(),
            'zan_obuch'=>$this->decimal(22,3),
            'zan_inie'=>$this->decimal(22,3),
            'svobod'=>$this->decimal(22,3),
            'neisp'=>$this->decimal(22,3),
            'punkt_pit'=>$this->decimal(22,3),
            'pom_dlya_uch'=>$this->decimal(22,3),
            'pom_dlya_med'=>$this->decimal(22,3),
            'pom_dlya_sport'=>$this->decimal(22,3),
            'pom_dlya_soc'=>$this->decimal(22,3),
            'in_nezh_plosh'=>$this->decimal(22,3),
            'zhil_tkr'=>$this->decimal(22,3),
            'zhil_nas'=>$this->decimal(22,3),
            'zhil_np'=>$this->decimal(22,3),
            'nzhil_tkr'=>$this->decimal(22,3),
            'nzhil_nas'=>$this->decimal(22,3),
            'nzhil_np'=>$this->decimal(22,3),
            'aren'=>$this->decimal(22,3),
            'pbp'=>$this->decimal(22,3),
            'cnt_mest_zan_obuch'=>$this->integer(),
            'cnt_mest_zan_in_obuch'=>$this->integer(),
            'cnt_svobod_mest'=>$this->integer(),
            'cnt_neisp_mest'=>$this->integer(),
            'cnt_nepr_isp_mest'=>$this->integer(),
            'cnt_mest_inv'=>$this->integer(),
            'cnt_mest_vozm_neisp_mest'=>$this->integer(),
            'cnt_mest_vozm_neprig_mest'=>$this->integer(),
        ]);

        $this->addForeignKey('fk-objects_area-id_object','objects_area','id_object','objects','id','CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%objects_area}}');
    }
}
