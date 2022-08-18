public function actionIndex3(){
        //get current user ID
        $id = Yii::$app->user->getId();
        
        /*****************************************************************************/
        /**get 'tempoh perkhidmatan di gred semasa' **/
        //get current year
        $currentYear = date('Y');
        
        //find [v_co_icno] from database that match with [$id]-currentUser AND
        //find [tahun] from database that match with [$currentYear]
        $model = Idp::findOne(['v_co_icno' => $id,'tahun' => $currentYear]);
        $mata = Idp::find()->where(['v_co_icno' => $id,'tahun' => $currentYear]);
        
//        //get today's date
//        $currentDate = date('Y-m-d');
//        
//        //get 'tarikh sandangan bagi gred terkini' from database
//        //function date_create() return a new DateTime object - if omitted, the date will be read as a string - DKW
//        $datetime1 = date_create($model->v_co_sand_date);
//        $datetime2 = date_create($currentDate);
//        
//        //date_diff() function calculate the difference two dates
//        $interval = date_diff($datetime1, $datetime2);
//
//        //format the date difference
//        $interval2 =  $interval->format('%y TAHUN %m BULAN %d HARI');
//
//        /*****************************************************************************/
//        /**get 'PEGAWAI PELULUS KURSUS JFPIU' name from his IC no **/
//        
//        $pegawai_icno = $model->pp;
//        $model2 = Idp::findOne(['v_co_icno' => $pegawai_icno]);
//        $nama_pegawai = $model2->v_co_title.' '.$model2->v_co_name;
//        
//        //render data to our view
//        //return $this->render('index', ['model' => $model, 'interval2' => $interval2, 'nama_pegawai' => $nama_pegawai]);
        
//        $dataProvider = new ActiveDataProvider([
//           'query' => $mata,
//           'pagination' => [
//               'pageSize' => 100,
//           ],
//        ]);
        
        return $this->render('index3', [
            'model' => $model,
            //'searchModel' => $searchModel,
            //'dataProvider' => $dataProvider,
        ]);
        
//        return $this->render('index', [
//            'model' => $model,
//        ]);
    }