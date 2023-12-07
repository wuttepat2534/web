<?php
require_once 'api/config.php';
if(empty(get_session()))
{
  echo "<SCRIPT LANGUAGE='JavaScript'>
          window.location.href = './login';
        </SCRIPT>";
  exit();
}
?>
<!DOCTYPE html>
<html>
<head>
  <?php include("master/MasterPages.php"); ?>
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed text-sm">
  <input type="hidden" id="username" value="<?=get_session()?>">
  <input type="hidden" id="ip" value="<?=get_client_ip()?>">
  <div class="wrapper">
    <?php include ("partials/_navbar.php"); ?>
    <?php include ("partials/_sidebar.php"); ?>
    <div class="content-wrapper">
      <section class="content-header pt-4 pb-4">
        <h1 style="font-size: 30px;">ตั้งค่าบัญชีธนาคาร</h1>
      </section>
      <section class="content">
        <div class="row">

          <div class="col-sm-4">
            <div class="card card-scb card-outline">
              <div class="card-body box-profile">
                <div class="row">
                  <div class="col-sm-12 mb-3 text-center">
                    <?php
                    $q_scb = dd_q('SELECT * FROM autobank_tb WHERE a_bank_code=?', ['scb']);
                    $row_scb = $q_scb->fetch(PDO::FETCH_ASSOC);
                    ?>
                    <img style="width: 50px;" src="./images/bank/<?=$row_scb['a_bank_code']?>.png">
                    <br>
                    <span>
                      <code class="text-dark" style="font-size: 14px;">
                        Status:
                        <?php
                        if($row_scb['a_bank_run'] == "1")
                        {
                        ?>
                        <span class="bg-success"> Online</span>
                        <?php
                        }
                        else
                        {
                        ?>
                        <span class="bg-danger"> Offline</span>
                        <?php
                        }
                        ?>
                      </code>
                    </span>
                    <br>
                    <span>
                      <code class="text-dark" style="font-size: 14px;">
                        Last update: <?=date('d/m/Y H:i:s', strtotime($row_scb['a_bank_update']))?>
                      </code>
                    </span>
                  </div>
                  <div class="col-sm-12 mb-3">
                    <strong>ชื่อบัญชี</strong>
                    <input type="text" class="form-control" id="txt_scb_name" value="<?=$row_scb['a_bank_acc_name']?>">
                  </div>
                  <div class="col-sm-12 mb-3">
                    <strong>เลขบัญชี</strong>
                    <input type="text" class="form-control" id="txt_scb_number" value="<?=$row_scb['a_bank_acc_number']?>">
                    <span class="text-danger">Format การใส่คือ 000-0-00000-0</span>
                  </div>
                  <div class="col-sm-12 mb-1">
                    <?php
                    if($row_scb['a_bank_status'] == "1")
                    {
                    ?>
                    <button type="button" id="btn_close_scb" class="btn btn-danger btn-block">
                      <i class="fas fa-times"></i> ปิดใช้งาน
                    </button>
                    <?php
                    }
                    else if($row_scb['a_bank_status'] == "0")
                    {
                    ?>
                    <button type="button" id="btn_open_scb" class="btn btn-success btn-block">
                      <i class="fas fa-check"></i> เปิดใช้งาน
                    </button>
                    <?php
                    }
                    ?>
                  </div>
                  <div class="col-sm-12">
                    <button type="button" id="btn_save_scb" class="btn btn-scb btn-block">
                      <i class="fas fa-save"></i> บันทึกการตั้งค่า
                    </button>
			<input type="hidden" class="form-control" id="txt_scb_username" value="<?=$row_scb['a_bank_username']?>">
			<input type="hidden" class="form-control" id="txt_scb_password" value="<?=$row_scb['a_bank_password']?>">
                  </div>
                </div>
              </div>
            </div>
          </div>

       <!--   <div class="col-sm-4">
            <div class="card card-tmw card-outline">
              <div class="card-body box-profile">
                <div class="row">
                  <div class="col-sm-12 mb-3 text-center">
                    <?php
                    $q_tmw = dd_q('SELECT * FROM autobank_tb WHERE a_bank_code=?', ['tmw']);
                    $row_tmw = $q_tmw->fetch(PDO::FETCH_ASSOC);
                    ?>
                    <img style="width: 50px;" src="./images/bank/<?=$row_tmw['a_bank_code']?>.png">
                    <br>
                    <span>
                      <code class="text-dark" style="font-size: 14px;">
                        Status:
                        <?php
                        if($row_tmw['a_bank_run'] == "1")
                        {
                        ?>
                        <span class="bg-success"> Online</span>
                        <?php
                        }
                        else
                        {
                        ?>
                        <span class="bg-danger"> Offline</span>
                        <?php
                        }
                        ?>
                      </code>
                    </span>
                    <br>
                    <span>
                      <code class="text-dark" style="font-size: 14px;">
                        Last update: <?=date('d/m/Y H:i:s', strtotime($row_tmw['a_bank_update']))?>
                      </code>
                    </span>
                    <br>
                    <span>
                      <code style="font-size: 14px;">
                        <a href="https://tmw.push888.co" target="_blank">### ตั้งค่าบัญชี wallet ###</a>
                      </code>
                    </span>
                  </div>
                  <div class="col-sm-12 mb-3">
                    <strong>ชื่อบัญชี</strong>
                    <input type="text" class="form-control" id="txt_tmw_name" value="<?=$row_tmw['a_bank_acc_name']?>">
                  </div>
                  <div class="col-sm-12 mb-3">
                    <strong>เลขบัญชี</strong>
                    <input type="text" class="form-control" id="txt_tmw_number" value="<?=$row_tmw['a_bank_acc_number']?>">
                    <span class="text-danger">Format การใส่คือ 000-0000000</span>
                  </div>
                  <div class="col-sm-12 mb-3">
                    <strong>wallet_acc</strong>
                    <input type="text" class="form-control" id="txt_tmw_username" value="<?=$row_tmw['a_bank_username']?>">
                  </div>
                  <div class="col-sm-12 mb-1">
                    <?php
                    if($row_tmw['a_bank_status'] == "1")
                    {
                    ?>
                    <button type="button" id="btn_close_tmw" class="btn btn-danger btn-block">
                      <i class="fas fa-times"></i> ปิดใช้งาน
                    </button>
                    <?php
                    }
                    else if($row_tmw['a_bank_status'] == "0")
                    {
                    ?>
                    <button type="button" id="btn_open_tmw" class="btn btn-success btn-block">
                      <i class="fas fa-check"></i> เปิดใช้งาน
                    </button>
                    <?php
                    }
                    ?>
                  </div>
                  <div class="col-sm-12">
                    <button type="button" id="btn_save_tmw" class="btn btn-tmw btn-block">
                      <i class="fas fa-save"></i> บันทึกการตั้งค่า
                    </button>
			<input type="hidden" class="form-control" id="txt_tmw_password" value="<?=$row_tmw['a_bank_password']?>">
                  </div>
                </div>
              </div>
            </div>
          </div> -->

        </div>
      </section>
    </div>
  </div>
</body>
<?php include('partials/_footer.php'); ?>
<script type="text/javascript">

  $("#btn_close_scb").click(function(e) {
    e.preventDefault();
    var formData = new FormData();
    formData.append('type', 'btn_close_scb');
    formData.append('username', $("#username").val());
    formData.append('ip', $("#ip").val());

    $.ajax({
      type: 'POST',
      url: 'system/api_bank_config',
      data:formData,
      contentType: false,
      processData: false,
    }).done(function(res){
      result = res;
      alert(result.message);
      window.location = './bank_config';
      console.clear();
    }).fail(function(jqXHR){
      res = jqXHR.responseJSON;
      alert(res.message);
      console.clear();
    });
  });
  $("#btn_open_scb").click(function(e) {
    e.preventDefault();
    var formData = new FormData();
    formData.append('type', 'btn_open_scb');
    formData.append('username', $("#username").val());
    formData.append('ip', $("#ip").val());

    $.ajax({
      type: 'POST',
      url: 'system/api_bank_config',
      data:formData,
      contentType: false,
      processData: false,
    }).done(function(res){
      result = res;
      alert(result.message);
      window.location = './bank_config';
      console.clear();
    }).fail(function(jqXHR){
      res = jqXHR.responseJSON;
      alert(res.message);
      console.clear();
    });
  });
  $("#btn_save_scb").click(function(e) {
    e.preventDefault();
    var formData = new FormData();
    formData.append('a_bank_acc_name', $("#txt_scb_name").val());
    formData.append('a_bank_acc_number', $("#txt_scb_number").val());
    formData.append('a_bank_username', $("#txt_scb_username").val());
    formData.append('a_bank_password', $("#txt_scb_password").val());

    formData.append('type', 'btn_save_scb');
    formData.append('username', $("#username").val());
    formData.append('ip', $("#ip").val());

    $.ajax({
      type: 'POST',
      url: 'system/api_bank_config',
      data:formData,
      contentType: false,
      processData: false,
    }).done(function(res){
      result = res;
      alert(result.message);
      window.location = './bank_config';
      console.clear();
    }).fail(function(jqXHR){
      res = jqXHR.responseJSON;
      alert(res.message);
      console.clear();
    });
  });

  $("#btn_close_bay").click(function(e) {
    e.preventDefault();
    var formData = new FormData();
    formData.append('type', 'btn_close_bay');
    formData.append('username', $("#username").val());
    formData.append('ip', $("#ip").val());

    $.ajax({
      type: 'POST',
      url: 'system/api_bank_config',
      data:formData,
      contentType: false,
      processData: false,
    }).done(function(res){
      result = res;
      alert(result.message);
      window.location = './bank_config';
      console.clear();
    }).fail(function(jqXHR){
      res = jqXHR.responseJSON;
      alert(res.message);
      console.clear();
    });
  });
  $("#btn_open_bay").click(function(e) {
    e.preventDefault();
    var formData = new FormData();
    formData.append('type', 'btn_open_bay');
    formData.append('username', $("#username").val());
    formData.append('ip', $("#ip").val());

    $.ajax({
      type: 'POST',
      url: 'system/api_bank_config',
      data:formData,
      contentType: false,
      processData: false,
    }).done(function(res){
      result = res;
      alert(result.message);
      window.location = './bank_config';
      console.clear();
    }).fail(function(jqXHR){
      res = jqXHR.responseJSON;
      alert(res.message);
      console.clear();
    });
  });
  $("#btn_save_bay").click(function(e) {
    e.preventDefault();
    var formData = new FormData();
    formData.append('a_bank_acc_name', $("#txt_bay_name").val());
    formData.append('a_bank_acc_number', $("#txt_bay_number").val());
    formData.append('a_bank_username', $("#txt_bay_username").val());
    formData.append('a_bank_password', $("#txt_bay_password").val());

    formData.append('type', 'btn_save_bay');
    formData.append('username', $("#username").val());
    formData.append('ip', $("#ip").val());

    $.ajax({
      type: 'POST',
      url: 'system/api_bank_config',
      data:formData,
      contentType: false,
      processData: false,
    }).done(function(res){
      result = res;
      alert(result.message);
      window.location = './bank_config';
      console.clear();
    }).fail(function(jqXHR){
      res = jqXHR.responseJSON;
      alert(res.message);
      console.clear();
    });
  });

  $("#btn_close_tmw").click(function(e) {
    e.preventDefault();
    var formData = new FormData();
    formData.append('type', 'btn_close_tmw');
    formData.append('username', $("#username").val());
    formData.append('ip', $("#ip").val());

    $.ajax({
      type: 'POST',
      url: 'system/api_bank_config',
      data:formData,
      contentType: false,
      processData: false,
    }).done(function(res){
      result = res;
      alert(result.message);
      window.location = './bank_config';
      console.clear();
    }).fail(function(jqXHR){
      res = jqXHR.responseJSON;
      alert(res.message);
      console.clear();
    });
  });
  $("#btn_open_tmw").click(function(e) {
    e.preventDefault();
    var formData = new FormData();
    formData.append('type', 'btn_open_tmw');
    formData.append('username', $("#username").val());
    formData.append('ip', $("#ip").val());

    $.ajax({
      type: 'POST',
      url: 'system/api_bank_config',
      data:formData,
      contentType: false,
      processData: false,
    }).done(function(res){
      result = res;
      alert(result.message);
      window.location = './bank_config';
      console.clear();
    }).fail(function(jqXHR){
      res = jqXHR.responseJSON;
      alert(res.message);
      console.clear();
    });
  });
  $("#btn_save_tmw").click(function(e) {
    e.preventDefault();
    var formData = new FormData();
    formData.append('a_bank_acc_name', $("#txt_tmw_name").val());
    formData.append('a_bank_acc_number', $("#txt_tmw_number").val());
    formData.append('a_bank_username', $("#txt_tmw_username").val());
    formData.append('a_bank_password', $("#txt_tmw_password").val());

    formData.append('type', 'btn_save_tmw');
    formData.append('username', $("#username").val());
    formData.append('ip', $("#ip").val());

    $.ajax({
      type: 'POST',
      url: 'system/api_bank_config',
      data:formData,
      contentType: false,
      processData: false,
    }).done(function(res){
      result = res;
      alert(result.message);
      window.location = './bank_config';
      console.clear();
    }).fail(function(jqXHR){
      res = jqXHR.responseJSON;
      alert(res.message);
      console.clear();
    });
  });

</script>
</html>