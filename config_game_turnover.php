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

  if(isset($_REQUEST['btnSave']))
  {
    $q_1 = dd_q('SELECT * FROM turnover_tb ORDER BY t_id ASC');
    while($row = $q_1->fetch(PDO::FETCH_ASSOC))
    {
      $t_active = $_POST['t_active'.$row['t_id']];
      dd_q('UPDATE turnover_tb SET t_active=? WHERE t_id=?', [
        $t_active, 
        $row['t_id']
      ]);
    }
    echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
    echo "<SCRIPT LANGUAGE='JavaScript'>
            alert('ทำรายการสำเร็จ');
            window.location = '".base_url()."/config_game_turnover';
          </SCRIPT>";
  }
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
      <section class="content-header pt-4 pb-2">
        <h1 style="font-size: 30px;" class="mb-1">ตั้งค่าเกมที่นำมาคิดยอดเทิร์น <small>(Admin only)</small></h1>
        <h5 class="text-danger">**ตั้งค่าครั้งเดียวมีผลกับทุกโปรโมชั่น ที่มีการคิดยอดเทิร์นแบบ winloss</h5>
      </section>
      <section class="content">
        <div class="col-sm-12">
            <div class="card card-outline">
              <div class="card-body box-profile">
                <div class="table-responsive">
                  <form method="POST">
                    <table class="table table-bordered table-hover" id="tb_data" style="width: 100%;">
                      <thead class="thead-light text-center">
                        <tr>
                          <th scope="col">ลำดับ</th>
                          <th scope="col">ประเภท</th>
                          <th scope="col">คิดยอดเทิร์น</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $_no = 0;
                        $q_1 = dd_q('SELECT * FROM turnover_tb ORDER BY t_id ASC');
                        while($row = $q_1->fetch(PDO::FETCH_ASSOC))
                        {
                          $_no++;
                        ?>
                        <tr>
                          <td class="text-center"><?=$_no?></td>
                          <td><?=$row['t_code']?></td>
                          <td>
                            <select class="form-control" name="t_active<?=$row['t_id']?>" required>
                              <option value="">--- กรุณาเลือก ---</option>
                              <option value="1" <?php if($row['t_active']=="1"){echo "selected";}?>>นำ winloss ค่ายนี้มาคิดเทิร์น</option>
                              <option value="0" <?php if($row['t_active']=="0"){echo "selected";}?>>ไม่นำ winloss ค่ายนี้มาคิดเทิร์น</option>
                            </select>
                          </td>
                        </tr>
                        <?php
                        }
                        ?>
                      </tbody>
                    </table>
                    <button type="submit" name="btnSave" class="btn btn-success btn-block">บันทึกข้อมูล</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
      </section>
    </div>
  </div>

</body>
<?php include('partials/_footer.php'); ?>
</html>