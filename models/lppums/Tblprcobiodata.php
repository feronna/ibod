<?php

namespace app\models\lppums;

use Yii;
use app\models\lppums\TblStafAkses;
use app\models\hronline\Tblprcobiodata as BaseBiodata;

class Tblprcobiodata extends BaseBiodata
{
    public static function getDb()
    {
        return Yii::$app->get('db'); // second database
    }

    public function formName()
    {
        return '';
    }

    public function getAdminPosition()
    {
        $subQuery = (new \yii\db\Query())
            ->select(['MAX(appoinment_date)'])
            ->from(['hronline.tblrscoadminpost'])
            ->where(['ICNO' => $this->ICNO]);

        $query = (new \yii\db\Query())
            ->select(['b.position_name'])
            ->from(['a' => 'hronline.tblrscoadminpost'])
            ->leftJoin(['b' => 'hronline.adminposition'], 'a.adminpos_id = b.id')
            ->where(['a.ICNO' => $this->ICNO, 'a.appoinment_date' => $subQuery])
            ->one();

        //        $command = $query->createCommand();
        //        
        //        $admin = $command->execute();

        return $query;
    }

    public function getStaffAkses()
    {
        return $this->hasOne(TblStafAkses::className(), ['ICNO' => 'ICNO'])->from(['StafAkses' => TblStafAkses::tableName()]);
    }
}
