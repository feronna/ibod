<?php

namespace app\models\patrol;

use Yii;

/**
 * This is the model class for table "keselamatan.patrol_main_table".
 *
 * @property int $id
 * @property string $icno peronda
 * @property int $route_id refer to ref_route
 * @property string $assign_by
 * @property string $assign_dt
 * @property string $update_by
 * @property string $update_dt
 */
class PatrolMainTable extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'keselamatan.patrol_main_table';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['route_id'], 'integer'],
            [['assign_dt', 'update_dt'], 'safe'],
            [['icno', 'assign_by', 'update_by'], 'string', 'max' => 12],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'icno' => 'Icno',
            'route_id' => 'Route ID',
            'assign_by' => 'Assign By',
            'assign_dt' => 'Assign Dt',
            'update_by' => 'Update By',
            'update_dt' => 'Update Dt',
        ];
    }
}
