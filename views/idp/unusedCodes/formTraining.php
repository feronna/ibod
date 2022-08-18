<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\DetailView;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$timezone = "Asia/Singapore";
if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);
$date = date('Y-m-d');

//$uID = $_SESSION['uID'];

//$con = mysql_connect("localhost","root","");
//if (!$con){
//	die('Could not connect: ' . mysql_error());
//}
//
//mysql_select_db("meritdb", $con);
//
//$sql="SELECT * FROM clubs";
//$result = mysql_query($sql);
////$row = mysql_fetch_array($result);
//
//$sql2 = "SELECT * FROM tahapPenglibatan ORDER BY noPenglibatan";
//$result2 = mysql_query($sql2);
//
//$sql3 = "SELECT * FROM semester";
//$result3 = mysql_query($sql3);
//
//mysql_close($con);
?>
<html>
<head>
<script src="jquery-1.11.3.js"></script> <!-- nama jQuery-->
<script>
var tryAndError2 = $.noConflict(true);
//$(document).ready(function()
tryAndError2(document).ready(function()
{
    var max_fields      = 10; //maximum input boxes allowed
    var wrapper         = tryAndError2(".input_fields_wrap"); //Fields wrapper
    var add_button      = tryAndError2(".add_field_button"); //Add button ID
    
    var x = 1; //initlal text box count
    tryAndError2(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            tryAndError2(wrapper).append('<div><input type="text" name="mytext[]"/><a href="#" class="remove_field">Batal</a></div>'); //add input box
        }
    });
    
    tryAndError2(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); tryAndError2(this).parent('div').remove(); x--;
    })
});



//var tryAndError3 = $.noConflict(true);
//$(document).ready(function()
//tryAndError3(document).ready(function addFields()
//{
function addFields(){
            var number = document.getElementById("member").value;
            var container = document.getElementById("contain");
            while (container.hasChildNodes()) {
                container.removeChild(container.lastChild);
            }
            for (i=0;i<number;i++){
                container.appendChild(document.createTextNode("No matrik pelajar " + (i+1)));
                var input = document.createElement("input");
                input.type = "text";
				input.name = "mytext[]";
                container.appendChild(input);
                container.appendChild(document.createElement("br"));
            }
        }

/**		
var tryAndError3 = $.noConflict(true);
//function checkDuplicate(){
tryAndError3(function(){

tryAndError3('input[name^="mytext"]').change(function() {

    var $current = tryAndError3(this);

    tryAndError3('input[name^="mytext"]').each(function() {
        if (tryAndError3(this).val() == $current.val() && tryAndError3(this).attr('id') != $current.attr('id'))
        {
            alert('duplicate found!');
        }

    });
  });
});

**/
</script>
</head>
<body>
<h1>Borang Laporan Aktiviti Pelajar</h1>
	<div class = "contact">
        <form action="insertActivity.php" method="post">
			<br><br>
			<fieldset>
			<legend>Borang Laporan Aktiviti Pelajar</legend>
			<table border="0" cellpadding="2" cellspacing="2" width="100%">
			<tr><th bgcolor="lightgrey" colspan="2" align="center">MAKLUMAT PENGANJUR</th></tr>
			<tr>
			<td><label>Pertubuhan</label></td>
			<td>
				<select name="clubID">
					<option>--SILA PILIH--</option>
					<option value = "1" >1</option>
                                        
				</select>
			</td>
			</tr>
			<tr><th bgcolor="lightgrey" colspan="2" align="center">MAKLUMAT PROGRAM</th></tr>
			<tr>
			<td><label>Kod Program</label></td>
			<td><input size="80%" type="text" name="kodProgram"></td>
			</tr>
			<tr>
			<td><label>Nama Program</label></td>
			<td><input size="80%" type="text" name="namaProgram"></td>
			</tr>
			<tr>
			<td><label>Tempat</label></td>
			<td><input size="80%" type="text" name="lokasi"></td>
			</tr>
			<tr>
			<td><label>Tarikh</label></td>
			<td><input type="date" name="tarikh"></td>
			</tr>
			<tr>
			<td><label>Sesi</label></td>
			<td><select name="pilihSesi">
					<option>--SILA PILIH--</option>
					<option value = "1" >1</option>
				</select></td>
			</tr>
			<tr>
			<td><label>Peringkat</label></td>
			<td><select name="pilihPeringkat">
					<option>--SILA PILIH--</option>
					<option value = "1" >1</option>
				</select></td>
			</tr>
			<tr><th bgcolor="lightgrey" colspan="2" align="center">MAKLUMAT PESERTA</th></tr>
			<!--<tr>
			<td><label>Sila isi no matrik pelajar di sini :<label></td>
			<td><div class="input_fields_wrap">
			<button class="add_field_button">Tambah Pelajar</button>
				<div><input type="text" name="mytext[]"></div>
			</div></td>
			</tr>-->
			<tr>
			<td><label>Masukkan jumlah peserta di sini :</label></td>
			<td><input type="text" id="member" name="member" value=""><br/>
				<a href="#" id="filldetails" onclick="addFields()">TEKAN DI SINI</a>
				<div id="contain"/>
			</td>
			</tr>
			</table>
			</fieldset>
			<input type="submit" class="submitButton" value="Kemaskini">
			<input type="reset" class="resetButton" value="Batal" align="left">
	</form>
</div>
</body>
</html>


