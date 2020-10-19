<?php


namespace app\controllers\api;


use app\models\User;
use Yii;
use yii\rest\Controller;

class UserController extends Controller
{
    public function actionGetCurrent()
    {
        return User::findOne(Yii::$app->user->id);
    }
}