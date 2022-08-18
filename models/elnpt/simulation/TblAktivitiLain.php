<?php

namespace app\models\elnpt\simulation;

use Yii;

/**
 * This is the model class for table "hrm.elnpt_v3_tbl_aktiviti_lain".
 *
 * @property int $id
 * @property int $lpp_id
 * @property int $kategori
 * @property string $title
 * @property string $jenis
 * @property string $peranan
 * @property string $file_name
 * @property string $filehash
 * @property string $verified_by
 * @property string $verified_dt
 */
class TblAktivitiLain extends \yii\db\ActiveRecord
{
    public $file;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.elnpt_v3_tbl_aktiviti_lain';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'file', 'jenis'], 'required'],
            [['lpp_id', 'kategori'], 'integer'],
            [['verified_dt'], 'safe'],
            [['title'], 'string', 'max' => 300],
            [['jenis', 'peranan'], 'string', 'max' => 50],
            [['file_name'], 'string', 'max' => 3000],
            [['filehash'], 'string', 'max' => 150],
            [['verified_by'], 'string', 'max' => 12],
            [['file'], 'file', 'extensions' => ['pdf', 'jpg', 'png'], 'maxSize' => 1024 * 1024 * 5],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'lpp_id' => 'Lpp ID',
            'kategori' => 'Kategori',
            'title' => 'Aktiviti / Kursus',
            'jenis' => 'Jenis',
            'peranan' => 'Peranan',
            'file_name' => 'File Name',
            'filehash' => 'Filehash',
            'verified_by' => 'Verified By',
            'verified_dt' => 'Verified Dt',
        ];
    }
}
