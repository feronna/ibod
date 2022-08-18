<?php

namespace app\models\cv;

use Yii;

/**
 * This is the model class for table "hrm.cv_ref_rank_up".
 *
 * @property int $id
 * @property int $gred_id_semasa
 * @property string $gred_semasa
 * @property string $nama_semasa
 * @property int $gred_id_rank_up
 * @property string $gred_rank_up
 * @property string $nama_rank_up
 */
class RefRankUp extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.cv_ref_rank_up';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gred_id_semasa', 'gred_id_rank_up'], 'integer'],
            [['gred_semasa', 'gred_rank_up'], 'string', 'max' => 10],
            [['nama_semasa', 'nama_rank_up'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'gred_id_semasa' => 'Gred Id Semasa',
            'gred_semasa' => 'Gred Semasa',
            'nama_semasa' => 'Nama Semasa',
            'gred_id_rank_up' => 'Gred Id Rank Up',
            'gred_rank_up' => 'Gred Rank Up',
            'nama_rank_up' => 'Nama Rank Up',
        ];
    }
}
