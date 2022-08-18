<?php

namespace app\models\penamatanperkhidmatan;

use Yii;

/**
 * This is the model class for table "penamatanperkhidmatan.ref_soalanexitinterview".
 *
 * @property int $id
 * @property string $soalan_bm
 * @property string $soalan_bi
 * @property int $status
 */
class RefSoalanexitinterview extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.tamat_ref_soalanexitinterview';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['soalan_bm', 'soalan_bi'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'soalan_bm' => 'Soalan Bm',
            'soalan_bi' => 'Soalan Bi',
            'status' => 'Status',
        ];
    }
}
