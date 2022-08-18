<?php

namespace app\models\elnpt\simulation;

use Yii;

/**
 * This is the model class for table "hrm.elnpt_tbl_simulasi_dec".
 *
 * @property int $id
 * @property string $lpp_id
 * @property int $kategori_id
 * @property double $mata_1
 * @property double $mata_2
 * @property double $sasaran_1
 * @property double $sasaran_2
 * @property double $mata_hakiki
 * @property double $mata_non_hakiki
 * @property double $limpahan_hakiki
 * @property double $sub_jumlah
 * @property int $isElaun
 * @property double $jumlah_1
 */
class TblSimulasiDec extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.elnpt_tbl_simulasi_dec';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lpp_id', 'kategori_id', 'isElaun'], 'integer'],
            [['mata_1', 'mata_2', 'sasaran_1', 'sasaran_2', 'mata_hakiki', 'mata_non_hakiki', 'limpahan_hakiki', 'sub_jumlah', 'jumlah_1'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'lpp_id' => 'Lpp ID',
            'kategori_id' => 'Kategori ID',
            'mata_1' => 'Mata 1',
            'mata_2' => 'Mata 2',
            'sasaran_1' => 'Sasaran 1',
            'sasaran_2' => 'Sasaran 2',
            'mata_hakiki' => 'Mata Hakiki',
            'mata_non_hakiki' => 'Mata Non Hakiki',
            'limpahan_hakiki' => 'Limpahan Hakiki',
            'sub_jumlah' => 'Sub Jumlah',
            'isElaun' => 'Is Elaun',
            'jumlah_1' => 'Jumlah 1',
        ];
    }
}
