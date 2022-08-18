<?php

namespace app\models\ikalendar;

use Yii;

/**
 * This is the model class for table "hronline.hr_users_to_groups".
 *
 * @property string $user_id
 * @property string $group_id
 * @property int $moderate
 * @property int $subscribe
 */
class TblHrUsersGroups extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hronline.hr_users_to_groups';
    }

    /**
     * @inheritdoc$primaryKey
     */
    public static function primaryKey()
    {
        return ["user_id"];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'group_id', 'moderate', 'subscribe'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'group_id' => 'Group ID',
            'moderate' => 'Moderate',
            'subscribe' => 'Subscribe',
        ];
    }

    public function getGroup()
    {
        return $this->hasOne(\app\models\ikalendar\RefHrGroups::className(), ['group_id' => 'group_id']);
    }
}
