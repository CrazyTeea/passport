<?php


namespace app\commands;

use app\models\Founders;
use app\models\Organizations;
use app\models\Regions;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key;
use Yii;
use yii\console\Controller;



class ReferenceController extends Controller
{
    static $jwt_key = 'example_key233';

    /**
     * @return string
     * @throws \yii\db\Exception
     */
    public function actionIndex(){
        $transaction = Yii::$app->db->beginTransaction();
        if ($this->actionRegions() and $this->actionFounders() and $this->actionOrgs()) {
            $transaction->commit();
            echo "success";exit();
        }
        $transaction->rollBack();
        echo "error";exit();
    }


    public function actionOrgs(){
        echo "Выполняется синхронизация организаций\n";
        $err=0;
        $signer = new Sha256();
        $key = new Key( self::$jwt_key );
        $token = ( new Builder() )->withClaim( 'reference', 'organization' )
            // ->sign($signer, self::$jwt_key)
            ->getToken( $signer, $key );
        $response_token = file_get_contents( "http://api.xn--80apneeq.xn--p1ai/api.php?option=reference_api&action=get_reference&module=constructor&reference_token=$token" );
        $signer = new Sha256();
        $token = ( new Parser() )->parse( $response_token );
        if ( $token->verify( $signer, self::$jwt_key ) ) {
            $data_reference = $token->getClaims();
            foreach ($data_reference AS $key => $data) {
                $row_org = Organizations::findOne( $data->getValue()->id );
                if (!$row_org) {
                    $row_org = new Organizations();
                    $row_org->id = $data->getValue()->id;
                }
                $row_org->full_name = htmlspecialchars_decode( $data->getValue()->fullname );
                $row_org->short_name = htmlspecialchars_decode( $data->getValue()->shot_name );
                $row_org->name = htmlspecialchars_decode( $data->getValue()->name );
                $row_org->id_region = ($data->getValue()->region_id > 86 || !$data->getValue()->region_id) ? 86 : $data->getValue()->region_id;

                if (!$row_org->save()) {
                    $err++;
                    print_r($row_org->id_region);
                }

            }
        } else return false;
        return !$err;

    }
    public function actionRegions(){
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
        if($token->verify($signer, self::$jwt_key)){

            $data_reference = $token->getClaims();

            foreach ($data_reference AS $key=>$data){

                $region = Regions::findOne(['id'=>$data->getValue()->id]) ?? new Regions();

                $region->id=$data->getValue()->id;
                $region->region = $data->getValue()->name;


                if(!$region->save(false)){
                    $err++;
                    print_r($region->getErrors());
                }
            }

            return !$err;

        }else return false;
    }
    public function actionFounders(){
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
        if($token->verify($signer, self::$jwt_key)){

            $data_reference = $token->getClaims();

            foreach ($data_reference AS $key=>$data) {
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