<?php

namespace app\models\elnpt;

use Yii;

/**
 * This is the model class for table "hrm.elnpt_tbl_markah".
 *
 * @property int $id
 * @property int $lpp_id
 * @property int $aspek_id
 * @property double $skor
 * @property double $markah_pyd
 * @property double $markah_ppp
 * @property double $markah_ppk
 */
class TblMarkah extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.elnpt_tbl_markah';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lpp_id', 'aspek_id'], 'integer'],
            [['skor', 'markah_pyd', 'markah_ppp', 'markah_ppk'], 'number'],
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
            'aspek_id' => 'Aspek ID',
            'skor' => 'Skor',
            'markah_pyd' => 'Markah Pyd',
            'markah_ppp' => 'Markah Ppp',
            'markah_ppk' => 'Markah Ppk',
        ];
    }
}
