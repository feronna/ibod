<?php

namespace app\models\elnpt\testing;

use Yii;

use app\models\elnpt\testing\RefUserAccess;

/**
 * This is the model class for table "hrm.elnpt_tbl_user_access".
 *
 * @property int $id
 * @property string $icno
 * @property int $access 1 - admin
 */
class TblTestingAccess extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.elnpt_tbl_user_access';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
//    public static function getDb()
//    {
//        return Yii::$app->get('db2');
//    }

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
    
    public function getAksesDesc() {
        return $this->hasOne(RefUserAccess::className(), ['id' => 'access']);
    }
    
}
