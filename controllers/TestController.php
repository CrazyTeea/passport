<?php


namespace app\controllers;


use yii\helpers\Json;
use yii\web\Controller;
use yii\web\UploadedFile;

class TestController extends Controller
{
    public function actionUpload(){
        $file = UploadedFile::getInstanceByName('file');
        return Json::encode($file);
    }
}