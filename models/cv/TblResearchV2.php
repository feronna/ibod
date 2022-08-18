<?php

namespace app\models\cv;

use Yii;

/**
 * This is the model class for table "{{%hrm.cv_tbl_research}}".
 *
 * @property int $id
 * @property string $ICNO
 * @property string $title
 * @property string $researchers
 * @property int $role_id
 * @property int $level_id
 * @property string $start_date
 * @property string $end_date
 * @property int $agency_id
 * @property string $amount
 * @property int $verified
 * @property int $deleted
 */
class TblResearchV2 extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%hrm.cv_tbl_research}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ICNO','title', 'researchers','start_date', 'end_date','role_id', 'level_id', 'agency_id','status','amount'], 'required'],
            [['role_id', 'level_id', 'agency_id', 'verified', 'deleted'], 'integer'],
            [['start_date', 'end_date','status'], 'safe'],
            [['amount'], 'number'],
            [['ICNO'], 'string', 'max' => 12],
            [['title', 'researchers'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ICNO' => 'Icno',
            'title' => 'Title',
            'researchers' => 'Researchers',
            'role_id' => 'Role',
            'level_id' => 'Level',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'agency_id' => 'Agency Name',
            'amount' => 'Amount',
            'verified' => 'Verified',
            'deleted' => 'Deleted',
            'Status' => 'Status',
        ];
    }
    
    public function getBiodata() {
        return $this->hasOne(\app\models\hronline\Tblprcobiodata::className(), ['ICNO' => 'ICNO']);
    }
    
    public function getPeranan() {
        return $this->hasOne(\app\models\cv\RefRoleResearch::className(), ['id' => 'role_id']);
    }
    
    public function getLevel() {
        return $this->hasOne(\app\models\cv\RefLevel::className(), ['id' => 'level_id']);
    }
    
    public function getAgency() {
        return $this->hasOne(\app\models\cv\RefAgencyName::className(), ['id' => 'agency_id']);
    }
    
    public function getVerification() {
       if($this->verified == 0){
           return '<span class="label label-default">New Record</span>';
       }
       if($this->verified == 1){
           return '<span class="label label-success">Verified</span>';
       }
       if($this->verified == 2){
           return '<span class="label label-info">Review</span>';
       }
       if($this->verified == 99){
           return '<span class="label label-danger">Rejected</span>';
       }
    }
}
