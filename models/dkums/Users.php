<?php

namespace app\models\dkums;

use app\models\lppums\TblPenetapPenilai;
use Yii;

/**
 * This is the model class for table "utilities.dkums_users".
 *
 * @property int $id
 * @property string $icno
 * @property int $access 1 - admin
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'utilities.dkums_users';
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

    /**
     * ni utk urusetia induk atau pun admin
     */
    public static function isUserAdmin($userid)
    {

        $model = self::findOne(['icno' => $userid, 'access' => 1]);

        if ($model) {
            return true;
        }

        return false;
    }

    public static function isUserPenetapPenilai($userid)
    {
        $curr_year = date('Y');

        $model = TblPenetapPenilai::find()->where(['penetap_icno' => $userid, 'tahun'=>$curr_year])->one();

        if ($model) {
            return $model;
        }

        return false;
    }
}
