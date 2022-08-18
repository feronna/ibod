<?php

namespace app\models\myintegriti;

use Yii;

/**
 * This is the model class for table "utilities.itg_ref_penilaian".
 *
 * @property int $id
 * @property string $soalan
 * @property string $code
 */
class RefPenilaian extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $depression_scale = [
        ['score' => '0', 'status' => 'NORMAL'],
        ['score' => '5', 'status' => 'RINGAN / MILD'],
        ['score' => '7', 'status' => 'SEDERHANA / MODERATE'],
        ['score' => '11', 'status' => 'TERUK / SEVERE'],
        ['score' => '14', 'status' => 'SANGAT TERUK / EXTREMELY SEVERE'],
    ];

    public static function tableName()
    {
        return 'utilities.itg_ref_penilaian';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['soalan'], 'string', 'max' => 500],
            [['code'], 'string', 'max' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'soalan' => 'Soalan',
            'code' => 'Code',
        ];
    }
}
