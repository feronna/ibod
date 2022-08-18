<?php

namespace app\models\portfolio;

use Yii;

/**
 * This is the model class for table "hrm.portfolio_tbl_borang".
 *
 * @property int $id
 * @property string $icno
 * @property int $myjd_id
 * @property string $kod_borang
 * @property string $borang
 * @property string $created_at
 */
class TblBorang extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $files;
    public static function tableName()
    {
        return 'hrm.portfolio_tbl_borang';
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
            [['kod_borang'], 'string', 'max' => 55],
            [['borang','file'], 'string', 'max' => 555],
            [['files'], 'file','extensions'=>'pdf','maxSize'=>6666240, 'tooBig' => 'Limit is 6MB'], 
            [['borang'], 'required','message' => Yii::t('app', 'Wajib Diisi')]  

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
            'kod_borang' => 'Kod Borang',
            'borang' => 'Borang',
            'created_at' => 'Created At',
        ];
    }
}
