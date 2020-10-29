<?php


namespace app\controllers\app;


use Yii;
use yii\web\Controller;

abstract class AppController extends Controller
{
    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);
        if (!Yii::$app->getUser()->can('user'))
            Yii::$app->homeUrl = '/admin/statistic';

    }
}