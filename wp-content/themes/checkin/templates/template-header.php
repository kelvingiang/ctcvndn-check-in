<?php
require_once DIR_MODEL . 'model-check-in-event-function.php';
$model = new Model_Check_In_Event_Function();
$event = $model->getActiveItem();
$GLOBALS['title'] = $event['title'];
?>
<div class="header">

</div>
<div class="header-logo">
    <img src="<?php echo  PART_IMAGES . 'logo.png' ?>" />
</div>

<div class="header-title">
    <div><?php echo get_post_meta('1', '_text_name', true) ?></div>
    <div><?php echo $GLOBALS['title'] ?></div>
    <!-- <div>lean through opertional excellence & sustainability</div> -->
</div>