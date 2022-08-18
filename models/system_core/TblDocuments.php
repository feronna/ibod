<?php

namespace app\models\system_core;

use Yii;

/**
 * This is the model class for table "system_core.tbl_documents".
 *
 * @property string $id
 * @property string $filehash
 * @property string $file_name
 * @property string $module
 * @property string $created_by
 * @property string $created_dt
 * @property string $deleted_by
 * @property string $deleted_dt
 */
class TblDocuments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'system_core.tbl_documents';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_dt', 'deleted_dt'], 'safe'],
            [['filehash'], 'string', 'max' => 150],
            [['file_name'], 'string', 'max' => 3000],
            [['module'], 'string', 'max' => 50],
            [['created_by', 'deleted_by'], 'string', 'max' => 12],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'filehash' => 'Filehash',
            'file_name' => 'File Name',
            'module' => 'Module',
            'created_by' => 'Created By',
            'created_dt' => 'Created Dt',
            'deleted_by' => 'Deleted By',
            'deleted_dt' => 'Deleted Dt',
        ];
    }

    public function getCreateUser()
    {
        return $this->hasOne(\app\models\hronline\Tblprcobiodata::className(), ['ICNO' => 'created_by']);
    }
}
