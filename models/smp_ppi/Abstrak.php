<?php

namespace app\models\smp_ppi;

use Yii;

/**
 * This is the model class for table "dbo.vw_CV_Abstract".
 *
 * @property int $ID
 * @property string $PubID
 * @property string $User_Ic
 * @property string $ProceedingLevel
 * @property string $AuthorType
 * @property string $FullAuthorName
 * @property string $StartDate
 * @property string $EndDate
 * @property string $ProsidingName
 * @property string $PaperTitle
 * @property string $Isbn_issn
 * @property string $Volume
 * @property string $Isu
 * @property string $Venue
 * @property string $ApproveStatus
 */
class Abstrak extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dbo.vw_CV_Abstract';
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
            [['ID'], 'integer'],
            [['FullAuthorName', 'PaperTitle'], 'string'],
            [['StartDate', 'EndDate'], 'safe'],
            [['PubID'], 'string', 'max' => 8],
            [['User_Ic', 'ProceedingLevel', 'AuthorType', 'Isbn_issn', 'Volume'], 'string', 'max' => 50],
            [['ProsidingName', 'Isu'], 'string', 'max' => 2500],
            [['Venue'], 'string', 'max' => 400],
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
            'ProceedingLevel' => 'Proceeding Level',
            'AuthorType' => 'Author Type',
            'FullAuthorName' => 'Full Author Name',
            'StartDate' => 'Start Date',
            'EndDate' => 'End Date',
            'ProsidingName' => 'Prosiding Name',
            'PaperTitle' => 'Paper Title',
            'Isbn_issn' => 'Isbn Issn',
            'Volume' => 'Volume',
            'Isu' => 'Isu',
            'Venue' => 'Venue',
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
