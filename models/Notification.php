<?php

namespace app\models;

use Yii;
use yii\helpers\Html;

/**
 * This is the model class for table "tbl_ntf".
 *
 * @property int $id
 * @property string $icno icno staf
 * @property string $title nama modul
 * @property string $content
 * @property string $ntf_dt
 * @property int $status 0 = unread || 1 = read || 2 = archived
 */
class Notification extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'system_core.tbl_notifications';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
                [['ntf_dt'], 'safe'],
                [['status'], 'integer'],
                [['icno'], 'string', 'max' => 15],
                [['title'], 'string', 'max' => 100],
                [['content'], 'string', 'max' => 1000],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'icno' => 'Icno',
            'title' => 'Title',
            'content' => 'Content',
            'ntf_dt' => 'Ntf Dt',
            'status' => 'Status',
        ];
    }

    public function getFormattedntfdt() {

        return \DateTime::createFromFormat('Y-m-d H:i:s', $this->ntf_dt)->format('d/m/Y h:ia');
    }

    public function getRead() {

        $status = '';

        if ($this->status == 0) {

            $status = Html::a('<i class="fa fa-envelope-o"></i>', ['site/read_noti', 'id' => $this->id]);
        } else if ($this->status == 1) {

            $status = Html::a('<i class="fa fa-envelope-open-o"></i>', ['site/read_noti', 'id' => $this->id]);
        }

        return $status;
    }

    public function getReadArc() {
        $status = Html::a('<i class="fa fa-envelope-open-o"></i>', ['site/read-arc', 'id' => $this->id]);

        return $status;
    }

    
    /**
     * untuk kasi return sampi titik yang pertama.
     * 
     * @return string
     */
    public function getShort() {
        
        $mystring = $this->content;
        $first = strtok($mystring, '.');
        return $first; 
    }
    
    
    /**
     * untuk kasi return sampi titik yang pertama.
     * 
     * @return string
     */
    public function getShortTitle() {
        
        $mystring = $this->title;
        $first = strtok($mystring, ' ');
        return $first; 
    }
    

}
