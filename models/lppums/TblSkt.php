<?php

namespace app\models\lppums;

use Yii;

/**
 * This is the model class for table "hrm.lppums_tbl_skt".
 *
 * @property string $skt_id
 * @property string $skt_projek
 * @property string $skt_petunjuk
 * @property string $skt_kuantiti
 * @property string $skt_kualiti
 * @property string $skt_masa
 * @property string $skt_kos
 * @property string $skt_sasar
 * @property string $skt_capai
 * @property string $skt_ulasan
 * @property string $lpp_id
 * @property string $skt_status NULL, TAMB
 * @property string $skt_status_gugur GUGUR
 */
class TblSkt extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.lppums_skt';
    }
    
    public static function getDb()
    {
        return Yii::$app->get('db');
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
//    public static function getDb()
//    {
//        return Yii::$app->get('db');
//    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lpp_id'], 'integer'],
            [['skt_projek'], 'string', 'max' => 180],
            [['skt_petunjuk'], 'string', 'max' => 50],
            [['skt_kuantiti', 'skt_kualiti', 'skt_masa', 'skt_kos', 'skt_sasar', 'skt_capai'], 'string', 'max' => 150],
            [['skt_projek', 'skt_kuantiti', 'skt_kualiti', 'skt_masa', 'skt_kos', 'skt_sasar', 'skt_capai', 'skt_ulasan'], 'default', 'value' => null],
            [['skt_ulasan'], 'string', 'max' => 250],
            [['skt_status', 'skt_status_gugur'], 'string', 'max' => 5],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'skt_id' => 'Skt ID',
            'skt_projek' => 'Skt Projek',
            'skt_petunjuk' => 'Skt Petunjuk',
            'skt_kuantiti' => 'Skt Kuantiti',
            'skt_kualiti' => 'Skt Kualiti',
            'skt_masa' => 'Skt Masa',
            'skt_kos' => 'Skt Kos',
            'skt_sasar' => 'Skt Sasar',
            'skt_capai' => 'Skt Capai',
            'skt_ulasan' => 'Skt Ulasan',
            'lpp_id' => 'Lpp ID',
            'skt_status' => 'Skt Status',
            'skt_status_gugur' => 'Skt Status Gugur',
        ];
    }
}
