<?php

namespace app\models\myidp;

use Yii;

/**
 * This is the model class for table "idpv4.user".
 *
 * @property string $username
 * @property string $password
 * @property string $notes
 * @property string $begin_date
 * @property string $end_date
 * @property string $begin_time
 * @property string $end_time
 * @property string $birthday
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'idpv4.user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['begin_date', 'end_date', 'begin_time', 'end_time', 'birthday'], 'safe'],
            [['username', 'password'], 'string', 'max' => 25],
            [['notes'], 'string', 'max' => 100],
            [['notes'],'required', 'message' => 'Ruangan ini adalah mandatori'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'username' => 'Username',
            'password' => 'Password',
            'notes' => 'Notes',
            'begin_date' => 'Begin Date',
            'end_date' => 'End Date',
            'begin_time' => 'Begin Time',
            'end_time' => 'End Time',
            'birthday' => 'Birthday',
        ];
    }
}
