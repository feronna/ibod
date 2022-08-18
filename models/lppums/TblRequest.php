<?php

namespace app\models\lppums;

use Yii;
use app\models\hronline\Tblprcobiodata;

/**
 * This is the model class for table "hrm.lppums_tbl_request".
 *
 * @property int $id
 * @property string $lpp_id
 * @property string $ICNO
 * @property string $close_date
 */
class TblRequest extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.lppums_tbl_request';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lpp_id', 'close_date', 'ICNO'], 'required'],
            [['lpp_id'], 'integer'],
            [['close_date'], 'safe'],
            [['ICNO'], 'string', 'max' => 12],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'lpp_id' => 'Lpp ID',
            'ICNO' => 'Icno',
            'close_date' => 'Close Date',
        ];
    }
    
    public function getPemohon() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'ICNO']);
    }
    
}
