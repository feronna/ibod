<?php

namespace app\models\elnpt\elnpt2;

use Yii;

/**
 * This is the model class for table "hrm.elnpt_v2_tbl_smartv3".
 *
 * @property int $id
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
class TblSmartV3 extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.elnpt_v2_tbl_smartv3';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fullname'], 'required'],
            [['sysnopsis', 'files', 'label', 'url', 'folder', 'IMS_Content', 'page', 'book', 'data', 'forum', 'chat', 'choice', 'gloss', 'workshop', 'lesson', 'scorm', 'wiki', 'survey', 'feedback', 'h5p', 'assgmt', 'quiz', 'total', 'bl_sysnopsis', 'bl_kandungan', 'bl_aktiviti', 'bl_penafsiran'], 'integer'],
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
            'id' => 'ID',
            'fullname' => 'Fullname',
            'name' => 'Name',
            'username_AD' => 'Username Ad',
            'email' => 'Email',
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
            'h5p' => 'H5p',
            'assgmt' => 'Assgmt',
            'quiz' => 'Quiz',
            'total' => 'Total',
            'bl_sysnopsis' => 'Bl Sysnopsis',
            'bl_kandungan' => 'Bl Kandungan',
            'bl_aktiviti' => 'Bl Aktiviti',
            'bl_penafsiran' => 'Bl Penafsiran',
            'status' => 'Status',
        ];
    }
}
