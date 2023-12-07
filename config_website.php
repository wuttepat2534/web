<?php
require_once 'api/config.php';
if(empty(get_session()))
{
  echo "<SCRIPT LANGUAGE='JavaScript'>
          window.location.href = './login';
        </SCRIPT>";
  exit();
}
else
{
  // ===== get permission =====
  if(get_admin("a_role") != "1")
  {
    echo "<SCRIPT LANGUAGE='JavaScript'>
    window.location.href = './unauthorized';
    </SCRIPT>";
    exit;
  }
  // ===== get permission =====
}
$q_u = dd_q('SELECT * FROM website_tb WHERE (id = ?)', [1]);
$row_u = $q_u->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
  <?php include("master/MasterPages.php"); ?>
  <style type="text/css">
<!--
.style1 {
	color: #007bff;
	font-weight: bold;
	font-size: 24px;
}
.style2 {color: #009900}
-->
  </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed text-sm">
  <div class="wrapper">
    <?php include ("partials/_navbar.php"); ?>
    <?php include ("partials/_sidebar.php"); ?>
    <div class="content-wrapper">
      <section class="content-header pt-4 pb-4">
        <h1 style="font-size: 30px;">ตั้งค่าเว็บไซค์ SEO </h1>

     	<table width="100%" border="0" align="center" cellpadding="10">
  <tr>
    <td colspan="2"><div align="center" class="style1">ตั้งค่าเว็บไซต์</div></td>
    <input name="id" id="id" type="hidden" value="<?php echo $row_u['id']; ?>" size="100">
    <td colspan="2"><div align="center"><span class="style1">ตั้งค่ารูปสไลด์โชว์หน้าเว็บ</span></div></td>
    </tr>
  <tr>
    <td width="16%"><div align="center">ชื่อเว็บ</div></td>
    <td width="34%"><input id="namesite" name="title" class="form-control" type="text" value="<?php echo $row_u['namesite']; ?>" size="100"></td>
    <td width="14%"><div align="center">ภาพสไลด์ 1 </div></td>
    <td width="36%"><input name="slider1" id="slider1" class="form-control"  type="text" value="<?php echo $row_u['slider1']; ?>" size="100"></td>
  </tr>
  <tr>
    <td><div align="center">title เว็บ </div></td>
    <td><input name="title" id="title" type="text" class="form-control" value="<?php echo $row_u['title']; ?>" size="100"></td>
    <td><div align="center">ภาพสไลด์ 2 </div></td>
    <td><input name="slider2" id="slider2"  type="text" class="form-control" value="<?php echo $row_u['slider2']; ?>" size="100"></td>
  </tr>
  <tr>
    <td><div align="center">Discription</div></td>
    <td><input name="description" id="description" type="text" class="form-control" value="<?php echo $row_u['description']; ?>" size="100"></td>
    <td><div align="center">ภาพสไลด์ 3 </div></td>
    <td><input name="slider3" id="slider3"  type="text" class="form-control" value="<?php echo $row_u['slider3']; ?>" size="100"></td>
  </tr>
  <tr>
    <td><div align="center">Keyword</div></td>
    <td><input name="keyword" id="keyword" type="text" class="form-control" value="<?php echo $row_u['keyword']; ?>" size="100"></td>
    <td><div align="center">ภาพสไลด์ 4 </div></td>
    <td><input name="slider4" id="slider4"  type="text" class="form-control" value="<?php echo $row_u['slider4']; ?>" size="100"></td>
  </tr>
  <tr>
    <td><div align="center">Logo เว็บ </div></td>
    <td><input name="logo" id="logo" type="text" class="form-control" value="<?php echo $row_u['logo']; ?>" size="100"></td>
    <td><div align="center">ภาพสไลด์ 5 </div></td>
    <td><input name="slider5" id="slider5"  type="text" class="form-control" value="<?php echo $row_u['slider5']; ?>" size="100"></td>
  </tr>
  <tr>
    <td><div align="center">พื้นหลังเว็บ</div></td>
    <td><input name="bg" id="bg"  type="text" class="form-control" value="<?php echo $row_u['bg']; ?>" size="100"></td>
    <td><div align="center">ภาพสไลด์ 6 </div></td>
    <td><input name="slider6" id="slider6"  type="text" class="form-control" value="<?php echo $row_u['slider6']; ?>" size="100"></td>
  </tr>
  <tr>
    <td><div align="center">Copyright</div></td>
    <td><input name="copyright" id="copyright" class="form-control"  type="text" value="<?php echo $row_u['copyright']; ?>" size="100"></td>
    <td colspan="2"><div align="center"><span class="style1">ตั้งค่าช่องทางติดต่อเว็บ</span></div></td>
    </tr>
  <tr>
    <td><div align="center">ประกาศหน้าสมาชิก</div></td>
    <td><input name="post" id="post"  type="text" class="form-control" value="<?php echo $row_u['post']; ?>" size="100"></td>
    <td><div align="center">URL Line </div></td>
    <td><input name="lineurl" id="lineurl"  type="text" class="form-control" value="<?php echo $row_u['lineurl']; ?>" size="100"></td>
  </tr>
  
  <tr>
    <td colspan="2"><div align="center"><span class="style1">ตั้งค่าระบบความปลอดภัย</span></div></td>
    <td><div align="center">ID Line ติดต่อ </div></td>
    <td><input name="line" id="line" type="text" class="form-control" value="<?php echo $row_u['line']; ?>" size="100"></td>
  </tr>
  <tr>
    <td><div align="center">Google reCAPTCHA Site V2</div></td>
    <td><input name="recaptchakey" id="recaptchakey"  type="text" class="form-control" value="<?php echo $row_u['recaptchakey']; ?>" size="100"  ></td>
    <td colspan="2"><div align="center"><span class="style1">ตั้งค่าไลน์แจ้งเตือน</span></div></td>
    </tr>
  <tr>
    <td><div align="center">Google reCAPTCHA Secret V2</div></td>
    <td><input name="recapchasecret" id="recapchasecret"  type="text" class="form-control" value="<?php echo $row_u['recapchasecret']; ?>" size="100"  ></td>
    <td><div align="center">Token Line ฝาก </div></td>
    <td><input name="linewallet" id="linewallet"  type="text" class="form-control" value="<?php echo $row_u['linewallet']; ?>" size="100" ></td>
  </tr>
  <tr>
    <td colspan="2"><div align="center"><span class="style1">ตั้งค่า ถอน และ % โปรโมชั่นเสริม </span></div></td>
    <td><div align="center">Token Line สมัคร </div></td>
    <td><input name="lineregister" id="lineregister"  type="text" class="form-control" value="<?php echo $row_u['lineregister']; ?>" size="100"  ></td>
  </tr>
  <tr>
    <td><div align="center">ถอนเงินขั้นต่ำ</div></td>
    <td><input name="min_withdraw" id="min_withdraw" class="form-control"  type="text" value="<?php echo $row_u['min_withdraw']; ?>" size="100"></td>
    <td><div align="center">token ไลน์ถอน</div></td>
    <td><input name="tokenline" id="tokenline"  type="text" class="form-control" value="<?php echo $row_u['tokenline']; ?>" size="100"  ></td>
  </tr>
  <tr>
    <td><div align="center">ลำดับขั้นชวนเพื่อน <span class="badge badge-success">New</span></div></td>
    <td>
      <input name="aff_step" id="aff_step" min="1" max="3" type="text" class="form-control" value="<?php echo $row_u['aff_step']; ?>" size="20">    </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><div align="center">% ชวนเพื่อน ขั้น 1 </div></td>
    <td><input name="affpersen" id="affpersen"  type="text" class="form-control" value="<?php echo $row_u['affpersen']; ?>" size="20">
      % (0.1 เท่ากับ 10%) (ตอนนี้ : <span class="style2"><?php echo $row_u['affpersen']*100; ?>%</span>)</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><div align="center">% ชวนเพื่อน ขั้น 2 <span class="badge badge-success">New</span></div></td>
    <td><input name="affpersen2" id="affpersen2"  type="text" class="form-control" value="<?php echo $row_u['affpersen2']; ?>" size="20">
      % (0.1 เท่ากับ 10%) (ตอนนี้ : <span class="style2"><?php echo $row_u['affpersen2']*100; ?>%</span>)</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><div align="center">% ชวนเพื่อน ขั้น 3 <span class="badge badge-success">New</span></div></td>
    <td><input name="affpersen3" id="affpersen3"  type="text" class="form-control" value="<?php echo $row_u['affpersen3']; ?>" size="20">
      % (0.1 เท่ากับ 10%) (ตอนนี้ : <span class="style2"><?php echo $row_u['affpersen3']*100; ?>%</span>)</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><div align="center">ประเภทรายได้ที่คิดค่าแนะนำ <span class="badge badge-success">New</span></div></td>
    <td>
      <select name="aff_type" id="aff_type" class="form-control">
        <option value="1" <?php if($row_u['aff_type'] == "1"){echo "selected";} ?>>ยอดฝากแรกของเพื่อน</option>
        <option value="2" <?php if($row_u['aff_type'] == "2"){echo "selected";} ?>>ทุกยอดฝากของเพื่อน</option>
        <option value="3" <?php if($row_u['aff_type'] == "3"){echo "selected";} ?>>ยอดเสียของเพื่อน เหมือนคืนยอดเสีย</option>
      </select>    </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><div align="center">ค่าแนะนำที่รับได้สูงสุดต่อวัน <span class="badge badge-success">New</span></div></td>
    <td><input name="aff_maxofday" id="aff_maxofday"  type="number" step="0.01" class="form-control" value="<?php echo $row_u['aff_maxofday']; ?>">
    (หน่วยเป็นบาท)</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><div align="center">% คืนยอดเสีย</div></td>
    <td><input name="affwinloss" id="affwinloss"  type="number" step="0.1" class="form-control" value="<?php echo $row_u['affwinloss']; ?>" size="20">
      % (0.1 เท่ากับ 10%) (ตอนนี้ : <span class="style2"><?php echo $row_u['affwinloss']*100; ?>%</span>)</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><div align="center">ยอดเสียขั้นต่ำที่รับคืนได้ </div></td>
    <td><input name="minwinloss" id="minwinloss"  type="number" min="1" class="form-control" value="<?php echo $row_u['minwinloss']; ?>" size="100"></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><div align="center"><span class="style1">ตั้งค่า ทรูวอลเลตรับเงิน </span></div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><div align="center">เบอร์ทรูวอลเลตที่ใช้รับเงิน</div></td>
    <td><input name="truewallet" id="truewallet"  type="text" class="form-control" value="<?php echo $row_u['truewallet']; ?>" size="100"></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <button type="submit" id="settingwebsite" class="btn btn-primary btn-lg"><i class="fas fa-save fa-lg"></i> บันทึก</button>
</table>

</form>
    </div>
  </div>
</body>
</body>
<?php include('partials/_footer.php'); ?>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
 <script type="text/javascript">
 
  $("#settingwebsite").click(function(e) {
    e.preventDefault();
    var formData = new FormData();
	formData.append('type', 'settingwebsite');
	formData.append('id', $("#id").val());
  formData.append('namesite', $("#namesite").val());
	formData.append('title', $("#title").val());
	formData.append('description', $("#description").val());
	formData.append('keyword', $("#keyword").val());
	formData.append('line', $("#line").val());
	formData.append('logo', $("#logo").val());
	formData.append('bg', $("#bg").val());
	formData.append('slider1', $("#slider1").val());
	formData.append('slider2', $("#slider2").val());
	formData.append('slider3', $("#slider3").val());
	formData.append('slider4', $("#slider4").val());
	formData.append('slider5', $("#slider5").val());
	formData.append('slider6', $("#slider6").val());
	formData.append('lineurl', $("#lineurl").val());
	formData.append('copyright', $("#copyright").val());
	formData.append('post', $("#post").val());
	formData.append('min_withdraw', $("#min_withdraw").val());
	formData.append('recaptchakey', $("#recaptchakey").val());
	formData.append('tokenline', $("#tokenline").val());
	formData.append('recapchasecret', $("#recapchasecret").val());
	formData.append('affpersen', $("#affpersen").val());
  formData.append('affpersen2', $("#affpersen2").val());
  formData.append('affpersen3', $("#affpersen3").val());
  formData.append('aff_step', $("#aff_step").val());
  formData.append('aff_type', $("#aff_type").val());
  formData.append('aff_maxofday', $("#aff_maxofday").val());
	formData.append('truewallet', $("#truewallet").val());
	formData.append('linewallet', $("#linewallet").val());
  formData.append('lineregister', $("#lineregister").val());
  formData.append('affwinloss', $("#affwinloss").val());
  formData.append('minwinloss', $("#minwinloss").val());

    $.ajax({
      type: 'POST',
      url: 'api/edit_website.php',
      data:formData,
      contentType: false,
      processData: false,
    }).done(function(res){
      result = res;
      alert(result.message);
      window.location = './config_website';
      console.clear();
    }).fail(function(jqXHR){
      res = jqXHR.responseJSON;
      alert(res.message);
      console.clear();
    });
  });
 </script>
</html>