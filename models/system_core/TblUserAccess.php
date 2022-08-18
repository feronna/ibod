<?php

namespace app\models\system_core;

use Yii;

/**
 * This is the model class for table "dass.tbl_user_access".
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
        return 'system_core.tbl_user_access';
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
    public function getKakitangan() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
}
