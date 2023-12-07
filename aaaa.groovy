<script type="text/javascript">
  toastr.options = {
    "closeButton": true,
    "debug": false,
    "newestOnTop": false,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "preventDuplicates": false,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
  }
  function ck_alert_topup()
  {
    var formData = new FormData();
    formData.append('ip', $("#ip").val());
    $.ajax({
        type: 'POST',
        url: 'https://betmix357.co/system/ck_topup',
        data:formData,
        contentType: false,
        processData: false,
    }).done(function(res) {
      for (let i = 0; i < res.message.length; i++)
      {
        setTimeout(function () {
          if(res.message[i].t_status == "1") {
            toastr.success('ระบบปรับยอดเงินให้คุณแล้ว จำนวน '+res.message[i].t_amount+' บาท', 'เติมเงินสำเร็จ');
          } else if(res.message[i].t_status == "3") {
            toastr.error('รายการเติมเงินถูกยกเลิก', 'ผิดพลาด');
          }
        }, i * 1000);
      }
    }).fail(function(jqXHR) {
      res = jqXHR.responseJSON;
      console.log(res);
    });
  }
  $(document).ready(function()
  {
      if (window.location.pathname != "" && window.location.pathname != "/#" && window.location.pathname != "/" && window.location.pathname != "/home" && window.location.pathname != "/login" && window.location.pathname != "/register" && window.location.pathname != "/promotion" && window.location.pathname != "/promotion-get" && window.location.pathname != "/promotions" && window.location.pathname != "/forgetpassword")
      {
          ck_alert_topup();
      }
  });
</script>