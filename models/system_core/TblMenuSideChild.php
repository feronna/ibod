<?php

namespace app\models\system_core;

use Yii;

/**
 * This is the model class for table "system_core.tbl_menu_side".
 *
 * @property int $id
 * @property int $order
 * @property string $label
 * @property string $url openpos/index
 * @property int $icon_id
 * @property string $visible
 * @property int $parent_id
 * @property int $status 1 = aktif || 0 = inactive
 */
class TblMenuSideChild extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'system_core.tbl_menu_side';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['label', 'url'], 'required'],
            [['order', 'icon_id', 'parent_id', 'status'], 'integer'],
            [['label'], 'string', 'max' => 50],
            [['url'], 'string', 'max' => 255],
            [['visible'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order' => 'Order',
            'label' => 'Label',
            'url' => 'Url',
            'icon_id' => 'Icon ID',
            'visible' => 'Visible',
            'parent_id' => 'Parent ID',
            'status' => 'Status',
        ];
    }
}
