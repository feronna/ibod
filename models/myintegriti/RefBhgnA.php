<?php

namespace app\models\myintegriti;

use Yii;

/**
 * This is the model class for table "ref_penilaian".
 *
 * @property int $id
 * @property string $soalan
 * @property string $code
 */
class RefBhgnA extends \yii\db\ActiveRecord
{
    
    public $depression_scale = [
        ['score' => '0', 'status' => 'NORMAL'],
        ['score' => '5', 'status' => 'RINGAN / MILD'],
        ['score' => '7', 'status' => 'SEDERHANA / MODERATE'],
        ['score' => '11', 'status' => 'TERUK / SEVERE'],
        ['score' => '14', 'status' => 'SANGAT TERUK / EXTREMELY SEVERE'],
    ];
    
    public $anxiety_scale = [
        ['score' => '0', 'status' => 'NORMAL'],
        ['score' => '4', 'status' => 'RINGAN / MILD'],
        ['score' => '6', 'status' => 'SEDERHANA / MODERATE'],
        ['score' => '8', 'status' => 'TERUK / SEVERE'],
        ['score' => '10', 'status' => 'SANGAT TERUK / EXTREMELY SEVERE'],
    ];
    
    public $stress_scale = [
        ['score' => '0', 'status' => 'NORMAL'],
        ['score' => '8', 'status' => 'RINGAN / MILD'],
        ['score' => '10', 'status' => 'SEDERHANA / MODERATE'],
        ['score' => '13', 'status' => 'TERUK / SEVERE'],
        ['score' => '17', 'status' => 'SANGAT TERUK / EXTREMELY SEVERE'],
    ];
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'utilities.itg_ref_bahagian_a';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
//    public static function getDb()
//    {
//        return Yii::$app->get('db2');
//    }

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
