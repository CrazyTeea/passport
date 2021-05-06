<?php


namespace app\controllers\app;

use app\models\ObjDocs;
use app\models\ObjDocTypes;
use app\models\Objects;
use app\models\ObjectsArea;
use app\models\ObjectsMoney;
use app\models\ObjectsTariff;
use app\models\ObjFiles;
use app\models\Organizations;
use Yii;
use yii\helpers\Json;
use yii\web\UploadedFile;

class ObjectsController extends AppController
{
    public function actionObject(): string
    {
        if ($post = Yii::$app->request->post()) {
            return Json::encode($post);
        }
        return $this->render('object');
    }

    public function actionArea(): string
    {
        return $this->render('area');
    }

    public function actionTariff(): string
    {
        return $this->render('tariff');
    }

    public function actionMoney(): string
    {
        return $this->render('money');
    }

    public function actionEnd(): string
    {
        return $this->render('end');
    }


    public function actionCreate($id_org): string
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

            $obj->countingNumberFields();
            Organizations::UpdateTime($id_org);
        }
        return Json::encode($ret ?? 'Не верный пост');
    }

    public function actionUpdate($id): string
    {
        if ($post = Yii::$app->request->post()) {
            $post = Json::decode($post['object'], false);

            $obj = Objects::findOne($id);

            Organizations::Active($obj->id_org);

            foreach ($post as $key => $item) {
                if (!in_array($key, ['id_org', 'area', 'money', 'tariff', 'date_start_reconstruct', 'date_end_reconstruct'])) {
                    $obj->$key = $item;
                }
            }
            $obj->date_start_reconstruct =
                $obj->reconstruct ?
                    (is_array($post->date_start_reconstruct) ?
                        (($post->date_start_reconstruct[0] ?? '0000') . '-' . ($post->date_start_reconstruct[1] ?? '01') . '-01') : null) : null;
            $obj->date_end_reconstruct =
                $obj->reconstruct ?
                    (is_array($post->date_end_reconstruct) ?
                        (($post->date_end_reconstruct[0] ?? '0000') . '-' . ($post->date_end_reconstruct[1] ?? '01') . '-01') : null) : null;

            $ret = ['success' => $obj->save(), 'errors' => $obj->getErrors()];
            $obj->countingNumberFields();
            Organizations::UpdateTime($obj->id_org);
        }
        return Json::encode($ret ?? 'Не верный пост');
    }

    public function actionDelete($id): string
    {
        $obj = Objects::findOne($id);
        $obj->system_status = 0;

        $ret = ['success' => $obj->save(), 'errors' => $obj->getErrors()];
        Organizations::UpdateTime($obj->id_org);

        return Json::encode($ret ?? 'Не верный пост');
    }

    public function actionSetArea($id): string
    {
        if ($post = Yii::$app->request->post()) {
            $post = Json::decode($post['area'], false);

            $area = ObjectsArea::findOne(['id_object' => $id]) ?? new ObjectsArea();
            if ($area->isNewRecord) {
                $area->id_object = $id;
            }

            foreach ($post as $key => $item) {
                $area->$key = $item;
            }

            $ret = ['success' => $area->save(), 'errors' => $area->getErrors()];
            $obj = Objects::findOne($id);
            $obj->countingNumberFields();

            Organizations::UpdateTime($obj->id_org);
        }
        return Json::encode($ret ?? 'Не верный пост');
    }

    public function actionSetMoney($id): string
    {
        if ($post = Yii::$app->request->post()) {
            $post = Json::decode($post['money'], false);

            $money = ObjectsMoney::findOne(['id_object' => $id]) ?? new ObjectsMoney();
            if ($money->isNewRecord) {
                $money->id_object = $id;
            }

            foreach ($post as $key => $item) {
                $money->$key = $item;
            }

            $ret = ['success' => $money->save(), 'errors' => $money->getErrors()];
            $obj = Objects::findOne($id);
            $obj->countingNumberFields();
            Organizations::UpdateTime($obj->id_org);
        }
        return Json::encode($ret ?? 'Не верный пост');
    }

    public function actionSetTariff($id): string
    {
        if ($post = Yii::$app->request->post()) {
            $post = Json::decode($post['tariff'], false);

            $tariff = ObjectsTariff::findOne(['id_object' => $id]) ?? new ObjectsTariff();
            if ($tariff->isNewRecord) {
                $tariff->id_object = $id;
            }

            foreach ($post as $key => $item) {
                $tariff->$key = $item;
            }

            $ret = ['success' => $tariff->save(), 'errors' => $tariff->getErrors()];
            $obj = Objects::findOne($id);
            $obj->countingNumberFields();
            Organizations::UpdateTime($obj->id_org);
        }
        return Json::encode($ret ?? 'Не верный пост');
    }

    public function actionUpdateCount($id)
    {
        Objects::findOne($id)->countingNumberFields();
    }
    public function actionDelFile($id_obj)
    {
        $post = Yii::$app->request->post();
        if (!$post) {
            return Json::encode('не верный пост');
        }
        $desc = $post['desc'];

        $file = ObjDocs::find()->joinWith(['descriptor', 'file'])->where(['id_obj' => $id_obj, 'desc' => $desc])->one();

        if ($file->file) {
            $file->file->deleteFile($id_obj, $desc);
            $file->delete();
        }

        $obj = Objects::findOne($id_obj);

        Organizations::UpdateTime($obj->id_org);

        return Json::encode(['success' => true]);
    }


    public function actionSetFiles($id_obj): string
    {
        $post = Yii::$app->request->post();
        if (!$post) {
            return Json::encode(['success' => false, 'error' => ['type' => 2, 'errors' => []]]);
        }
        $desc = $post['desc'];
        $id_desc = ObjDocTypes::findOne(['desc' => $desc])->id ?? null;
        if (!$id_desc) {
            return Json::encode(['success' => false, 'error' => ['type' => 0, 'message' => 'Дескриптор не найден в системе. Обратитесть в тех. поддержку']]);
        }

        $client_file = UploadedFile::getInstanceByName($desc);

        if (!$client_file) {
            return Json::encode(['success' => false, 'error' => ['type' => 1, 'message' => 'Не удалось загрузить файл. Проверьте размер файла и его расширение']]);
        }

        $file = ObjDocs::find()->joinWith(['descriptor'])->where(['id_obj' => $id_obj, 'desc' => $desc])->one() ?? new ObjDocs();
        if ($file->isNewRecord) {
            $file->id_obj = $id_obj;
            $file->id_obj_desc = ObjDocTypes::findOne(['desc' => $desc])->id;
        } elseif ($files = ObjFiles::findOne($file->id_file)) {
            $files->deleteFile($id_obj, $desc);
        }
        $file->id_obj_file = (new ObjFiles())->upload($client_file, $id_obj, $desc);
        $obj = Objects::findOne($id_obj);
        Organizations::UpdateTime($obj->id_org);
        // $post = Json::decode($post,false);
        return Json::encode(['success' => $file->save(), 'error' => ['type' => 2, 'errors' => $file->getErrors()]]);
    }
}
