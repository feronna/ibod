<?php

namespace app\models\portfolio;

use Yii;

/**
 * This is the model class for table "hrm.portfolio_tbl_jawatankuasa".
 *
 * @property int $id
 * @property string $icno
 * @property int $myjd_id
 * @property string $catatan
 * @property string $created_at
 */
class TblJawatankuasa extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $files;
    public static function tableName()
    {
        return 'hrm.portfolio_tbl_jawatankuasa';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['myjd_id'], 'integer'],
            [['created_at'], 'safe'],
            [['icno'], 'string', 'max' => 15],
            [['catatan','file'], 'string', 'max' => 555],
            [['files'], 'file','extensions'=>'pdf','maxSize'=>6666240, 'tooBig' => 'Limit is 6MB'], 
            [['catatan' ], 'required','message' => Yii::t('app', 'Wajib Diisi')] 

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
            'myjd_id' => 'Myjd ID',
            'catatan' => 'Catatan',
            'created_at' => 'Created At',
        ];
    }
}
