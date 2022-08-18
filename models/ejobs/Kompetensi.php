<?php

namespace app\models\ejobs;
use app\models\ejobs\Iklan;

use Yii;

/**
 * This is the model class for table "ejobs.temuduga_kompetensi".
 *
 * @property int $id
 * @property int $iklan_id
 * @property int $ref_no
 * @property string $tarikh_srt
 * @property string $tarikh_maklumbalas
 * @property string $tarikh_komp
 * @property string $masa_komp
 * @property string $tempat_komp
 */
class Kompetensi extends \yii\db\ActiveRecord
{
    // add the function below:
    public static function getDb() {
        return Yii::$app->get('db7');  // second database
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ejobs.kompetensi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['iklan_id', 'ref_no'], 'integer'],
            [['tarikh_srt', 'tarikh_maklumbalas', 'tarikh_komp','tarikh_noti'], 'safe'],
            [['tempat_komp','desc_komp'], 'string'],
            [['masa_komp','title_komp'], 'string', 'max' => 100],
            [['hari_maklumbalas'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'iklan_id' => 'Iklan ID',
            'ref_no' => 'Ref No',
            'tarikh_srt' => 'Tarikh Srt',
            'tarikh_maklumbalas' => 'Tarikh Maklumbalas',
            'tarikh_komp' => 'Tarikh Komp',
            'masa_komp' => 'Masa Komp',
            'tempat_komp' => 'Tempat Komp',
        ];
    }
    
    public function getIklan() {
        return $this->hasOne(Iklan::className(), ['id' => 'iklan_id']);
    }
}
