﻿<?php
require_once 'api/config.php';
require 'scanqr/scb/class.php';
require_once __DIR__.'/scanqr/vendor/autoload.php';
require_once 'api/Service/amb.php';
$api = new AMBAPI();
use Zxing\QrReader;

if(empty(get_session()))
{
  echo "<SCRIPT LANGUAGE='JavaScript'>
          window.location.href = './login';
        </SCRIPT>";
  exit();
}
else
{
  $q_website = dd_q('SELECT * FROM website_tb WHERE (id = ?)', [1]);
  $row_website = $q_website->fetch(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
  <?php include("master/MasterPages.php"); ?>
  <script type="text/javascript" src="<?=base_url()?>/themes/v2/js/jquery-1.10.2.minc619.js?v=1.0"></script>
  <script type="text/javascript" src="<?=base_url()?>/themes/v2/js/owl.carousel.min2048.js?v=1.5"></script>
  <script type="text/javascript" src="<?=base_url()?>/themes/v2/js/min-v3.js"></script>
  <script type="text/javascript" src="<?=base_url()?>/themes/v2/js/animate.min2d4c.js?v=2.3"></script> 
  <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.all.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.8.1/parsley.min.js" type="33c59bba0d8725c03bd010e9-text/javascript"></script>
  <link rel="stylesheet" href="<?=base_url()?>/style-upslip.css">
<style>
button:focus,
input:focus,
textarea:focus,
select:focus {
  outline: none; }

.tabs {
  display: block;
  display: -webkit-flex;
  display: -moz-flex;
  display: flex;
  -webkit-flex-wrap: wrap;
  -moz-flex-wrap: wrap;
  flex-wrap: wrap;
  margin: 0;
  overflow: hidden; }
  .tabs [class^="tab"] label,
  .tabs [class*=" tab"] label {
    color: #efedef;
    cursor: pointer;
    display: block;
    font-size: 24px;
    font-family: thaisanslite_r1;
    font-weight: 300;
    line-height: 1em;
    padding: 2rem 0;
    text-align: center; }
  .tabs [class^="tab"] [type="radio"],
  .tabs [class*=" tab"] [type="radio"] {
    border-bottom: 1px solid rgba(239, 237, 239, 0.5);
    cursor: pointer;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    display: block;
    width: 70%;
      margin:auto;
    -webkit-transition: all 0.3s ease-in-out;
    -moz-transition: all 0.3s ease-in-out;
    -o-transition: all 0.3s ease-in-out;
    transition: all 0.3s ease-in-out; }
    .tabs [class^="tab"] [type="radio"]:hover, .tabs [class^="tab"] [type="radio"]:focus,
    .tabs [class*=" tab"] [type="radio"]:hover,
    .tabs [class*=" tab"] [type="radio"]:focus {
      border-bottom: 1px solid #fd264f; }
    .tabs [class^="tab"] [type="radio"]:checked,
    .tabs [class*=" tab"] [type="radio"]:checked {
      border-bottom: 2px solid #fd264f;
      margin:auto;
      width:50%; }
    .tabs [class^="tab"] [type="radio"]:checked + div,
    .tabs [class*=" tab"] [type="radio"]:checked + div {
      opacity: 1; }
    .tabs [class^="tab"] [type="radio"] + div,
    .tabs [class*=" tab"] [type="radio"] + div {
      display: block;
      opacity: 0;
      padding: 2rem 0;
      -webkit-transition: all 0.3s ease-in-out;
      -moz-transition: all 0.3s ease-in-out;
      -o-transition: all 0.3s ease-in-out;
      transition: all 0.3s ease-in-out; }
  .tabs .tab-2 {
    width: 50%; }
    .tabs .tab-2 [type="radio"] + div {
      width: 200%;
      margin-left: 200%; }
    .tabs .tab-2 [type="radio"]:checked + div {
      margin-left: 0; }
    .tabs .tab-2:last-child [type="radio"] + div {
      margin-left: 100%; }
    .tabs .tab-2:last-child [type="radio"]:checked + div {
      margin-left: -100%; }
</style>
</head>
<body data-rsssl=1 class="home blog">
  <input type="hidden" id="username" value="<?=get_session()?>">
  <input type="hidden" id="ip" value="<?=get_client_ip()?>">

 

  <!-- top logo add line for mobile 
  <div class="tt-l tt-full head_mc">
    <div class="tt_l h-linem">
      <a href="<?=$_CONFIG['urlline']?>" target="_blank">
        <img src="<?=base_url()?>/images/qr-line/button-lineadd.jpg"/>
      </a>
    </div>
  </div>-->
  <!-- top logo add line for mobile -->

  <!-- top-menu -->
  <?php include("partials/_top-menu.php"); ?>
  <!-- top-menu -->

  <!-- slide -->
  <?php include("partials/_slide.php"); ?>
  <!-- slide -->

  <div class="wrapper">
    <div class="tt_l tt_full p_gl">
      <div id="ct_from" class="tt_l tt_full title_page">
        <h1>ฝากเงิน</h1>
      </div>

      <div class="tt_l tt_full tt_content bg">
        <div class="tt_l tt_full">
          <div class="tt_l tt_full fr_login">
            <div class="fr_center">
              <div class="tabs">
                <div class="tab-2">
                  <label for="tab2-1"><img src="<?=base_url()?>/images/bank-transfer.png" width="35"> ฝากธนาคาร</label>
                  <input id="tab2-1" name="tabs-two" type="radio" checked="checked">
                <div>
                <div class="tt_l tt_full deposit-head">
                  <h2 class="mt-2" style="margin-bottom: 25px;">บัญชีธนาคารสำหรับฝากเงิน</h2>
                </div>
			  

              <?php
              $autobank_tb = dd_q("SELECT * FROM autobank_tb WHERE a_bank_status='1' AND a_bank_code = 'scb'");
              while($row = $autobank_tb->fetch(PDO::FETCH_ASSOC))
              {
              ?>
              <?php
                $userbank_tb = dd_q('SELECT * FROM user_tb WHERE (u_user = ?)', [get_session()]);
                $row_userbank = $userbank_tb->fetch(PDO::FETCH_ASSOC);
              ?>
              <div class="tt_l tt_full deposit-head boxbanknew warp-up">
              	 <table style="margin: auto;">
                  <tr>
                    <td ><img style="vertical-align: sub;" src="theme-login/images/bank/<?php echo $row_userbank['u_bank_code'];?>.svg"></td>
                    <td style="padding-left: 20px;"><a class="tt_l tt_full" style="color:#fff; font-size: clamp(20px, 2.5vw, 28px);"><?=get_wallet("u_bank_name")?></a>
                        <a class="tt_l tt_full" style="color:#adadad; font-size: clamp(18px, 2.5vw, 20px);"><?=get_wallet("u_fname")?></a>
                        <a class="tt_l tt_full" style="color:#adadad; font-size: clamp(18px, 2.5vw, 20px);"><?=get_wallet("u_bank_number")?></a></td>
                  </tr>
                  
                  <tr>
                    <td><div align="center"><img style="padding-bottom: 5px; padding-top: 5px;" src="images/deposit-1.png" width="50" height="100" /></div></td>
                    <td>&nbsp;</td>
                  </tr>
                  
                  <tr>
                    <td><img style="vertical-align: sub;" src="theme-login/images/bank/scb.svg"></td>
                    <td style="padding-left: 20px; vertical-align: top; color:#fff;">
                    <p class="tt_l tt_full" style="color:#fff; font-size: clamp(20px, 2.5vw, 28px);"><?=$row['a_bank_name']?></p>
                    <p class="tt_l tt_full" style="color:#adadad; font-size: clamp(18px, 2.5vw, 20px);" id="bank_name_<?=$row['a_bank_code']?>"><?=$row['a_bank_acc_name']?></p>
                    <p class="tt_l tt_full" style="color:#adadad; font-size: clamp(18px, 2.5vw, 20px);" id="bank_acc_<?=$row['a_bank_code']?>"><?=$row['a_bank_acc_number']?></p>
 
                  
                  </td>
                  </tr>
                </table>
                
                <?php
				#แสดงข้อมูล ในช่วงเวลา 5 ทุ่ม
                if(date("Y-m-d 11:i:s") == date("Y-m-d h:i:s")) {
                ?>
                	<p style="color: #ff2f2f;font-size: clamp(20px, 2.5vw, 28px); text-align: center;">ฝากช่วงเวลา 5 ทุ่ม - เที่ยงคืน แจ้งสลิปพร้อมเบอร์</p>
                <?php
                } else {
                ?> 
					<p style="color: #109700;font-size: clamp(20px, 2.5vw, 28px); text-align: center;">ฝากออโต้แปกติ</p>
          <?php 
          }
          ?>
                
              </div>

                <div class="bank-acc-info" style="margin-bottom: 25px;">
                  <button style="background:#4e2a81;" class="btn-copy blobgame bluegame active" onClick="copyToClipboard('#bank_acc_<?=$row['a_bank_code']?>')" ><i class="fa fa-copy"></i> คัดลอกเลขบัญชี</button>
                </div>
                <?php
              }
              ?>
<!-------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
              <?php
              $autobank_tb = dd_q("SELECT * FROM autobank_tb WHERE a_bank_status='1' AND a_bank_code = 'noauto'");
              while($row = $autobank_tb->fetch(PDO::FETCH_ASSOC))
              {
              ?>
              <?php
                $userbank_tb = dd_q('SELECT * FROM user_tb WHERE (u_user = ?)', [get_session()]);
                $row_userbank = $userbank_tb->fetch(PDO::FETCH_ASSOC);
              ?>

              <div class="tt_l tt_full deposit-head boxbanknew warp-up">
              	 <table style="margin: auto;">
                  <tr>
                    <td ><img style="vertical-align: sub;" src="theme-login/images/bank/<?php echo $row_userbank['u_bank_code'];?>.svg"></td>
                    <td style="padding-left: 20px;"><a class="tt_l tt_full" style="color:#fff; font-size: clamp(20px, 2.5vw, 28px);"><?=get_wallet("u_bank_name")?></a>
                        <a class="tt_l tt_full" style="color:#adadad; font-size: clamp(18px, 2.5vw, 20px);"><?=get_wallet("u_fname")?></a>
                        <a class="tt_l tt_full" style="color:#adadad; font-size: clamp(18px, 2.5vw, 20px);"><?=get_wallet("u_bank_number")?></a></td>
                  </tr>
                  
                  <tr>
                    <td><div align="center"><img style="padding-bottom: 5px; padding-top: 5px;" src="images/deposit-1.png" width="50" height="100" /></div></td>
                    <td>&nbsp;</td>
                  </tr>
                  
                  <tr>
                    <td><img style="vertical-align: sub;" src="theme-login/images/bank/<?php echo $row['a_bank_acc_name_eng'];?>.svg"></td>
                    <td style="padding-left: 20px; vertical-align: top; color:#fff;">
                    <p class="tt_l tt_full" style="color:#fff; font-size: clamp(20px, 2.5vw, 28px);"><?=$row['a_bank_name']?></p>
                    <p class="tt_l tt_full" style="color:#adadad; font-size: clamp(18px, 2.5vw, 20px);" id="bank_name_<?=$row['a_bank_code']?>"><?=$row['a_bank_acc_name']?></p>
                    <p class="tt_l tt_full" style="color:#adadad; font-size: clamp(18px, 2.5vw, 20px);" id="bank_acc_<?=$row['a_bank_code']?>"><?=$row['a_bank_acc_number']?></p>
 
                  
                  </td>
                  </tr>
                </table>
                
                <p style="color: #ff2f2f;font-size: clamp(20px, 2.5vw, 28px); text-align: center;">ฝากบัญชีนี้แจ้งสลิปทุกครั้ง!!</p>
              </div>

                <div class="bank-acc-info" style="margin-bottom: 25px;">
                  <button style="background:#4e2a81;" class="btn-copy blobgame bluegame active" onClick="copyToClipboard('#bank_acc_<?=$row['a_bank_code']?>')" ><i class="fa fa-copy"></i> คัดลอกเลขบัญชี</button>
                </div>
                <?php
              }
              ?>

              <!-- new scb slip 2021-10-16 -->
              <?php
              $autobank_tb = dd_q("SELECT * FROM autobank_tb WHERE a_bank_status='1' AND a_bank_code = 'scbslip'");
              while($row = $autobank_tb->fetch(PDO::FETCH_ASSOC))
              {
              ?>
                <div class="tt_l tt_full deposit-head">
                  <h3 class="pt-1"><p>ฝากแบบเช็คสลิป</h3>
                </div>
                <div class="bank-box scb-box">
                  <img style="width: 250px;" src="./themes/v2/images/scb-logo.png">
                </div>

                <div class="bank-acc-info">
                  <div class="w50 bdr">
                    <p style="color:#CCCCCC; font-size:16px;">เลขบัญชี</p>
                    <p id="bank_acc_<?=$row['a_bank_code']?>"><?=$row['a_bank_acc_number']?></p>
                  </div>
                  <div class="w50">
                    <p style="color:#CCCCCC; font-size:16px;">ชื่อบัญชี</p>
                    <p id="bank_name_<?=$row['a_bank_code']?>"><?=$row['a_bank_acc_name']?></p>
                  </div>
                </div>

                <div class="bank-acc-info">
                  <button class="btn-copy" onClick="copyToClipboard('#bank_acc_<?=$row['a_bank_code']?>')" ><i class="fa fa-copy"></i> คัดลอกเลขบัญชี</button>
                </div>
				
				<form name="form" id="file-upload-form" method="POST" enctype="multipart/form-data" class="uploader">
                  <input id="file-upload" type="file" name="image_slip" accept="image/*" />
                  <br>
                  <label for="file-upload" id="file-drag">
                    <img id="file-image" src="#" alt="Preview" class="hidden">
                    <div id="start">
                      <i class="fa fa-download" aria-hidden="true"></i>
                      <div>อัพโหลดสลิปที่นี่เพื่อทำรายการฝาก</div>
                      <div id="notimage" class="hidden">Please select an image</div>
                      <span id="file-upload-btn" class="btn btn-primary"><i class="fal fa-images"></i> อัพโหลดสลิป</span>
                    </div>
                    <div id="response" class="hidden">
                      <div id="messages"></div>
                      <progress class="progress" id="file-progress" value="0">
                        <span>0</span>%
                      </progress>
                      <button type="submit" name="btnUpload" class="tt_l tt_ful fr_submit_bk">
                      <i class="fad fa-wallet"></i> อัพโหลดสลิป
                    </button>
                    </div>
                  </label>
                </form>
 
                <?php
                if(isset($_REQUEST['btnUpload']))
                {
                  $_deviceid = $row['a_bank_username'];
                  $_pin = $row['a_bank_password'];
                  $_acc_num = str_replace("-", "", $row['a_bank_acc_number']);

                  $path = "img-slip/";
                  $type = explode("/", $_FILES['image_slip']['type']);
                  if ($type[0] == "image")
                  {
                    try
                    {
                      $qrcode = new QrReader($_FILES["image_slip"]["tmp_name"]);
                      $text = $qrcode->text();
                      $apiSCB = new SCB($_deviceid, $_pin, $_acc_num);
                      $dataLogin = $apiSCB->login();
                      if ($dataLogin->success == true)
                      {
                        $data = $apiSCB->qr_scan($text);

                        if(!empty($data) && !is_null($data))
                        {
                          if(array_key_exists('data', $data))
                          {
                            if(array_key_exists('pullSlip', $data['data']))
                            {
                              if(array_key_exists('receiver', $data['data']['pullSlip']))
                              {
                                if(array_key_exists('name', $data['data']['pullSlip']['receiver']))
                                {
                                  $check = $data['data']['pullSlip']['receiver']['name'];
                                }
                                else
                                {
                                  $check = "";
                                }
                              }
                              else
                              {
                                $check = "";
                              }
                            }
                            else
                            {
                              $check = "";
                            }
                          }
                          else
                          {
                            $check = "";
                          }
                        }
                        else
                        {
                          $check = "";
                        }

                        //if ($check != "" && strpos($check, $row['a_bank_acc_name']) !== false && strpos($check, $row['a_bank_acc_name_eng']) !== false)
						if ($check != "" && (strpos($check, $row['a_bank_acc_name']) !== false || strpos($check, $row['a_bank_acc_name_eng']) !== false))
                        {
                          $u_id = get_wallet("u_id");
                          $u_user = get_wallet("u_user");
                          $u_agent_id = get_wallet("u_agent_id");
                          $u_fname = get_wallet("u_fname");
                          $u_lname = get_wallet("u_lname");
                          $u_bank_code = get_wallet("u_bank_code");
                          $u_bank_number = get_wallet("u_bank_number");
                          $u_bank_name = get_wallet("u_bank_name");
                          $u_aff = get_wallet("u_aff");

                          $t_topup_bank = $data['data']['pullSlip']['transRef'];
                          $t_tx_id = $data['data']['pullSlip']['transRef'];
                          $t_amount = $data['data']['amount'];

                          $date = date_create($data['data']['pullSlip']['dateTime']);
                          $date = date_format($date,"Y/m/d H:i:s");
                          $txnDateTime = new DateTime($date);
                          $t_date_create = $txnDateTime->format('Y-m-d');
                          $t_time_create = $txnDateTime->format('H:i:s');
                          $t_create_date = $txnDateTime->format('Y-m-d H:i:s');

                          $q_t = dd_q('SELECT * FROM topup_db WHERE t_tx_id = ?', [$t_tx_id]);
                          if ($q_t->rowCount() == 0)
                          {
                            if(!empty($u_agent_id))
                            {
                              $_GetUserCredit = $api->getUserCredit($u_agent_id);
                              if ($_GetUserCredit->success == true)
                              {
                                $deposit = $api->transferCreditTo($u_agent_id, str_replace(",","",number_format($t_amount, 2, '.', '')));
                                if ($deposit->success == true)
                                {
                                  $deposit = json_decode(json_encode($deposit->data), true);
                                  $ExternalTransactionId = $deposit['ref'];

                                  // 2022/01/10
                                  // === เช็ค outstanding ยอดล่าสุด ===
                                  $sum_outstanding = 0;
                                  $q_trans = dd_q('SELECT * FROM transfergame_tb WHERE t_user = ? AND t_transaction_id != ? ORDER BY t_id DESC LIMIT 1', [
                                    $u_user,
                                    ""
                                  ]);
                                  if ($q_trans->rowCount() > 0)
                                  {
                                    $row_trans = $q_trans->fetch(PDO::FETCH_ASSOC);
                                    $outs = $api->GetWinLose($u_agent_id, $row_trans['t_transaction_id']);
                                    if ($outs->success == true)
                                    {
                                      $outs = json_decode(json_encode($outs->data), true);
                                      foreach ($outs["data"] as $val)
                                      {
                                        $sum_outstanding = $sum_outstanding + ($val['outstanding']);
                                      }
                                    }
                                  }

                                  $q_top = dd_q('SELECT * FROM topup_db WHERE t_user = ? AND t_transaction_id != ? AND t_status = ? ORDER BY t_id DESC LIMIT 1', [
                                    $u_user,
                                    "",
                                    "1"
                                  ]);
                                  if ($q_top->rowCount() > 0)
                                  {
                                    $row_top = $q_top->fetch(PDO::FETCH_ASSOC);
                                    $outs = $api->GetWinLose($u_agent_id, $row_top['t_transaction_id']);
                                    if ($outs->success == true)
                                    {
                                      $outs = json_decode(json_encode($outs->data), true);
                                      foreach ($outs["data"] as $val)
                                      {
                                        $sum_outstanding = $sum_outstanding + ($val['outstanding']);
                                      }
                                    }
                                  }
                                  // === เช็ค outstanding ยอดล่าสุด ===

                                  $isResetPromotion = true;
                                  $_GetUserCredit = json_decode(json_encode($_GetUserCredit->data), true);

                                  if($sum_outstanding != 0)
                                  {
                                    $isResetPromotion = false;
                                    write_log("SCB Topup Slip ไม่รีโปร", $u_user." ไม่รีโปรเนื่องจาก outstanding = ".$sum_outstanding, get_client_ip());
                                  }
                                  else if($_GetUserCredit['credit'] > 5)
                                  {
                                    $isResetPromotion = false;
                                    write_log("SCB Topup Slip ไม่รีโปร", $u_user." ไม่รีโปรเนื่องจากเครดิตคงเหลือ = ".$_GetUserCredit['credit'], get_client_ip());
                                  }

                                  if(!$isResetPromotion) //ไม่รีโปร
                                  {
                                    $q_insert_t = dd_q('INSERT INTO topup_db (t_u_id, t_user, t_agent_id, t_fname, t_topup_bank, t_tx_id, t_amount, t_bank_code, t_bank_number, t_bank_name, t_sys_bank_code, t_sys_bank_name, t_sys_bank_number, t_action_by, t_create_date, t_date_create, t_time_create, t_status, t_type, t_before_wallet, t_after_wallet, t_type_system, t_system_create_date, t_system_create_time, t_transaction_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
                                      $u_id, 
                                      $u_user, 
                                      $u_agent_id, 
                                      $u_fname." ".$u_lname, 
                                      $t_topup_bank, 
                                      $t_tx_id, 
                                      $t_amount, 
                                      $u_bank_code, 
                                      $u_bank_number, 
                                      $u_bank_name, 
                                      $row['a_bank_code'], 
                                      $row['a_bank_name'], 
                                      $row['a_bank_acc_number'], 
                                      'System', 
                                      $t_create_date,
                                      $t_date_create, 
                                      $t_time_create, 
                                      '1', 
                                      '1', 
                                      $deposit['before'], 
                                      $deposit['after'], 
                                      "scb",
                                      date("Y-m-d"),
                                      date('H:i:s'),
                                      $ExternalTransactionId
                                    ]);
                                    if($q_insert_t == true)
                                    {
                                      $q_update_u = dd_q('UPDATE user_tb SET u_vip=? WHERE u_id=?', [
                                        'Vip', 
                                        $u_id
                                      ]);
                                      if($q_update_u == true)
                                      {
                                        //% แนะนำเพื่อน
                                        if(!empty($u_aff))
                                        {
                                          if($row_website['aff_type'] == "1") //ฝากแรกของเพื่อน
                                          {
                                            $q_t_aff = dd_q('SELECT * FROM topup_db WHERE t_user = ?', [$u_user]);
                                            if ($q_t_aff->rowCount() == 1)
                                            {
                                              if($row_website['aff_step'] >= 1)
                                              {
                                                $aff_percent = $t_amount * $row_website['affpersen'];
                                                dd_q('INSERT INTO aff_percent_tb (aff_u_user_ref, aff_user, aff_first_topup, aff_amount, aff_status, aff_step, aff_create_date, aff_create_time) VALUES (?, ?, ?, ?, ?, ?, ?, ?)', [
                                                  $u_aff, 
                                                  $u_user, 
                                                   $t_amount, 
                                                  $aff_percent, 
                                                  '0',
                                                  1, 
                                                  date("Y-m-d"),
                                                  date('H:i:s')
                                                ]);
                                              }
                                              if($row_website['aff_step'] >= 2)
                                              {
                                                $q_u2 = dd_q('SELECT * FROM user_tb WHERE u_user = ?', [
                                                  $u_aff
                                                ]);
                                                if ($q_u2->rowCount() > 0)
                                                {
                                                  $row_u2 = $q_u2->fetch(PDO::FETCH_ASSOC);
                                                  if(!empty($row_u2['u_aff']))
                                                  {
                                                    $aff_percent2 = $t_amount * $row_website['affpersen2'];
                                                    dd_q('INSERT INTO aff_percent_tb (aff_u_user_ref, aff_user, aff_first_topup, aff_amount, aff_status, aff_step, aff_create_date, aff_create_time) VALUES (?, ?, ?, ?, ?, ?, ?, ?)', [
                                                      $row_u2['u_aff'], 
                                                      $u_user, 
                                                      $t_amount, 
                                                      $aff_percent2, 
                                                      '0',
                                                      2, 
                                                      date("Y-m-d"),
                                                      date('H:i:s')
                                                    ]);
                                                  }
                                                }
                                              }
                                              if($row_website['aff_step'] == 3)
                                              {
                                                $q_u2 = dd_q('SELECT * FROM user_tb WHERE u_user = ?', [
                                                  $u_aff
                                                ]);
                                                if ($q_u2->rowCount() > 0)
                                                {
                                                  $row_u2 = $q_u2->fetch(PDO::FETCH_ASSOC);
                                                  if(!empty($row_u2['u_aff']))
                                                  {
                                                    $q_u3 = dd_q('SELECT * FROM user_tb WHERE u_user = ?', [
                                                      $row_u2['u_aff']
                                                    ]);
                                                    if ($q_u3->rowCount() > 0)
                                                    {
                                                      $row_u3 = $q_u3->fetch(PDO::FETCH_ASSOC);
                                                      if(!empty($row_u3['u_aff']))
                                                      {
                                                        $aff_percent3 = $t_amount * $row_website['affpersen3'];
                                                        dd_q('INSERT INTO aff_percent_tb (aff_u_user_ref, aff_user, aff_first_topup, aff_amount, aff_status, aff_step, aff_create_date, aff_create_time) VALUES (?, ?, ?, ?, ?, ?, ?, ?)', [
                                                          $row_u3['u_aff'], 
                                                          $u_user, 
                                                          $t_amount, 
                                                          $aff_percent3, 
                                                          '0',
                                                          3, 
                                                          date("Y-m-d"),
                                                          date('H:i:s')
                                                        ]);
                                                      }
                                                    }
                                                  }
                                                }
                                              }
                                            }
                                          }
                                          else if($row_website['aff_type'] == "2")  //ทุกยอดฝาก
                                          {
                                            if($row_website['aff_step'] >= 1)
                                            {
                                              $aff_percent = $t_amount * $row_website['affpersen'];
                                              dd_q('INSERT INTO aff_percent_tb (aff_u_user_ref, aff_user, aff_first_topup, aff_amount, aff_status, aff_step, aff_create_date, aff_create_time) VALUES (?, ?, ?, ?, ?, ?, ?, ?)', [
                                                $u_aff, 
                                                $u_user, 
                                                $t_amount, 
                                                $aff_percent, 
                                                '0',
                                                1, 
                                                date("Y-m-d"),
                                                date('H:i:s')
                                              ]);
                                            }
                                            if($row_website['aff_step'] >= 2)
                                            {
                                              $q_u2 = dd_q('SELECT * FROM user_tb WHERE u_user = ?', [
                                                $u_aff
                                              ]);
                                              if ($q_u2->rowCount() > 0)
                                              {
                                                $row_u2 = $q_u2->fetch(PDO::FETCH_ASSOC);
                                                if(!empty($row_u2['u_aff']))
                                                {
                                                  $aff_percent2 = $t_amount * $row_website['affpersen2'];
                                                  dd_q('INSERT INTO aff_percent_tb (aff_u_user_ref, aff_user, aff_first_topup, aff_amount, aff_status, aff_step, aff_create_date, aff_create_time) VALUES (?, ?, ?, ?, ?, ?, ?, ?)', [
                                                    $row_u2['u_aff'], 
                                                    $u_user, 
                                                    $t_amount, 
                                                    $aff_percent2, 
                                                    '0',
                                                    2, 
                                                    date("Y-m-d"),
                                                    date('H:i:s')
                                                  ]);
                                                }
                                              }
                                            }
                                            if($row_website['aff_step'] == 3)
                                            {
                                              $q_u2 = dd_q('SELECT * FROM user_tb WHERE u_user = ?', [
                                                $u_aff
                                              ]);
                                              if ($q_u2->rowCount() > 0)
                                              {
                                                $row_u2 = $q_u2->fetch(PDO::FETCH_ASSOC);
                                                if(!empty($row_u2['u_aff']))
                                                {
                                                  $q_u3 = dd_q('SELECT * FROM user_tb WHERE u_user = ?', [
                                                    $row_u2['u_aff']
                                                  ]);
                                                  if ($q_u3->rowCount() > 0)
                                                  {
                                                    $row_u3 = $q_u3->fetch(PDO::FETCH_ASSOC);
                                                    if(!empty($row_u3['u_aff']))
                                                    {
                                                      $aff_percent3 = $t_amount * $row_website['affpersen3'];
                                                      dd_q('INSERT INTO aff_percent_tb (aff_u_user_ref, aff_user, aff_first_topup, aff_amount, aff_status, aff_step, aff_create_date, aff_create_time) VALUES (?, ?, ?, ?, ?, ?, ?, ?)', [
                                                        $row_u3['u_aff'], 
                                                        $u_user, 
                                                        $t_amount, 
                                                        $aff_percent3, 
                                                        '0',
                                                        3, 
                                                        date("Y-m-d"),
                                                        date('H:i:s')
                                                      ]);
                                                    }
                                                  }
                                                }
                                              }
                                            }
                                          }
                                        }
                                        $msg_alert = "เติมเงินสำเร็จ คุณได้รับเครดิต จำนวน: ".number_format($t_amount, 2, '.', ',')." เครดิต";
                                        ?>
                                        <script type="text/javascript">
                                          Swal.fire({
                                            type: 'success',
                                            title: 'สำเร็จ',
                                            text: '<?=$msg_alert?>',
                                          }).then((result) => {
                                            window.location = './wallet';
                                          });
                                        </script>
                                        <?php
                                        notify_message($u_user." เติมเงินผ่าน SCB SLIP แบบไม่รีโปร ".number_format($t_amount,2,',','.')." บาท", $row_website['linewallet']);
                                      }
                                    }
                                  }
                                  else //รีโปร
                                  {
                                    dd_q('UPDATE transfergame_tb SET t_active=? WHERE t_user=?', [
                                      "N", 
                                      $u_user
                                    ]);

                                    $q_insert_t = dd_q('INSERT INTO topup_db (t_u_id, t_user, t_agent_id, t_fname, t_topup_bank, t_tx_id, t_amount, t_bank_code, t_bank_number, t_bank_name, t_sys_bank_code, t_sys_bank_name, t_sys_bank_number, t_action_by, t_create_date, t_date_create, t_time_create, t_status, t_type, t_before_wallet, t_after_wallet, t_type_system, t_system_create_date, t_system_create_time, t_transaction_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
                                      $u_id, 
                                      $u_user, 
                                      $u_agent_id, 
                                      $u_fname." ".$u_lname, 
                                      $t_topup_bank, 
                                      $t_tx_id, 
                                      $t_amount, 
                                      $u_bank_code, 
                                      $u_bank_number, 
                                      $u_bank_name, 
                                      $row['a_bank_code'], 
                                      $row['a_bank_name'], 
                                      $row['a_bank_acc_number'], 
                                      'System', 
                                      $t_create_date,
                                      $t_date_create, 
                                      $t_time_create, 
                                      '1', 
                                      '1', 
                                      $deposit['before'], 
                                      $deposit['after'], 
                                      "scb",
                                      date("Y-m-d"),
                                      date('H:i:s'),
                                      $ExternalTransactionId
                                    ]);
                                    if($q_insert_t == true)
                                    {
                                      $q_update_u = dd_q('UPDATE user_tb SET u_vip=? WHERE u_id=?', [
                                        'Vip', 
                                        $u_id
                                      ]);
                                      if($q_update_u == true)
                                      {
                                        //% แนะนำเพื่อน
                                        if(!empty($u_aff))
                                        {
                                          if($row_website['aff_type'] == "1") //ฝากแรกของเพื่อน
                                          {
                                            $q_t_aff = dd_q('SELECT * FROM topup_db WHERE t_user = ?', [$u_user]);
                                            if ($q_t_aff->rowCount() == 1)
                                            {
                                              if($row_website['aff_step'] >= 1)
                                              {
                                                $aff_percent = $t_amount * $row_website['affpersen'];
                                                dd_q('INSERT INTO aff_percent_tb (aff_u_user_ref, aff_user, aff_first_topup, aff_amount, aff_status, aff_step, aff_create_date, aff_create_time) VALUES (?, ?, ?, ?, ?, ?, ?, ?)', [
                                                  $u_aff, 
                                                  $u_user, 
                                                  $t_amount, 
                                                  $aff_percent, 
                                                  '0',
                                                  1, 
                                                  date("Y-m-d"),
                                                  date('H:i:s')
                                                ]);
                                              }
                                              if($row_website['aff_step'] >= 2)
                                              {
                                                $q_u2 = dd_q('SELECT * FROM user_tb WHERE u_user = ?', [
                                                  $u_aff
                                                ]);
                                                if ($q_u2->rowCount() > 0)
                                                {
                                                  $row_u2 = $q_u2->fetch(PDO::FETCH_ASSOC);
                                                  if(!empty($row_u2['u_aff']))
                                                  {
                                                    $aff_percent2 = $t_amount * $row_website['affpersen2'];
                                                    dd_q('INSERT INTO aff_percent_tb (aff_u_user_ref, aff_user, aff_first_topup, aff_amount, aff_status, aff_step, aff_create_date, aff_create_time) VALUES (?, ?, ?, ?, ?, ?, ?, ?)', [
                                                      $row_u2['u_aff'], 
                                                      $u_user, 
                                                      $t_amount, 
                                                      $aff_percent2, 
                                                      '0',
                                                      2, 
                                                      date("Y-m-d"),
                                                      date('H:i:s')
                                                    ]);
                                                  }
                                                }
                                              }
                                              if($row_website['aff_step'] == 3)
                                              {
                                                $q_u2 = dd_q('SELECT * FROM user_tb WHERE u_user = ?', [
                                                  $u_aff
                                                ]);
                                                if ($q_u2->rowCount() > 0)
                                                {
                                                  $row_u2 = $q_u2->fetch(PDO::FETCH_ASSOC);
                                                  if(!empty($row_u2['u_aff']))
                                                  {
                                                    $q_u3 = dd_q('SELECT * FROM user_tb WHERE u_user = ?', [
                                                      $row_u2['u_aff']
                                                    ]);
                                                    if ($q_u3->rowCount() > 0)
                                                    {
                                                      $row_u3 = $q_u3->fetch(PDO::FETCH_ASSOC);
                                                      if(!empty($row_u3['u_aff']))
                                                      {
                                                        $aff_percent3 = $t_amount * $row_website['affpersen3'];
                                                        dd_q('INSERT INTO aff_percent_tb (aff_u_user_ref, aff_user, aff_first_topup, aff_amount, aff_status, aff_step, aff_create_date, aff_create_time) VALUES (?, ?, ?, ?, ?, ?, ?, ?)', [
                                                          $row_u3['u_aff'], 
                                                          $u_user, 
                                                          $t_amount, 
                                                          $aff_percent3, 
                                                          '0',
                                                          3, 
                                                          date("Y-m-d"),
                                                          date('H:i:s')
                                                        ]);
                                                      }
                                                    }
                                                  }
                                                }
                                              }
                                            }
                                          }
                                          else if($row_website['aff_type'] == "2")  //ทุกยอดฝาก
                                          {
                                            if($row_website['aff_step'] >= 1)
                                            {
                                              $aff_percent = $t_amount * $row_website['affpersen'];
                                              dd_q('INSERT INTO aff_percent_tb (aff_u_user_ref, aff_user, aff_first_topup, aff_amount, aff_status, aff_step, aff_create_date, aff_create_time) VALUES (?, ?, ?, ?, ?, ?, ?, ?)', [
                                                $u_aff, 
                                                $u_user, 
                                                $t_amount, 
                                                $aff_percent, 
                                                '0',
                                                1, 
                                                date("Y-m-d"),
                                                date('H:i:s')
                                              ]);
                                            }
                                            if($row_website['aff_step'] >= 2)
                                            {
                                              $q_u2 = dd_q('SELECT * FROM user_tb WHERE u_user = ?', [
                                                $u_aff
                                              ]);
                                              if ($q_u2->rowCount() > 0)
                                              {
                                                $row_u2 = $q_u2->fetch(PDO::FETCH_ASSOC);
                                                if(!empty($row_u2['u_aff']))
                                                {
                                                  $aff_percent2 = $t_amount * $row_website['affpersen2'];
                                                  dd_q('INSERT INTO aff_percent_tb (aff_u_user_ref, aff_user, aff_first_topup, aff_amount, aff_status, aff_step, aff_create_date, aff_create_time) VALUES (?, ?, ?, ?, ?, ?, ?, ?)', [
                                                    $row_u2['u_aff'], 
                                                    $u_user, 
                                                    $t_amount, 
                                                    $aff_percent2, 
                                                    '0',
                                                    2, 
                                                    date("Y-m-d"),
                                                    date('H:i:s')
                                                  ]);
                                                }
                                              }
                                            }
                                            if($row_website['aff_step'] == 3)
                                            {
                                              $q_u2 = dd_q('SELECT * FROM user_tb WHERE u_user = ?', [
                                                $u_aff
                                              ]);
                                              if ($q_u2->rowCount() > 0)
                                              {
                                                $row_u2 = $q_u2->fetch(PDO::FETCH_ASSOC);
                                                if(!empty($row_u2['u_aff']))
                                                {
                                                  $q_u3 = dd_q('SELECT * FROM user_tb WHERE u_user = ?', [
                                                    $row_u2['u_aff']
                                                  ]);
                                                  if ($q_u3->rowCount() > 0)
                                                  {
                                                    $row_u3 = $q_u3->fetch(PDO::FETCH_ASSOC);
                                                    if(!empty($row_u3['u_aff']))
                                                    {
                                                      $aff_percent3 = $t_amount * $row_website['affpersen3'];
                                                      dd_q('INSERT INTO aff_percent_tb (aff_u_user_ref, aff_user, aff_first_topup, aff_amount, aff_status, aff_step, aff_create_date, aff_create_time) VALUES (?, ?, ?, ?, ?, ?, ?, ?)', [
                                                        $row_u3['u_aff'], 
                                                        $u_user, 
                                                        $t_amount, 
                                                        $aff_percent3, 
                                                        '0',
                                                        3, 
                                                        date("Y-m-d"),
                                                        date('H:i:s')
                                                      ]);
                                                    }
                                                  }
                                                }
                                              }
                                            }
                                          }
                                        }
                                        $msg_alert = "เติมเงินสำเร็จ คุณได้รับเครดิต จำนวน: ".number_format($t_amount, 2, '.', ',')." เครดิต";
                                        ?>
                                        <script type="text/javascript">
                                          Swal.fire({
                                            type: 'success',
                                            title: 'สำเร็จ',
                                            text: '<?=$msg_alert?>',
                                          }).then((result) => {
                                            window.location = './wallet';
                                          });
                                        </script>
                                        <?php
                                        notify_message($u_user." เติมเงินผ่าน SCB SLIP แบบรีโปร ".number_format($t_amount,2,',','.')." บาท", $row_website['linewallet']);
                                      }
                                    }
                                  }
                                }
                                else
                                {
                                  write_log("เติมเงิน scb slip", get_wallet("u_user")." - ".json_encode($deposit->message), get_client_ip());
                                ?>
                                <script type="text/javascript">
                                  Swal.fire({
                                    type: 'error',
                                    title: 'ผิดพลาด',
                                    text: '<?=$deposit->message?>',
                                  }).then((result) => {
                                    window.location = './wallet';
                                  });
                                </script>
                                <?php
                                }
                              }
                              else
                              {
                                write_log("เติมเงิน scb slip", json_encode($_GetUserCredit), get_client_ip());
                              ?>
                              <script type="text/javascript">
                                Swal.fire({
                                  type: 'error',
                                  title: 'ผิดพลาด',
                                  text: 'ไม่สามารถดึงข้อมูลเครดิตได้ กรุณาลองใหม่อีกครั้ง',
                                }).then((result) => {
                                    window.location = './deposit';
                                });
                              </script>
                              <?php
                              }
                            }
                            else
                            {
                            ?>
                            <script type="text/javascript">
                              Swal.fire({
                                type: 'error',
                                title: 'ผิดพลาด',
                                text: 'รหัสเข้าเกมยังไม่ถูกสร้าง กรุณาติดต่อแอดมิน',
                              }).then((result) => {
                                  window.location = './deposit';
                              });
                            </script>
                            <?php
                            }
                          }
                          else
                          {
                          ?>
                          <script type="text/javascript">
                            Swal.fire({
                              type: 'error',
                              title: 'ผิดพลาด',
                              text: 'สลิปนี้ถูกใช้งานไปแล้ว',
                            }).then((result) => {
                                window.location = './deposit';
                            });
                          </script>
                          <?php
                          }
                        }
                        else
                        {
                          write_log("เติมเงิน scb slip ผู้รับเงินไม่ตรงกับที่ระบบกำหนดไว้", get_wallet("u_user")." - ".json_encode($data, JSON_UNESCAPED_UNICODE), get_client_ip());
                          if($check != "")
                          {
                          ?>
                          <script type="text/javascript">
                            Swal.fire({
                              type: 'error',
                              title: 'ผิดพลาด',
                              text: 'ผู้รับเงินไม่ตรงกับที่ระบบกำหนดไว้',
                            }).then((result) => {
                                window.location = './deposit';
                            });
                          </script>
                          <?php
                          }
                          else
                          {
                          ?>
                          <script type="text/javascript">
                            Swal.fire({
                              type: 'error',
                              title: 'ผิดพลาด',
                              text: '<?=json_encode($data, JSON_UNESCAPED_UNICODE)?>',
                            }).then((result) => {
                                window.location = './deposit';
                            });
                          </script>
                          <?php
                          }
                        }
                      }
                      else
                      {
                      ?>
                      <script type="text/javascript">
                        Swal.fire({
                          type: 'error',
                          title: 'ผิดพลาด',
                          text: '<?=$dataLogin->message?>',
                        }).then((result) => {
                            window.location = './deposit';
                        });
                      </script>
                      <?php
                      }
                    }
                    catch(Exception $e)
                    {
                    ?>
                    <script type="text/javascript">
                      Swal.fire({
                        type: 'error',
                        title: 'ผิดพลาด',
                        text: '<?=$e->getMessage()?>',
                      }).then((result) => {
                        window.location = './deposit';
                      });
                    </script>
                    <?php
                    }
                  }
                  else
                  {
                  ?>
                  <script type="text/javascript">
                    Swal.fire({
                      type: 'error',
                      title: 'ผิดพลาด',
                      text: 'อัพโหลดได้เฉพาะรูปภาพเท่านั้น',
                    }).then((result) => {
                        window.location = './deposit';
                    });
                  </script>
                  <?php
                  }
                }
              }

              $autobank_tb = dd_q("SELECT * FROM autobank_tb WHERE a_bank_status='0' AND a_bank_code = 'scbslip'");
              while($row = $autobank_tb->fetch(PDO::FETCH_ASSOC))
              {
              ?>
              <!--<div class="tt_l tt_full deposit-head">
              <h3 class="pt-1"><p>เนื่องจาก ธนาคาร มีปัญหาจึงปิดระบบฝากแบบธนาคาร ชั่วคราว</p> ให้ฝากแบบ ทรูมันนี่ วอลเลตแทน</h3>
              </div>-->
              <?php
              }
              ?>
              <!-- new scb slip 2021-10-16 -->

              <div class="danger-a">
                <a style="color:#CCCCCC; font-size:16px;">ชื่อบัญชีฝากต้องตรงกับบัญชีถอน ไม่เช่นนั้นจะถอนเงินไม่ได้</a>
                <a style="color:#CCCCCC; font-size:16px;">(ระบบจะจับคู่ยอดเงินเครดิตเข้าบัญชีท่านอัติโนมัติ)</a>
              </div>
 

              <div class="depositList" style="text-align: center;">
                <div class="w50">
                  <a class="timerange"><i class="fa fa-check" aria-hidden="true"></i> ฟรีค่าทำเนียมการโอนเงินทุกธนาคาร</a>
                </div>
                <div class="w50">
                  <a class="feefree"><i class="fa fa-times" aria-hidden="true"></i> หลีกกลี่ยงการฝากเงินในช่วงเวลา 23.30-00.30</a>
                </div>
                 
              </div>
      </div>
    </div>

                <!-- True Wallet -->
                  <div class="tab-2">
                    <label for="tab2-2"><img src="<?=base_url()?>/images/twm.png" width="35"> ทรูวอลเลต</label>
                    <input id="tab2-2" name="tabs-two" type="radio">
                  <div>
                    <div class="depositList" style="text-align: center;">
                      <div style=" padding-top:20px; display: inline-grid;">
                        <div class="tt_l tt_full deposit-head">
                          <h2 class="mt-2" style="margin-bottom: 25px;">ฝาก ทรูวอลเลต ซองของขวัญ</h2>
                        </div>
                        <img style="background: white; padding: 20px; border-radius: 20px; margin: auto;" src="<?=base_url()?>/images/wallet-logo.png" width="300">
                      </div>
                    </div>
                    <form name="form">
                      <div class="form-group">
                        <p class="textlogin0" style="font-size:24px;"> กรอกลิงค์ซองของขวัญ</p>
                        <input type="text" class="tt_fr" id="txt_link" placeholder="https://gift.truemoney.com/campaign/?v=xxxxx" required>
                      </div>
                      <div class="form-group mt-2">
                        <button style="background: #f58220;" type="submit" id="btn_tmwtopup" onClick="topuptmwvoucher('<?=base_url()?>');return false;" class="tt_l tt_ful fr_submit_bk">
                          <i class="fad fa-wallet"></i> ยืนยันการเติมเงิน
                        </button>
                      </div>
                      <a href="howtowallet.php" target="_blank">
                        <h3 align="right" style="color:#CCCCCC; padding-bottom:5px; font-size:24px;">
                          <span class="fa fa-question-circle" aria-hidden="true"></span> วิธีเติมเงินกดที่นี่
                        </h3>
                      </a>
                    </form>
                  </div>
                  <!-- True Wallet -->
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- footer -->
  <?php include("partials/_footer.php"); ?>
  <!-- footer -->

</body>
</html>
<script type="text/javascript">
  function copyToClipboard(element)
  {
    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val($(element).text().replaceAll("-", "")).select();
    document.execCommand("copy");
    $temp.remove();
    Swal.fire(
	  'คัดลอกเลขบัญชี',
	  'คัดลอกเลขบัญชี  สำเร็จ',
	  'success'
	)
  }

  // var news = '!! คำเตือน !!|<a style="color: #dc3545; font-family: thaisanslite_r1; font-size: 18px;"><i class="fa fa-times" aria-hidden="true"></i> <i class="fa fa-times" aria-hidden="true"></i> เครดิตฟรี ห้ามเล่นยอดรวมกับยอดฝากเด็ดขาด กรุณาเคลียยอดเครดิตฟรีให้หมด หรือเหลือน้อยกว่า 5 เครดิต ก่อนเติมเงินเพิ่ม หากถอนเงินได้ไม่ครบ ทางทีมจะไม่รับผิดชอบใดๆทั้งสิ้น <i class="fa fa-times" aria-hidden="true"></i> <i class="fa fa-times" aria-hidden="true"></i></a>';
  // var news_imgs = '';

  // news = news.split('|');
  // var wrapper = document.createElement('div');
  // wrapper.innerHTML = news[1];

  // setTimeout(function(){
  //   swal.fire({
  //     title: news[0],
  //     text: news[1],
  //     imageUrl: news_imgs,
  //     icon: news_imgs,
  //     content: wrapper,
  //     animation: true,
  //   });
  //   $('.swal2-content').html(news[1]);
  //   $('.swal2-title').css('color','red');
  // },3000);
</script>
<script type="text/javascript" src="<?=base_url()?>/script-upslip.js"></script>