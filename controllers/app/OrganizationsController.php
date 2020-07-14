<?php


namespace app\controllers\app;

use app\models\Organizations;
use app\models\OrgArea;
use app\models\OrgDocs;
use app\models\OrgInfo;
use app\models\OrgLiving;
use app\models\OrgLivingStudents;
use app\models\UsersInfo;
use Yii;
use yii\helpers\Json;
use yii\web\Controller;

class OrganizationsController extends Controller
{
    public function actionUsersInfo($id){
        if ($post = Yii::$app->request->post()){
            $data = Json::decode($post['users'],false);
            foreach ($data as $item){
                $info = UsersInfo::findOne($item->id) ?? new UsersInfo();
                $info->id_org = $id;
                $info->name = $item->name;
                $info->position = $item->position;
                $info->email = $item->email;
                $info->phone = $item->phone;
                $ret[] = [$item->email=>['success'=>$info->save(),'errors'=>$info->getErrors()]];
            }
            return Json::encode($ret ?? []);
        }
    }
    public function actionDeleteUsersInfo($id){
        return Json::encode(['success'=>UsersInfo::deleteAll(['id'=>$id])>0]);
    }

    public function actionSetOrgInfo($id)
    {
        if($post = Yii::$app->request->post()){
            $post = Json::decode($post['org'],false);
            $org = Organizations::findOne($id);
            $org->stud_cnt=$post->organization->stud_cnt;
            $org->stud_cnt_inos=$post->organization->stud_cnt_inos;
            $org->stud_cnt_rus=$post->organization->stud_cnt_rus;
            $org_save = $org->save();


            $org_docs = OrgDocs::findAll(['id_desc'=>[1,2],'id_org'=>$id]);
            if (!$org_docs){
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
            foreach($post->info as $info){
                $inf = OrgInfo::findOne([$info->id]) ?? new OrgInfo();
                $inf->id_org = $info->id_org;
                $inf->stud_type = $info->stud_type;


                $inf->s_f_b_spo = $info->s_f_b_spo;
                $inf->s_b_s_spo = $info->s_b_s_spo;
                $inf->s_m_b_spo = $info->s_m_b_spo;
                $inf->s_p_u_spo = $info->s_p_u_spo;

                $inf->s_f_b_bak = $info->s_f_b_bak;
                $inf->s_b_s_bak = $info->s_b_s_bak;
                $inf->s_m_b_bak = $info->s_m_b_bak;
                $inf->s_p_u_bak = $info->s_p_u_bak;

                $inf->s_f_b_spec = $info->s_f_b_spec;
                $inf->s_b_s_spec = $info->s_b_s_spec;
                $inf->s_m_b_spec = $info->s_m_b_spec;
                $inf->s_p_u_spec = $info->s_p_u_spec;

                $inf->s_f_b_mag = $info->s_f_b_mag;
                $inf->s_b_s_mag = $info->s_b_s_mag;
                $inf->s_m_b_mag = $info->s_m_b_mag;
                $inf->s_p_u_mag = $info->s_p_u_mag;

                $inf->s_f_b_asp = $info->s_f_b_asp;
                $inf->s_b_s_asp = $info->s_b_s_asp;
                $inf->s_m_b_asp = $info->s_m_b_asp;
                $inf->s_p_u_asp = $info->s_p_u_asp;

                $inf->s_f_b_ord = $info->s_f_b_ord;
                $inf->s_b_s_ord = $info->s_b_s_ord;
                $inf->s_m_b_ord = $info->s_m_b_ord;
                $inf->s_p_u_ord = $info->s_p_u_ord;

                $inf->s_f_b_in = $info->s_f_b_in;
                $inf->s_b_s_in = $info->s_b_s_in;
                $inf->s_m_b_in = $info->s_m_b_in;
                $inf->s_p_u_in = $info->s_p_u_in;


                $info_save[$inf->stud_type] = ['success'=>$inf->save(),'errors'=>$inf->getErrors()];
            }
            $ret = ['org'=>['success'=>$org_save,'errors'=>$org->getErrors()],'info'=>$info_save];
        }
        return Json::encode($ret ?? 'не верный пост');
    }

    public function actionSetOrgArea($id)
    {
        if($post = Yii::$app->request->post()){
            $post = Json::decode($post['org_area'],false);
            $area = OrgArea::findOne(['id_org'=>$id]) ?? new OrgArea();
            $area->id_org = $id;
            foreach ($post as $key => $item){
                $area->$key = $item;
            }
            $ret = ['org_area'=>['success'=>$area->save(),'errors'=>$area->getErrors()]];
        }
        return Json::encode($ret ?? 'не верный пост');
    }

    public function actionSetOrgLiving($id)
    {
        if($post = Yii::$app->request->post()){
            $post = Json::decode($post['org_living'],false);
            $liv = OrgLiving::findOne(['id_org'=>$id]) ?? new OrgLiving();
            $keys = [];
            $liv->id_org = $id;

            if (isset($post->living)) {

                foreach ($post->living as $key => $item) {
                    $liv->$key = $item;
                }
            }

            $ret = ['org_living'=>['success'=>$liv->save(),'errors'=>$liv->getErrors()]];
            $living_studs =[];
            foreach ($post->living_studs as $item){

                $stud_item = Json::decode(Json::encode($item),false);
                if (isset($stud_item->label)  and $stud_item->label =='Всего' or !isset($stud_item->type)) continue;
                $stud = isset($stud_item->id) ? OrgLivingStudents::findOne($stud_item->id) : new OrgLivingStudents();
                if ($stud->isNewRecord){
                    $stud->invalid = $post->invalid;
                    $stud->id_org = $id;
                    $stud->id_living = $liv->id;
                }

                $stud->type = $stud_item->type;
                $stud->budjet_type = $stud_item->budjet_type;
                $stud->spo = $stud_item->spo ?? null;
                $stud->bak = $stud_item->bak ?? null;
                $stud->spec = $stud_item->spec ?? null;
                $stud->mag = $stud_item->mag ?? null;
                $stud->asp = $stud_item->asp ?? null;
                $stud->ord = $stud_item->ord ?? null;
                $stud->in = $stud_item->ipo ?? null;
                if (!$stud->spec and !$stud->spo and !$stud->bak and !$stud->mag and !$stud->ord and !$stud->in) continue;
                $living_studs[] = ['success' => $stud->save(), 'errors' => $stud->errors];

            }
            $ret = ['org_living'=>['success'=>$liv->save(),'errors'=>$liv->getErrors()],'living_studs'=>$living_studs];

        }
        return Json::encode($ret ?? 'не верный пост');
    }
}