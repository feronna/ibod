<?php

namespace app\models\kontrak;

use Yii;

/**
 * This is the model class for table "hrm.kontrak_tbl_attachment".
 *
 * @property int $id
 * @property int $kontrak_id
 * @property string $type
 * @property string $url
 */
class TblAttachment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.kontrak_tbl_attachment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kontrak_id'], 'integer'],
            [['type'], 'string', 'max' => 100],
            [['url'], 'string', 'max' => 500],
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
            'type' => 'Type',
            'url' => 'Url',
        ];
    }
}
