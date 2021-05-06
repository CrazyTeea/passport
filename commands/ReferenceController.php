<?php


namespace app\commands;

use app\models\Founders;
use app\models\Objects;
use app\models\ObjectsArea;
use app\models\Organizations;
use app\models\Regions;
use app\models\User;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key;
use Yii;
use yii\console\Controller;
use yii\db\Exception;
use yii\rbac\PhpManager;

class ReferenceController extends Controller
{
    public static $jwt_key = 'example_key233';

    /**
     * @return void
     * @throws Exception
     */
    public function actionIndex(): void
    {
        $transaction = Yii::$app->db->beginTransaction();

        $flag = $this->actionRegions()
        and $this->actionFounders()
        and $this->actionOrgs()// and $this->actionUser()
        ;

        if ($flag) {
            $transaction->commit();
        } else {
            $transaction->rollBack();
        }

        echo $flag ? "success \n" : "error \n";
    }

    public function actionUser(): bool
    {
        echo "Выполняется синхронизация юзеров\n";
        $err = 0;
        $signer = new Sha256();
        $key = new Key('example_key233');
        $token = (new Builder())->set('reference', 'all_user')
            //->sign($signer, 'example_key233')
            ->getToken($signer, $key);

        $response_token = file_get_contents("http://api.xn--80apneeq.xn--p1ai/api.php?option=reference_api&action=get_reference&module=constructor&reference_token=$token");

        $signer = new Sha256();
        $token = (new Parser())->parse($response_token);
        $ias_user = null;
        if ($token->verify($signer, 'example_key233')) {
            $data_reference = $token->getClaims();

            foreach ($data_reference as $key => $data) {
                $user = User::findOne(['username' => $data->getValue()->login]) ?? new User();
                $user->username = $data->getValue()->login;
                $user->name = $data->getValue()->name;
                $user->id_org = $data->getValue()->podved_id;

                $role = $user->id_org ? 'user' : 'admin';

                $user->generateAuthKey();
                $user->setPassword($data->getValue()->pwd);

                if ($user->save()) {
                    echo "{$user->username} : {$user->id_org} \n";
                    $rbac = new PhpManager();
                    $rbac->revokeAll($user->id);
                    $rbac->assign($rbac->getRole($role), $user->id);
                } else {
                    $err++;
                }
            }
        }

        return !$err;
    }

    public function actionOrgs(): bool
    {
        echo "Выполняется синхронизация организаций\n";
        $err = 0;
        $signer = new Sha256();
        $key = new Key('example_key233');
        $token = (new Builder())->withClaim('reference', 'organization')
            // ->sign($signer, self::$jwt_key)
            ->getToken($signer, $key);
        $response_token = file_get_contents("http://api.xn--80apneeq.xn--p1ai/api.php?option=reference_api&action=get_reference&module=constructor&reference_token=$token");
        $signer = new Sha256();
        $token = (new Parser())->parse($response_token);
        if ($token->verify($signer, $key)) {
            $data_reference = $token->getClaims();
            foreach ($data_reference as $data) {

                //   dd($data);

                $row_org = Organizations::findOne($data->getValue()->id) ?? new Organizations();

                $row_org->id = $data->getValue()->id;
                $row_org->id_founder = $data->getValue()->subordination;
                $row_org->full_name = htmlspecialchars_decode($data->getValue()->fullname);
                $row_org->short_name = htmlspecialchars_decode($data->getValue()->shot_name);
                $row_org->name = htmlspecialchars_decode($data->getValue()->name);
                $row_org->id_region = Regions::findOne($data->getValue()->region_id)->id ?? 86;
                $row_org->system_status = ($data->getValue()->system_status != 0 and in_array($data->getValue()->status_org, [1, 2]) and in_array($data->getValue()->type_org, [13])) ? 1 : 0;

                if (!$row_org->save()) {
                    $err++;
                    print_r($row_org->id_region);
                }
            }
        } else {
            return false;
        }
        return !$err;
    }

    public function actionRegions(): bool
    {
        echo "Выполняется синхронизация регионов\n";
        $timestart = time();
        $err = 0;

        $signer = new Sha256();

        $key = new Key('example_key233');

        $token = (new Builder())->set('reference', 'region')
            //->sign($signer, self::$jwt_key)
            ->getToken($signer, $key);

        $response_token = file_get_contents("http://api.xn--80apneeq.xn--p1ai/api.php?option=reference_api&action=get_reference&module=constructor&reference_token=$token");

        $signer = new Sha256();
        $token = (new Parser())->parse($response_token);
        if ($token->verify($signer, $key)) {
            $data_reference = $token->getClaims();

            foreach ($data_reference as $key => $data) {
                $region = Regions::findOne(['id' => $data->getValue()->id]) ?? new Regions();

                $region->id = $data->getValue()->id;
                $region->region = $data->getValue()->name;


                if (!$region->save(false)) {
                    $err++;
                    print_r($region->getErrors());
                }
            }

            return !$err;
        } else {
            return false;
        }
    }

    public function actionFounders(): bool
    {
        echo "Выполняется синхронизация фаундеров\n";

        $err = 0;
        $timestart = time();
        $signer = new Sha256();
        $key = new Key('example_key233');

        $token = (new Builder())->set('reference', 'organization_founder')
            // ->sign()
            ->getToken($signer, $key);

        $response_token = file_get_contents("http://api.xn--80apneeq.xn--p1ai/api.php?option=reference_api&action=get_reference&module=constructor&reference_token=$token");

        $signer = new Sha256();
        $token = (new Parser())->parse($response_token);
        if ($token->verify($signer, $key)) {
            $data_reference = $token->getClaims();

            foreach ($data_reference as $key => $data) {
                $founder = Founders::findOne($data->getValue()->id) ?? new Founders();
                $founder->id = $data->getValue()->id;
                $founder->founder = $data->getValue()->name;
                $founder->system_status = $data->getValue()->system_status;
                if (!$founder->save()) {
                    $err++;
                    print_r($founder->getErrors());
                }
            }
        }
        return !$err;
    }

    public function actionSync()
    {
        $csvP = Yii::getAlias('@webroot') . "/templates/objs.csv";
        $csv = fopen($csvP, 'r');


        //Objects::deleteAll(['not in', 'id_org', [181, 117]]);

        while (($row = fgetcsv($csv, 3412, ';')) != false) {
            if ($row[0] == 181 or $row[0] == 117) {
                continue;
            }
            if (!($org = Organizations::findOne($row[0]))) {
                continue;
            }
            try {
                $ojs_real = Objects::getRealEstateObjects2($row[0], null);
                $real_estate = null;
                if (array_search($row[3], array_column($ojs_real, 'cadastral_number')) !== false) {
                    $real_estate_id = array_search($row[3], array_column($ojs_real, 'cadastral_number'));

                    $real_estate = $ojs_real[$real_estate_id];
                }

                $addr = $real_estate['objectEgrnAddress'] ?? $row[2];

                $obj = Objects::findOne(['address' => $addr, 'kad_number' => $row[3]]) ?? new Objects();


                $obj->id_org = $org->id;
                $obj->id_realEstate = $real_estate['id'] ?? null;
                $obj->name = $real_estate['object_name'] ?? $row[1];
                $obj->address = $addr;
                $obj->id_region = $real_estate['egrn_id_region'] ?? null;
                $obj->doc_number = $real_estate['registration_right_number'] ?? null;
                $obj->reg_zap = $real_estate['registration_right_date'] ?? null;

                $obj->kad_number = $row[3];
                $obj->stroy_date_end = strlen($row[4]) == 4 ? "$row[4]-01-01" : null;
                $obj->exp_date = strlen($row[5]) == 4 ? "$row[5]-01-01" : null;
                $obj->smet = floatval($row[6]);
                $obj->money_faip = floatval($row[7]);
                $obj->money_vneb = floatval($row[8]);
                $obj->stroy_date_start = strlen($row[9]) == 4 ? "$row[9]-01-01" : null;
                $obj->date_end_reconstruct = strlen($row[10]) == 4 ? "$row[10]-01-01" : null;
                $obj->ustav_dey = $row[11];

                $flat_plan = [
                    'Коридорная' => 'kor',
                    'Блочная' => 'bloch',
                    'Квартирная' => 'kvar',
                    'Гостиничная' => 'gost'
                ];

                $flat_type = [
                    'Одноместный' => 'odn',
                    'Двухместное' => 'dvuh',
                    'Трёхместное и более' => 'treh',
                    'Смешанное' => 'smesh'
                ];
                $prib_type = [
                    'Общедомовые' => 'obsh',
                    'Индивидуальные (на комнату)' => 'ind',
                    'Отсутствуют' => 'ots',
                ];

                $obj->flat_plan = $flat_plan[$row[15]] ?? null;
                $obj->flat_type = $flat_type[$row[16]] ?? null;
                $obj->prib_type = $flat_type[$row[17]] ?? null;
                $obj->pandus = $row[18];
                $obj->mech_por = $row[19];
                $obj->sanusel = $row[20];
                $obj->signal = $row[21];
                $obj->pokr = $row[22];
                $obj->vives = $row[23];
                $obj->wifi = $row[30];
                $obj->tech = $row[31];
                $obj->max_per = intval($row[32]);
                $obj->min_per = intval($row[31]);


                if ($obj->save()) {
                    printf("obj: id: %d id_realestate: %d name: %s \n", $obj->id, $obj->id_realEstate, $obj->name);
                    $area = new ObjectsArea();
                    $area->id_object = $obj->id;
                    $area->aren = floatval($row[12]);
                    $area->pbp = floatval($row[13]);
                    $area->cnt_mest_inv = $row[14];
                    $area->punkt_pit = floatval($row[24]);
                    $area->pom_dlya_uch = floatval($row[25]);
                    $area->pom_dlya_med = floatval($row[26]);
                    $area->pom_dlya_sport = floatval($row[27]);
                    $area->pom_dlya_kult = floatval($row[28]);
                    $area->pom_dlya_soc = floatval($row[29]);
                    $area->save();
                }
            } catch (\Exception $e) {
                printf("%s \n", $e->getMessage());
            }
        }
        $this->actionCountingNumberFieldsObjects();
        $this->actionCountingNumberFieldsOrgs();
    }

    public function actionCountingNumberFieldsObjects()
    {
        foreach (Objects::findAll(['system_status' => 1]) as $object) {
            echo $object->id . ' - ' . ($object->countingNumberFields() ? 'success' : 'error') . "\n";
        }
    }

    public function actionCountingNumberFieldsOrgs()
    {
        foreach (Organizations::findAll(['system_status' => 1]) as $org) {
            echo $org->id . ' - ' . ($org->countingNumberFields() ? 'success' : 'error') . "\n";
        }
    }

    public function actionTest()
    {
        echo date('Y', strtotime('1932-01-01'));
    }

    /*public function actionCountingNumberFieldsOrg()
    {
        $org = Organizations::findOne(101);
        echo $org->id . ' - ' . ($org->countingNumberFields() ? 'success' : 'error') . "\n";
    }*/
}
