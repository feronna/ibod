<?php

namespace app\models\smp_ppi;

use Yii;

/**
 * This is the model class for table "dbo.vw_CV_PreUni".
 *
 * @property int $ID
 * @property string $PubID
 * @property string $User_Ic
 * @property int $IsPublic
 * @property string $Keterangan_PublicationStatus
 * @property string $BookCatID
 * @property string $isResearchBook
 * @property string $AuthorType
 * @property string $FullAuthorName
 * @property int $PublicationYear
 * @property string $BookTitle
 * @property string $Publisher
 * @property string $ISBN
 * @property string $Abstract
 * @property string $ApproveStatus
 */
class PreUni extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dbo.vw_CV_PreUni';
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
            [['FullAuthorName', 'Abstract'], 'string'],
            [['PubID'], 'string', 'max' => 8],
            [['User_Ic', 'Keterangan_PublicationStatus', 'isResearchBook', 'AuthorType', 'ISBN'], 'string', 'max' => 50],
            [['BookCatID', 'ApproveStatus'], 'string', 'max' => 1],
            [['BookTitle', 'Publisher'], 'string', 'max' => 500],
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
            'BookCatID' => 'Book Cat ID',
            'isResearchBook' => 'Is Research Book',
            'AuthorType' => 'Author Type',
            'FullAuthorName' => 'Full Author Name',
            'PublicationYear' => 'Publication Year',
            'BookTitle' => 'Book Title',
            'Publisher' => 'Publisher',
            'ISBN' => 'Isbn',
            'Abstract' => 'Abstract',
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

