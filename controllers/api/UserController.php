<?php


namespace app\controllers\api;

use app\models\User;
use Yii;
use yii\rest\Controller;

class UserController extends Controller
{
    public function actionGetCurrent()
    {
        $user = User::find()->select(['id','id_org','username','name','position'])
            ->where(['id'=>Yii::$app->user->id])->one();
        $user['roles']=Yii::$app->getAuthManager()->getRolesByUser($user->id);
        return $user;
    }
}
