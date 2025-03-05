<?php
require_once(DIR_MODEL . 'model-check-in-setting.php');
class Controller_Check_In_Report
{

    public function __construct()
    {
        add_action('admin_menu', array($this, 'Create'));
    }

    // PHAN TAO MENU CON TRONG MENU CHA CUNG LA POST TYPE
    public function Create()
    {
        $parent_slug = 'check_in_page';
        $page_title = __('Check In Report');
        $menu_title = __('Check In Report');
        $capability = 'manage_categories';
        $menu_slug = 'check_in_report_page';
        add_submenu_page($parent_slug, $page_title, $menu_title, $capability, $menu_slug, array($this, 'dispatchActive'));
    }

    public function dispatchActive()
    {
        //        echo __METHOD__;
        $action = getParams('action');
        switch ($action) {
            case 'export':
                $this->exportAction();
                break;
            default:
                $this->displayPage();
                break;
        }
    }

    public function displayPage()
    {
        require_once(DIR_VIEW . 'view-check-in-report.php');
    }

    public function exportAction()
    {
        $model = new Model_Check_In_Setting();
        $model->ExCheckInToExcel();
    }

    // public function barcodeAction()
    // {
    //     $model = new Admin_Model_Check_In_Setting();
    //     $model->ExportBarcode();
    // }

    // public function waitingAction()
    // {
    //     if (isPost()) {
    //         // update_option("Waiting_text", $_POST['txtWait']);
    //         update_option("Title_text", $_POST['txtTitle']);
    //         update_post_meta(1, '_part_text', $_POST['txtPart']);

    //         $paged = max(1, getParams('page'));
    //         $url = 'admin.php?page=' . $_REQUEST['page'] . '&paged=' . $paged . '&msg=1';
    //         wp_redirect($url);
    //     }
    //     require_once(DIR_VIEW . 'view-check-in-waiting.php');
    // }
}
