<?php

namespace app\models\penamatanperkhidmatan;

use Yii;

/**
 * This is the model class for table "penamatanperkhidmatan.tbl_kontrak".
 *
 * @property int $id
 * @property string $program
 * @property string $tempoh_kontrak
 * @property string $tarikh_kuatkuasa
 */
class TblKontrak extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.tamat_tbl_kontrak';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tarikh_kuatkuasa'], 'safe'],
            [['program'], 'string', 'max' => 500],
            [['tempoh_kontrak'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'program' => 'Program',
            'tempoh_kontrak' => 'Tempoh Kontrak',
            'tarikh_kuatkuasa' => 'Tarikh Kuatkuasa',
        ];
    }
}
