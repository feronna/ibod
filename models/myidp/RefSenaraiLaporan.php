<?php

namespace app\models\myidp;

use Yii;

/**
 * This is the model class for table "hrd.idp_ref_senarai_laporan".
 *
 * @property int $id
 * @property string $rpt_title
 * @property int $rpt_status
 */
class RefSenaraiLaporan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrd.idp_ref_senarai_laporan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rpt_status'], 'integer'],
            [['rpt_title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'rpt_title' => 'Rpt Title',
            'rpt_status' => 'Rpt Status',
        ];
    }
}
