jQuery(document).ready(function() {
    //    // SAN PHAM CHAY O DUOI TRANG INDEX

    // menu
    jQuery("nav.primary-menu ul.sf-menu").superfish();

    // tab
    $(function() {
        $("#tabs").tabs();
    });

    jQuery(".selectmenu").selectmenu({});

    jQuery(".MyDate").datepicker({
        dateFormat: "dd-mm-yy",
        changeMonth: true,
        changeYear: true,
    });

    //  NGOAI VIEC KHAI BAO TAI DAY CON KHAI BAO TAI  CSS DE HIDE
    //  .ui-datepicker-year{ display: none;} TAI FILE admin-style.css
    jQuery(".MyDateNoYear").datepicker({
        dateFormat: "dd-mm",
        changeMonth: true,
        changeYear: false,
    });

    jQuery(".email").focusout(function(e) {
        var email = document.getElementById("txt_email");
        var filter =
            /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if (!filter.test(email.value)) {
            jQuery("#error-email").text("請輸入正確 E-mail 地址 ! ");
            email.focus;
        } else {
            jQuery("#error-email").text("");
        }
    });

    jQuery(".type-phone-more").keypress(function(event) {
        return isPhone(event, this);
    });

    function isPhone(evt, element) {
        var charCode = evt.which ? evt.which : event.keyCode;
        if (
            //(charCode != 45 || jQuery(element).val().indexOf('-') != -1) && // “-” CHECK MINUS, AND ONLY ONE.
            charCode != 45 && // “-” CHECK MINUS, AND MORE.
            (charCode != 46 || jQuery(element).val().indexOf(".") != -1) && // “.” CHECK DOT, AND ONLY ONE.
            charCode != 8 && // “.” CHECK DOT, AND ONLY ONE.
            (charCode < 48 || charCode > 57)
        )
            return false;
        return true;
    }

    //   / gioi han ly tu nhap vao   THE SCRIPT THAT CHECKS IF THE KEY PRESSED IS A NUMERIC OR DECIMAL VALUE.
    jQuery(".type-phone").keypress(function(event) {
        return isPhone(event, this);
    });

    function isPhone(evt, element) {
        var charCode = evt.which ? evt.which : event.keyCode;
        if (
            (charCode != 45 || $(element).val().indexOf("-") != -1) && // “-” CHECK MINUS, AND ONLY ONE.
            (charCode != 46 || $(element).val().indexOf(".") != -1) && // “.” CHECK DOT, AND ONLY ONE.
            charCode != 8 && // “.” CHECK DOT, AND ONLY ONE.
            (charCode < 48 || charCode > 57)
        )
            return false;
        return true;
    }

    jQuery(".type-number").keypress(function(event) {
        return isOnlyNumber(event, this);
    });

    jQuery(".type-time").keyup(function(e) {
        var txt = jQuery(this).val();
        // neu co 4 ky tu nhap vao thi them dau /
        if (txt.length === 2) {
            jQuery(this).val(txt + ":");
            // neu phim xoa nguoc se xoa 1 ky tu sau cung
            if (e.keyCode === 8) {
                jQuery(this).val(txt.substring(0, txt.length - 1));
            }
        }

        // neu phim DEL se xoa sach ky tu trong  input
        if (e.keyCode === 46) {
            jQuery(this).val("");
        }
    });

    function isOnlyNumber(evt) {
        var charCode = evt.which ? evt.which : event.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) return false;
        return true;
    }

    // waiting function
    function showwaiting() {
        $("#waiting-img").css("display", "block");
    }

    function hidewaiting() {
        $("#waiting-img").css("display", "none");
    }

    function fnpopup() {
        //   var error = '<?php echo $e_error ?>';
        //   var post ='<?php echo $e_branch ?>';
        //   if(error==='' && post !==''){
        $("#div-popup").fadeIn("slow");
        $("#div-alertInfo").css("top", "150px");
        setTimeout(closePopup, 5000);
        // }
    }

    function closePopup() {
        $("#div-popup").fadeOut("slow");
        $("#div-alertInfo").css("top", "0px");
        $("#div-alertInfo").css("opacity", "0");
        //  window.location.reload();
        //  window.location='<?php echo home_url('events') ?>';
    }

    function fnOpenNormalDialog() {
        $("#dialog-confirm").html("Confirm Dialog Box");

        // Define the Dialog and its properties.
        $("#dialog-confirm").dialog({
            resizable: false,
            modal: true,
            title: "Modal",
            height: 250,
            width: 400,
            buttons: {
                Yes: function() {
                    $(this).dialog("close");
                    callback(true);
                },
                No: function() {
                    $(this).dialog("close");
                    callback(false);
                },
            },
        });
    }

    //<![CDATA[

    // Set cookie
    function setCookie(name, value, expires, path, domain, secure) {
        document.cookie =
            name +
            "=" +
            escape(value) +
            (expires == null ? "" : "; expires=" + expires.toGMTString()) +
            (path == null ? "" : "; path=" + path) +
            (domain == null ? "" : "; domain=" + domain) +
            (secure == null ? "" : "; secure");
    }

    // Read cookie
    function getCookie(name) {
        var cname = name + "=";
        var dc = document.cookie;
        if (dc.length > 0) {
            begin = dc.indexOf(cname);
            if (begin != -1) {
                begin += cname.length;
                end = dc.indexOf(";", begin);
                if (end == -1) end = dc.length;
                return unescape(dc.substring(begin, end));
            }
        }
        return null;
    }

    //delete cookie
    function eraseCookie(name, path, domain) {
        if (getCookie(name)) {
            document.cookie =
                name +
                "=" +
                (path == null ? "" : "; path=" + path) +
                (domain == null ? "" : "; domain=" + domain) +
                "; expires=Thu, 01-Jan-70 00:00:01 GMT";
        }
    }

    //]]>
});

function myLoadMore(postType, lastID, cateName, cateValue, path) {
    // phần chạy tại điểm hiện tại dịch xuống 300px
    // 获取当前滚动位置
    var currentScroll = $(window).scrollTop();
    // 计算目标滚动位置
    var targetScroll = currentScroll + 300;
    // 滚动到目标位置
    $("html, body").animate({
            scrollTop: targetScroll,
        },
        800
    );

    jQuery.ajax({
        url: path, // lay doi tuong chuyen sang dang array
        type: "post", //                data: $(this).serialize(),
        data: {
            lastID: lastID,
            postName: postType,
            cateName: cateName,
            cateValue: cateValue,
        },
        dataType: "json",
        success: function(data) {
            // set ket qua tra ve  data tra ve co thanh phan status va message
            if (data.status === "done") {
                jQuery(".article-box").append(data.html);
            } else if (data.status === "empty") {
                jQuery("#load-more").hide();
            }
        },
        error: function(xhr) {
            console.log(xhr.reponseText);
            //console.log(data.status);
        },
    });
}