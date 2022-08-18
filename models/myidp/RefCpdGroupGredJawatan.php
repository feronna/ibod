<?php

namespace app\models\myidp;

use Yii;
use app\models\hronline\Tblprcobiodata;
use app\models\hronline\Tblrscosandangan;

/**
 * This is the model class for table "{{%myidp.ref_cpdgroup_gredjawatan}}".
 *
 * @property int $cpdgroup
 * @property string $gred
 * @property string $tahun
 */
class RefCpdGroupGredJawatan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%hrd.idp_ref_cpdgroup_gredjawatan}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cpdgroup', 'gred', 'tahun'], 'required'],
            [['cpdgroup'], 'integer'],
            [['gred'], 'string', 'max' => 10],
            [['tahun'], 'string', 'max' => 4],
            [['gred_skim'], 'string', 'max' => 5],
            [['cpdgroup', 'gred'], 'unique', 'targetAttribute' => ['cpdgroup', 'gred']],
            [['cpdgroup', 'gred', 'tahun'], 'unique', 'targetAttribute' => ['cpdgroup', 'gred', 'tahun']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'cpdgroup' => Yii::t('app', 'Cpdgroup'),
            'gred' => Yii::t('app', 'Gred'),
            'tahun' => Yii::t('app', 'Tahun'),
            'gred_skim' => Yii::t('app', 'Gred Skim'),
        ];
    }

    public function getCpdGroup()
    {
        return $this->hasOne(RefCpdGroup::className(), ['cpdgroup' => 'cpdgroup']);
    }

    public static function countStaff($gred_skim, $tahun)
    {

        $count = 0;

        if ($tahun == date('Y')) {

            $modelB = Tblprcobiodata::find()
                ->joinWith('jawatan')
                ->where(['Status' => '1'])
                ->andWhere(['gred_skim' => $gred_skim])
                ->all();

            foreach ($modelB as $mB) {

                $modelS = RptStatistikIdpV2::find()
                    ->where(['staf_status' => '1', 'statusIDP' => '1', 'tahun' => $tahun, 'icno' => $mB->ICNO])
                    ->one();

                if ($modelS) {
                    $count = $count + 1;
                }

            }
            
        } else {

            $modelB = RptStatistikIdpV2::find()
                ->where(['staf_status' => '1', 'statusIDP' => '1', 'tahun' => $tahun])
                ->all();

            //$h = [];
            foreach ($modelB as $mB) {

                $modelS = Tblrscosandangan::find()
                    ->where(['tblrscosandangan.id' => $mB->sandangan_id])
                    ->one();

                if (
                    $modelS
                    && ($modelS->jawatan->gred_skim == $gred_skim)
                ) {
                    $count = $count + 1;
                }
            }
        }

        return $count;
    
    }
}
