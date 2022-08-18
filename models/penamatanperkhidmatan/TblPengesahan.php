<?php

namespace app\models\penamatanperkhidmatan;

use Yii;

/**
 * This is the model class for table "penamatanperkhidmatan.tbl_pengesahan".
 *
 * @property int $id
 * @property int $permohonan_id
 * @property int $dept_id
 * @property string $perkara
 * @property double $baki
 */
class TblPengesahan extends \yii\db\ActiveRecord
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
            [['permohonan_id', 'dept_id'], 'integer'],
            [['baki'], 'number'],
            [['perkara'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'permohonan_id' => 'Permohonan ID',
            'dept_id' => 'Dept ID',
            'perkara' => 'Perkara',
            'baki' => 'Baki',
        ];
    }
    public function getChild(){
        return $this->hasMany(TblPengesahanChild::className(), ['parent_id' => 'id']);
    }
}
