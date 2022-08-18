<?php

namespace app\models\myidp;

use Yii;
use app\models\hronline\Tblprcobiodata;

/**
 * This is the model class for table "hrd.idp_tbl_ul".
 *
 * @property string $userID
 * @property string $ul_type
 */
class UrusetiaLatihan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrd.idp_tbl_ul';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['userID'], 'required'],
            [['userID'], 'string', 'max' => 12],
            [['ul_type'], 'string', 'max' => 25],
            [['level'], 'integer'],
            [['userID'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'userID' => 'User ID',
            'ul_type' => 'Ul Type',
            'level' => Yii::t('app', 'Level'),
        ];
    }

    public function getBiodata()
    {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'userID']);
    }
}
