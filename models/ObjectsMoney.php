<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "objects_money".
 *
 * @property int $id
 * @property int|null $id_object
 * @property float|null $money_prozh_bez_dop
 * @property float|null $money_prozh_dop
 * @property float|null $money_aren
 * @property float|null $money_cel_sred
 * @property float|null $voda
 * @property float|null $tep
 * @property float|null $gaz
 * @property float|null $elect
 * @property float|null $uborka_ter
 * @property float|null $uborka_pom
 * @property float|null $tech_obs
 * @property float|null $derivation
 * @property float|null $tbo
 * @property float|null $gos_prov
 * @property float|null $attest
 * @property float|null $prot_pozhar
 * @property float|null $inie_rash
 * @property float|null $ohrana
 * @property float|null $anti_ter
 * @property float|null $inie_rash_ohrana
 * @property float|null $nalog_imush
 * @property float|null $zem_nalog
 * @property float|null $svaz
 * @property float|null $kap_rem
 * @property float|null $tek_rem
 * @property float|null $mygk_inv
 * @property float|null $osn_sred
 * @property float|null $opla_trud
 *
 * @property Objects $object
 */
class ObjectsMoney extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'objects_money';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_object'], 'integer'],
            [['money_prozh_bez_dop', 'money_prozh_dop', 'money_aren', 'money_cel_sred', 'voda', 'tep', 'gaz', 'elect', 'uborka_ter', 'uborka_pom', 'tech_obs', 'derivation', 'tbo', 'gos_prov', 'attest', 'prot_pozhar', 'inie_rash', 'ohrana', 'anti_ter', 'inie_rash_ohrana', 'nalog_imush', 'zem_nalog', 'svaz', 'kap_rem', 'tek_rem', 'mygk_inv', 'osn_sred', 'opla_trud'], 'number'],
            [['id_object'], 'exist', 'skipOnError' => true, 'targetClass' => Objects::className(), 'targetAttribute' => ['id_object' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_object' => 'Id Object',
            'money_prozh_bez_dop' => 'Money Prozh Bez Dop',
            'money_prozh_dop' => 'Money Prozh Dop',
            'money_aren' => 'Money Aren',
            'money_cel_sred' => 'Money Cel Sred',
            'voda' => 'Voda',
            'tep' => 'Tep',
            'gaz' => 'Gaz',
            'elect' => 'Elect',
            'uborka_ter' => 'Uborka Ter',
            'uborka_pom' => 'Uborka Pom',
            'tech_obs' => 'Tech Obs',
            'derivation' => 'Derivation',
            'tbo' => 'Tbo',
            'gos_prov' => 'Gos Prov',
            'attest' => 'Attest',
            'prot_pozhar' => 'Prot Pozhar',
            'inie_rash' => 'Inie Rash',
            'ohrana' => 'Ohrana',
            'anti_ter' => 'Anti Ter',
            'inie_rash_ohrana' => 'Inie Rash Ohrana',
            'nalog_imush' => 'Nalog Imush',
            'zem_nalog' => 'Zem Nalog',
            'svaz' => 'Svaz',
            'kap_rem' => 'Kap Rem',
            'tek_rem' => 'Tek Rem',
            'mygk_inv' => 'Mygk Inv',
            'osn_sred' => 'Osn Sred',
            'opla_trud' => 'Opla Trud',
        ];
    }

    /**
     * Gets query for [[Object]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getObject()
    {
        return $this->hasOne(Objects::className(), ['id' => 'id_object']);
    }
}
