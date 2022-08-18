<?php

namespace app\models\aduan;

use Yii;
use app\models\hronline\Tblprcobiodata;

/**
 * This is the model class for table "keselamatan.rpt_tbl_access".
 *
 * @property string $staff_icno
 * @property string $access_type
 * @property int $level
 */
class RptTblAccess extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'keselamatan.rpt_tbl_access';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['staff_icno'], 'required'],
            [['level'], 'integer'],
            [['staff_icno'], 'string', 'max' => 12],
            [['access_type'], 'string', 'max' => 25],
            [['staff_icno'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'staff_icno' => Yii::t('app', 'Staff Icno'),
            'access_type' => Yii::t('app', 'Access Type'),
            'level' => Yii::t('app', 'Level'),
        ];
    }

    public function getBiodata()
    {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'staff_icno']);
    }
}
