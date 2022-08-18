<?php

namespace app\models\cbelajar;

use Yii;

/**
 * This is the model class for table "cbelajar.ref_prestasi".
 *
 * @property int $id
 * @property string $prestasi
 * @property string $jenis_prestasi
 */
class RefPrestasi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrd.cb_ref_prestasi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['prestasi'], 'string'],
            [['jenis_prestasi'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'prestasi' => 'Prestasi',
            'jenis_prestasi' => 'Jenis Prestasi',
        ];
    }
}
