<?php

namespace app\models\lppums\v2;

use Yii;

/**
 * This is the model class for table "hrm.lppums_v2_tbl_ketakakuran".
 *
 * @property int $id
 * @property int $icno
 * @property string $content
 * @property string $file_name
 * @property string $filehash
 * @property string $created_dt
 * @property int $created_by
 */
class TblKetakakuranStaff extends \yii\db\ActiveRecord
{
    public $file;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.lppums_v2_tbl_ketakakuran';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['icno', 'content', 'file', 'file_name', 'filehash', 'created_dt', 'created_by'], 'required'],
            [['icno', 'created_by'], 'integer'],
            [['content'], 'string'],
            [['created_dt'], 'safe'],
            [['file_name'], 'string', 'max' => 3000],
            [['filehash'], 'string', 'max' => 150],
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
            'icno' => 'Icno',
            'content' => 'Content',
            'file_name' => 'File Name',
            'filehash' => 'Filehash',
            'created_dt' => 'Created Dt',
            'created_by' => 'Created By',
        ];
    }

    public function getStaff()
    {
        return $this->hasOne(\app\models\hronline\Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }

    public function getUploader()
    {
        return $this->hasOne(\app\models\hronline\Tblprcobiodata::className(), ['ICNO' => 'created_by']);
    }
}
