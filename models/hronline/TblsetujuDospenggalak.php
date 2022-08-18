<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.tblsetuju_dospenggalak".
 *
 * @property int $id
 * @property string $icno
 * @property int $setuju_st
 * @property string $penerangan
 * @property string $kemaskini_dt
 */
class TblsetujuDospenggalak extends \yii\db\ActiveRecord
{
    public $tarikh_dos2;

    public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }

    public static function tableName()
    {
        return 'hronline.tblsetuju_dospenggalak';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['setuju_st'], 'integer'],
            [['penerangan'], 'string'],
            [['kemaskini_dt',' tarikh_dos2'], 'safe'],
            [['icno'], 'string', 'max' => 15],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'icno' => 'Icno',
            'setuju_st' => 'Setuju St',
            'penerangan' => 'Penerangan',
            'kemaskini_dt' => 'Kemaskini Dt',
        ];
    }
}
