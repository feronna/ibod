<?php

namespace app\models\pengesahan;

use Yii;

/**
 * This is the model class for table "pengesahan.tbl_access_canselori".
 *
 * @property int $id
 * @property string $icno
 * @property int $access 1 - admin
 */
class TblAccessCanselori extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
//        return 'pengesahan.tbl_access_canselori';
        return 'hrm.sah_tbl_access_canselori';
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
