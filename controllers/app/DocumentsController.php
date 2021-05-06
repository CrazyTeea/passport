<?php


namespace app\controllers\app;

use app\models\ObjDocs;
use app\models\OrgDocs;
use Yii;
use yii\web\NotFoundHttpException;

class DocumentsController extends AppController
{
    public function actionIndex(): string
    {
        return $this->render('index');
    }


    public function actionGetDoc($id)
    {
        $doc = OrgDocs::findOne($id);
        if (!$doc) {
            throw new NotFoundHttpException('Файл не найден');
        }
        $path = Yii::getAlias('@webroot') . "/uploads/orgs/{$doc->id_org}/{$doc->descriptor->desc}/{$doc->file->name}";
        if (!(file_exists($path) and is_file($path))) {
            throw new NotFoundHttpException('Файл не найден');
        }
        return Yii::$app->response->sendFile($path, $doc->file->name, ['inline' => true]);
    }
    public function actionGetObjDoc($id)
    {
        $doc = ObjDocs::findOne($id);
        if (!$doc) {
            throw new NotFoundHttpException('Файл не найден');
        }
        $path = Yii::getAlias('@webroot') . "/uploads/objs/{$doc->id_obj}/{$doc->descriptor->desc}/{$doc->file->name}";
        if (!(file_exists($path) and is_file($path))) {
            throw new NotFoundHttpException('Файл не найден');
        }
        return Yii::$app->response->sendFile($path, $doc->file->name, ['inline' => true]);
    }
}
