<?php

namespace app\models\cbelajar;

use Yii;

/**
 * This is the model class for table "hrd.cb_rating".
 *
 * @property int $id
 * @property int $idKriteria
 * @property int $idLkk
 * @property string $p_icno
 * @property string $p_komen
 */
class Rating extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrd.cb_rating';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idKriteria', 'idLkk'], 'integer'],
            [['dt_rating'], 'safe'],

            [['p_komen'], 'string'],
            [['p_icno'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'idKriteria' => 'Id Kriteria',
            'idLkk' => 'Id Lkk',
            'p_icno' => 'P Icno',
            'p_komen' => 'P Komen',
        ];
    }
}
