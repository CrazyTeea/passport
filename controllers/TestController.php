<?php


namespace app\controllers;


use yii\helpers\Json;
use yii\httpclient\Client;
use yii\web\Controller;
use yii\web\UploadedFile;

class TestController extends Controller
{
    public function actionUpload(){
        $file = UploadedFile::getInstanceByName('file');
        return Json::encode($file);
    }

    public function actionKek($id_org)
{
    $client = new Client();
    $response = $client->createRequest()
        ->setUrl('https://xn--b1adcgjb2abq4al4j.xn--80apneeq.xn--p1ai/api/graph?access-token=23498jfskduespq0')
        ->setMethod('POST')
        ->setData(['query' => "{
            realEstates(id_org:{$id_org}){              
                cadastral_number
                egrn_id_region
                id
                object_name
                objectEgrnAddress
            }
        }"])->send();
    return Json::encode($response->getData()['data']['realEstates']);
}
}