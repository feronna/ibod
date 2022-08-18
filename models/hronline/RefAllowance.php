<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.ref_allowance".
 *
 * @property string $it_income_code
 * @property string $it_account_name
 */
class RefAllowance extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hronline.ref_allowance';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['it_income_code', 'it_account_name'], 'required'],
            [['it_income_code', 'it_account_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'it_income_code' => 'It Income Code',
            'it_account_name' => 'It Account Name',
        ];
    }
}
