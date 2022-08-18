<?php

namespace app\models\cv;

use Yii;

/**
 * This is the model class for table "dbo.vw_Expertise".
 *
 * @property string $Name
 * @property string $UserID
 * @property string $Category
 * @property string $ID_category
 * @property string $Groups
 * @property string $ID_group
 * @property string $Area
 * @property string $ID_area
 * @property int $Status
 * @property string $TarikhLulus
 * @property string $User_KodJbtn
 */
class TblExpertise extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dbo.vw_Expertise';
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
            [['Name'], 'required'],
            [['Status'], 'integer'],
            [['TarikhLulus'], 'safe'],
            [['Name'], 'string', 'max' => 1000],
            [['UserID', 'ID_category', 'ID_group', 'ID_area', 'User_KodJbtn'], 'string', 'max' => 50],
            [['Category'], 'string', 'max' => 100],
            [['Groups', 'Area'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Name' => 'Name',
            'UserID' => 'User ID',
            'Category' => 'Category',
            'ID_category' => 'Id Category',
            'Groups' => 'Groups',
            'ID_group' => 'Id Group',
            'Area' => 'Area',
            'ID_area' => 'Id Area',
            'Status' => 'Status',
            'TarikhLulus' => 'Tarikh Lulus',
            'User_KodJbtn' => 'User Kod Jbtn',
        ];
    }
}
