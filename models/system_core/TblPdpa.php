<?php

namespace app\models\system_core;

use Yii;

/**
 * This is the model class for table "system_core.tbl_pdpa".
 *
 * @property int $id
 * @property string $icno
 * @property int $accept_dt
 */
class TblPdpa extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'system_core.tbl_pdpa';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['accept_dt'], 'string'],
            [['icno'], 'string', 'max' => 12],
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
            'accept_dt' => 'Accept Dt',
        ];
    }
}
