<?php

namespace app\models\pengesahan;

use Yii;

/**
 * This is the model class for table "hrm.sah_tbl_user_access".
 *
 * @property int $id
 * @property string $icno
 * @property int $access 1 - admin
 */
class TblUserAccess extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.sah_tbl_user_access';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['access'], 'integer'],
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
            'icno' => 'Icno',
            'access' => 'Access',
        ];
    }
}
