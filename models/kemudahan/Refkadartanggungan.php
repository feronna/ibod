<?php

namespace app\models\kemudahan;
use app\models\hronline\Tblprcobiodata;

use Yii;

/**
 * This is the model class for table "utilities.fac_ref_kadar_tanggungan".
 *
 * @property int $id
 * @property string $icno
 * @property string $name
 * @property string $tanggungan
 * @property string $isActive 0 = inactive, 1 = active
 */
class Refkadartanggungan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'utilities.fac_ref_kadar_tanggungan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['icno'], 'string', 'max' => 12],
            [['name'], 'string', 'max' => 300],
            [['tanggungan'], 'string', 'max' => 50],
            [['isActive'], 'string', 'max' => 5],
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
            'name' => 'Name',
            'tanggungan' => 'Tanggungan',
            'isActive' => 'Is Active',
        ];
    }
    public function getStaffName() {
        return $this->hasOne(Tblprcobiodata::className(), ['CONm' => 'name']);
    }
     public function getKakitangan() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
}
