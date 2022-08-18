<?php

namespace app\models\cbelajar;

use Yii;

/**
 * This is the model class for table "cbelajar.tbl_doktoral".
 *
 * @property int $id
 * @property string $icno
 * @property string $terima
 * @property string $syarat_id
 * @property string $semak_doktoral
 * @property string $created_dt
 * @property int $tahun
 */
class TblDoktoral extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cbelajar.tbl_doktoral';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_dt'], 'safe'],
            [['tahun'], 'integer'],
            [['icno'], 'string', 'max' => 14],
            [['terima'], 'string', 'max' => 10],
            [['syarat_id', 'semak_doktoral'], 'string', 'max' => 20],
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
            'terima' => 'Terima',
            'syarat_id' => 'Syarat ID',
            'semak_doktoral' => 'Semak Doktoral',
            'created_dt' => 'Created Dt',
            'tahun' => 'Tahun',
        ];
    }
}
