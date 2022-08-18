<?php

namespace app\models\patrol;

use Yii;

/**
 * This is the model class for table "keselamatan.patrol_bit_pictures".
 *
 * @property int $id
 * @property string $file_hashcode
 * @property string $route_id
 * @property string $uploaded_by
 * @property string $datetime
 * @property int $bit_id
 */
class BitPictures extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'keselamatan.patrol_bit_pictures';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['datetime'], 'safe'],
            [['bit_id'], 'integer'],
            [['file_hashcode'], 'string', 'max' => 100],
            [['route_id'], 'string', 'max' => 3],
            [['type'], 'string', 'max' =>10 ],
            [['uploaded_by'], 'string', 'max' => 12],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'file_hashcode' => 'File Hashcode',
            'route_id' => 'Route ID',
            'uploaded_by' => 'Uploaded By',
            'datetime' => 'Datetime',
            'bit_id' => 'Bit ID',
        ];
    }
}
