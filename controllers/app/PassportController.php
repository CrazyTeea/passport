<?php

namespace app\controllers\app;

class PassportController extends AppController
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionOrgInfo()
    {
        return $this->render('orgInfo');
    }

    public function actionAreaInfo()
    {
        return $this->render('areaInfo');
    }

    public function actionLivingInfo()
    {
        return $this->render('livingInfo');
    }

    public function actionLivingInfoInv()
    {
        return $this->render('livingInfoInv');
    }
}