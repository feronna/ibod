<?php

namespace app\models\kontrak;

use Yii;

/**
 * This is the model class for table "kontrak.ref_kriteriakpi".
 *
 * @property int $id
 * @property string $kriteria
 */
class RefKriteriaKpi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.kontrak_ref_kriteriakpi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kriteria'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kriteria' => 'Kriteria',
        ];
    }
}
