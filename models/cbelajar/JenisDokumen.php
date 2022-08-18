<?php

namespace app\models\cbelajar;

use Yii;

/**
 * This is the model class for table "cbelajar.dokumen".
 *
 * @property int $id
 * @property string $jenisDokumen
 * @property int $DokumenCd
 */
class JenisDokumen extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cbelajar.dokumen';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['jenisDokumen', 'DokumenCd'], 'required'],
            [['DokumenCd'], 'integer'],
            [['jenisDokumen'], 'string', 'max' => 60],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'jenisDokumen' => 'Jenis Dokumen',
            'DokumenCd' => 'Dokumen Cd',
        ];
    }
}
