<?php

namespace app\models\portfolio;
use app\models\hronline\Department;
use Yii;

/**
 * This is the model class for table "hrm.portfolio_tbl_peringkat".
 *
 * @property int $id
 * @property int $peringkat
 * @property int $dept_id
 * @property string $updated
 * @property string $updated_by
 */
class TblPeringkat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.portfolio_tbl_peringkat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['peringkat', 'dept_id'], 'integer'],
            [['updated'], 'safe'],
            [['updated_by'], 'string', 'max' => 15],
      //       [['peringkat'], 'required','message' => Yii::t('app', 'Wajib Diisi')]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'peringkat' => 'Peringkat',
            'dept_id' => 'Dept ID',
            'updated' => 'Updated',
            'updated_by' => 'Updated By',
        ];
    }
    
    
        public function getKakitangan() {
        return $this->hasOne(\app\models\hronline\Tblprcobiodata::className(), ['DeptId' => 'dept_id']);
    }
    
          public function getIdPeringkat() {
        return $this->hasOne(TblSenaraiPeringkat::className(), ['id_peringkat' => 'id']);
    }
    
//            public function getRefPeringkat() {
//        return $this->hasOne(RefPeringkat::className(), ['peringkat' => 'id']);
//    }
    
    
}
