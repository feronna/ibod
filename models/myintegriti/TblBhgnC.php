<?php

namespace app\models\myintegriti;

use Yii;

/**
 * This is the model class for table "utilities.itg_tbl_bahagian_C".
 *
 * @property int $id_penilaian id tbl_penilaian
 * @property string $last_updated_dt
 * @property int $b1
 * @property int $b2
 * @property int $b3
 * @property int $b4
 * @property int $b5
 * @property int $b6
 * @property int $b7
 * @property int $b8
 * @property int $b9
 * @property string $b9_others
 * @property int $b10
 * @property int $b11
 * @property string $komen
 */
class TblBhgnC extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'utilities.itg_tbl_bahagian_C';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_penilaian', 'b1', 'b2', 'b3', 'b4', 'b5', 'b6', 'b7','b10','komen'], 'required'],
            [['id_penilaian', 'b1', 'b2', 'b3', 'b4', 'b5', 'b6', 'b7', 'b8', 'b9', 'b10', 'b11'], 'integer'],
            [['last_updated_dt'], 'safe'],
            [['b9_others', 'komen'], 'string'],
            [['id_penilaian'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_penilaian' => 'Id Penilaian',
            'last_updated_dt' => 'Last Updated Dt',
            'b1' => 'B1',
            'b2' => 'B2',
            'b3' => 'B3',
            'b4' => 'B4',
            'b5' => 'B5',
            'b6' => 'B6',
            'b7' => 'B7',
            'b8' => 'B8',
            'b9' => 'B9',
            'b9_others' => 'B9 Others',
            'b10' => 'B10',
            'b11' => 'B11',
            'komen' => 'This field',
        ];
    }
}
