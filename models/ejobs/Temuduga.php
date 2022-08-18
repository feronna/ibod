<?php

namespace app\models\ejobs;
use app\models\ejobs\Iklan;

use Yii;

/**
 * This is the model class for table "ejobs.temuduga".
 *
 * @property int $id
 * @property int $iklan_id
 * @property int $ref_no
 * @property string $tarikh_srt
 * @property string $bil_srt
 * @property string $tarikh_maklumbalas
 * @property string $tarikh_iv
 * @property string $masa_iv
 * @property string $tempah_iv
 */
class Temuduga extends \yii\db\ActiveRecord
{
    // add the function below:
    public static function getDb() {
        return Yii::$app->get('db7'); // second database
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ejobs.temuduga';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['iklan_id', 'ref_no'], 'integer'],
            [['tarikh_srt', 'tarikh_maklumbalas', 'tarikh_iv','tarikh_noti'], 'safe'],
            [['tempat_iv'], 'string'],
            [['bil_srt'], 'string', 'max' => 150],
            [['masa_iv'], 'string', 'max' => 100],
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
            'bil_srt' => 'Bil Srt',
            'tarikh_maklumbalas' => 'Tarikh Maklumbalas',
            'tarikh_iv' => 'Tarikh Iv',
            'masa_iv' => 'Masa Iv',
            'tempat_iv' => 'Tempah Iv',
        ];
    }
    
    public function getIklan() {
        return $this->hasOne(Iklan::className(), ['id' => 'iklan_id']);
    }
}
