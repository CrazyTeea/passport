<?php

namespace app\controllers\app;

use app\jobs\ExportJob;
use app\jobs\statisticJob;
use Yii;
use yii\base\Exception;

class ExportController extends AppController
{
    /**
     * @param null $id_org
     *
     * @throws Exception
     */
    public function actionExportData($id_org = null)
    {
        $get = Yii::$app->request->get();

        if (
            strlen($pages = $get['pages']) == 0 and
            (Yii::$app->user->can('admin') or Yii::$app->user->can('root'))
        ) {
            throw new Exception("выгрузка без страниц не допустима");
        }
        $pages = explode(',', $get['pages']);

        if ($id_org) {
            $where = ['organizations.id' => $id_org];
        } elseif (isset($get['id'])) {
            $get['id'] = explode(',', $get['id']);
            if ($get['id'][0] !== '') {
                $where = ['organizations.id' => $get['id']];
            } else {
                $where = ['system_status' => 1];
            }
        } else {
            $where = ['system_status' => 1];
        }

        $fileName = $id_org ? 'Выгрузка ПЖФ по организации' : 'Общая выгрузка';

        $mail = $get['mail'];

        Yii::$app->queue->push(
            new ExportJob(
                compact(
                    'pages',
                    'where',
                    'mail',
                    'id_org',
                    'fileName'
                )
            )
        );
    }

    public function actionExportStat()
    {
        $get = Yii::$app->request->get();
        $mail = $get['mail'];

        $where = ['system_status' => 1];

        if (isset($get['id']) and $get['id']) {
            $where['organizations.id'] = array_map(function ($item) {
                return $item * 1;
            }, explode(',', $get['id']));
        }
        if (isset($get['id_founder']) and $get['id_founder']) {
            $where['id_founder'] = explode(',', $get['id_founder']);
        }
        if (isset($get['id_region']) and $get['id_region']) {
            $where['id_region'] = explode(',', $get['id_region']);
        }


        Yii::$app->queue->push(new statisticJob(compact('where', 'mail')));
    }
}
