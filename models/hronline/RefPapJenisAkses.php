<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.ref_pap_jenis_akses".
 *
 * @property int $id
 * @property string $nama_akses
 * @property string $pentadbir person incharge icno
 */
class RefPapJenisAkses extends \yii\db\ActiveRecord
{
    public static function getDb(){
        return Yii::$app->get('db2');
    }

    public static function tableName()
    {
        return 'hronline.ref_pap_jenis_akses';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id'], 'integer'],
            [['nama_akses'], 'string', 'max' => 50],
            [['pentadbir'], 'string', 'max' => 15],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama_akses' => 'Nama Akses',
            'pentadbir' => 'Pentadbir',
        ];
    }

    public function getBiodata() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'pentadbir']);
    }
    public function getAkses() {
        return $this->hasOne(TblPapAkses::className(), ['pap_ja_id' => 'id'])->andWhere(['icno'=>Yii::$app->user->getId()]);
    }
}
