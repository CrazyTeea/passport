<?php


namespace app\controllers\app;


use app\models\Organizations;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Html;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Yii;

class ExportController extends AppController
{

    private function cntStudents(array $students): array{
        $arr = [
            'fed_spo'=>0,
            'fed_spo_in'=>0
        ];
    }

    private function cntArea(array $objs): array
    {
        $arr = [
            'zil' => [
                'area_zan_obuch' => 0,
                'area_in_kat_nan' => 0,
                'svobod' => 0,
                'ne_isp' => 0,
                'tkr' => 0,
                'nas' => 0,
                'np' => 0,
                'odp' => 0,
                'zpo' => 0,
                'cnt_mest_pl_na_odn' => 0,
                'cnt_mest_obsh_na_odn' => 0
                //'ne_isp'=>0,
            ],
            'nezil' => [
                'obsh' => 0,
                'tkr' => 0,
                'nas' => 0,
                'np' => 0
            ]
        ];

        foreach ($objs as $item) {
            if ($item->area) {
                $arr['zil']['area_zan_obuch'] += $item->area->zan_obuch;
                $arr['zil']['area_in_kat_nan'] += $item->area->zan_inie;
                $arr['zil']['svobod'] += $item->area->svobod;
                $arr['zil']['ne_isp'] += $item->area->neisp;
                $arr['zil']['tkr'] += $item->area->zhil_tkr;
                $arr['zil']['nas'] += $item->area->zhil_nas;
                $arr['zil']['np'] += $item->area->zhil_np;

                $arr['zil']['odp'] += $item->area->zhil_nas;
                $arr['zil']['zpo'] += $item->area->zhil_np;

                $arr['nezil']['tkr'] += $item->area->nzhil_tkr;
                $arr['nezil']['nas'] += $item->area->nzhil_nas;
                $arr['nezil']['np'] += $item->area->nzhil_np;

                $arr['zil']['cnt_mest_pl_na_odn'] += $item->area->cnt_mest_pl_na_odn;
                $arr['zil']['cnt_mest_obsh_na_odn'] += $item->area->cnt_mest_obsh_na_odn;

                $arr['nezil']['obsh'] += (
                    $item->area->punkt_pit +
                    $item->area->pom_dlya_uch +
                    $item->area->pom_dlya_med +
                    $item->area->pom_dlya_sport +
                    $item->area->pom_dlya_soc +
                    $item->area->pom_dlya_kult +
                    $item->area->in_nezh_plosh
                );
            }
        }
        return $arr;
    }

    /**
     * @param null $id_org
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     * @throws \yii\base\Exception
     */
    public function actionExportData($id_org = null)
    {
        $get = Yii::$app->request->get();

        if (strlen($pages = $get['pages']) == 0)
            throw new \yii\base\Exception("выгрузка без страниц не допустима");
        $pages = explode(',', $get['pages']);


        if ($id_org) {
            $where = ['organizations.id' => $id_org];
        } elseif (isset($get['id'])) {
            $get['id'] = explode(',', $get['id']);
            if ($get['id'][0] !== '')
                $where = ['organizations.id' => $get['id']];
            else $where = [];
        } else $where = [];


        $orgs = Organizations::find()->where($where)->all();

        // dd($orgs);


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

        foreach ($orgs as $org_index => $org) {
            $cell_pos = $org_index + 2;
            foreach ($pages as $index => $page) {
                switch ($page * 1) {
                    case 1:
                    case 2:
                    {
                        $spreadsheet->setActiveSheetIndex(0);
                        $sheet = $spreadsheet->getActiveSheet();
                        $sheet->setCellValue("A{$cell_pos}", $org->id);
                        $sheet->setCellValue("B{$cell_pos}", $org->full_name);
                        $sheet->setCellValue("C{$cell_pos}", $org->short_name);
                        $sheet->setCellValue("D{$cell_pos}", $org->founder->founder);
                        $sheet->setCellValue("E{$cell_pos}", $org->region->region);

                        if (isset($org->info[0])) {
                            $sheet->setCellValue("G{$cell_pos}", $org->info[0]->s_f_b_spo);
                            $sheet->setCellValue("H{$cell_pos}", $org->info[0]->s_f_b_bak);
                            $sheet->setCellValue("I{$cell_pos}", $org->info[0]->s_f_b_spec);
                            $sheet->setCellValue("J{$cell_pos}", $org->info[0]->s_f_b_mag);
                            $sheet->setCellValue("K{$cell_pos}", $org->info[0]->s_f_b_asp);
                            $sheet->setCellValue("L{$cell_pos}", $org->info[0]->s_f_b_ord);
                            $sheet->setCellValue("M{$cell_pos}", $org->info[0]->s_f_b_in);

                            $sheet->setCellValue("O{$cell_pos}", $org->info[0]->s_b_s_spo);
                            $sheet->setCellValue("P{$cell_pos}", $org->info[0]->s_b_s_bak);
                            $sheet->setCellValue("Q{$cell_pos}", $org->info[0]->s_b_s_spec);
                            $sheet->setCellValue("R{$cell_pos}", $org->info[0]->s_b_s_mag);
                            $sheet->setCellValue("S{$cell_pos}", $org->info[0]->s_b_s_asp);
                            $sheet->setCellValue("T{$cell_pos}", $org->info[0]->s_b_s_ord);
                            $sheet->setCellValue("U{$cell_pos}", $org->info[0]->s_b_s_in);

                            $sheet->setCellValue("W{$cell_pos}", $org->info[0]->s_m_b_spo);
                            $sheet->setCellValue("X{$cell_pos}", $org->info[0]->s_m_b_bak);
                            $sheet->setCellValue("Y{$cell_pos}", $org->info[0]->s_m_b_spec);
                            $sheet->setCellValue("Z{$cell_pos}", $org->info[0]->s_m_b_mag);
                            $sheet->setCellValue("AA{$cell_pos}", $org->info[0]->s_m_b_asp);
                            $sheet->setCellValue("AB{$cell_pos}", $org->info[0]->s_m_b_ord);
                            $sheet->setCellValue("AC{$cell_pos}", $org->info[0]->s_m_b_in);

                            $sheet->setCellValue("AE{$cell_pos}", $org->info[0]->s_p_u_spo);
                            $sheet->setCellValue("AF{$cell_pos}", $org->info[0]->s_p_u_bak);
                            $sheet->setCellValue("AG{$cell_pos}", $org->info[0]->s_p_u_spec);
                            $sheet->setCellValue("AH{$cell_pos}", $org->info[0]->s_p_u_mag);
                            $sheet->setCellValue("AI{$cell_pos}", $org->info[0]->s_p_u_asp);
                            $sheet->setCellValue("AJ{$cell_pos}", $org->info[0]->s_p_u_ord);
                            $sheet->setCellValue("AK{$cell_pos}", $org->info[0]->s_p_u_in);
                        }
                        if (isset($org->info[1])) {
                            $sheet->setCellValue("AU{$cell_pos}", $org->info[1]->s_f_b_spo);
                            $sheet->setCellValue("AV{$cell_pos}", $org->info[1]->s_f_b_bak);
                            $sheet->setCellValue("AW{$cell_pos}", $org->info[1]->s_f_b_spec);
                            $sheet->setCellValue("AX{$cell_pos}", $org->info[1]->s_f_b_mag);
                            $sheet->setCellValue("AY{$cell_pos}", $org->info[1]->s_f_b_asp);
                            $sheet->setCellValue("AZ{$cell_pos}", $org->info[1]->s_f_b_ord);
                            $sheet->setCellValue("BA{$cell_pos}", $org->info[1]->s_f_b_in);

                            $sheet->setCellValue("BC{$cell_pos}", $org->info[1]->s_b_s_spo);
                            $sheet->setCellValue("BD{$cell_pos}", $org->info[1]->s_b_s_bak);
                            $sheet->setCellValue("BE{$cell_pos}", $org->info[1]->s_b_s_spec);
                            $sheet->setCellValue("BF{$cell_pos}", $org->info[1]->s_b_s_mag);
                            $sheet->setCellValue("BG{$cell_pos}", $org->info[1]->s_b_s_asp);
                            $sheet->setCellValue("BH{$cell_pos}", $org->info[1]->s_b_s_ord);
                            $sheet->setCellValue("BI{$cell_pos}", $org->info[1]->s_b_s_in);

                            $sheet->setCellValue("BK{$cell_pos}", $org->info[1]->s_m_b_spo);
                            $sheet->setCellValue("BL{$cell_pos}", $org->info[1]->s_m_b_bak);
                            $sheet->setCellValue("BM{$cell_pos}", $org->info[1]->s_m_b_spec);
                            $sheet->setCellValue("BN{$cell_pos}", $org->info[1]->s_m_b_mag);
                            $sheet->setCellValue("BO{$cell_pos}", $org->info[1]->s_m_b_asp);
                            $sheet->setCellValue("BP{$cell_pos}", $org->info[1]->s_m_b_ord);
                            $sheet->setCellValue("BQ{$cell_pos}", $org->info[1]->s_m_b_in);

                            $sheet->setCellValue("BS{$cell_pos}", $org->info[1]->s_p_u_spo);
                            $sheet->setCellValue("BT{$cell_pos}", $org->info[1]->s_p_u_bak);
                            $sheet->setCellValue("BU{$cell_pos}", $org->info[1]->s_p_u_spec);
                            $sheet->setCellValue("BV{$cell_pos}", $org->info[1]->s_p_u_mag);
                            $sheet->setCellValue("BW{$cell_pos}", $org->info[1]->s_p_u_asp);
                            $sheet->setCellValue("BX{$cell_pos}", $org->info[1]->s_p_u_ord);
                            $sheet->setCellValue("BY{$cell_pos}", $org->info[1]->s_p_u_in);
                        }

                        $cnt = $this->cntArea($org->objs);

                        $sheet->setCellValue("CI{$cell_pos}", $cnt['zil']['area_zan_obuch']);
                        $sheet->setCellValue("CJ{$cell_pos}", $cnt['zil']['area_in_kat_nan']);
                        $sheet->setCellValue("CK{$cell_pos}", $cnt['zil']['svobod']);
                        $sheet->setCellValue("CL{$cell_pos}", $cnt['zil']['ne_isp']);
                        $sheet->setCellValue("CM{$cell_pos}",
                            $cnt['zil']['area_zan_obuch'] +
                            $cnt['zil']['area_in_kat_nan'] +
                            $cnt['zil']['svobod'] +
                            $cnt['zil']['ne_isp']);
                        $sheet->setCellValue("CN{$cell_pos}", $cnt['nezil']['obsh']);
                        $sheet->setCellValue("CO{$cell_pos}",
                            $cnt['nezil']['obsh'] +
                            $cnt['zil']['area_zan_obuch'] +
                            $cnt['zil']['area_in_kat_nan'] +
                            $cnt['zil']['svobod'] +
                            $cnt['zil']['ne_isp']);
                        $sheet->setCellValue("CP{$cell_pos}", $cnt['zil']['tkr']);
                        $sheet->setCellValue("CQ{$cell_pos}", $cnt['zil']['nas']);
                        $sheet->setCellValue("CR{$cell_pos}", $cnt['zil']['np']);

                        $sheet->setCellValue("CS{$cell_pos}", $cnt['nezil']['tkr']);
                        $sheet->setCellValue("CT{$cell_pos}", $cnt['nezil']['nas']);
                        $sheet->setCellValue("CU{$cell_pos}", $cnt['nezil']['np']);

                        $sheet->setCellValue("CV{$cell_pos}", $cnt['zil']['cnt_mest_pl_na_odn']);
                        $sheet->setCellValue("CW{$cell_pos}", $cnt['zil']['cnt_mest_obsh_na_odn']);

                        $kek = 0;
                        break;
                    }
                    case 3:
                    {
                        $spreadsheet->setActiveSheetIndex(1);
                        $sheet = $spreadsheet->getActiveSheet();
                        $sheet->setCellValue("A{$cell_pos}", $org->id);
                        $sheet->setCellValue("B{$cell_pos}", $org->full_name);
                        $sheet->setCellValue("C{$cell_pos}", $org->short_name);
                        $sheet->setCellValue("D{$cell_pos}", $org->founder->founder);
                        $sheet->setCellValue("E{$cell_pos}", $org->region->region);
                         $sheet->setCellValue("G{$cell_pos}", 12);
                         $sheet->setCellValue("H{$cell_pos}", 123);



                        break;
                    }
                    /*
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