
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />



	<!-- blueprint CSS framework 
	-->
	<link rel="stylesheet" type="text/css" href="/idp/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="/idp/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="/idp/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="/idp/css/main.css" />
	<link rel="stylesheet" type="text/css" href="/idp/css/form.css" />
<!--
	-->
	<!-- bs-custom.css = customized css for my bootstrap design - added by EBS -->
	<link rel="stylesheet" type="text/css" href="/idp/css/bs-custom.css" media="screen, projection" />

	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" type="text/css" href="/idp/assets/c1a1281a/css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="/idp/assets/c1a1281a/css/bootstrap-responsive.min.css" />
<link rel="stylesheet" type="text/css" href="/idp/assets/c1a1281a/css/bootstrap-yii.css" />
<link rel="stylesheet" type="text/css" href="/idp/assets/c1a1281a/css/jquery-ui-bootstrap.css" />
<script type="text/javascript" src="/idp/assets/3c563235/jquery.min.js"></script>
<script type="text/javascript" src="/idp/assets/3c563235/jquery.yiiactiveform.js"></script>
<script type="text/javascript" src="/idp/assets/c1a1281a/js/bootstrap.bootbox.min.js"></script>
<script type="text/javascript" src="/idp/assets/c1a1281a/js/bootstrap.min.js"></script>
<title>MyIDP - Individual Development Plan - Mohon Kursusluar</title>
	<link href="/idp/images/ums_logo.ico" rel="shortcut icon" type="image/x-icon" />
</head>

<body>

<div class="container" id="page">
<!--
	<div id="header">
		<div id="logo"></div>
	</div>
-->
<div style="padding:1em">
    <div class="navbar"><div class="navbar-inner"><div class="container"><a href="/idp/index.php" class="brand">UTAMA</a><ul id="yw0" class="nav"><li class="dropdown-submenu dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">STAF <span class="caret"></span></a><ul id="yw1" class="dropdown-menu"><li><a tabindex="-1" href="/idp/index.php?r=site/idp">PERMOHONAN KURSUS ANJURAN DALAMAN</a></li><li><a tabindex="-1" href="/idp/index.php?r=kursusluar/admin">PERMOHONAN KURSUS ANJURAN AGENSI LUAR</a></li></ul></li><li class="dropdown-submenu dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">PENTADBIR <span class="caret"></span></a><ul id="yw2" class="dropdown-menu"><li><a tabindex="-1" href="/idp/index.php?r=viewBiodata/admin">SENARAI IDP STAF</a></li><li><a tabindex="-1" href="/idp/index.php?r=v_idp_senarai_kursus/admin">PENETAPAN KURSUS / SIRI</a></li><li><a tabindex="-1" href="/idp/index.php?r=kelulusan/takwim">KELULUSAN KURSUS ANJURAN DALAMAN STAF</a></li><li><a tabindex="-1" href="/idp/index.php?r=kelulusankursusluar/admin">KELULUSAN KURSUS ANJURAN AGENSI LUAR STAF</a></li><li><a tabindex="-1" href="/idp/index.php?r=hr_v_cpd_senarai_latihan/admin">PENGURUSAN KURSUS</a></li></ul></li><li><a href="/idp/index.php?r=site/laporan">LAPORAN</a></li><li class="dropdown-submenu dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">PENETAPAN <span class="caret"></span></a><ul id="yw3" class="dropdown-menu"><li><a tabindex="-1" href="/idp/index.php?r=hrakses/admin">Peranan</a></li><li><a tabindex="-1" href="/idp/index.php?r=v_idp_kumpulan/admin">Kumpulan</a></li><li><a tabindex="-1" href="/idp/index.php?r=ridpmatamin/admin">Mata Minima</a></li><li><a tabindex="-1" href="/idp/index.php?r=v_idp_profil/admin">Profil Staf Semasa</a></li><li><a tabindex="-1" href="/idp/index.php?r=department/admin">Pegawai / Ketua JFPIU</a></li><li><a tabindex="-1" href="/idp/index.php?r=v_idp_pp_hod/admin">Pegawai / Ketua Individu</a></li><li><a tabindex="-1" href="/idp/index.php?r=bahagianJFPIU/admin">Bahagian JFPIU</a></li></ul></li><li><a href="/idp/index.php?r=site/logout">Logout (AISYAH BINTI ZAINAL)</a></li></ul></div></div></div></div>
			<div class="breadcrumbs">
<a href="/idp/index.php">Home</a> &raquo; <a href="/idp/index.php?r=kursusluar/admin">Kursus Luar</a> &raquo; <span>Mohon</span></div><!-- breadcrumbs -->
	
	<div id="content">
	<style type="text/css">
<!--
.style1 {font-size: 12px}
-->
</style>


<h3>Permohonan Kursus Luar</h3>

<div class="form">

<form class="well form-vertical" enctype="multipart/form-data" id="d-mohon-kursus-luar-form" action="/idp/index.php?r=kursusluar/mohon" method="post">
	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<div class="alert alert-block alert-error" id="d-mohon-kursus-luar-form_es_" style="display:none"><p>Please fix the following input errors:</p>
<ul><li>dummy</li></ul></div>
	<table width="100%"  border="1" class="items table table-bordered table-condensed" style="background: #FFFFFF;">
	<tr bgcolor="c3d9ff">
	<th colspan="2">MAKLUMAT PROGRAM (<em>PROGRAMME INFORMATION</em>) </th>
	</tr>
	<tr>
	<td class='span4'>Penganjur (<em>Organiser</em>) <span class="required">*</span></td>
	<td>
	<select class="input-xxlarge" value="" name="d_mohon_kursus_luar[d_mkl_jenis_penganjur]" id="d_mohon_kursus_luar_d_mkl_jenis_penganjur">
<option value="">Sila Pilih</option>
<option value="1">UMS (JFPIU/Persatuan/Kesatuan/Kelab)</option>
<option value="2">Agensi Luar (External Agencies)</option>
</select>	<div class="help-block error" id="d_mohon_kursus_luar_d_mkl_jenis_penganjur_em_" style="display:none"></div>	
	</td>
	</tr>
	<tr>
	<td>Nama Penganjur (<em>Name of Organiser</em>) <span class="required">*</span></td>
	<td>
	<input size="60" maxlength="255" class="span8" name="d_mohon_kursus_luar[d_mkl_nama_penganjur]" id="d_mohon_kursus_luar_d_mkl_nama_penganjur" type="text" />	<div class="help-block error" id="d_mohon_kursus_luar_d_mkl_nama_penganjur_em_" style="display:none"></div>	</td>
	</tr>
	<tr>
	<td>Nama Program (<em>Name of Programme</em>) <span class="required">*</span></td>
	<td>
	<input size="60" maxlength="255" class="span8" name="d_mohon_kursus_luar[d_mkl_nama_program]" id="d_mohon_kursus_luar_d_mkl_nama_program" type="text" />	<div class="help-block error" id="d_mohon_kursus_luar_d_mkl_nama_program_em_" style="display:none"></div>	</td>
	</tr>
	<tr>
	<td>Tarikh Mula (<em>Start Date</em>) <span class="required">*</span></td>
	<td>
	<input id="d_mohon_kursus_luar_d_mkl_tkh_program" name="d_mohon_kursus_luar[d_mkl_tkh_program]" type="text" />		&nbsp;<i>(yyyy-mm-dd)</i>
		<div class="help-block error" id="d_mohon_kursus_luar_d_mkl_tkh_program_em_" style="display:none"></div>	
	</td>
	</tr>
	<tr>
      <td>Tarikh Tamat (<em>End Date</em>) <span class="required">*</span></td>
      <td>
        <input id="d_mohon_kursus_luar_d_mkl_tkh_tmt_program" name="d_mohon_kursus_luar[d_mkl_tkh_tmt_program]" type="text" />		&nbsp;<i>(yyyy-mm-dd)</i>
        <div class="help-block error" id="d_mohon_kursus_luar_d_mkl_tkh_tmt_program_em_" style="display:none"></div> </td>
	  </tr>
	<tr>
	<td>Tempat (<em>Venue</em>) <span class="required">*</span></td>
	<td>
	<input size="60" maxlength="255" class="span8" name="d_mohon_kursus_luar[d_mkl_tmpt_program]" id="d_mohon_kursus_luar_d_mkl_tmpt_program" type="text" />	<div class="help-block error" id="d_mohon_kursus_luar_d_mkl_tmpt_program_em_" style="display:none"></div>	</td>
	</tr>
	<tr>
	<td>
	Maklumat Anggaran Pembiayaan<br>
	(<em>Information of Estimated Funding</em>)<br>
	(<span class="style1">*Tertakluk kepada Garis Panduan dan Syarat-syarat Mengikuti Kursus Anjuran Dalaman, Luaran dan Luar Negara</span>)
	</td>
	<td><table width="100%"  border="1" class="items table table-bordered table-condensed">
	<tr>
	<th scope="col"><div align="center">No.</div></th>
	<th scope="col"><div align="center">Perkara (<em>Description</em>) </div></th>
	<th scope="col"><div align="center">Jumlah (<em>Amount</em>) RM </div></th>
	</tr>
	<tr>
	<td><div align="center">1.</div></td>
	<td>Yuran Program (<em>Programme Fees</em>) </td>
	<td><div align="center">
	<input style="text-align: center" name="d_mohon_kursus_luar[d_mkl_yuran]" id="d_mohon_kursus_luar_d_mkl_yuran" type="text" value="0.00" />		<div class="help-block error" id="d_mohon_kursus_luar_d_mkl_yuran_em_" style="display:none"></div></div>
	</td>
	</tr>
	<tr>
	<td><div align="center">2.</div></td>
	<td>Tiket Kapal Terbang (<em>Airplane Ticket</em>) </td>
	<td><div align="center">
	<input style="text-align: center" name="d_mohon_kursus_luar[d_mkl_tiket]" id="d_mohon_kursus_luar_d_mkl_tiket" type="text" value="0.00" />		<div class="help-block error" id="d_mohon_kursus_luar_d_mkl_tiket_em_" style="display:none"></div></div>
	</td>
	</tr>
	<tr>
	<td><div align="center">3.</div></td>
	<td>Hotel Penginapan (<em>Hotel Accommodation</em>) </td>
	<td><div align="center">
	<input style="text-align: center" name="d_mohon_kursus_luar[d_mkl_penginapan]" id="d_mohon_kursus_luar_d_mkl_penginapan" type="text" maxlength="255" value="0.00" />		<div class="help-block error" id="d_mohon_kursus_luar_d_mkl_penginapan_em_" style="display:none"></div></div>
	</td>
	</tr>
	<!--
	<tr>
	<td colspan="2"><div align="right">Jumlah Yang Dipohon (Amount Requested)</div></td>
	<td>&nbsp;</td>
	</tr>
	-->
	</table></td>
	</tr>
	<tr>
	<td colspan="2">NYATAKAN DENGAN RINGKAS ASPEK TUGAS UTAMA ANDA YANG BERKAITAN DENGAN PROGRAM PEMBANGUNAN PROFESIONAL YANG DIPOHON.<br>
	(<em>DESCRIBE BRIEFLY THE ASPECT OF YOUR MAIN DUTIES AND HOW THE PROGRAMME APPLIED IS RELATED TO YOUR PROFESIONAL DEVELOPMENT</em>). <span class="required">*</span></td>
	</tr>
	<tr>
	<td colspan="2">
	<textarea rows="6" cols="50" class="span8" name="d_mohon_kursus_luar[d_mkl_aspek_tugas]" id="d_mohon_kursus_luar_d_mkl_aspek_tugas"></textarea>		<div class="help-block error" id="d_mohon_kursus_luar_d_mkl_aspek_tugas_em_" style="display:none"></div>	</td>
	</tr>
	<tr>
	<td>Muatnaik dokumen (1): </td>
	<td><input id="ytd_mohon_kursus_luar_upload1" type="hidden" value="" name="d_mohon_kursus_luar[upload1]" /><input size="60" maxlength="255" name="d_mohon_kursus_luar[upload1]" id="d_mohon_kursus_luar_upload1" type="file" /></td>
	</tr>
	<tr>
	<td>Muatnaik dokumen (2): </td>
	<td><input id="ytd_mohon_kursus_luar_upload2" type="hidden" value="" name="d_mohon_kursus_luar[upload2]" /><input size="60" maxlength="255" name="d_mohon_kursus_luar[upload2]" id="d_mohon_kursus_luar_upload2" type="file" /></td>
	</tr>
	<tr>
	<td>Muatnaik dokumen (3): </td>
	<td><input id="ytd_mohon_kursus_luar_upload3" type="hidden" value="" name="d_mohon_kursus_luar[upload3]" /><input size="60" maxlength="255" name="d_mohon_kursus_luar[upload3]" id="d_mohon_kursus_luar_upload3" type="file" /></td>
	</tr>
	<tr>
	<td colspan="2">Tarikh Permohonan (<em>Application Date</em>): 03-12-2019</td>
	</tr>
	</table>

	<br>
	
<!--
	<b>PEGAWAI MEMPERAKUKAN PERMOHONAN KURSUS LUAR JFPIU : ENCIK MOHD AZWAN BIN ALLEH</b>
	<br>
-->
	<div class="row buttons">
		<input type="submit" name="yt0" value="Hantar Permohonan" id="yt0" />	</div>

<input type="hidden" name="__ncforminfo" value="jrSTKUXm6JFrUFKG3EMW1aAwPrL2Dd0SQI0-63rcjrwdo9KENaI53zTVQzZy3pohd0gbeGxPdpi-ipGTdhfxD-OML_GsVv1lpLoYsbJBzjVt16HAORsb5Uku1QqFah2w12rHE6EtUggTgEtZqBvCFZgH_A8PIn6yJwDYgHJ_A0rz677p4bVBL0oHjCn9E5-6I7ED5cwlrIezoE33H4cHFvXmBBMU_3uBgQGbdlyc1uyCRq8uOhmfsO62fL-UBR34"/></form>
</div><!-- form --></div><!-- content -->

	<div class="clear"></div>
	</div><!-- page -->

<script type="text/javascript" src="/idp/assets/3c563235/jui/js/jquery-ui.min.js"></script>
<script type="text/javascript">
/*<![CDATA[*/
jQuery(function($) {
jQuery('a[rel="tooltip"]').tooltip();
jQuery('a[rel="popover"]').popover();
jQuery('#d_mohon_kursus_luar_d_mkl_tkh_program').datepicker({'dateFormat':'yy-mm-dd','changeMonth':true,'changeYear':true,'yearRange':'-50:+10'});
jQuery('#d_mohon_kursus_luar_d_mkl_tkh_tmt_program').datepicker({'dateFormat':'yy-mm-dd','changeMonth':true,'changeYear':true,'yearRange':'-50:+10'});
jQuery('body').on('click','#yt0',function(){return confirm('Permohonan akan dihantar kepada ketua JFPIU untuk perakuan. Anda pasti semua maklumat telah diisi dengan betul dan lengkap?');});
jQuery('#d-mohon-kursus-luar-form').yiiactiveform({'attributes':[{'id':'d_mohon_kursus_luar_d_mkl_jenis_penganjur','inputID':'d_mohon_kursus_luar_d_mkl_jenis_penganjur','errorID':'d_mohon_kursus_luar_d_mkl_jenis_penganjur_em_','model':'d_mohon_kursus_luar','name':'d_mkl_jenis_penganjur','enableAjaxValidation':true,'summary':true},{'id':'d_mohon_kursus_luar_d_mkl_nama_penganjur','inputID':'d_mohon_kursus_luar_d_mkl_nama_penganjur','errorID':'d_mohon_kursus_luar_d_mkl_nama_penganjur_em_','model':'d_mohon_kursus_luar','name':'d_mkl_nama_penganjur','enableAjaxValidation':true,'summary':true},{'id':'d_mohon_kursus_luar_d_mkl_nama_program','inputID':'d_mohon_kursus_luar_d_mkl_nama_program','errorID':'d_mohon_kursus_luar_d_mkl_nama_program_em_','model':'d_mohon_kursus_luar','name':'d_mkl_nama_program','enableAjaxValidation':true,'summary':true},{'id':'d_mohon_kursus_luar_d_mkl_tkh_program','inputID':'d_mohon_kursus_luar_d_mkl_tkh_program','errorID':'d_mohon_kursus_luar_d_mkl_tkh_program_em_','model':'d_mohon_kursus_luar','name':'d_mkl_tkh_program','enableAjaxValidation':true,'summary':true},{'id':'d_mohon_kursus_luar_d_mkl_tkh_tmt_program','inputID':'d_mohon_kursus_luar_d_mkl_tkh_tmt_program','errorID':'d_mohon_kursus_luar_d_mkl_tkh_tmt_program_em_','model':'d_mohon_kursus_luar','name':'d_mkl_tkh_tmt_program','enableAjaxValidation':true,'summary':true},{'id':'d_mohon_kursus_luar_d_mkl_tmpt_program','inputID':'d_mohon_kursus_luar_d_mkl_tmpt_program','errorID':'d_mohon_kursus_luar_d_mkl_tmpt_program_em_','model':'d_mohon_kursus_luar','name':'d_mkl_tmpt_program','enableAjaxValidation':true,'summary':true},{'id':'d_mohon_kursus_luar_d_mkl_yuran','inputID':'d_mohon_kursus_luar_d_mkl_yuran','errorID':'d_mohon_kursus_luar_d_mkl_yuran_em_','model':'d_mohon_kursus_luar','name':'d_mkl_yuran','enableAjaxValidation':true,'summary':true},{'id':'d_mohon_kursus_luar_d_mkl_tiket','inputID':'d_mohon_kursus_luar_d_mkl_tiket','errorID':'d_mohon_kursus_luar_d_mkl_tiket_em_','model':'d_mohon_kursus_luar','name':'d_mkl_tiket','enableAjaxValidation':true,'summary':true},{'id':'d_mohon_kursus_luar_d_mkl_penginapan','inputID':'d_mohon_kursus_luar_d_mkl_penginapan','errorID':'d_mohon_kursus_luar_d_mkl_penginapan_em_','model':'d_mohon_kursus_luar','name':'d_mkl_penginapan','enableAjaxValidation':true,'summary':true},{'id':'d_mohon_kursus_luar_d_mkl_aspek_tugas','inputID':'d_mohon_kursus_luar_d_mkl_aspek_tugas','errorID':'d_mohon_kursus_luar_d_mkl_aspek_tugas_em_','model':'d_mohon_kursus_luar','name':'d_mkl_aspek_tugas','enableAjaxValidation':true,'summary':true},{'summary':true},{'summary':true},{'summary':true},{'summary':true},{'summary':true},{'summary':true},{'summary':true},{'summary':true},{'summary':true},{'summary':true},{'summary':true},{'summary':true},{'summary':true},{'summary':true},{'summary':true},{'summary':true},{'summary':true},{'summary':true},{'summary':true},{'summary':true},{'summary':true},{'summary':true},{'summary':true},{'summary':true},{'summary':true},{'summary':true},{'summary':true},{'summary':true},{'summary':true},{'summary':true},{'summary':true},{'summary':true},{'summary':true},{'summary':true},{'summary':true},{'summary':true},{'summary':true},{'summary':true},{'summary':true},{'summary':true},{'summary':true},{'summary':true}],'summaryID':'d-mohon-kursus-luar-form_es_','errorCss':'error'});
});
/*]]>*/
</script>
</body>
</html>
<div align='center'>
</div>