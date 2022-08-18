<?php

namespace app\models\hronline;


class Tables  {

    public static function tableName() {
        return null;
    }
    
    

    public function getTablename($tblnm){
        $table_lists = ['Tblrscosandangan'=>'Status Sandangan','Tblrscoapmtstatus'=>'Status Lantikan','Tblrscoservstatus'=>'Status Perkhidmatan', 'Tblpendidikan'=>'Pendidikan',
        'TblPenempatan'=>'Penempatan','Tblrscoaptathy'=>'Pihak Berkuasa Melantik','Tblrscoservload'=>'Beban Perkhidmatan','Tblrscoconfirmstatus'=>'Status Pengesahan','Tblrscoprobtnperiod'=>'Tempoh Percubaan','Tblrscopsnstatus'=>'Status Pencen',
        'Tblrscopsnathy'=>'Pihak Berkuasa Pencen','Tblrscosaltype'=>'Jenis Gaji','Tblrscoservtype'=>'Jenis Perkhidmatan','Tblrscosalmovemth'=>'Pergerakan Gaji','Tblrscofileno'=>'Fail Perkhidmatan']; //,'Umsper'=>'Umsper'
        if(array_key_exists($tblnm, $table_lists)){
            return $table_lists[$tblnm];
        }
        return null;
    }

    public function getLink($tblnm){
        $table_lists = ['Tblrscosandangan'=>'status-sandangan','Tblrscoapmtstatus'=>'status-lantikan','Tblrscoservstatus'=>'status-perkhidmatan', 'Tblpendidikan'=>'pendidikan',
        'TblPenempatan'=>'penempatan','Tblrscoaptathy'=>'pihak-berkuasa-melantik','Tblrscoservload'=>'beban-perkhidmatan','Tblrscoconfirmstatus'=>'status-pengesahan','Tblrscoprobtnperiod'=>'tempoh-percubaan','Tblrscopsnstatus'=>'status-pencen',
        'Tblrscopsnathy'=>'pihak-berkuasa-pencen','Tblrscosaltype'=>'jenis-gaji','Tblrscoservtype'=>'jenis-perkhidmatan','Tblrscosalmovemth'=>'pergerakan-gaji','Tblrscofileno'=>'fail-perkhidmatan'];
        if(array_key_exists($tblnm, $table_lists)){
            return $table_lists[$tblnm];
        }
        return null;
    }


  

}
  
