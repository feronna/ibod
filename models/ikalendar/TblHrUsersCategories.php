<?php

namespace app\models\ikalendar;

use Yii;

/**
 * This is the model class for table "hronline.hr_users_to_categories".
 *
 * @property int $user_id
 * @property int $category_id
 * @property int $moderate
 */
class TblHrUsersCategories extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hronline.hr_users_to_categories';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'category_id', 'moderate'], 'integer'],
        ];
    }

    /**
     * @inheritdoc$primaryKey
     */
    public static function primaryKey()
    {
        return ["user_id", "category_id"];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'category_id' => 'Category ID',
            'moderate' => 'Moderate',
        ];
    }
}
