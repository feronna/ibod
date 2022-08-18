<?php

namespace app\models\cbelajar;

use Yii;

/**
 * This is the model class for table "cbelajar.ref_penajaan".
 *
 * @property int $id
 * @property string $penajaan
 * @property string $penajaanCd
 */
class RefPenajaan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrd.cb_ref_penajaan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['penajaan'], 'string', 'max' => 255],
            [['penajaanCd'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'penajaan' => 'Penajaan',
            'penajaanCd' => 'Penajaan Cd',
        ];
    }
}
