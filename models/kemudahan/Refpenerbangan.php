<?php

namespace app\models\kemudahan;

use Yii;

/**
 * This is the model class for table "facility.ref_penerbangan".
 *
 * @property int $id
 * @property string $jenisKelas
 * @property string $idKelas
 */
class Refpenerbangan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'utilities.fac_ref_penerbangan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['penerbangan'], 'string', 'max' => 255],
            [['flightType'], 'string', 'max' => 20],
            [['isActive'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'jenisKelas' => 'Jenis Kelas',
            'idKelas' => 'Id Kelas',
            'penerbangan' => 'Penerbangan',
            'flightType' => 'Flight Type',  
            
         ];
    }
     public function getFlightTy() {
        if ($this->flightType == '1') {
           return '<span class="label label-success"> PERLEPASAN (DEPART) </span>';
        }
        if ($this->flightType == '2') {
            return '<span class="label label-primary">KETIBAAN (ARRIVAL)</span>';
        }
        
    }
     public function getActive() {
        if ($this->isActive == '1') {
           return '<span class="label label-success"> ACTIVE </span>';
        }
        if ($this->isActive == '0') {
            return '<span class="label label-danger"> INACTIVE </span>';
        }
        
    }
}
