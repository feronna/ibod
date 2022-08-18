<?php

namespace app\models\elnpt;
use app\models\elnpt\Tblprcobiodata;

use Yii;

/**
 * This is the model class for table "hrm.elnpt_tbl_request".
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
        return 'hrm.elnpt_tbl_request';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lpp_id', 'ICNO', 'close_date'], 'required'],
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
            'ICNO' => 'ICNO',
            'close_date' => 'Close Date',
        ];
    }
    
    public function getGuru() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'ICNO']);
    }
}
