<?php

namespace app\models\cv;

use Yii;

/**
 * This is the model class for table "hrm.cv_pnl_pnl".
 *
 * @property string $fid
 * @property string $uid
 * @property string $title
 * @property int $type
 * @property string $year
 * @property string $examiner_type
 * @property string $level
 * @property string $student_name
 * @property string $institution
 * @property int $score
 * @property int $final_score
 */
class TblPanel extends \yii\db\ActiveRecord {

    public static function getDb() {
        return Yii::$app->get('db'); // second database
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'hrm.cv_pnl_pnl';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['fid', 'title','type','year'], 'required'],
            [['title', 'student_name', 'institution'], 'string'],
            [['type', 'score', 'final_score','year'], 'integer'],
            [['ICNO', 'uid'], 'safe'],
            [['level'], 'string', 'max' => 30],
            [['ICNO'], 'string', 'max' => 12],
            [['year'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [['uid', 'examiner_type'], 'string', 'max' => 20],
            [['fid'], 'unique'],
             [['examiner_type','level','student_name','institution'], 'required', 'when' => function ($model) {
                return $model->type == 13;
            }, 'enableClientValidation' => false],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'fid' => 'Fid',
            'uid' => 'Uid',
            'title' => 'Title',
            'type' => 'Type',
            'year' => 'Year',
            'examiner_type' => 'Examiner Type',
            'level' => 'Level',
            'student_name' => 'Student Name',
            'institution' => 'Institution',
            'score' => 'Score',
            'final_score' => 'Final Score',
        ];
    }

    public function getName() {
        return $this->hasOne(\app\models\cv\RefPanelType::className(), ['id' => 'type']);
    }
    
    public function getUniversity() {
        return $this->hasOne(\app\models\cv\RefUniversity::className(), ['id' => 'institution']);
    } 

    public function getBiodata() {
        return $this->hasOne(\app\models\hronline\Tblprcobiodata::className(), ['ICNO' => 'ICNO']);
    }
}
