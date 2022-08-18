<?php

namespace app\models\elnpt\penerbitan;

use Yii;

/**
 * This is the model class for table "dbo.vw_CV_Technical".
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
class DboVwCVTechnical extends \yii\db\ActiveRecord
{
    public $jenis;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dbo.vw_CV_Technical';
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
            [['PubID', 'User_Ic', 'Keterangan_PublicationStatus', 'PublicationType', 'AuthorType', 'FullAuthorName', 'ISBN', 'Title', 'Publisher', 'Volume', 'PageNumber', 'Issue', 'Abstract', 'SourceName', 'ApproveStatus'], 'string'],
            [['jenis'], 'safe'],
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
    
    public function afterFind()
    {
        parent::afterFind();

        $this->jenis = "BUKU-BUKU TEKS (AKADEMIK)";
    }
}
