<?php
require_once(DIR_MODEL . 'model-check-in-setting.php');

class Controller_Check_In_Setting
{
    private $_model;
    public function __construct()
    {
        add_action('admin_menu', array($this, 'Create'));
        $this->_model = new Model_Check_In_Setting();
    }

    // PHAN TAO MENU CON TRONG MENU CHA CUNG LA POST TYPE
    public function Create()
    {
        $parent_slug = 'check_in_page';
        $page_title = __('Check In Setting');
        $menu_title = __('Check In Setting');
        $capability = 'manage_categories';
        $menu_slug = 'check_in_setting_page';
        // $icon = PART_ICON . '/staff-icon.png';  // THAM SO THU 6 LA LINK DEN ICON DAI DIEN
        $position = 18;
        add_submenu_page($parent_slug, $page_title, $menu_title, $capability, $menu_slug, array($this, 'dispatchActive'), $position);
    }

    public function dispatchActive()
    {
        //        echo __METHOD__;
        $action = getParams('action');
        switch ($action) {
            case 'waiting':
                $this->waitingAction();
                break;
            case 'import_member':
                $this->ImportMemberAction();
                break;
            case 'import_member_more':
                $this->ImportMemberMoreAction();
                break;
            case 'reset_checkin':
                $this->ResetCheckInAction();
                break;
            case 'create_qrcode':
                $this->CreateQRCodeAction();
                break;
            case 'create_qrcode_name':
                $this->CreateNameQRCodeAction();
                break;
            case 'open_qrcode_folder':
                $this->openFOlderAction();
                break;
            case 'export_member':
                $this->exportMemberAction();
                break;
            default:
                $this->displayPage();
                break;
        }
    }

    public function displayPage()
    {
        require_once(DIR_VIEW . 'view-check-in-setting.php');
    }

    public function waitingAction()
    {
        if (isPost()) {
            update_post_meta(1, '_text_name', $_POST['txt-name']);
            update_post_meta(1, '_text_waiting', $_POST['txt-waiting']);
            update_post_meta(1, '_text_part', $_POST['txt-qrcode']);
        }
        ToBack();
    }

    public function openFOlderAction()
    {
        //== mở folder bằng explorer ==================================
        $directory = get_post_meta(1, '_text_part', true);
        // 检查目录是否存在
        if (is_dir($directory)) {
            // 使用 explorer 命令打开资源管理器并显示目录
            exec("start explorer $directory");
        } else {
            echo "目录 $directory 不存在";
        }
        ToBack(1);
    }

    // Export Group Function

    public function ExportMemberAction()
    {
        $model = new Model_Check_In_Setting();
        $model->ExportMember();
    }


    public function ExportCheckInAction()
    {
        $model = new Model_Check_In_Setting();
        $model->ExCheckInToExcel();
    }

    public function ExportMemberPostAction()
    {
        $model = new Model_Check_In_Setting();
        $model->ExportMemberPost();
    }

    public function ExportMemberTableAction()
    {
        $model = new Model_Check_In_Setting();
        $model->ExportMemberTable();
    }

    public function ExportGuestsAction()
    {
        $model = new Model_Check_In_Setting();
        $model->ExportGuests();
    }

    // Import Group Function 

    public function ImportMemberMoreAction()
    {
        if (isPost()) {
            $errors = array();
            $file_name = $_FILES['myfile']['name'];
            $file_size = $_FILES['myfile']['size'];
            $file_tmp = $_FILES['myfile']['tmp_name'];
            $file_type = $_FILES['myfile']['type'];

            $file_trim = ((explode('.', $_FILES['myfile']['name'])));
            $trim_name = strtolower($file_trim[0]);
            $trim_type = strtolower($file_trim[1]);
            //$name = $_SESSION['login'];
            // $cus_name = 'avatar-'.$name . '.' . $trim_type;  //tao name moi cho file tranh trung va mat file

            $extensions = array("xls", "xlsx");
            if (in_array($trim_type, $extensions) === false) {
                $errors[] = "extension not allowed, please choose a excel file.";
            }
            if ($file_size > 20097152) {
                $errors[] = 'File size must be excately 20 MB';
            }
            if (empty($errors)) {
                $path = DIR_FILE;
                move_uploaded_file($file_tmp, ($path . $file_name));

                $excelList = $path . $file_name;
                // require_once(DIR_MODEL . 'model_check_in_setting.php');
                $model = new Model_Check_In_Setting();
                $model->ImportGuestsUpdateInfo($excelList);

                ToBack();
            }
        }
        require_once(DIR_VIEW . 'view_guests_import.php');
    }

    public function ImportMemberAction()
    {
        if (isPost()) {
            $errors = array();
            $file_name = $_FILES['myfile']['name'];
            $file_size = $_FILES['myfile']['size'];
            $file_tmp = $_FILES['myfile']['tmp_name'];
            $file_type = $_FILES['myfile']['type'];

            $file_trim = ((explode('.', $_FILES['myfile']['name'])));
            $trim_name = strtolower($file_trim[0]);
            $trim_type = strtolower($file_trim[1]);
            //$name = $_SESSION['login'];
            // $cus_name = 'avatar-'.$name . '.' . $trim_type;  //tao name moi cho file tranh trung va mat file

            $extensions = array("xls", "xlsx");
            if (in_array($trim_type, $extensions) === false) {
                $errors[] = "extension not allowed, please choose a excel file.";
            }
            if ($file_size > 20097152) {
                $errors[] = 'File size must be excately 20 MB';
            }
            if (empty($errors)) {
                $path = DIR_FILE;
                move_uploaded_file($file_tmp, ($path . $file_name));

                $excelList = $path . $file_name;
                // require_once(DIR_MODEL . 'model_check_in_setting.php');
                $model = new Model_Check_In_Setting();
                $model->ImportGuests($excelList);

                ToBack();
            }
        }
        require_once(DIR_VIEW . 'view_guests_import.php');
    }

    // Create Group QRCode    
    public function ResetCheckInAction()
    {
        $this->_model->ResetCheckIn();
        ToBack();
    }

    public function CreateQRCodeAction()
    {
        $model = new Model_Check_In_Setting();
        $model->create_QRCode();
        ToBack();
    }

    public function CreateNameQRCodeAction()
    {
        $model = new Model_Check_In_Setting();
        $model->create_QRCode_Name();
        ToBack();
    }

    public function  CreateRegisteredQRCodeAction()
    {
        $model = new Model_Check_In_Setting();
        $model->create_registered_QRCode();
        ToBack();
    }
}
