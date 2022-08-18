<?php

namespace app\models\elnpt\simulation;

use Yii;

/**
 * This is the model class for table "hrm.elnpt_v3_tbl_manual".
 *
 * @property int $id
 * @property int $lpp_id
 * @property int $aktiviti_id
 * @property double $bil
 * @property string $file_name
 * @property string $filehash
 * @property string $verified_by
 * @property string $verified_dt
 */
class TblManualKeyIn extends \yii\db\ActiveRecord
{
    public $file;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.elnpt_v3_tbl_manual';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['file', 'file_name', 'filehash', 'lpp_id', 'aktiviti_id', 'bil'], 'required'],
            [['id', 'lpp_id', 'aktiviti_id'], 'integer'],
            [['bil'], 'number'],
            [['verified_dt'], 'safe'],
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
            'aktiviti_id' => 'Aktiviti ID',
            'bil' => 'Purata/ Bilangan/ Jumlah',
            'file_name' => 'File Name',
            'filehash' => 'Filehash',
            'verified_by' => 'Verified By',
            'verified_dt' => 'Verified Dt',
        ];
    }
}
