<?php

namespace app\models\elnpt;

use Yii;
use yii\helpers\ArrayHelper;
use app\models\UtilitiesFunc;

/**
 * This is the model class for table "dbo.vw_LNPT_Research".
 *
 * @property int $ID
 * @property string $IC
 * @property string $NoPer
 * @property string $Dept
 * @property string $Title
 * @property string $StartDate
 * @property string $EndDate
 * @property string $Membership
 * @property string $Amount
 * @property string $AgencyName
 * @property string $ProjectID
 * @property string $ResearchStatus
 * @property string $Researchers
 * @property int $StartYear
 * @property int $EndYear
 * @property string $GrantLevel
 * @property int $GrantLevelID
 * @property int $ExtensionNo
 */
class TblPenyelidikan2 extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dbo.vw_LNPT_Research';
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
            [['ID', 'StartYear', 'EndYear', 'GrantLevelID', 'ExtensionNo'], 'integer'],
            [['Title', 'Researchers'], 'string'],
            [['StartDate', 'EndDate'], 'safe'],
            [['Amount'], 'number'],
            [['IC', 'NoPer', 'Dept', 'Membership', 'ProjectID', 'ResearchStatus'], 'string', 'max' => 50],
            [['AgencyName'], 'string', 'max' => 100],
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
            'IC' => 'No Kp',
            'NoPer' => 'No Per',
            'Dept' => 'Dept',
            'Title' => 'Title',
            'StartDate' => 'Start Date',
            'EndDate' => 'End Date',
            'Membership' => 'Membership',
            'Amount' => 'Amount',
            'AgencyName' => 'Agency Name',
            'ProjectID' => 'Project ID',
            'ResearchStatus' => 'Research Status',
            'Researchers' => 'Researchers',
            'StartYear' => 'Start Year',
            'EndYear' => 'End Year',
            'GrantLevel' => 'Grant Level',
            'GrantLevelID' => 'Grant Level ID',
            'ExtensionNo' => 'Extension No',
        ];
    }
    public static function staffResearchList($icno)
    {

        $model = self::find()->where(['IC' => $icno])->andWhere(['ResearchStatus'=>"Sedang Berjalan"])->all();

        $arr = [];

        if ($model) {
            $arr = ArrayHelper::map($model, 'ProjectID', 'newTajuk');
        }

        return $arr;
    }
     public function getNewTajuk(){
        return $this->Title . ' (' . UtilitiesFunc::changeDateFormat($this->StartDate) . ')';
    }

}
