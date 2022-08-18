<?php

namespace app\models\kemudahan;

use Yii;

/**
 * This is the model class for table "facility.ref_tempahan".
 *
 * @property int $id
 * @property string $jenisTempahan
 * @property string $idTempahan
 */
class Reftempahan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'utilities.fac_ref_tempahan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['jenisTempahan'], 'string', 'max' => 255],
            [['idTempahan'], 'string', 'max' => 2],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'jenisTempahan' => 'Jenis Tempahan',
            'idTempahan' => 'Id Tempahan',
        ];
    }
}
