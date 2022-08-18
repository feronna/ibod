<?php

namespace app\models\penamatanperkhidmatan;

use Yii;

/**
 * This is the model class for table "penamatanperkhidmatan.tbl_pengesahan".
 *
 * @property int $id
 * @property int $kontrak_id
 * @property int $pengesahan_id
 * @property int $status
 * @property double $baki
 * @property string $ulasan
 * @property int $parent_id
 * @property string $item
 */
class TblPengesahanChild extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.tamat_tbl_pengesahan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kontrak_id', 'pengesahan_id', 'status', 'parent_id'], 'integer'],
            [['baki'], 'number'],
            [['ulasan'], 'string'],
            [['item'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kontrak_id' => 'Kontrak ID',
            'pengesahan_id' => 'Pengesahan ID',
            'status' => 'Status',
            'baki' => 'Baki',
            'ulasan' => 'Ulasan',
            'parent_id' => 'Parent ID',
            'item' => 'Item',
        ];
    }
}
