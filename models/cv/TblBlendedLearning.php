<?php

namespace app\models\cv;

use Yii;

/**
 * This is the model class for table "moodlev3.db_view_hr02_smartv3".
 *
 * @property string $fullname
 * @property string $name
 * @property string $username_AD
 * @property string $email
 * @property int $sysnopsis
 * @property int $files
 * @property int $label
 * @property int $url
 * @property int $folder
 * @property int $IMS_Content
 * @property int $page
 * @property int $book
 * @property int $data
 * @property int $forum
 * @property int $chat
 * @property int $choice
 * @property int $gloss
 * @property int $workshop
 * @property int $lesson
 * @property int $scorm
 * @property int $wiki
 * @property int $survey
 * @property int $feedback
 * @property int $h5p
 * @property int $assgmt
 * @property int $quiz
 * @property int $total
 * @property int $bl_sysnopsis
 * @property int $bl_kandungan
 * @property int $bl_aktiviti
 * @property int $bl_penafsiran
 * @property string $status
 */
class TblBlendedLearning extends \yii\db\ActiveRecord
{
    public static function getDb()
    {
        return Yii::$app->get('db13');
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'moodlev3.db_view_hr02_smartv3';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['total','bl_sysnopsis','bl_kandungan','bl_aktiviti','bl_penafsiran','status','name','username_AD'],'safe'],
            [['fullname'], 'string', 'max' => 254], 
            [['name'], 'string', 'max' => 201],
            [['username_AD', 'email'], 'string', 'max' => 100],
            [['status'], 'string', 'max' => 4],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'fullname' => 'COURSE CODE & NAME',
            'name' => 'NAME',
            'username_AD' => 'Username Ad', 
            'total' => 'Total',
            'bl_sysnopsis' => 'Bl Sysnopsis',
            'bl_kandungan' => 'Bl Kandungan',
            'bl_aktiviti' => 'Bl Aktiviti',
            'bl_penafsiran' => 'Bl Penafsiran',
            'status' => 'STATUS',
        ];
    }
}
