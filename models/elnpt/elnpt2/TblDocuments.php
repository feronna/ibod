<?php

namespace app\models\elnpt\elnpt2;

use Yii;

/**
 * This is the model class for table "hrm.elnpt_v2_tbl_document".
 *
 * @property int $id
 * @property int $lpp_id
 * @property int $bhg_no
 * @property int $id_table
 * @property string $filehash
 * @property string $file_name
 * @property string $created_dt
 * @property string $verified_by
 * @property string $verified_dt
 * @property string $ulasan
 */
class TblDocuments extends \yii\db\ActiveRecord
{
    public $file;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.elnpt_v2_tbl_document';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['file', 'file_name', 'filehash', 'created_dt', 'lpp_id', 'bhg_no', 'id_table'], 'required'],
            [['lpp_id', 'bhg_no', 'id_table'], 'integer'],
            [['created_dt', 'verified_dt'], 'safe'],
            [['filehash'], 'string', 'max' => 150],
            [['file_name'], 'string', 'max' => 3000],
            [['file'], 'file', 'extensions' => ['pdf', 'jpg', 'png'], 'maxSize' => 1024 * 1024 * 5],
            [['verified_by'], 'string', 'max' => 12],
            [['ulasan'], 'string', 'max' => 500],
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
            'bhg_no' => 'Bhg No',
            'id_table' => 'Id Table',
            'filehash' => 'Filehash',
            'file_name' => 'File Name',
            'created_dt' => 'Created Dt',
            'verified_by' => 'Verified By',
            'verified_dt' => 'Verified Dt',
            'ulasan' => 'Ulasan',
        ];
    }
}
