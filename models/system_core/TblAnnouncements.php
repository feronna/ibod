<?php

namespace app\models\system_core;

use Yii;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;
use DateTime;
use Exception;
use yii\helpers\Html;

/**
 * This is the model class for table "system_core.tbl_announcements".
 *
 * @property int $id
 * @property string $tag Maksimum 8 charater
 * @property string $title
 * @property string $content
 * @property string $start_dt
 * @property string $end_dt
 * @property string $create_by icno
 * @property string $create_dt
 * @property string $update_by icno
 * @property string $update_dt
 * @property int $status
 */
class TblAnnouncements extends \yii\db\ActiveRecord {

    public $file;

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'system_core.tbl_announcements';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['content'], 'string'],
            [['start_dt', 'end_dt', 'create_dt', 'update_dt','full_dt'], 'safe'],
            [['status', 'crawler'], 'integer'],
            [['tag'], 'string', 'max' => 8],
            [['title'], 'string', 'max' => 150],
            [['full_dt'], 'string', 'max' => 50],
            [['full_dt','tag', 'title'], 'required'],
            [['file', 'file_name_hashcode'], 'safe'],
            [['file', 'file_name_hashcode'], 'file', 'maxSize' => 1000 * 1024, 'tooBig' => 'File Limit is 1MB only'],
            [['create_by', 'update_by'], 'string', 'max' => 13],
        ];
    }
    
    public $date_range;

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'tag' => 'Tag',
            'title' => 'Title',
            'content' => 'Content',
            'start_dt' => 'Start Date',
            'end_dt' => 'End Date',
            'create_by' => 'Create By',
            'create_dt' => 'Create Dt',
            'update_by' => 'Update By',
            'update_dt' => 'Update Dt',
            'status' => 'Status',
            'tarikh' => 'Start Date',
            'crawlerAlt' => 'Crawler ?',
            'statusAlt' => 'Status ?',
            'full_dt' => 'Duration',
            'detailView' => 'View Content',
            'image' => 'Infografik',
            'file' => 'Infografik',
        ];
    }

    //untuk convert date
    public function behaviors() {
        return [
            'start_dt' => [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['start_dt'], // update 1 attribute 'created' OR multiple attribute ['created','updated']
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['start_dt'], // update 1 attribute 'created' OR multiple attribute ['created','updated']
                ],
                'value' => function ($event) {
                    return date('Y-m-d', strtotime(str_replace("/", "-", $this->start_dt)));
                },
            ],
            'end_dt' => [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['end_dt'], // update 1 attribute 'created' OR multiple attribute ['created','updated']
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['end_dt'], // update 1 attribute 'created' OR multiple attribute ['created','updated']
                ],
                'value' => function ($event) {
                    return date('Y-m-d', strtotime(str_replace("/", "-", $this->end_dt)));
                },
            ],
        ];
    }

    public function afterFind() {
        parent::afterFind();
        $this->start_dt = date('d/m/Y', strtotime(str_replace("-", "/", $this->start_dt)));
        $this->end_dt = date('d/m/Y', strtotime(str_replace("-", "/", $this->end_dt)));
    }
    
    public function getTarikh() {
        return $this->start_dt . ' to ' . $this->end_dt;
    }

    public function getCrawlerAlt() {

        if ($this->crawler == 0) {
            $v = '<span class="label label-danger">Off</span>';
        } else if ($this->crawler == 1) {
            $v = '<span class="label label-success">On</span>';
        }

        return $v;
    }

    public function getStatusAlt() {

        if ($this->status == 0) {
            $v = '<span class="label label-danger">Disabled</span>';
        } else if ($this->status == 1) {
            $v = '<span class="label label-success">Enabled</span>';
        }

        return $v;
    }
    
    public function getDetailView() {
        
        $val = "<i class='fa fa-eye' aria-hidden='true' data-toggle='tooltip' data-placement='top' 
           title='$this->content'></i>";
        
        return $val;
        
    }

    public function getImage() {


        if($this->file_name_hashcode){

            try {
                return Html::img(Yii::$app->FileManager->DisplayFile($this->file_name_hashcode),['class'=>'shrinkToFit', 'width'=>'80%']);
            }
            catch (Exception $e) {
                echo 'Cannot Load Image!' . $e->getMessage();
            }
              
        }

        return false;

    }

}
