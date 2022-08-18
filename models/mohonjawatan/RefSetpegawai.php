<?php

namespace app\models\mohonjawatan;

use Yii;

/**
 * This is the model class for table "mohonjawatan.ref_setpegawai".
 *
 * @property int $id
 * @property string $pemohon_icno
 * @property string $peraku_icno
 * @property string $pelulus_icno
 */
class RefSetpegawai extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.mj_ref_setpegawai';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pemohon_icno', 'peraku_icno', 'pelulus_icno'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pemohon_icno' => 'Pemohon Icno',
            'peraku_icno' => 'Peraku Icno',
            'pelulus_icno' => 'Pelulus Icno',
        ];
    }
        public function getPeraku() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'peraku_icno']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPemohon() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'pemohon_icno']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPelulus() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'pelulus_icno']);
    }
}
