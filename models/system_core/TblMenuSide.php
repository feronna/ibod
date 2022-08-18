<?php

namespace app\models\system_core;

use Yii;
//use app\models\system_core\TblMenuSide;
use app\models\system_core\TblMenuSideChild;
use app\models\system_core\RefIcon;

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
class TblMenuSide extends \yii\db\ActiveRecord
{
    
    public $parent_order;
    
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
            [['label', 'icon_id'], 'required'],
            [['order', 'icon_id', 'parent_id', 'status'], 'integer'],
            [['label'], 'string', 'max' => 50],
            [['url'], 'string', 'max' => 255],
            [['visible'], 'string'],
            ['parent_order', 'safe'],
            ['order', 'in', 'range' => TblMenuSide::find()->select('order')->where(['IS NOT', 'order', null])->andWhere(['parent_id' => null])->asArray()->column(),
                'not' => true, 'message' => "Order No sudah ada. Sila pilih lagi.", 'on' => 'create'],
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
        return $this->hasMany(TblMenuSideChild::className(), ['parent_id' => 'id']);
    }
    
    public function getChild2() {
        return $this->hasMany(TblMenuSideChild::className(), ['parent_id' => 'id'])->andOnCondition(['status' => 1]);
    }
    
    public function getIcon() {
        return $this->hasOne(RefIcon::className(), ['id' => 'icon_id']);
    }
}
