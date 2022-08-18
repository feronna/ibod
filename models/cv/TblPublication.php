<?php

namespace app\models\cv;

use Yii;

/**
 * This is the model class for table "{{%hrm.cv_tbl_publication}}".
 *
 * @property int $id
 * @property string $ICNO
 * @property int $role_id
 * @property string $full_author
 * @property int $year
 * @property string $title
 * @property int $type_id
 * @property string $indexing
 * @property string $volume
 * @property string $issue
 * @property string $page_no
 * @property string $publisher
 * @property int $verified
 * @property int $deleted
 */
class TblPublication extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%hrm.cv_tbl_publication}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ICNO','role_id','full_author','title','type_id','year','indexing','volume','issue','page_no','publisher'],'required'],
            [['role_id', 'year', 'type_id', 'verified', 'deleted'], 'integer'],
            [['ICNO'], 'string', 'max' => 12],
            [['full_author', 'publisher'], 'string', 'max' => 255],
            [['title'], 'string', 'max' => 500],
            [['indexing', 'volume', 'issue', 'page_no'], 'string', 'max' => 50],
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
            'role_id' => 'Role',
            'full_author' => 'Full Author Name',
            'year' => 'Year',
            'title' => 'Title',
            'type_id' => 'Type',
            'indexing' => 'Indexing',
            'volume' => 'Volume',
            'issue' => 'Issue',
            'page_no' => 'Page No',
            'publisher' => 'Publisher',
            'verified' => 'Verified',
            'deleted' => 'Deleted',
        ];
    }
    
    public function getRole() {
        return $this->hasOne(\app\models\cv\RefRolePublication::className(), ['id' => 'role_id']);
    }
    
    public function getType() {
        return $this->hasOne(\app\models\cv\RefPublicationSort::className(), ['id' => 'type_id']);
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
