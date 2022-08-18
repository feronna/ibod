<?php

namespace app\models\memorandum;

use Yii;
use app\models\hronline\Tblprcobiodata;
use app\models\memorandum\RefRole;

/**
 * This is the model class for table "utilities.memo_tbl_akses".
 *
 * @property int $id
 * @property string $icno
 * @property int $role
 */
class TblAkses extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'utilities.memo_tbl_akses';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['role'], 'integer'],
            [['icno'], 'string', 'max' => 15],
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
            'role' => 'Role',
        ];
    }
    
       public function getKakitangan() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
    
     public function getJenisAkses() {
        return $this->hasOne(RefRole::className(), ['id' => 'role']);
    }
}
