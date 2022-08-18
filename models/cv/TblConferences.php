<?php

namespace app\models\cv;

use Yii;

/**
 * This is the model class for table "{{%hrm.cv_tbl_conferences}}".
 *
 * @property int $id
 * @property string $ICNO
 * @property string $event_title
 * @property string $paper_title
 * @property int $role_id
 * @property string $start_date
 * @property string $end_date
 * @property int $level_id
 * @property string $venue
 * @property int $verified
 * @property int $deleted
 */
class TblConferences extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%hrm.cv_tbl_conferences}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ICNO','event_title','paper_title','start_date','end_date','role_id','level_id','venue'],'required'],
            [['role_id', 'level_id', 'verified', 'deleted'], 'integer'],
            [['start_date', 'end_date'], 'safe'],
            [['ICNO'], 'string', 'max' => 12],
            [['event_title', 'paper_title', 'venue'], 'string', 'max' => 500],
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
            'event_title' => 'Event Title',
            'paper_title' => 'Article/Working Paper',
            'role_id' => 'Role',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'level_id' => 'Level',
            'venue' => 'Venue',
            'verified' => 'Verified',
            'deleted' => 'Deleted',
        ];
    }
    
    public function getBiodata() {
        return $this->hasOne(\app\models\hronline\Tblprcobiodata::className(), ['ICNO' => 'ICNO']);
    }
     
    public function getRole() {
        return $this->hasOne(\app\models\cv\RefRoleConferences::className(), ['id' => 'role_id']);
    }
    
    public function getLevel() {
        return $this->hasOne(\app\models\cv\RefLevel::className(), ['id' => 'level_id']);
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
