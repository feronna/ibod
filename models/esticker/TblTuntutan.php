<?php

namespace app\models\esticker;

use Yii;

/**
 * This is the model class for table "{{%keselamatan.stc_tbl_tuntutan}}".
 *
 * @property int $id
 * @property string $ICNO
 * @property int $pay_status
 * @property int $pay_type
 * @property string $updater
 * @property string $updater_at
 * @property string $remark
 */
class TblTuntutan extends \yii\db\ActiveRecord
{
    public $total;
    public static function getDb() {
        return Yii::$app->get('db'); // second database
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%keselamatan.stc_tbl_tuntutan}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['remark'],'required'],
            [['pay_status', 'pay_type'], 'integer'],
            [['updater_at','total'], 'safe'],
            [['ICNO', 'updater'], 'string', 'max' => 12],
            [['remark'], 'string', 'max' => 250],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ICNO' => 'Icno',
            'pay_status' => 'Pay Status',
            'pay_type' => 'Pay Type',
            'updater' => 'Updater',
            'updater_at' => 'Updater At',
            'remark' => 'Remark',
        ];
    }
    
    public function getBiodata() {
        return $this->hasOne(\app\models\hronline\tblprcobiodata::className(), ['ICNO' => 'ICNO']);
    }
}
