<?php

namespace app\models\Klinikpanel;

use Yii;

/**
 * This is the model class for table "klinikpanel2.diagnosis".
 *
 * @property int $id_diagonsis
 * @property string $nama_rawatan
 * @property string $kategori
 */
class RefDiagnosis extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.myhealth_diagnosis';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama_rawatan'], 'required'],
            [['nama_rawatan', 'kategori'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_diagnosis' => 'Id Diagnosis',
            'nama_rawatan' => 'Nama Rawatan',
            'kategori' => 'Kategori',
        ];
    }
}
