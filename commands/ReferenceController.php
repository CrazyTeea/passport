<?php


namespace app\commands;

use app\models\Founders;
use app\models\Organizations;
use app\models\Regions;
use app\models\User;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key;
use Yii;
use yii\console\Controller;
use yii\rbac\PhpManager;


class ReferenceController extends Controller
{
    static $jwt_key = 'example_key233';

    /**
     * @return string
     * @throws \yii\db\Exception
     */
    public function actionIndex(): void
    {
        $transaction = Yii::$app->db->beginTransaction();

        $flag = $this->actionRegions() and $this->actionFounders() and $this->actionOrgs() and $this->actionUser();

        if ($flag) {
            $transaction->commit();
        } else {
            $transaction->rollBack();
        }

        echo $flag ? "success \n" : "error \n";
    }

    public function actionKek()
    {
        $signer = new Sha256();
        $token = (new Builder())->set('reference', 'all_user')
            ->sign($signer, 'example_key233')
            ->getToken();

        $response_token = file_get_contents("http://api.xn--80apneeq.xn--p1ai/api.php?option=reference_api&action=get_reference&module=constructor&reference_token=$token");

        $signer = new Sha256();
        $token = (new Parser())->parse($response_token);
        $ias_user = null;
        if ($token->verify($signer, 'example_key233')) {
            $data_reference = $token->getClaims();
            echo count($data_reference) . "\n";
        }
    }

    public function actionUser()
    {
        echo "Выполняется синхронизация юзеров\n";
        $err = 0;
        $signer = new Sha256();
        $token = (new Builder())->set('reference', 'all_user')
            ->sign($signer, 'example_key233')
            ->getToken();

        $response_token = file_get_contents("http://api.xn--80apneeq.xn--p1ai/api.php?option=reference_api&action=get_reference&module=constructor&reference_token=$token");

        $signer = new Sha256();
        $token = (new Parser())->parse($response_token);
        $ias_user = null;
        if ($token->verify($signer, 'example_key233')) {
            $data_reference = $token->getClaims();

            foreach ($data_reference as $key => $data) {

                $role = 'user';
                switch ($data->getValue()->access) {
                    case 'user':
                    case 'podved':
                    case 'other_podved':
                    case 'minprosv_podved':
                    {
                        $role = 'user';
                        break;
                    }
                    default:
                    {
                        $role = 'admin';
                    }
                }

                $user = User::findOne(['username' => $data->getValue()->login]) ?? new User();
                $user->username = $data->getValue()->login;

                $role = $user->username == 'admin@admin.ru' ? 'root' : 'user';

                $user->name = $data->getValue()->name;
                $user->id_org = $data->getValue()->podved_id;
                $user->setPassword($data->getValue()->pwd);

                if ($user->save()) {
                    $rbac = new PhpManager();
                    $rbac->revokeAll($user->id);
                    $rbac->assign($rbac->getRole($role), $user->id);
                } else $err++;

            }
        }

        return !$err;
    }


    public function actionOrgs()
    {
        echo "Выполняется синхронизация организаций\n";
        $err = 0;
        $signer = new Sha256();
        $key = new Key(self::$jwt_key);
        $token = (new Builder())->withClaim('reference', 'organization')
            // ->sign($signer, self::$jwt_key)
            ->getToken($signer, $key);
        $response_token = file_get_contents("http://api.xn--80apneeq.xn--p1ai/api.php?option=reference_api&action=get_reference&module=constructor&reference_token=$token");
        $signer = new Sha256();
        $token = (new Parser())->parse($response_token);
        if ($token->verify($signer, self::$jwt_key)) {
            $data_reference = $token->getClaims();
            foreach ($data_reference as $key => $data) {
                $row_org = Organizations::findOne($data->getValue()->id);
                if (!$row_org) {
                    $row_org = new Organizations();
                    $row_org->id = $data->getValue()->id;
                }
                $row_org->id_founder = $data->getValue()->subordination;
                $row_org->full_name = htmlspecialchars_decode($data->getValue()->fullname);
                $row_org->short_name = htmlspecialchars_decode($data->getValue()->shot_name);
                $row_org->name = htmlspecialchars_decode($data->getValue()->name);
                $row_org->id_region = ($data->getValue()->region_id > 86 || !$data->getValue()->region_id) ? 86 : $data->getValue()->region_id;

                if (!$row_org->save()) {
                    $err++;
                    print_r($row_org->id_region);
                }

            }
        } else return false;
        return !$err;

    }

    public function actionRegions()
    {
        echo "Выполняется синхронизация регионов\n";
        $timestart = time();
        $err = 0;

        $signer = new Sha256();

        $token = (new Builder())->set('reference', 'region')
            ->sign($signer, self::$jwt_key)
            ->getToken();

        $response_token = file_get_contents("http://api.xn--80apneeq.xn--p1ai/api.php?option=reference_api&action=get_reference&module=constructor&reference_token=$token");

        $signer = new Sha256();
        $token = (new Parser())->parse($response_token);
        if ($token->verify($signer, self::$jwt_key)) {

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

        } else return false;
    }

    public function actionFounders()
    {
        echo "Выполняется синхронизация фаундеров\n";

        $err = 0;
        $timestart = time();
        $signer = new Sha256();

        $token = (new Builder())->set('reference', 'organization_founder')
            ->sign($signer, self::$jwt_key)
            ->getToken();

        $response_token = file_get_contents("http://api.xn--80apneeq.xn--p1ai/api.php?option=reference_api&action=get_reference&module=constructor&reference_token=$token");

        $signer = new Sha256();
        $token = (new Parser())->parse($response_token);
        if ($token->verify($signer, self::$jwt_key)) {

            $data_reference = $token->getClaims();

            foreach ($data_reference as $key => $data) {
                $founder = Founders::findOne($data->getValue()->id) ?? new Founders();
                $founder->id = $data->getValue()->id;
                $founder->founder = $data->getValue()->name;
                if (!$founder->save()) {
                    $err++;
                    print_r($founder->getErrors());
                }
            }
        }
        return !$err;

    }


}