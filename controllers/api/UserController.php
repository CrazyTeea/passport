<?php


namespace app\controllers\api;


use app\models\User;
use Yii;
use yii\rest\Controller;

class UserController extends Controller
{
    public function actionGetCurrent()
    {
        $user = User::findOne(Yii::$app->user->id);
        $user['roles']=Yii::$app->getAuthManager()->getRolesByUser($user->id);
        return $user;
    }
}