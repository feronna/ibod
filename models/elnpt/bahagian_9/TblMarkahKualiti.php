<?php

namespace app\models\elnpt\bahagian_9;

use app\models\elnpt\elnpt2\RefAspekPenilaian;
use Yii;

/**
 * This is the model class for table "hrm.elnpt_tbl_mrkh_kualiti".
 *
 * @property int $id
 * @property string $lpp_id
 * @property int $ref_kualiti_id
 * @property double $markah_ppp
 * @property double $markah_ppk
 * @property double $markah_peer
 */
class TblMarkahKualiti extends \yii\db\ActiveRecord
{
    public $ref_id;
    public $aspek;
    public $desc;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.elnpt_tbl_mrkh_kualiti';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lpp_id', 'ref_kualiti_id'], 'integer'],
            //            [['markah_ppp', 'markah_ppk', 'markah_peer'], 'number'],
            [['markah_ppp', 'markah_ppk', 'markah_peer'], 'number', 'min' => 0, 'max' => 100],

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
            'ref_kualiti_id' => 'Ref Kualiti ID',
            'markah_ppp' => 'Markah Ppp',
            'markah_ppk' => 'Markah Ppk',
            'markah_peer' => 'Markah Peer',
        ];
    }

    public function getKualiti()
    {
        return $this->hasOne(RefAspekPenilaian::className(), ['id' => 'ref_kualiti_id']);
    }
}
