<?php

namespace app\models\system_core;

use Yii;
//use app\models\system_core\TblMenuSide;
use app\models\system_core\TblMenuTopChild;
use app\models\system_core\RefIcon;

/**
 * This is the model class for table "system_core.tbl_menu_top".
 *
 * @property int $id
 * @property int $order
 * @property string $label
 * @property string $url
 * @property int $icon_id
 * @property string $visible
 * @property int $parent_id
 * @property int $status
 */
class TblMenuTop extends \yii\db\ActiveRecord
{
    public $parent_order;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'system_core.tbl_menu_top';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
//            [['order', 'icon_id', 'parent_id', 'status'], 'integer'],
//            [['label'], 'string', 'max' => 50],
//            [['url', 'visible'], 'string', 'max' => 100],
            [['label', 'icon_id'], 'required'],
            [['order', 'icon_id', 'parent_id', 'status'], 'integer'],
            [['label'], 'string', 'max' => 150],
            [['url'], 'string', 'max' => 255],
            [['visible'], 'string'],
            ['parent_order', 'safe'],
//            ['order', 'in', 'range' => TblMenuTop::find()->select('order')->where(['IS NOT', 'order', null])->andWhere(['parent_id' => null])->asArray()->column(),
//                'not' => true, 'message' => "Order No sudah ada. Sila pilih lagi.", 'on' => 'create'],
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
    
    public function getChild() {
        return $this->hasMany(TblMenuTopChild::className(), ['parent_id' => 'id']);
    }
    
    public function getChild2() {
        return $this->hasMany(TblMenuTopChild::className(), ['parent_id' => 'id'])->andOnCondition(['status' => 1]);
    }
    
    public function getIcon() {
        return $this->hasOne(RefIcon::className(), ['id' => 'icon_id']);
    }
}
