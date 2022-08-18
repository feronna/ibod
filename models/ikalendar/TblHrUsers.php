<?php

namespace app\models\ikalendar;

use app\models\ikalender\TblHrUsersGroups;
use Yii;

/**
 * This is the model class for table "hronline.hr_users".
 *
 * @property string $user_id
 * @property string $password
 * @property string $temp_password
 * @property string $email
 * @property string $view
 * @property string $post
 * @property string $add_users
 * @property string $add_categories
 * @property string $add_groups
 * @property int $isadmin
 */
class TblHrUsers extends \yii\db\ActiveRecord
{
    public $moderate;
    public $modGroup;
    public $subsGroup;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hronline.hr_users';
    }

    /**
     * @inheritdoc$primaryKey
     */
    public static function primaryKey()
    {
        return ["email"];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['view', 'post', 'add_users', 'add_categories', 'add_groups', 'isadmin'], 'integer'],
            [['email'], 'required'],
            [['password', 'temp_password'], 'string', 'max' => 32],
            [['email'], 'string', 'max' => 80],
            [['moderate', 'modGroup', 'subsGroup'], 'safe'],
            [['view', 'post', 'add_users', 'add_categories', 'add_groups', 'isadmin'], 'default', 'value' => 0],
            ['email', 'unique']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'password' => 'Password',
            'temp_password' => 'Temp Password',
            'email' => 'Staf',
            'view' => 'View',
            'post' => 'Post',
            'add_users' => 'Add Users',
            'add_categories' => 'Add Categories',
            'add_groups' => 'Add Groups',
            'isadmin' => 'Isadmin',
        ];
    }

    public function getStaf()
    {
        return $this->hasOne(\app\models\hronline\Tblprcobiodata::className(), ['ICNO' => 'email']);
    }

    public function getGroupAccess()
    {
        return $this->hasOne(\app\models\ikalendar\TblHrUsersGroups::className(), ['user_id' => 'user_id']);
    }
}
