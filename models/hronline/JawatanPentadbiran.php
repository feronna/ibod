<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.jawatanpentadbiran".
 *
 * @property int $id
 * @property string $name
 * @property string $otherCd
 */
class JawatanPentadbiran extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hronline.jawatanpentadbiran';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 255],
            [['otherCd'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'otherCd' => 'Other Cd',
        ];
    }
}
