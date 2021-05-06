<?php


namespace app\controllers\app;

use app\models\DocTypes;
use app\models\Files;
use app\models\Organizations;
use app\models\OrgArea;
use app\models\OrgDocs;
use app\models\OrgInfo;
use app\models\OrgLiving;
use app\models\OrgLivingStudents;
use app\models\UsersInfo;
use Yii;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class OrganizationsController extends AppController
{
    public function actionUsersInfo($id): string
    {
        if ($post = Yii::$app->request->post()) {
            $data = Json::decode($post['users'], false);

            Organizations::Active($id);

            foreach ($data as $item) {
                $info = UsersInfo::findOne($item->id) ?? new UsersInfo();
                $info->id_org = $id;
                $info->name = $item->name;
                $info->position = $item->position;
                $info->email = $item->email;
                $info->phone = $item->phone;
                $ret[] = [$item->email => ['success' => $info->save(), 'errors' => $info->getErrors()]];
            }
        }
        return Json::encode($ret ?? []);
    }

    public function actionDeleteUsersInfo($id): string
    {
        return Json::encode(['success' => UsersInfo::deleteAll(['id' => $id]) > 0]);
    }

    public function actionSetFiles($id_org): string
    {
        $post = Yii::$app->request->post();
        if (!$post) {
            return Json::encode(['success' => false, 'error' => ['type' => 2, 'errors' => []]]);
        }
        $desc = $post['desc'];
        $id_desc = DocTypes::findOne(['desc' => $desc])->id ?? null;
        if (!$id_desc) {
            return Json::encode(['success' => false, 'error' => ['type' => 0, 'message' => 'Дескриптор не найден в системе. Обратитесть в тех. поддержку']]);
        }

        $client_file = UploadedFile::getInstanceByName($desc);

        if (!$client_file) {
            return Json::encode(['success' => false, 'error' => ['type' => 1, 'message' => 'Не удалось загрузить файл. Проверьте размер файла и его расширение']]);
        }

        $file = OrgDocs::find()->joinWith(['descriptor'])->where(['id_org' => $id_org, 'desc' => $desc])->one() ?? new OrgDocs();
        if ($file->isNewRecord) {
            $file->id_org = $id_org;
            $file->id_desc = DocTypes::findOne(['desc' => $desc])->id;
        } elseif ($files = Files::findOne($file->id_file)) {
            $files->deleteFile($id_org, $desc);
        }
        $file->id_file = (new Files())->upload($client_file, $id_org, $desc);
        // $post = Json::decode($post,false);
        return Json::encode(['success' => $file->save(), 'error' => ['type' => 2, 'errors' => $file->getErrors()]]);
    }

    public function actionDelFile($id_org)
    {
        $post = Yii::$app->request->post();
        if (!$post) {
            return Json::encode('не верный пост');
        }
        $desc = $post['desc'];

        $file = OrgDocs::find()->joinWith(['descriptor', 'file'])->where(['id_org' => $id_org, 'desc' => $desc])->one();

        if ($file->file) {
            $file->file->deleteFile($id_org, $desc);
            $file->delete();
        }
        return Json::encode(['success' => true]);
    }

    public function actionSetOrgInfo($id): string
    {
        $post = Yii::$app->request->post();
        if (!$post) {
            return Json::encode('не верный пост');
        }
        $post = Json::decode($post['org'], false);
        $org = Organizations::findOne($id);
        $org->stud_cnt = $post->organization->stud_cnt;
        $org->stud_cnt_inos = $post->organization->stud_cnt_inos;
        $org->stud_cnt_rus = $post->organization->stud_cnt_rus;
        $org_save = $org->save();

        Organizations::Active($id);

        $org_docs = OrgDocs::findAll(['id_desc' => [1, 2], 'id_org' => $id]);
        if (!$org_docs) {
            $org_doc = new OrgDocs();
            $org_doc->id_org = $id;
            $org_doc->id_desc = 1;
            $org_doc->save();

            $org_doc = new OrgDocs();
            $org_doc->id_org = $id;
            $org_doc->id_desc = 2;
            $org_doc->save();
        }

        $info_save = [];
        foreach ($post->info as $info) {
            $inf = OrgInfo::findOne($info->id ?? null) ?? new OrgInfo();

            $inf->id_org = $id;

            $inf->stud_type = $info->stud_type;

            foreach ($info as $key => $value) {
                if (in_array(
                    $key,
                    [
                        'spo_all', 'bak_all', 'spec_all',
                        'mag_all', 'asp_all', 'ord_all',
                        'in_all', 'all', 's_f_b_all',
                        's_b_s_all', 's_m_b_all', 's_p_u_all',
                        'id', 'id_org', 'stud_type']
                )) {
                    continue;
                }
                $inf->$key = $value;
            }

            $info_save[$inf->stud_type] = ['success' => $inf->save(), 'errors' => $inf->getErrors()];
        }
        $ret = ['org' => ['success' => $org_save, 'errors' => $org->getErrors()], 'info' => $info_save];

        $org->countingNumberFields();
        Organizations::UpdateTime($id);
        return Json::encode($ret);
    }

    public function actionSetOrgArea($id): string
    {
        if ($post = Yii::$app->request->post()) {
            $post = Json::decode($post['org_area'], false);
            $area = OrgArea::findOne(['id_org' => $id]) ?? new OrgArea();
            $area->id_org = $id;

            Organizations::Active($id);

            foreach ($post as $key => $column) {
                if (in_array($key, ['id', 'id_org', 'area_cnt_mest'])) {
                    continue;
                }
                $area->$key = $post->$key;
            }

            $ret = ['org_area' => ['success' => $area->save(), 'errors' => $area->getErrors()]];

            Organizations::findOne($id)->countingNumberFields();
            Organizations::UpdateTime($id);
        }
        return Json::encode($ret ?? 'не верный пост');
    }

    public function actionSetOrgLiving($id): string
    {
        if ($post = Yii::$app->request->post()) {
            $post = Json::decode($post['org_living'], false);
            $liv = OrgLiving::findOne(['id_org' => $id]) ?? new OrgLiving();

            $liv->id_org = $id;

            Organizations::Active($id);

            if (isset($post->living)) {
                foreach ($post->living as $key => $item) {
                    $liv->$key = $item;
                }
            }

            $living_studs = [];

            $del = Json::decode(Yii::$app->request->post('toDelete')) ?? null;

            if ($del) {
                OrgLivingStudents::deleteAll(['id' => $del]);
            }

            foreach ($post->living_studs as $item) {
                $stud_item = Json::decode(Json::encode($item), false);
                if (isset($stud_item->label) and $stud_item->label == 'Всего' or !isset($stud_item->type)) {
                    continue;
                }
                $stud = isset($stud_item->id) ? OrgLivingStudents::findOne($stud_item->id) : new OrgLivingStudents();
                if ($stud->isNewRecord) {
                    $stud->invalid = $post->invalid;
                    $stud->id_org = $id;
                    $stud->id_living = $liv->id;
                }

                $stud->type = $stud_item->type;
                $stud->name = $stud_item->name;
                $stud->budjet_type = $stud_item->budjet_type;
                $stud->spo = $stud_item->spo ?? null;
                $stud->bak = $stud_item->bak ?? null;
                $stud->spec = $stud_item->spec ?? null;
                $stud->mag = $stud_item->mag ?? null;
                $stud->asp = $stud_item->asp ?? null;
                $stud->ord = $stud_item->ord ?? null;
                $stud->in = $stud_item->in ?? null;
                if (is_null($stud->spec) and
                    is_null($stud->spo) and
                    is_null($stud->asp) and
                    is_null($stud->bak) and
                    is_null($stud->mag) and
                    is_null($stud->ord) and
                    is_null($stud->in)) {
                    continue;
                }
                $living_studs[] = [
                    'success' =>
                        $stud->save(),
                    'errors' =>
                        $stud->errors];
            }
            $ret = [
                'org_living' =>
                    ['success' =>
                        $liv->save(),
                        'errors' =>
                            $liv->getErrors()
                    ],
                'living_studs' => $living_studs];

            Organizations::findOne($id)->countingNumberFields();
            Organizations::UpdateTime($id);
        }
        return Json::encode($ret ?? 'не верный пост');
    }

    public function actionSetOrgValue($id): string
    {
        $org = Organizations::findOne($id);
        if (!$org) {
            throw new NotFoundHttpException("Организация не найдена");
        }
        $value = Yii::$app->request->post('value');
        $attr = Yii::$app->request->post('attr');
        $org->$attr = $value;
        Organizations::UpdateTime($id);
        return Json::encode(['success' => $org->save(), 'errors' => $org->getErrors(), $value]);
    }

    public function actionSetOrgCovid($id): string
    {
        $org = Organizations::findOne($id);

        $colls = ['covid_var1','covid_var2','covid_var3','covid_var4','covid_var5'];

        $post = Yii::$app->request->post('organization');

        $data = Json::decode($post, false);

        foreach ($colls as $coll) {
            $org->$coll = $data->$coll;
        }

        $org->countingNumberFields();
        Organizations::UpdateTime($id);

        return Json::encode(['success'=>$org->save(),'errors'=>$org->getErrors()]);
    }
}
