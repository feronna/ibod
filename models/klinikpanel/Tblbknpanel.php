<?php

namespace app\models\klinikpanel;

use Yii;

/**
 * This is the model class for table "klinikpanel2.tblbknpanel".
 *
 * @property int $id
 * @property string $icno
 * @property string $nama_klinik
 * @property string $rawatan
 * @property string $no_resit
 * @property string $tuntutan
 * @property string $tuntutan_date
 * @property string $insert_by
 * @property string $insert_dt
 */
class Tblbknpanel extends \yii\db\ActiveRecord
{
    // add the function below:
    public static function getDb() {
        return Yii::$app->get('db'); // second database
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.myhealth_tblbknpanel';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rawatan'], 'string'],
            [['tuntutan'], 'number'],
            [['tuntutan_date', 'insert_dt'], 'safe'],
            [['icno', 'insert_by'], 'string', 'max' => 16],
            [['nama_klinik'], 'string', 'max' => 255],
            [['no_resit'], 'string', 'max' => 100],
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
            'nama_klinik' => 'Nama Klinik',
            'rawatan' => 'Rawatan',
            'no_resit' => 'No Resit',
            'tuntutan' => 'Tuntutan',
            'tuntutan_date' => 'Tuntutan Date',
            'insert_by' => 'Insert By',
            'insert_dt' => 'Insert Dt',
        ];
    }
    
    public function getKakitangan()
    {
        return $this->hasOne(Tblmaxtuntutan::className(), ['max_icno' => 'icno']);
    }
    
    public function getInsertby()
    {
        return $this->hasOne(\app\models\hronline\Tblprcobiodata::className(), ['ICNO' => 'insert_by']);
    }
}
