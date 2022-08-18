<?php

namespace app\models\keselamatan;

use Yii;

/**
 * This is the model class for table "keselamatan.ref_unit".
 *
 * @property int $id
 * @property string $unit_name
 * @property string $added_by
 * @property string $added_dt
 * @property int $active 1-active , 0-inactive
 */
class RefUnit extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'keselamatan.ref_unit';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['added_dt'], 'safe'],
            [['active','c_report_id'], 'integer'],
            [['unit_name'], 'string', 'max' => 150],
            [['added_by','kampus'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'unit_name' => 'Unit Name',
            'added_by' => 'Added By',
            'added_dt' => 'Added Dt',
            'active' => 'Active',
        ];
    }
}
