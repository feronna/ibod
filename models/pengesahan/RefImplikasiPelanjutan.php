<?php

namespace app\models\Pengesahan;

use Yii;

/**
 * This is the model class for table "pengesahan.ref_implikasi_pelanjutan".
 *
 * @property int $id
 * @property string $tempoh
 */
class RefImplikasiPelanjutan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
//        return 'pengesahan.ref_implikasi_pelanjutan';
        return 'hrm.sah_ref_implikasi_pelanjutan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['implikasi'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'implikasi' => 'Implikasi Pelanjutan',
        ];
    }
}
