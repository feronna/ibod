<?php

namespace app\models\cv;

use Yii;

/**
 * This is the model class for table "{{%hrm.cv_tbl_stewardship}}".
 *
 * @property int $id
 * @property string $title
 * @property int $type_id
 * @property int $role_id
 * @property int $level_id
 * @property string $date
 * @property string $conferring_body
 */
class TblStewardship extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%hrm.cv_tbl_stewardship}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ICNO','type_id', 'role_id', 'level_id','date','title','conferring_body'],'required'],
            [['type_id', 'role_id', 'level_id'], 'integer'],
            [['date','verified','deleted','ICNO'], 'safe'],
            [['title'], 'string', 'max' => 500],
            [['conferring_body'], 'string', 'max' => 250],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'type_id' => 'Type',
            'role_id' => 'Individual/Institutional',
            'level_id' => 'Level',
            'date' => 'Date',
            'conferring_body' => 'Conferring Body',
        ];
    }
    
    public function getBiodata() {
        return $this->hasOne(\app\models\hronline\Tblprcobiodata::className(), ['ICNO' => 'ICNO']);
    }
    
    public function getRole() {
        return $this->hasOne(\app\models\cv\RefRoleStewardship::className(), ['id' => 'role_id']);
    }
    
    public function getLevel() {
        return $this->hasOne(\app\models\cv\RefLevel::className(), ['id' => 'level_id']);
    }
    
    public function getType() {
        return $this->hasOne(\app\models\cv\RefTypeStewardship::className(), ['id' => 'type_id']);
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
