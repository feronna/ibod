<?php

namespace app\models\ptb;

use Yii;
use app\models\ptb\Application;
/**
 * This is the model class for table "ptb.tbl_penyelia".
 *
 * @property int $id
 * @property string $jenis_penyelia
 * @property string $icno
 */
class TblPenyelia extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.ptb_tbl_penyelia';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['jenis_penyelia'], 'string', 'max' => 50],
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
            'jenis_penyelia' => 'Jenis Penyelia',
            'icno' => 'Icno',
        ];
    }
 
}
