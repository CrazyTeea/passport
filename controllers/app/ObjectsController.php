<?php


namespace app\controllers\app;


use app\models\Objects;
use app\models\ObjectsArea;
use app\models\ObjectsMoney;
use app\models\ObjectsTariff;
use app\models\Organizations;
use Yii;
use yii\helpers\Json;
use yii\web\Controller;

class ObjectsController extends AppController
{
    public function actionObject($id = null)
    {
        if ($post = Yii::$app->request->post()) {
            return Json::encode($post);
        }
        return $this->render('object');
    }

    public function actionArea()
    {
        return $this->render('area');
    }

    public function actionTariff()
    {
        return $this->render('tariff');
    }

    public function actionMoney()
    {
        return $this->render('money');
    }

    public function actionCreate($id_org)
    {
        if ($post = Yii::$app->request->post()) {
            $post = Json::decode($post['object'], false);

            $obj = new Objects();
            $obj->id_org = $id_org;

            Organizations::Active($id_org);

            foreach ($post as $key => $item) {
                $obj->$key = $item;
            }

            $ret = ['success' => $obj->save(), 'errors' => $obj->getErrors()];

        }
        return Json::encode($ret ?? 'Не верный пост');
    }

    public function actionUpdate($id)
    {
        if ($post = Yii::$app->request->post()) {
            $post = Json::decode($post['object'], false);

            $obj = Objects::findOne($id);

            Organizations::Active($obj->id_org);

            foreach ($post as $key => $item) {
                if (!in_array($key, ['id_org', 'area', 'money', 'tariff']))
                    $obj->$key = $item;
            }

            $ret = ['success' => $obj->save(), 'errors' => $obj->getErrors()];

        }
        return Json::encode($ret ?? 'Не верный пост');
    }

    public function actionSetArea($id)
    {
        if ($post = Yii::$app->request->post()) {
            $post = Json::decode($post['area'], false);

            $area = ObjectsArea::findOne(['id_object' => $id]) ?? new ObjectsArea();
            if ($area->isNewRecord)
                $area->id_object = $id;

            foreach ($post as $key => $item) {
                $area->$key = $item;
            }

            $ret = ['success' => $area->save(), 'errors' => $area->getErrors()];

        }
        return Json::encode($ret ?? 'Не верный пост');
    }

    public function actionSetMoney($id)
    {
        if ($post = Yii::$app->request->post()) {
            $post = Json::decode($post['money'], false);

            $money = ObjectsMoney::findOne(['id_object' => $id]) ?? new ObjectsMoney();
            if ($money->isNewRecord)
                $money->id_object = $id;

            foreach ($post as $key => $item) {
                $money->$key = $item;
            }

            $ret = ['success' => $money->save(), 'errors' => $money->getErrors()];

        }
        return Json::encode($ret ?? 'Не верный пост');
    }

    public function actionSetTariff($id)
    {
        if ($post = Yii::$app->request->post()) {
            $post = Json::decode($post['tariff'], false);

            $tariff = ObjectsTariff::findOne(['id_object' => $id]) ?? new ObjectsTariff();
            if ($tariff->isNewRecord)
                $tariff->id_object = $id;

            foreach ($post as $key => $item) {
                $tariff->$key = $item;
            }

            $ret = ['success' => $tariff->save(), 'errors' => $tariff->getErrors()];

        }
        return Json::encode($ret ?? 'Не верный пост');
    }
}