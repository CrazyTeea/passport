<?php


namespace app\controllers\app;

use app\models\Organizations;
use app\models\OrgArea;
use app\models\OrgInfo;
use app\models\OrgLiving;
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
            $org->stud_cnt=$post->stud_cnt;
            $org->stud_cnt_inos=$post->stud_cnt_inos;
            $org->stud_cnt_rus=$post->stud_cnt_rus;
            $org_save = $org->save();
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
            foreach ($post as $key => $item){
                $liv->$key = $item;
            }
            $ret = ['org_area'=>['success'=>$liv->save(),'errors'=>$liv->getErrors()]];
        }
        return Json::encode($ret ?? 'не верный пост');
    }
}