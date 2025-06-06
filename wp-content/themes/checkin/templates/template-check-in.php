<div>
    <div class="my-waiting">
        <img src="<?php echo PART_IMAGES . 'loading_pr2.gif' ?>" />
    </div>
    <div class="my_container">
        <div class='check-in-box'>
            <div class="check-in-form">
                <form name="check-form" id="check-form" method="post" action="">
                    <div class="check-form-input">
                        <input type="text" id="txt-barcode" name="txt-barcode" placeholder="QRCode 碼"
                            class="form-control" required title="Username should only contain lowercase letters. e.g. john" />

                        <button id="btn-submit" name="btn-submit" class="btn-submit-barcode">
                            提交
                        </button>
                    </div>
                </form>
                <div>
                    <div id="last-check-in"></div>
                </div>
                <div class="ad-style">
                    <div>
                        <img src="<?php echo PART_IMAGES . 'digiwin-logo.png'; ?>" />
                        <label>鼎捷軟件(越南)維護製作</label>
                    </div>
                </div>
            </div>

            <div class="check-in-value">
                <div id="barcode-error">QRCode 不正確 !</div>
                <div id="accout-unactive"> 您的賬號還沒啟用 ! </div>
                <div id="guest-main">
                    <div>
                        <div id="guest-pictrue"></div>
                    </div>
                    <div>
                        <div class="guest-name">
                            <div id="guest_name"></div>
                        </div>

                        <div class="guest-info" style="margin-top: 1rem" ;>
                            <div>會員編號 : </div>
                            <div id="guest_code">&nbsp; </div><br />
                        </div>

                        <div class="guest-info">
                            <div>公司名稱 : </div>
                            <div id="guest_company_cn">&nbsp; </div>
                            <!-- <div id="guest_company_vn">&nbsp; </div> -->
                        </div>

                        <div class="guest-info">
                            <div>公司地址 : </div>
                            <div id="guest_address">&nbsp; </div>
                        </div>

                        <div class="guest-info">
                            <div>聯絡電話 : </div>
                            <div id="guest_phone">&nbsp; </div>
                        </div>

                        <div class="guest-info">
                            <div>聯絡電郵 : </div>
                            <div id="guest_email">&nbsp; </div>
                        </div>

                        <div class="guest-info">
                            <div>經營行業 : </div>
                            <div id="guest_career">&nbsp; </div>
                        </div>

                    </div>
                </div>
                <div id="check-in-main">
                    <!-- <img src="<?php echo PART_IMAGES . 'logo.png' ?>" /> -->
                     <div><?php echo $GLOBALS['title'] ?></div>
                </div>
            </div>
        </div>
    </div>
    <?php
    require_once DIR_MODEL . 'model-check-in-event-function.php';
    $model_event = new Model_Check_In_Event_Function();
    $active_event = $model_event->getActiveItem();
    $active_event_id = $active_event['ID'];
    ?>

    <script type="text/javascript">
        jQuery(document).ready(function() {

            jQuery("#txt-barcode").focus();

            jQuery('#btn-submit').click(function(e) {
                submitAction();
                e.preventDefault();
            });

            jQuery('#txt-barcode').keydown(function(e) {
                if (e.key === "Enter" || e.keyCode === 13) {
                    e.preventDefault(); // 避免表單自動提交
                    submitAction();
                }
            });

            function submitAction() {
                var barcode = jQuery('#txt-barcode').val().trim();
                console.log(barcode);
                if (barcode != '') {
                    var event = '<?php echo $active_event_id ?>';
                    jQuery('.my-waiting').css('display', 'flex');

                    jQuery.ajax({
                        url: '<?php echo get_template_directory_uri() . '/ajax/update-check-in.php' ?>', // lay doi tuong chuyen sang dang array
                        type: 'post',
                        data: {
                            id: barcode,
                            event: event
                        },
                        dataType: 'json',
                        success: function(data) { // set ket qua tra ve  data tra ve co thanh phan status va message
                            jQuery("#txt-barcode").val('');
                            if (data.status === 'done') {
                                //window.location.reload();  
                                jQuery('#guest-main, #last-check-in, #accout-unactive').css('display', 'block');
                                jQuery('#barcode-error, #accout-unactive, #check-in-main').css('display', 'none');
                                jQuery('#last-check-in').children().remove();
                                // if (data.info.TotalTimes > 1) {
                                //     jQuery('#last-check-in').css('display', 'block');
                                //     jQuery('#last-check-in').append("<label> Kiểm soát lần  thứ  : " + data.info.TotalTimes + "</label>");
                                //     jQuery('#last-check-in').append("<label> Kiểm soát lần Trước : " + data.info.LastCheckIn + "</label>");
                                // }
                                jQuery('#guest_code').text(data.info.member_code);
                                jQuery('#guest_name').text(data.info.contact);
                                jQuery('#guest_company_cn').html(data.info.company_cn + '<br>' + data.info.company_vn);
                                jQuery('#guest_company_vn').text(data.info.company_vn);
                                jQuery('#guest_address').text(data.info.address);
                                jQuery('#guest_email').text(data.info.email);
                                jQuery('#guest_phone').text(data.info.phone);
                                jQuery('#guest_career').text(data.info.career);
                                jQuery('#last-check-in').text('');
                                if (data.check == 1) {
                                    jQuery('#last-check-in').text('已經報到!')
                                }
                                // jQuery('#guest-picture').append(data.info.Img);

                                window.setTimeout(function() {
                                    jQuery('.my-waiting').css('display', 'none');
                                }, 100);
                                // window.setTimeout(function() {
                                //     location.reload();
                                // }, 10000);
                                //   alert(data.info.FullName);
                            } else if (data.status === 'error') {
                                jQuery('#guest-main, #last-check-in, #accout-unactive, #check-in-main', ).css('display', 'none');
                                jQuery('#barcode-error').css('display', 'flex');
                                window.setTimeout(function() {
                                    jQuery('.my-waiting').css('display', 'none');
                                }, 100);
                            } else if (data.status === 'unactive') {
                                jQuery('#guest-main, #last-check-in, #barcode-error, #check-in-main').css('display', 'none');
                                jQuery('#accout-unactive').css('display', 'flex');
                                window.setTimeout(function() {
                                    jQuery('.my-waiting').css('display', 'none');
                                }, 100);
                            }
                        },
                        error: function(xhr) {
                            console.log(xhr.reponseText);
                        }
                    });
                }
            }
        });
    </script>