<?php

namespace app\models\elnpt\penerbitan;

use Yii;

/**
 * This is the model class for table "dbo.vw_LNPT_Pub_Article".
 *
 * @property string $ID
 * @property string $User_Ic
 * @property string $Type
 * @property string $Title
 * @property string $ApproveStatus
 * @property string $PublicationYear
 */
class TblLnptPubArticle extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dbo.vw_LNPT_Pub_Article';
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
            [['Type'], 'required'],
            [['ID'], 'string', 'max' => 11],
            [['User_Ic', 'ApproveStatus', 'PublicationYear'], 'string', 'max' => 50],
            [['Type'], 'string', 'max' => 7],
            [['Title'], 'string', 'max' => 2500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'User_Ic' => 'User Ic',
            'Type' => 'Type',
            'Title' => 'Title',
            'ApproveStatus' => 'Approve Status',
            'PublicationYear' => 'Publication Year',
        ];
    }
}
