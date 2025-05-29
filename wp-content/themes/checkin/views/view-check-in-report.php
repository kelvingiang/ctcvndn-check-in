<?php
require_once DIR_CODES . 'my-list.php';
$myList = new Codes_My_List();

require_once(DIR_MODEL . 'model-check-in-report.php');
$model = new Model_Check_In_Report();

$registerTotal = $model->RegisterTotal();
$listGuests = $model->ReportJoinView();
$actionEvent = $model->getActionEvent();

$page = getParams('page');
?>
<div class="check-in-event-title">
    <?php echo $actionEvent['title'] ?>
</div>
<div class="check-in-head">
    <div>
        <a class="button button-primary" href="<?php echo "admin.php?page=$page&action=export" ?>"><?php _e('導出記錄') ?></a>
    </div>

    <div class="check-in-total">
        <?php echo __('Total of registrations') . ' : ' . $registerTotal['COUNT(ID)']; ?>
        <br> <?php echo __('Total attendance') . ' : ' . count($listGuests); ?>
    </div>
</div>

<div class="check-in-content">
    <div class="check-in-content-row header-style">
        <div></div>
        <div><?php _e('編碼'); ?></div>
        <div><?php _e('公司名稱'); ?></div>
        <div><?php _e('Full Name') ?></div>
        <div><?php _e('Phone') ?></div>
        <div><?php _e('日期') ?></div>
        <div><?php _e('時間') ?></div>
    </div>
    <?php foreach ($listGuests as $key => $val) { ?>
        <div class="check-in-content-row">
            <div><?php echo $key + 1 ?></div>
            <div><?php echo $val['member_code'] ?></div>
            <div><?php echo $val['company_cn'] ?></div>
            <div><?php echo $val['contact'] ?></div>
            <div><?php echo $val['phone'] ?></div>
            <div><?php echo $val['date'] ?></div>
            <div><?php echo $val['time'] ?></div>
        </div>
    <?php } ?>
</div>