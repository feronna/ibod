<?php

namespace app\models\smp_ppi;

use Yii;

/**
 * This is the model class for table "dbo.vw_CV_Magazine".
 *
 * @property int $ID
 * @property string $PubID
 * @property string $User_Ic
 * @property int $IsPublic
 * @property string $Keterangan_PublicationStatus
 * @property string $PublicationType
 * @property string $AuthorType
 * @property string $FullAuthorName
 * @property int $PublicationYear
 * @property string $ISBN
 * @property string $Title
 * @property string $Publisher
 * @property string $Volume
 * @property string $PageNumber
 * @property string $Issue
 * @property string $Abstract
 * @property string $SourceName
 * @property string $ApproveStatus
 */
class Magazine extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dbo.vw_CV_Magazine';
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
            [['ID'], 'required'],
            [['ID', 'IsPublic', 'PublicationYear'], 'integer'],
            [['FullAuthorName', 'Title', 'Publisher', 'Abstract', 'SourceName'], 'string'],
            [['PubID'], 'string', 'max' => 8],
            [['User_Ic', 'Keterangan_PublicationStatus', 'AuthorType', 'ISBN', 'Volume', 'PageNumber', 'Issue'], 'string', 'max' => 50],
            [['PublicationType'], 'string', 'max' => 100],
            [['ApproveStatus'], 'string', 'max' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'PubID' => 'Pub ID',
            'User_Ic' => 'User Ic',
            'IsPublic' => 'Is Public',
            'Keterangan_PublicationStatus' => 'Keterangan Publication Status',
            'PublicationType' => 'Publication Type',
            'AuthorType' => 'Author Type',
            'FullAuthorName' => 'Full Author Name',
            'PublicationYear' => 'Publication Year',
            'ISBN' => 'Isbn',
            'Title' => 'Title',
            'Publisher' => 'Publisher',
            'Volume' => 'Volume',
            'PageNumber' => 'Page Number',
            'Issue' => 'Issue',
            'Abstract' => 'Abstract',
            'SourceName' => 'Source Name',
            'ApproveStatus' => 'Approve Status',
        ];
    }

     public function getAuthorstatus() {
        if($this->AuthorType == 'First Author'){
            return 'Penulis Utama';
        }
        else{
            return $this->Authorstatus;
        }
    }
}

