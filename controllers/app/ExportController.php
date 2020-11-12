<?php


namespace app\controllers\app;


use app\models\Organizations;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Html;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Yii;

class ExportController extends AppController
{
    /**
     * @param null $id_org
     * @throws \yii\base\Exception
     */
    public function actionExportData($id_org = null)
    {
        $get = Yii::$app->request->get();

        if (strlen($pages = $get['pages']) == 0)
            throw new \yii\base\Exception("выгрузка без страниц не допустима");
        $pages = explode(',', $get['pages']);

        $where = [];

        $where = isset($get['id']) ? ['organizations.id' => explode(',', $get['id'])] : ['organizations.id' => $id_org];


        $orgs = Organizations::find()->where($where)->all();


        $page_names = [
            'Сведения об организации',
            'Сведения о количестве мест и площади жилищного фонда, используемого в уставной деятельности',
            'Сведения о проживающих в жилищном фонде, используемом в уставной деятельности',
            'Сведения о проживающих лицах с ограниченными возможностями в жилищном фонде, используемом в уставной деятельности',
            'Сведения о жилом объекте',
            'Сведения о площади, проживающих и количестве мест в жилом объекте',
            'Сведения о поступлениях и расходах на объект',
            'Сведения о тарифах установленных для проживания в жилом объекте'
        ];
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load('templates/template.xlsx');

        foreach ($orgs as $org_index=> $org) {
            $cell_pos = $org_index+2;
            foreach ($pages as $index => $page) {
                switch ($page) {
                    case 1:
                    {
                        $spreadsheet->setActiveSheetIndex(0);
                        $sheet = $spreadsheet->getActiveSheet();
                        $sheet->setCellValue("A${cell_pos}",$org->id);

                        break;
                    }
                    /*case 2:
                    {
                        break;
                    }
                    case 3:
                    {
                        break;
                    }
                    case 4:
                    {
                        break;
                    }
                    case 5:
                    {
                        break;
                    }
                    case 6:
                    {
                        break;
                    }
                    case 7:
                    {
                        break;
                    }
                    case 8:
                    {
                        break;
                    }*/
                }

            }
        }



        $xlsx = new Xlsx($spreadsheet);
        $xlsx->save('xlsx.xlsx');


    }

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

        //$html->getActiveSheet()->getDefaultRowDimension()->setRowHeight(200);
        $html->getActiveSheet()->getDefaultColumnDimension()->setWidth(100);

        $writer = IOFactory::createWriter($html, 'Xlsx');

        $path = Yii::getAlias('@webroot') . '/uploads/statistic.xlsx';

        $writer->save($path);

        Yii::$app->response->sendFile($path)->send();

        unlink($path);


    }
}