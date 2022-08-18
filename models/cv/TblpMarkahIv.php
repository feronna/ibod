<?php

namespace app\models\cv;

use Yii;

/**
 * This is the model class for table "cvonline.tbl_markah_iv".
 *
 * @property int $id
 * @property int $gred_id
 * @property int $markah
 * @property string $panel_ICNO
 * @property string $datetime
 * @property int $iv_id
 * @property string $ulasan
 */
class TblpMarkahIv extends \yii\db\ActiveRecord
{
    public static function getDb() {
        return Yii::$app->get('db'); // second database
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.cv_tbl_markah_iv';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['markah','ulasan'], 'required'],
            [['gred_id', 'markah', 'iv_id','subj_id'], 'integer'],
            [['datetime'], 'safe'],
            [['ulasan'], 'string'],
            [['panel_ICNO'], 'string', 'max' => 12],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'gred_id' => 'Gred ID',
            'markah' => 'Markah',
            'panel_ICNO' => 'Panel Icno',
            'datetime' => 'Datetime',
            'iv_id' => 'Iv ID',
            'ulasan' => 'Ulasan',
        ];
    }
    
    public function getStatusMarkah() {
        return $this->hasOne(\app\models\ejobs\StatusMarkah::className(), ['id' => 'markah']);
    }
    
    public function getBiodata() {
        return $this->hasOne(\app\models\hronline\TblprcobiodataSearch::className(), ['ICNO' => 'panel_ICNO']);
    }
    
     public function getSubjek() {
        return $this->hasOne(\app\models\ejobs\TblpSubjek::className(), ['id' => 'subj_id']);
    }
}
