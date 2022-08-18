<!DOCTYPE html>
<html>
    <?= $this->render('/kontrak/_topmenu') ?>
<?php 
        $jumlah = $count;
        $count=ceil($count/5) * 5;
$width = 100/($count/5);
    ?>
<style>
#myProgress {
  width: 100%;
  background-color: #ddd;
}

#myBar {
  width: <?=$width?>%;
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
  <div align="center" class="progress progress-striped active text-center" id="myBar"><?=round($width, 2)?>%</div>
</div>
    <div id="status" align="center">Sila Tunggu.......</div>
<br>

<script>
    var progress = <?php echo $width ?>;
    window.onload = function() {
                    codeAddress(1,progress);
                  };
    var elem = document.getElementById("myBar");
    var count = "<?= $count ?>";
    var sesi = "<?= $sesi ?>";
    var tahun = "<?= $tahun ?>";
    var tahunlnpt = "<?= $tahunlnpt?>";
    function codeAddress(val, width) {
    if(val<=count){
    $.ajax({
           timeout: 0,
           url: "laporan?sesi="+sesi+"&tahun="+tahun+"&no1="+val+'&tahunlnpt='+tahunlnpt,
           success: function(data) {
           elem.style.width = width + '%'; 
           elem.textContent = Math.round(width,2) + '%';
           codeAddress(val+5, width+progress); 
    }
      });
  
      }
      else{
      elem.style.width = '100%'; 
      document.getElementById("status").textContent = 'Selesai';
      window.location.href = '/staff/web/uploads-kontrak/data-kontrakpentadbiran.xlsx';
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
