<?php

namespace app\models\ikalendar;

use Yii;

/**
 * This is the model class for table "hronline.hr_groups".
 *
 * @property string $group_id
 * @property string $name
 * @property string $sub_of
 * @property string $sequence
 */
class RefHrGroups extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hronline.hr_groups';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sub_of', 'sequence'], 'integer'],
            [['name'], 'string', 'max' => 40],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'group_id' => 'Group ID',
            'name' => 'Name',
            'sub_of' => 'Sub Of',
            'sequence' => 'Sequence',
        ];
    }
}
