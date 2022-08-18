<?php

namespace app\models\kontrak;

use Yii;
use app\models\kontrak\RefUlasanTnca;

/**
 * This is the model class for table "kontrak.tbl_ulasantnca".
 *
 * @property int $id
 * @property int $kontrak_id
 * @property int $ulasantnca_id
 * @property string $status
 */
class TblUlasanTnca extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.kontrak_tbl_ulasantnca';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kontrak_id', 'ulasantnca_id'], 'integer'],
            [['status'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kontrak_id' => 'Kontrak ID',
            'ulasantnca_id' => 'Ulasantnca ID',
            'status' => 'Status',
        ];
    }
    
    public function getPerkara() {
        return $this->hasOne(RefUlasanTnca::className(), ['id' => 'ulasantnca_id']);
    }
}
