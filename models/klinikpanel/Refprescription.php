<?php

namespace app\models\klinikpanel;


/**
 * This is the model class for table "hrm.myhealth_ref_prescription".
 *
 * @property string $id
 * @property string $name
 * @property int $type_id
 * @property string $unit
 * @property string $price
 * @property int $isActive 1=Active , 2= Inactive
 * @property string $priceUms
 */
class Refprescription extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.myhealth_ref_prescription';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['type_id', 'isActive'], 'integer'],
            [['price', 'priceUms'], 'number'],
            [['id'], 'string', 'max' => 11],
            [['name'], 'string', 'max' => 255],
            [['unit'], 'string', 'max' => 50],
            [['id'], 'unique'],
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
            'type_id' => 'Type ID',
            'unit' => 'Unit',
            'price' => 'Price',
            'isActive' => 'Is Active',
            'priceUms' => 'Price Ums',
        ];
    }
    
}
