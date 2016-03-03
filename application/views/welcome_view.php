<!-- <!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>

	<style type="text/css">

	::selection{ background-color: #E13300; color: white; }
	::moz-selection{ background-color: #E13300; color: white; }
	::webkit-selection{ background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		margin: 40px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
	}

	a {
		color: #003399;
		background-color: transparent;
		font-weight: normal;
	}

	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0 0 14px 0;
		padding: 14px 15px 10px 15px;
	}

	code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
	}

	#body{
		margin: 0 15px 0 15px;
	}
	
	p.footer{
		text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}
	
	#container{
		margin: 10px;
		border: 1px solid #D0D0D0;
		-webkit-box-shadow: 0 0 8px #D0D0D0;
	}
	</style>
</head>
<body>

<div id="container">
	<h1>Welcome to Admin Panel!</h1>

	<div id="body">
		<p>Pada halaman ini, anda dapat melakukan pengaturan data-data referensi.</p>
	</div>

</div>

</body>
</html> -->


<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8">
<tilte>Input Bayar</title>
<?php
// $this->load->view('kepala');
?>
</head> 
<body>
<script type="text/javascript">
function kali()
{var bil1 = parseFloat
(document.fform.harga_mak.value);
var bil2 = parseFloat
(document.fform.jumlah_mak.value);
var hasil= bil1 * bil2;
document.fform.total_bay.value= hasil;}
</script>
<div data-role="page" id="bayar" data-add-back-btn="true" >
<div data-role="header">
<h1>Input Makanan</h1>
</div><!-- /header -->
<div data-role="content">
<?php echo form_open('bayar/simpan',array('name'=>'fform'))?>
<tr>
<td><label>Id Bayar</label></td>
<td><input type="text" name="id_bay" id="id_bay"/></td>
</tr>
<tr>
<td><label>Nama Makanan</label></td>
<td><select name="nama_mak">
<?php
// foreach ($tampil->result() as $row)
// {
// echo "<option value='".$row->nama_makanan."'>".$row->nama_makanan."</option>";
// }
?> 
</select></td>
</tr>
<tr>
<td><label>Harga Makanan</label></td>
<td><input type= "text" name = "harga_mak"/></td>
</tr>
<tr>
<td><label>Jumlah Makanan</label></td>
<td><input type ="text" name = "jumlah_mak"/></td>
</tr>
<tr>
<td><label>Total Bayar</label></td>
<td><input type="text" name="total_bay" value=""/></td>
</tr>
<td colspan="2"><input type ="button" value ="Hitung" onClick = "kali()"/></td>
<br/>
<tr>
<td colspan="2"><input type="submit" value="Simpan" name="simpan"/></td>
</tr>
</form>
</div> <!-- /content -->
</div><!-- /page -->
</body>
</html>