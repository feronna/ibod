<?php

namespace app\models\cbelajar;

use Yii;

/**
 * This is the model class for table "hrd.cb_ref_elaun_a".
 *
 * @property string $id
 * @property string $nama_elaun
 * @property string $perkara
 * @property string $jenis_kadar
 * @property int $amaun
 * @property string $study
 */
class RefTblElaunA extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrd.cb_ref_elaun_a';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['amaun'], 'integer'],
            [['id'], 'string', 'max' => 5],
            [['nama_elaun'], 'string', 'max' => 255],
            [['perkara'], 'string', 'max' => 50],
            [['jenis_kadar', 'study'], 'string', 'max' => 2],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama_elaun' => 'Nama Elaun',
            'perkara' => 'Perkara',
            'jenis_kadar' => 'Jenis Kadar',
            'amaun' => 'Amaun',
            'study' => 'Study',
        ];
    }
}
