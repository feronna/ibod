<?php

namespace app\models\keselamatan;

use Yii;

/**
 * This is the model class for table "keselamatan.temp_table".
 *
 * @property int $id
 * @property string $no_pekerja
 * @property string $name
 * @property string $pos  for patrol , pos = route_id,
 * @property string $bit for patrol => bit_id
 * @property string $uploader
 * @property string $month
 * @property int $campus_id
 * @property int $type indicate which upload it come from , 1 = patrol
 * @property int $completed indicate if it done uploading to specific table
 */
class TempTable extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'keselamatan.temp_table';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['campus_id', 'type', 'completed'], 'integer'],
            [['no_pekerja', 'uploader'], 'string', 'max' => 12],
            [['name'], 'string', 'max' => 100],
            [['pos'], 'string', 'max' => 18],
            [['bit'], 'string', 'max' => 5],
            [['month'], 'string', 'max' => 2],
            [['lat', 'lng'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'no_pekerja' => 'No Pekerja',
            'name' => 'Name',
            'pos' => 'Pos',
            'bit' => 'Bit',
            'uploader' => 'Uploader',
            'month' => 'Month',
            'campus_id' => 'Campus ID',
            'type' => 'Type',
            'completed' => 'Completed',
        ];
    }

    public function getStatus()
    {
        $val = "";
        if ($this->completed == '3') {
            $val = 'Telah Wujud - Sila Kemaskini di Senarai Bit';
        }
        if ($this->completed == '0') {
            $val = 'Ready to Upload';
        }
        return $val;
    }
}
