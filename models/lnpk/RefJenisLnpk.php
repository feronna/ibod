<?php

namespace app\models\lnpk;

use Yii;

/**
 * This is the model class for table "hrm.lnpk_ref_lnpk".
 *
 * @property int $id
 * @property string $lnpk_desc
 */
class RefJenisLnpk extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.lnpk_ref_lnpk';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lnpk_desc'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'lnpk_desc' => 'Lnpk Desc',
        ];
    }
}
