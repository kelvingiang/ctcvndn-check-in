<?php
require_once(DIR_MODEL . 'model-check-in-function.php');
$model = new Model_Check_In_Function();
$ParamID = getParams('id');
echo $ParamID;
if (!empty(getParams('id'))) {
    $data = $model->get_item(getParams());
}
?>

<?php
$insert_id = $model->saveItem();
if (!empty($insert_id)) {
?>
    <div style=" background-color: #FFADAD; color: white; min-height: 150px; margin-left: -20px; margin-bottom: 50px; padding-left: 20px">

    </div>
<?php } ?>
<form action="" method="post" enctype="multipart/form-data" id="f-guests" name="f-guests">
    <input type='hidden' id='hidden_ID' name='hidden_ID' value='<?php echo $data['ID']; ?>' />
    <input type='hidden' id='hidden_member_code' name='hidden_member_code' value='<?php echo $data['member_code']; ?>' />
    <input type='hidden' id='hidden_qr_code' name='hidden_qr_code' value='<?php echo $data['qr_code']; ?>' />

    <!-- 
    <div class="row-one-column" style=" margin-top: 3rem ">
        <div class="cell-title ">
        </div>
        <div class="cell-text">
            <?php
            if (empty($data['img'])) {
                $guest_img = PART_IMAGES . 'no-image.jpg';
            } else {
                $guest_img = $data['img'];
            }

            ?>
            <img id="show-img" src="<?php echo  $guest_img; ?>">
            <!-- <input type="file" id="guests_img" name="guests_img" accept=".png, .jpg, .jpeg, .bmp" /> 
        </div>
    </div> 
-->


    <div class="row-two-column">
        <div class="col">
            <div class="cell-title">
                <label> 會員編碼 </label>
            </div>
            <div class="cell-text">
                <input type="text" name="txt_member_code" class='my-input' value='<?php echo $data['member_code']; ?>' 
                  <?php echo $data['member_code'] != '' ? "readonly" : ''; ?>
                />
            </div>
        </div>

        <div class="col">
            <?php if (getParams('action') != 'add') { ?>

                <?php $barcodeImgName = $data['member_code'] . '-' . $data['contact']; ?>
                <span>
                    <a href="<?php echo PART_IMAGES_QRCODE . $data['qr_code'] . '.png'; ?>" download="<?php echo $barcodeImgName . '.png' ?>">
                        <img id="img_barcode" name="img_barcode" title="點擊下載QRCODE檔案" src='<?php echo PART_IMAGES_QRCODE . $data['qr_code'] . '.png'; ?>'>
                    </a>
                </span>
        </div>

    <?php } ?>
    </div>
    </div>

    <div class="row-two-column">
        <div class="col">
            <div class="cell-title">
                <label> 聯絡人 </label>
            </div>
            <div class="cell-text">
                <input type="text" name="txt_contact" class='my-input' value='<?php echo $data['contact']; ?>' />
            </div>
        </div>

        <div class="col">
            <div class="cell-title">
                <label> 職稱/部門 </label>
            </div>
            <div class="cell-text">
                <input type="text" name="txt_position" class='my-input' value='<?php echo $data['position']; ?>' />
            </div>
        </div>
    </div>
    <div class="row-one-column">
        <div class="cell-title">
            <label>公司名稱-中文</label>
        </div>
        <div class="cell-text">
            <input type="text" name="txt_company_cn" class="my-input" required value="<?php echo $data['company_cn'] ?>" />
        </div>
    </div>

    <div class="row-one-column">
        <div class="cell-title">
            <label>公司名稱-越文</label>
        </div>
        <div class="cell-text">
            <input type="text" name="txt_company_vn" class="my-input" required value="<?php echo $data['company_vn'] ?>" />
        </div>
    </div>

    <div class="row-one-column">
        <div class="cell-title">
            <label>地址</label>
        </div>
        <div class="cell-text">
            <input type="text" name="txt_address" class="my-input" required value="<?php echo $data['address'] ?>" />
        </div>
    </div>



    <div class="row-two-column">

        <div class="col">
            <div class="cell-title">
                <label> 電話 </label>
            </div>
            <div class="cell-text">
                <input type="text" name="txt_phone" class='my-input' value='<?php echo $data['phone']; ?>' />
            </div>
        </div>

        <div class="col">
            <div class="cell-title">
                <label> E-mail </label>
            </div>
            <div class="cell-text">
                <input type="text" name="txt_email" class='my-input' value='<?php echo $data['email']; ?>' />
            </div>
        </div>
    </div>

    <div class="row-one-column">
        <div class="cell-title">
            <label>行業</label>
        </div>
        <div class="cell-text">
            <textarea name="txt_career" style="width: 90%" rows="5"><?php echo $data['career'] ?></textarea>
        </div>
    </div>

    <div class="row-one-column" style="padding-top: 20px; text-align: right">
        <div class="cell-title "><label class="label-admin"></label></div>
        <div class="cell-text">
            <input name="submit" id="submit" class="button button-primary" value="發 表" type="submit" style="margin-right: 50px">
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
</script>