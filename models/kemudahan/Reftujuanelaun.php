<?php

namespace app\models\kemudahan;

use Yii;

/**
 * This is the model class for table "utilities.fac_ref_tujuan_elaun".
 *
 * @property int $id
 * @property string $tujuan
 * @property int $isActive
 */
class Reftujuanelaun extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'utilities.fac_ref_tujuan_elaun';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['isActive'], 'integer'],
            [['tujuan'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tujuan' => 'Tujuan',
            'isActive' => 'Is Active',
        ];
    }
    public function getButiran() {
        if ($this->butiran == '1') {
            return 'Tugas Rasmi';
        } 
       
        if ($this->butiran == '2') {
            return 'Kursus Pendek';
        }

        if ($this->butiran == '3') {
            return 'Kursus Panjang (Cuti Belajar)';
        }
          
    }
}
