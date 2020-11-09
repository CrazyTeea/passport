<?php


namespace app\controllers\app;


use app\models\Organizations;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Html;
use Yii;

class ExportController extends AppController
{
    public function actionExportStat()
    {
        $get = Yii::$app->request->get();

        $where = ['system_status' => 1];

        if (isset($get['id']) and $get['id'])
            $where['organizations.id'] = array_map(function ($item) {
                return $item * 1;
            }, explode(',', $get['id']));
        if (isset($get['id_founder']) and $get['id_founder'])
            $where['id_founder'] = explode(',', $get['id_founder']);
        if (isset($get['id_region']) and $get['id_region'])
            $where['id_region'] = explode(',', $get['id_region']);

        $orgs = Organizations::find();

        if (isset($get['kont']) and $get['kont'] == 1) {
            $orgs = $orgs->joinWith('usersInfo', true, 'join');
        }
        if (isset($get['zap']) and $get['zap'] == 1) {
            $where = array_merge($where, ['active' => 1]);
        }

        if (isset($get['docs']) and $get['docs'] == 1) {
            $orgs = $orgs->joinWith('orgDocs');
            $having = ['>', 'count(org_docs.id)', 0];
        }

        $orgs = $orgs->andFilterWhere($where)->having($having ?? [])->groupBy('organizations.id');
        $orgs_id = (clone $orgs)->select(['organizations.id'])->column();

        $orgs = $orgs->all();



        $r_objs = \app\models\Objects::getRealEstateObjects($orgs_id);


        $html = $this->renderPartial('_stat', compact('orgs', 'r_objs'));

        $reader = new Html();

        $html = $reader->loadFromString($html);

        $html->getActiveSheet()->getDefaultRowDimension()->setRowHeight(15);
        $html->getActiveSheet()->getDefaultColumnDimension()->setWidth(12);

        $writer = IOFactory::createWriter($html, 'Xlsx');


        $path = Yii::getAlias('@webroot') . '/uploads/statistic.xlsx';

        $writer->save($path);

        Yii::$app->response->sendFile($path)->send();

        unlink($path);


    }
}