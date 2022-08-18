<?php

namespace app\models\elnpt;

use Yii;

/**
 * This is the model class for table "dbo.vw_Research".
 *
 * @property int $ID
 * @property string $IC
 * @property string $User_Name
 * @property string $NoPer
 * @property string $Gred
 * @property string $Dept
 * @property string $Title
 * @property string $StartDate
 * @property string $EndDate
 * @property string $Keyword
 * @property string $Membership
 * @property string $Amount
 * @property string $AmountReceived
 * @property string $AmountSpent
 * @property int $AgencyStatusID
 * @property string $AgencyName
 * @property string $ProjectID
 * @property string $ResearchStatus
 * @property string $Keterangan
 * @property int $Y
 * @property int $GrantTypeID
 * @property string $OtherAgency
 * @property string $Description
 * @property int $Duration
 * @property int $ExtraDuration
 * @property string $GrantTypeDecs
 * @property string $Location
 * @property int $Research_Status
 * @property string $GrantLevel
 * @property int $GrantLevelID
 * @property int $ExtensionNo
 * @property string $Researchers
 */
class TblPenyelidikan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dbo.vw_Research';
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
            [['ID', 'AgencyStatusID', 'Y', 'GrantTypeID', 'Duration', 'ExtraDuration', 'Research_Status', 'GrantLevelID', 'ExtensionNo'], 'integer'],
            [['User_Name', 'ExtensionNo'], 'required'],
            [['Title', 'Keyword', 'Description', 'Location', 'Researchers'], 'string'],
            [['StartDate', 'EndDate'], 'safe'],
            [['Amount', 'AmountReceived', 'AmountSpent'], 'number'],
            [['IC', 'NoPer', 'Gred', 'Dept', 'Membership', 'ProjectID', 'ResearchStatus'], 'string', 'max' => 50],
            [['User_Name'], 'string', 'max' => 1000],
            [['AgencyName'], 'string', 'max' => 100],
            [['Keterangan', 'OtherAgency'], 'string', 'max' => 200],
            [['GrantTypeDecs'], 'string', 'max' => 80],
            [['GrantLevel'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'IC' => 'Ic',
            'User_Name' => 'User Name',
            'NoPer' => 'No Per',
            'Gred' => 'Gred',
            'Dept' => 'Dept',
            'Title' => 'Title',
            'StartDate' => 'Start Date',
            'EndDate' => 'End Date',
            'Keyword' => 'Keyword',
            'Membership' => 'Membership',
            'Amount' => 'Amount',
            'AmountReceived' => 'Amount Received',
            'AmountSpent' => 'Amount Spent',
            'AgencyStatusID' => 'Agency Status ID',
            'AgencyName' => 'Agency Name',
            'ProjectID' => 'Project ID',
            'ResearchStatus' => 'Research Status',
            'Keterangan' => 'Keterangan',
            'Y' => 'Y',
            'GrantTypeID' => 'Grant Type ID',
            'OtherAgency' => 'Other Agency',
            'Description' => 'Description',
            'Duration' => 'Duration',
            'ExtraDuration' => 'Extra Duration',
            'GrantTypeDecs' => 'Grant Type Decs',
            'Location' => 'Location',
            'Research_Status' => 'Research Status',
            'GrantLevel' => 'Grant Level',
            'GrantLevelID' => 'Grant Level ID',
            'ExtensionNo' => 'Extension No',
            'Researchers' => 'Researchers',
        ];
    }
}
