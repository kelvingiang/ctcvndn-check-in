<?php $page = getParams('page'); ?>
<form id="f1" name="f1" method="POST" action="<?php echo "admin.php?page=$page&action=waiting" ?>">
    <div class="row-three-column">
        <div class="col">
            <div class="cell-title">
                <label> 商會名稱 </label>
            </div>
            <div class="cell-text">
                <input type="text" name="txt-name" id="txt-name" class='my-input' value='<?php echo get_post_meta('1', '_text_name', true) ?>' />
            </div>
        </div>
        <div class="col">
            <div class="cell-title">
                <label> 開始報到時間 </label>
            </div>
            <div class="cell-text">
                <input type="text" name="txt-waiting" id="txt-waiting" class='my-input' value='<?php echo get_post_meta('1', '_text_waiting', true)  ?>' />
            </div>
        </div>
        <div class="col">
            <div class="cell-title">
                <label> 二維碼檔路徑 </label>
            </div>
            <div class="cell-text">
                <input type="text" name="txt-qrcode" id="txt-qrcode" class='my-input' value='<?php echo get_post_meta('1', '_text_part', true) ?>' />
            </div>
        </div>
    </div>
</form>
<hr />
<div class=" report_head" style="height: 60px">
    <ul>
        <li>
            <a class="button button-primary" href="<?php echo "admin.php?page=$page&action=import_member" ?>">
                <?php _e('導入新名單'); ?>
            </a>
            <i style="color: red;">導入時會刪除所有名單</i>
        </li>
        <li>
            <a class="button button-primary" href="<?php echo "admin.php?page=$page&action=import_member_more" ?>">
                <?php _e('導入補充名單'); ?>
            </a>
            <i style="color: red;">導入補充名單不會刪除已有的名單</i>
        </li>
    </ul>
    <hr />
    <ul>

        <li>
            <a class="button button-primary" href="<?php echo "admin.php?page=$page&action=create_qrcode" ?>">
                <?php _e('批次產生 QRCode') ?>
            </a>
        </li>
        <li>
            <a class="button button-primary" href="<?php echo "admin.php?page=$page&action=create_qrcode_name" ?>">
                <?php _e(' 批次含姓名產生  QRCode') ?>
            </a>
        </li>

    </ul>
    <hr />
    <ul>
        <li>
            <a class="button btn-green" href="<?php echo "admin.php?page=$page&action=export_member" ?>">
                <?php _e('輸出會員名單') ?>
            </a>
        </li>
        <li>
            <a class="button btn-green" href="<?php echo "admin.php?page=$page&action=open_qrcode_folder" ?>">
                <?php _e(' 打開 QRCode 資料庫') ?>
            </a>
        </li>
    </ul>
    <hr />
    <ul>
        <li>
            <a class="button btn-delete" onclick="myFunction()"><?php _e('Clear check-in records') ?></a>
        </li>
    </ul>

</div>


<script type="text/javascript">
    jQuery(document).ready(function() {

        jQuery('#f1').keydown(function(event) {
            console.log('Keydown event triggered');
            if (event.keyCode === 13) {
                event.preventDefault();
                jQuery("#f1").submit();
            }
        })



    });



    function myFunction() {
        if (confirm("您確定刪除所有報到記錄")) {
            location.href = "<?php echo "admin.php?page=$page&action=reset_checkin" ?>";
        } else {
            window.stop();
        }
    }
</script>