<?php

namespace app\models\elnpt\simulation;

use Yii;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "hrm.elnpt_v3_tbl_pelajar".
 *
 * @property int $id
 * @property int $lpp_id
 * @property string $nomatrik_pljr
 * @property int $tahap_penyeliaan
 * @property int $status_penyeliaan
 * @property int $level_pengajian
 * @property string $filename
 * @property string $filehash
 * @property string $verified_by
 * @property string $verified_dt
 */
class TblPelajarManual extends \yii\db\ActiveRecord
{
    public $file;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.elnpt_v3_tbl_pelajar';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lpp_id', 'tahap_penyeliaan', 'status_penyeliaan', 'level_pengajian', 'file', 'file_name', 'filehash'], 'required'],
            [['lpp_id', 'tahap_penyeliaan', 'status_penyeliaan', 'level_pengajian'], 'integer'],
            [['verified_dt'], 'safe'],
            [['nomatrik_pljr'], 'string', 'max' => 50],
            [['filename'], 'string', 'max' => 3000],
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
            'nomatrik_pljr' => 'Nomatrik Pljr',
            'tahap_penyeliaan' => 'Tahap Penyeliaan',
            'status_penyeliaan' => 'Status Penyeliaan',
            'level_pengajian' => 'Level Pengajian',
            'filename' => 'Filename',
            'filehash' => 'Filehash',
            'verified_by' => 'Verified By',
            'verified_dt' => 'Verified Dt',
        ];
    }
}
