<?php

namespace app\controllers;

use app\models\ContactForm;
use app\models\Countries;
use app\models\Founders;
use app\models\LoginForm;
use app\models\Organizations;
use app\models\User;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\rbac\PhpManager;
use yii\web\Controller;
use yii\web\Response;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actionAdmin()
    {
        $user = User::findOne(['username' => 'admin@admin.ru']) ?? new User();
        $user->username = 'admin@admin.ru';
        $user->auth_key = Yii::$app->security->generateRandomString();
        $user->setPassword('password');
        if ($user->save()) {
            $php = new PhpManager();
            $php->revokeAll($user->id);
            $php->assign($php->getRole('root'), $user->id);
        }

    }
    public function actionFounders()
    {
        echo "Выполняется синхронизация фаундеров\n";

        $err = 0;
        $timestart = time();
        $signer = new Sha256();

        $token = (new Builder())->set('reference', 'organization_founder')
            ->sign($signer, 'secret')
            ->getToken();

        $response_token = file_get_contents("http://api.xn--80apneeq.xn--p1ai/api.php?option=reference_api&action=get_reference&module=constructor&reference_token=$token");

        $signer = new Sha256();
        $token = (new Parser())->parse($response_token);
        if ($token->verify($signer, 'secret')) {

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

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    private function checkRole()
    {
        if (!Yii::$app->user->can('user'))
            Yii::$app->homeUrl = '/admin/statistic';
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            $this->checkRole();
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $this->checkRole();
            if (str_contains(Url::previous(), '/main')) {
                return $this->redirect(Yii::$app->homeUrl);
            }
            return $this->goBack();
        }

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionOrgs()
    {
        echo "Выполняется синхронизация организаций\n";
        $err = 0;
        $signer = new Sha256();
        $key = new Key('secret');
        $token = (new Builder())->withClaim('reference', 'organization')
            // ->sign($signer, self::$jwt_key)
            ->getToken($signer, $key);
        $response_token = file_get_contents("http://api.xn--80apneeq.xn--p1ai/api.php?option=reference_api&action=get_reference&module=constructor&reference_token=$token");
        $signer = new Sha256();
        $token = (new Parser())->parse($response_token);
        if ($token->verify($signer, 'secret')) {
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
                $row_org->system_status = $data->getValue()->system_status;

                if (!$row_org->save()) {
                    $err++;
                    print_r($row_org->id_region);
                }

            }
        } else return false;
        return !$err;

    }


    public function actionKek()
    {
        $csvP = Yii::getAlias('@webroot') . "/kek.csv";
        $csv = fopen($csvP, 'r');
        while (($row = fgetcsv($csv, 32000, ';')) != false) {
            $country = Countries::findOne(['code' => $row['2']]) ?? new Countries();
            $country->code = $row['2'];
            $country->flag = $row['0'];
            $country->en = $row['1'];
            $country->ru = $row['3'];
            $country->save();
        }


    }
}
