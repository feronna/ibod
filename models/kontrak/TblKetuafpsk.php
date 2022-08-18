<?php

namespace app\models\kontrak;

use Yii;
use app\models\hronline\Tblprcobiodata;
/**
 * This is the model class for table "hrm.kontrak_tbl_ketuafpsk".
 *
 * @property int $id
 * @property string $icno
 * @property string $jabatan
 */
class TblKetuafpsk extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.kontrak_tbl_ketuafpsk';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['icno'], 'string', 'max' => 14],
            [['jabatan'], 'string', 'max' => 255],
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
            'jabatan' => 'Jabatan',
        ];
    }
    
    public function getKakitangan() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
}
