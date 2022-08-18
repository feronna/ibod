<?php

namespace app\models\cbelajar;

use Yii;

/**
 * This is the model class for table "cbelajar.ref_tempahan".
 *
 * @property int $id
 * @property string $jenisTempahan
 * @property string $idTempahan
 */
class RefTempahan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrd.cb_ref_tempahan';
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
