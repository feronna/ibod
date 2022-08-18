<?php

namespace app\models\kemudahan;

use Yii;

/**
 * This is the model class for table "facility.ref_penumpang".
 *
 * @property int $id
 * @property int $jeniskemudahan
 * @property string $icno
 * @property string $nama
 * @property string $hubungan
 * @property string $ref_icno
 * @property string $entry_date
 * @property int $parent_id
 */
class Refpenumpang extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'utilities.fac_ref_penumpang';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['icno', 'meter_padu'], 'required', 'message' => 'Ruang ini adalah mandatori'],
            [['parent_id'], 'integer'],
            [['entry_date'], 'safe'],
            [['jeniskemudahan'], 'string', 'max' => 5],
            [['icno', 'ref_icno'], 'string', 'max' => 12],
            [['nama', 'hubungan', 'meter_padu'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'jeniskemudahan' => 'Jeniskemudahan',
            'icno' => 'Icno',
            'nama' => 'Nama',
            'hubungan' => 'Hubungan',
            'meter_padu' => 'Meter',
            'ref_icno' => 'Ref Icno',
            'entry_date' => 'Entry Date',
            'parent_id' => 'Parent ID',
        ];
    }
}
