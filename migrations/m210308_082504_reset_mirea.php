<?php

use yii\db\Migration;

/**
 * Class m210308_082504_reset_mirea
 */
class m210308_082504_reset_mirea extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        \app\models\Objects::deleteAll(['id_org'=>100]);
        \app\models\OrgArea::deleteAll(['id_org'=>100]);
        \app\models\OrgInfo::deleteAll(['id_org'=>100]);
        \app\models\OrgDocs::deleteAll(['id_org'=>100]);
        \app\models\OrgLiving::deleteAll(['id_org'=>100]);
        \app\models\OrgLivingStudents::deleteAll(['id_org'=>100]);

        $user = \app\models\User::findOne(['username'=>'user2@admin.ru']) ?? new \app\models\User();
        $user->username = 'user2@admin.ru';
        $user->id_org = 2;
        $user->generateAuthKey();
        $user->generatePasswordResetToken();
        $user->setPassword('password');
        $user->status = 10;
        if ($user->save()){
            $role = new \yii\rbac\PhpManager();
            $role->revokeAll($user->id);
            $role->assign($role->getRole('user'),$user->id);

        }


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210308_082504_reset_mirea cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210308_082504_reset_mirea cannot be reverted.\n";

        return false;
    }
    */
}
