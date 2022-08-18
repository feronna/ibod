<?php
namespace app\models\myidp;

use Yii;

/**
 * This is the model class for table "{{%myidp.ref_cpdgroup}}".
 *
 * @property int $cpdgroup
 * @property string $tahun
 * @property int $mataMin
 * @property int $minTeras
 * @property int $minElektif
 * @property int $minUmum
 * @property int $minTerasUni
 * @property int $minTerasSkim
 * @property string $cpdtype
 */
class RefCpdGroup extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%hrd.idp_ref_cpdgroup}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tahun', 'cpdtype'], 'required'],
            [['mataMin', 'minTeras', 'minElektif', 'minUmum', 'minTerasUni', 'minTerasSkim'], 'integer'],
            [['tahun'], 'string', 'max' => 4],
            [['cpdtype'], 'string', 'max' => 25],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'cpdgroup' => Yii::t('app', 'Cpdgroup'),
            'tahun' => Yii::t('app', 'Tahun'),
            'mataMin' => Yii::t('app', 'Mata Min'),
            'minTeras' => Yii::t('app', 'Min Teras'),
            'minElektif' => Yii::t('app', 'Min Elektif'),
            'minUmum' => Yii::t('app', 'Min Umum'),
            'minTerasUni' => Yii::t('app', 'Min Teras Uni'),
            'minTerasSkim' => Yii::t('app', 'Min Teras Skim'),
            'cpdtype' => Yii::t('app', 'Cpdtype'),
        ];
    }
    
    public function getGredJawatan(){
        return $this->hasMany(RefCpdGroupGredJawatan::className(), ['cpdgroup' => 'cpdgroup']);
    }
}
