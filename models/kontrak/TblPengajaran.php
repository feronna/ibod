<?php

namespace app\models\kontrak;

use Yii;

/**
 * This is the model class for table "kontrak.tbl_pengajaran".
 *
 * @property int $id
 * @property string $coteaching
 */
class TblPengajaran extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.kontrak_tbl_pengajaran';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['coteaching'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'coteaching' => 'Coteaching',
        ];
    }
}
