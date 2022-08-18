<?php

namespace app\models\kemudahan;

use Yii;

/**
 * This is the model class for table "facility.ref_tujuan".
 *
 * @property int $id
 * @property string $tujuan
 */
class Reftujuan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'utilities.fac_ref_tujuan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tujuan'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tujuan' => 'Tujuan',
        ];
    }
}
