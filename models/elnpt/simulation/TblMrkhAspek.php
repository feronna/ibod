<?php

namespace app\models\elnpt\simulation;

use Yii;

/**
 * This is the model class for table "hrm.elnpt_v3_tbl_mrkh_aspek".
 *
 * @property int $id
 * @property int $lpp_id
 * @property int $bhg_no
 * @property int $aspek_id
 * @property double $skor
 * @property double $markah_pyd
 * @property double $markah_ppp
 * @property double $markah_ppk
 * @property double $markah_peer
 */
class TblMrkhAspek extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.elnpt_v3_tbl_mrkh_aspek';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lpp_id', 'bhg_no', 'aspek_id'], 'integer'],
            [['skor', 'markah_pyd', 'markah_ppp', 'markah_ppk', 'markah_peer'], 'number'],
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
            'bhg_no' => 'Bhg No',
            'aspek_id' => 'Aspek ID',
            'skor' => 'Skor',
            'markah_pyd' => 'Markah Pyd',
            'markah_ppp' => 'Markah Ppp',
            'markah_ppk' => 'Markah Ppk',
            'markah_peer' => 'Markah Peer',
        ];
    }
}
