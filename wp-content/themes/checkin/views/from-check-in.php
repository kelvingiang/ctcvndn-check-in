<?php
require_once(DIR_MODEL . 'model-check-in-function.php');
$model = new Model_Check_In_Function();

$ID = $member_code = $qr_code = $img =
    $company_cn = $company_vn = $contact = $position =
    $address = $phone = $email = $career
    = null;

$params = getParams();
if (isset($params['id'])) {
    $data = $model->get_item(getParams());
    $ID          = $data['ID'];
    $member_code = $data['member_code'];
    $qr_code     = $data['qr_code'];
    $contact     = $data['contact'];
    $position    = $data['position'];
    $company_cn  = $data['company_cn'];
    $company_vn  = $data['company_vn'];
    $address     = $data['address'];
    $phone       = $data['phone'];
    $career      = $data['career'];
    $email       = $data['email'];
    // $img         = $data['img'];
}


// if (empty($img)) {
//     $guest_img = PART_IMAGES . 'no-image.jpg';
// } else {
//     $guest_img = $img;
// }

?>


<form action="" method="post" enctype="multipart/form-data" id="f-guests" name="f-guests">
    <input type='hidden' id='hidden_ID' name='hidden_ID' value='<?php echo $ID; ?>' />
    <input type='hidden' id='hidden_member_code' name='hidden_member_code' value='<?php echo $member_code; ?>' />
    <input type='hidden' id='hidden_qr_code' name='hidden_qr_code' value='<?php echo $qr_code; ?>' />
    <!-- <img id="show-img" src="<?php //echo  $guest_img; 
                                    ?>"> -->

    <div class="row-two-column">
        <div class="col">
            <div class="cell-title">
                <label> 會員編碼 <i id="exited-member-code" class="error"></i> </label>
            </div>
            <div class="cell-text">
                <input type="text" name="txt_member_code" id="txt_member_code" class='my-input' value='<?php echo $member_code; ?>'
                    <?php echo $member_code != '' ? "readonly" : ''; ?> />
            </div>
        </div>

        <div class="col">
            <?php if (getParams('action') != 'add') { ?>
                <?php $barcodeImgName = $member_code . '-' . $contact; ?>
                <span>
                    <a href="<?php echo PART_IMAGES_QRCODE . $qr_code . '.png'; ?>"
                        download="<?php echo $barcodeImgName . '.png' ?>">
                        <img id="img_barcode" name="img_barcode" title="點擊下載QRCODE檔案"
                            style="width: 50px;"
                            src='<?php echo PART_IMAGES_QRCODE . $qr_code . '.png'; ?>'>
                    </a>
                </span>
            <?php } ?>
        </div>
    </div>

    <div class="row-two-column">
        <div class="col">
            <div class="cell-title">
                <label> 聯絡人 </label>
            </div>
            <div class="cell-text">
                <input type="text" name="txt_contact" class='my-input' value='<?php echo $contact; ?>' />
            </div>
        </div>

        <div class="col">
            <div class="cell-title">
                <label> 職稱/部門 </label>
            </div>
            <div class="cell-text">
                <input type="text" name="txt_position" class='my-input' value='<?php echo $position; ?>' />
            </div>
        </div>
    </div>

    <div class="row-one-column">
        <div class="cell-title">
            <label>公司名稱-中文</label>
        </div>
        <div class="cell-text">
            <input type="text" name="txt_company_cn" class="my-input" required value="<?php echo $company_cn ?>" />
        </div>
    </div>

    <div class="row-one-column">
        <div class="cell-title">
            <label>公司名稱-越文</label>
        </div>
        <div class="cell-text">
            <input type="text" name="txt_company_vn" class="my-input" required value="<?php echo $company_vn ?>" />
        </div>
    </div>

    <div class="row-one-column">
        <div class="cell-title">
            <label>地址</label>
        </div>
        <div class="cell-text">
            <input type="text" name="txt_address" class="my-input" required value="<?php echo $address ?>" />
        </div>
    </div>

    <div class="row-two-column">
        <div class="col">
            <div class="cell-title">
                <label> 電話 </label>
            </div>
            <div class="cell-text">
                <input type="text" name="txt_phone" class='my-input' value='<?php echo $phone; ?>' />
            </div>
        </div>

        <div class="col">
            <div class="cell-title">
                <label> E-mail </label>
            </div>
            <div class="cell-text">
                <input type="text" name="txt_email" class='my-input' value='<?php echo $email; ?>' />
            </div>
        </div>
    </div>

    <div class="row-one-column">
        <div class="cell-title">
            <label>行業</label>
        </div>
        <div class="cell-text">
            <textarea name="txt_career" style="width: 90%" rows="5"><?php echo $career ?></textarea>
        </div>
    </div>

    <div class="row-one-column" style="padding-top: 20px; text-align: right">
        <div class="cell-title "><label class="label-admin"></label></div>
        <div class="cell-text">
            <input type="submit" name="btn-submit" id="btn-submit" class="button button-primary" value="發 表"  style="margin-right: 50px">
        </div>
    </div>
</form>



<script type="text/javascript">
    // show hinh anh truoc khi up len
    jQuery(function() {
        jQuery("#guests_img").on("change", function() {
            var files = !!this.files ? this.files : [];
            if (!files.length || !window.FileReader)
                return; // no file selected, or no FileReader support

            if (/^image/.test(files[0].type)) { // only image file
                var reader = new FileReader(); // instance of the FileReader
                reader.readAsDataURL(files[0]); // read the local file

                reader.onloadend = function() { // set image data as background of div
                    console.log(this)
                    jQuery("#show-img").attr("src", this.result);;
                    // jQuery("#show-img").css("background-image", "url(" + this.result + ")");
                };
            }
        });
    });

    jQuery("#txt_member_code").blur(function(e) {
        let memberCode = jQuery(this).val();
                jQuery.ajax({
                    url: '<?php echo get_template_directory_uri() . '/ajax/check-member-code.php' ?>', // lay doi tuong chuyen sang dang array
                    type: 'post',
                    data: {
                        memberCode: memberCode,
                    },
                    dataType: 'json',
                    success: function(data) { // set ket qua tra ve  data tra ve co thanh phan status va message
                        if (data.status === 'exited') {
                             jQuery('#exited-member-code').text(data.message);
                             jQuery('#btn-submit').prop('disabled', true); 
                        }if(data.status === 'done'){
                            jQuery('#exited-member-code').text('');
                             jQuery('#btn-submit').prop('disabled', false); 
                        } 
                    },
                    error: function(xhr) {
                        console.log(xhr.reponseText);
                    }
                });
                e.preventDefault();

    });
</script>