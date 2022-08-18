<?php

namespace app\models\patrol;

use Yii;

/**
 * This is the model class for table "keselamatan.patrol_exchangepos".
 *
 * @property int $id
 * @property string $icno
 * @property string $tarikh
 * @property int $pos_asal
 * @property int $pos_baru
 * @property string $do_icno
 * @property string $remark
 */
class PatrolExchangepos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'keselamatan.patrol_exchangepos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tarikh'], 'safe'],
            [['pos_asal', 'pos_baru'], 'integer'],
            [['remark'], 'string'],
            [['icno', 'do_icno'], 'string', 'max' => 12],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'icno' => 'Icno',
            'tarikh' => 'Tarikh',
            'pos_asal' => 'Pos Asal',
            'pos_baru' => 'Pos Baru',
            'do_icno' => 'Do Icno',
            'remark' => 'Remark',
        ];
    }
}
