<?php

namespace app\models\smp_ppi;

use Yii;

/**
 * This is the model class for table "dbo.vw_CV_JournalInternational".
 *
 * @property int $ID
 * @property string $PubID
 * @property string $User_Ic
 * @property int $IsPublic
 * @property string $Keterangan_PublicationStatus
 * @property string $Type
 * @property string $CitedJournal
 * @property string $AuthorType
 * @property string $FullAuthorName
 * @property string $PublicationYear
 * @property string $Title
 * @property string $JournalName
 * @property string $Volume
 * @property string $Isu
 * @property string $PageNumber
 * @property string $ApproveStatus
 */
class JournalInternational extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dbo.vw_CV_JournalInternational';
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
            [['ID', 'IsPublic'], 'integer'],
            [['FullAuthorName', 'JournalName'], 'string'],
            [['PubID'], 'string', 'max' => 8],
            [['User_Ic', 'Keterangan_PublicationStatus', 'Type', 'CitedJournal', 'AuthorType', 'PublicationYear', 'Volume', 'PageNumber'], 'string', 'max' => 50],
            [['Title'], 'string', 'max' => 2500],
            [['Isu'], 'string', 'max' => 500],
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
            'Type' => 'Type',
            'CitedJournal' => 'Cited Journal',
            'AuthorType' => 'Author Type',
            'FullAuthorName' => 'Full Author Name',
            'PublicationYear' => 'Publication Year',
            'Title' => 'Title',
            'JournalName' => 'Journal Name',
            'Volume' => 'Volume',
            'Isu' => 'Isu',
            'PageNumber' => 'Page Number',
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
