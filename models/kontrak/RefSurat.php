<?php

namespace app\models\kontrak;

use Yii;

/**
 * This is the model class for table "kontrak.ref_surat".
 *
 * @property int $id
 * @property string $title
 * @property string $dokumen
 * @property int $job_category
 * @property int $warga
 * @property string $source
 */
class RefSurat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.kontrak_ref_surat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['job_category', 'warga'], 'integer'],
            [['title', 'dokumen', 'source'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'dokumen' => 'Dokumen',
            'job_category' => 'Job Category',
            'warga' => 'Warga',
            'source' => 'Source',
        ];
    }
}
