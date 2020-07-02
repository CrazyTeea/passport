<?php


namespace app\controllers\app;


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
                $info = UsersInfo::findOne(['id_org'=>$id,'email'=>$item->email]) ?? new UsersInfo();
                $info->id_org = $id;
                $info->name = $item->name;
                $info->position = $item->position;
                $info->email = $item->email;
                $ret[] = [$item->email=>['success'=>$info->save(),'errors'=>$info->getErrors()]];
            }
            return Json::encode($ret ?? []);
        }
    }
}