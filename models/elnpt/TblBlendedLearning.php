<?php

namespace app\models\elnpt;

use Yii;

/**
 * This is the model class for table "db_view_hr01".
 *
 * @property string $lastname
 * @property string $username_ic_pasportNo
 * @property string $email
 * @property string $fullname
 * @property string $Fakulti
 * @property string $sysnopsis
 * @property string $files
 * @property string $label
 * @property string $url
 * @property string $folder
 * @property string $IMS_Content
 * @property string $page
 * @property string $book
 * @property string $data
 * @property string $forum
 * @property string $chat
 * @property string $choice
 * @property string $gloss
 * @property string $workshop
 * @property string $lesson
 * @property string $scorm
 * @property string $wiki
 * @property string $survey
 * @property string $feedback
 * @property string $assgmt
 * @property string $quiz
 * @property string $hotpot
 * @property string $total
 * @property string $bl_sysnopsis
 * @property string $bl_kandungan
 * @property string $bl_aktiviti
 * @property string $bl_penafsiran
 * @property string $status
 */
class TblBlendedLearning extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'db_view_hr01';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db11');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sysnopsis', 'files', 'label', 'url', 'folder', 'IMS_Content', 'page', 'book', 'data', 'forum', 'chat', 'choice', 'gloss', 'workshop', 'lesson', 'scorm', 'wiki', 'survey', 'feedback', 'assgmt', 'quiz', 'hotpot', 'total', 'bl_sysnopsis', 'bl_kandungan', 'bl_aktiviti', 'bl_penafsiran'], 'integer'],
            [['lastname', 'username_ic_pasportNo', 'email'], 'string', 'max' => 100],
            [['fullname'], 'string', 'max' => 254],
            [['Fakulti'], 'string', 'max' => 255],
            [['status'], 'string', 'max' => 4],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'lastname' => 'Lastname',
            'username_ic_pasportNo' => 'Username Ic Pasport No',
            'email' => 'Email',
            'fullname' => 'Fullname',
            'Fakulti' => 'Fakulti',
            'sysnopsis' => 'Sysnopsis',
            'files' => 'Files',
            'label' => 'Label',
            'url' => 'Url',
            'folder' => 'Folder',
            'IMS_Content' => 'Ims Content',
            'page' => 'Page',
            'book' => 'Book',
            'data' => 'Data',
            'forum' => 'Forum',
            'chat' => 'Chat',
            'choice' => 'Choice',
            'gloss' => 'Gloss',
            'workshop' => 'Workshop',
            'lesson' => 'Lesson',
            'scorm' => 'Scorm',
            'wiki' => 'Wiki',
            'survey' => 'Survey',
            'feedback' => 'Feedback',
            'assgmt' => 'Assgmt',
            'quiz' => 'Quiz',
            'hotpot' => 'Hotpot',
            'total' => 'Total',
            'bl_sysnopsis' => 'Bl Sysnopsis',
            'bl_kandungan' => 'Bl Kandungan',
            'bl_aktiviti' => 'Bl Aktiviti',
            'bl_penafsiran' => 'Bl Penafsiran',
            'status' => 'Status',
        ];
    }
}
