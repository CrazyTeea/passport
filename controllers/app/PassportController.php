<?php

namespace app\controllers\app;

class PassportController extends AppController
{
    public function actionIndex(): string
    {
        return $this->render('index');
    }

    public function actionOrgInfo(): string
    {
        return $this->render('orgInfo');
    }
    public function actionOrgCovid(): string
    {
        return $this->render('orgCovid');
    }

    public function actionAreaInfo(): string
    {
        return $this->render('areaInfo');
    }

    public function actionLivingInfo(): string
    {
        return $this->render('livingInfo');
    }

    public function actionLivingInfoInv(): string
    {
        return $this->render('livingInfoInv');
    }

    public function actionAddContact(): string
    {
        return $this->render('addContact');
    }
}