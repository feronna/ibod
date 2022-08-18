<!DOCTYPE html>
<html>
    <?= $this->render('/kontrak/_topmenu') ?>
<?php 
        $jumlah = $count;
        $count=ceil($count/1) * 1;
$width = 100/($count/1);
    ?>
<style>
#myProgress {
  width: 100%;
  background-color: #ddd;
}

#myBar {
  width: 0%;
  height: 30px;
  background-color: #172D44;
  box-shadow: 0 2px 3px rgba(0, 0, 0, 0.25) inset;
  text-align: center;
  color: white;
  justify-content: center;
}
</style>
<body>

<!--    <h1><?=$jumlah?> data diproses. Sila Tunggu.......</h1>-->
<div id="myProgress">
  <div align="center" class="progress progress-striped active text-center" id="myBar">0%</div>
</div>
    <div id="status" align="center">Generating Document.......</div>
<br>

<script>
    var model = JSON.parse('<?php echo json_encode($listid); ?>');
    var progress = <?php echo $width ?>;
    window.onload = function() {
                    codeAddress(0,progress);
                  };
    var elem = document.getElementById("myBar");
    var count = "<?php echo $count ?>";
    function codeAddress(val, width) {
    if(val<count){
    $.ajax({
           timeout: 0,
           url: "laporan?row="+val+"&id="+model[val],
           success: function(data) {
           elem.style.width = width + '%'; 
           elem.textContent = Math.round(width,2) + '%';
           codeAddress(val+1, width+progress); 
    }
      });
  
      }
      else{
      elem.style.width = '100%'; 
      document.getElementById("status").textContent = 'Selesai';
      window.location.href = '/staff/web/uploads-kontrak/data-kontrakakademik.xlsx';
      };
      
//    if (progress >= 100) {
//      clearInterval(id);
//    } else {
//      elem.style.width = progress + '%'; 
//    }
};
</script>
</body>
</html>
