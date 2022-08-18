<?php

namespace app\models\Kadpekerja;

use Yii;

/**
 * This is the model class for table "facility_keselamatan.Utils_ref_jenis_kad".
 *
 * @property int $id
 * @property string $card_type jenis permohonan kad
 * @property int $isActive
 */
class Refjeniskad extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'keselamatan.Utils_ref_jenis_kad';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['isActive'], 'integer'],
            [['card_type'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'card_type' => 'Card Type',
            'isActive' => 'Is Active',
        ];
    }
     public function getKadPekerja() {
        return $this->hasOne(Refjeniskad::className(), ['id' => 'card_type']);
    } 
}
