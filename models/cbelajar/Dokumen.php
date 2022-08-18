<?php

namespace app\models\cbelajar;

use Yii;

/**
 * This is the model class for table "cbelajar.tbl_file_pemohon".
 *
 * @property int $id
 * @property string $icno
 * @property string $filename Nama Fail
 * @property int $dokumenCd
 * @property string $jenisDokumen
 */
class Dokumen extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrd.cb_tbl_file_pemohon';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'dokumenCd'], 'required'],
            [['id', 'dokumenCd'], 'integer'],
            [['icno'], 'string', 'max' => 12],
            [['filename'], 'string', 'max' => 150],
            [['jenisDokumen'], 'string', 'max' => 60],
            [['id'], 'unique'],
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
            'filename' => 'Filename',
            'dokumenCd' => 'Dokumen Cd',
            'jenisDokumen' => 'Jenis Dokumen',
        ];
    }
}
