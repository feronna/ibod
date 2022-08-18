<?php

namespace app\models\ikalendar;

use Yii;

/**
 * This is the model class for table "hronline.hr_categories".
 *
 * @property string $category_id
 * @property string $name
 * @property string $sub_of
 * @property string $sequence
 * @property string $restricted
 * @property string $description
 * @property string $color
 * @property string $background
 * @property string $short_name
 */
class RefHrCategories extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hronline.hr_categories';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sub_of', 'sequence', 'restricted'], 'integer'],
            [['color', 'description', 'sub_of', 'name', 'sequence'], 'required'],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 100],
            [['color'], 'string', 'max' => 30],
            [['background'], 'string', 'max' => 255],
            [['short_name'], 'string', 'max' => 5],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'category_id' => 'Category ID',
            'name' => 'Category Name',
            'sub_of' => 'Parent Category',
            'sequence' => 'Sequence',
            'restricted' => 'Restricted',
            'description' => 'Description',
            'color' => 'Text Color',
            'background' => 'Background',
            'short_name' => 'Short Name',
        ];
    }
}
