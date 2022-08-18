<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.tblrscoallowance".
 *
 * @property int $id
 * @property string $ICNO
 * @property string $it_income_code
 */
class Tblrscoallowance extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hronline.tblrscoallowance';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ICNO'], 'required'],
            [['ICNO'], 'string', 'max' => 12],
            [['it_income_code'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ICNO' => 'Icno',
            'it_income_code' => 'It Income Code',
        ];
    }
    
        public function getAllowance()
    {
        return $this->hasOne(RefAllowance::className(), ['it_income_code' => 'it_income_code']);
    }
}
