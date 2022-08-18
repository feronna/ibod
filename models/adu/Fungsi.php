<?php

namespace app\models\adu;

use Yii;

/**
 * This is the model class for table "utilities.adu_ref_fungsi".
 *
 * @property int $id
 * @property string $detail
 */
class Fungsi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'utilities.adu_ref_fungsi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['detail'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'detail' => 'Detail',
        ];
    }

    public function getNumDetail()
    {
        return $this->id . '. ' . $this->detail;
    }
}
