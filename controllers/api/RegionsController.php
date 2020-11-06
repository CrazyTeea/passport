<?php


namespace app\controllers\api;


use app\models\Countries;
use app\models\Objects;
use app\models\Organizations;
use app\models\Regions;
use yii\rest\Controller;

class RegionsController extends Controller
{
    public function actionAll()
    {
        return Regions::find()->all();
    }

    public function actionById($id)
    {
        return Regions::findOne($id);
    }

    public function actionCountries()
    {
        return Countries::find()->all();
    }
}