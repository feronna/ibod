<?php

namespace app\models\elnpt;

use Yii;

/**
 * This is the model class for table "dbo.vw_LNPT_GrantApplication".
 *
 * @property string $RefID
 * @property string $UserIC
 * @property string $Title
 * @property string $DateApply
 * @property int $Tahun
 * @property string $GrantType
 * @property int $Stat
 * @property string $GrantName
 * @property string $Agency
 */
class TblGrantApplication extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dbo.vw_LNPT_GrantApplication';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db10');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Title'], 'string'],
            [['DateApply'], 'safe'],
            [['Tahun', 'Stat'], 'integer'],
            [['GrantType'], 'required'],
            [['RefID', 'UserIC'], 'string', 'max' => 50],
            [['GrantType'], 'string', 'max' => 8],
            [['GrantName'], 'string', 'max' => 80],
            [['Agency'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'RefID' => 'Ref ID',
            'UserIC' => 'User Ic',
            'Title' => 'Title',
            'DateApply' => 'Date Apply',
            'Tahun' => 'Tahun',
            'GrantType' => 'Grant Type',
            'Stat' => 'Stat',
            'GrantName' => 'Grant Name',
            'Agency' => 'Agency',
        ];
    }
}
