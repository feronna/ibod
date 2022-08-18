<?php

namespace app\models\patrol;

use Yii;

/**
 * This is the model class for table "keselamatan.patrol_ref_route".
 *
 * @property int $id
 * @property string $route_name route name (alpha etc)
 * @property string $pic ketua peronda
 */
class RefRoute extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'keselamatan.patrol_ref_route';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['route_name'], 'string'],
            [['isActive','campus'], 'integer'],
            [['pic','added_by'], 'string', 'max' => 12],
            [['pos_kawalan'], 'check', 'on' => ['bit']],

            // [['route_name'], 'check', 'on' => ['rtr']],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'route_name' => 'Route Name',
            'pic' => 'Pic',
        ];
    }

    public static function bit($id){

        $val = self::findOne(['id'=>$id]);

        return $val->route_name;
    }
}
