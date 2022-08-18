<?php

namespace app\models\myidp;

use Yii;
use app\models\hronline\Tblprcobiodata;
use app\models\hronline\Tblbidangkepakaran;
use app\models\myidp\Penceramah;

/**
 * This is the model class for table "{{%myidp.ceramah}}".
 *
 * @property string $penceramahID
 * @property int $siriLatihanID
 * @property string $upah
 * @property string $jamuan
 * @property string $penginapan
 * @property string $tiket
 */
class Ceramah extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%hrd.idp_ceramah}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['penceramahID', 'siriLatihanID'], 'required'],
            [['siriLatihanID', 'jenis'], 'integer'],
            [['upah', 'jamuan', 'penginapan', 'tiket'], 'number'],
            [['penceramahID'], 'string', 'max' => 12],
            [['penceramahID', 'siriLatihanID'], 'unique', 'targetAttribute' => ['penceramahID', 'siriLatihanID']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'penceramahID' => Yii::t('app', 'Penceramah ID'),
            'siriLatihanID' => Yii::t('app', 'Siri Latihan ID'),
            'upah' => Yii::t('app', 'Upah'),
            'jamuan' => Yii::t('app', 'Jamuan'),
            'penginapan' => Yii::t('app', 'Penginapan'),
            'tiket' => Yii::t('app', 'Tiket'),
            'jenis' => Yii::t('app', 'Jenis'),
        ];
    }
    
    public function getPenceramah()
    {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO'=>'penceramahID']);
    }
    
    public function getPenceramahluar()
    {
        return $this->hasOne(Penceramah::className(), ['penceramah_id'=>'penceramahID']);
    }
    
    public function getKepakaran()
    {
        return $this->hasMany(Tblbidangkepakaran::className(), ['ICNO' => 'penceramahID']);
    }
    
    /** Relation **/
    public function getSiriceramah(){
        return $this->hasOne(SiriLatihan::className(), ['siriLatihanID' => 'siriLatihanID']);
    }
}
