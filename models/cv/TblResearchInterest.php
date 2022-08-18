<?php

namespace app\models\cv;

use Yii;

/**
 * This is the model class for table "dbo.vw_ResearchInterest".
 *
 * @property int $ID
 * @property string $UserID
 * @property string $Keyword
 * @property string $LastUpdate
 */
class TblResearchInterest extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dbo.vw_ResearchInterest';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db6');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['UserID', 'LastUpdate'], 'required'],
            [['LastUpdate'], 'safe'],
            [['UserID'], 'string', 'max' => 50],
            [['Keyword'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'UserID' => 'User ID',
            'Keyword' => 'Keyword',
            'LastUpdate' => 'Last Update',
        ];
    }
}
