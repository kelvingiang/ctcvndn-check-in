<?php
class Controller_Setting
{
    public function __construct()
    {
        add_action('admin_menu', array($this, 'AddToMenu'));
    }

    public function AddToMenu()
    {
        // THEM 1 NHOM MENU MOI VAO TRONG ADMIN MENU
        $page_title = '網站設定'; // TIEU DE CUA TRANG 
        $menu_title = '網站設定';  // TEN HIEN TRONG MENU
        // CHON QUYEN TRUY CAP manage_categories DE role ADMINNITRATOR VÀ EDITOR DEU THAY DUOC
        $capability = 'manage_categories'; // QUYEN TRUY CAP DE THAY MENU NAY
        $menu_slug = 'setting_page'; // TEN slug TEN DUY NHAT KO DC TRUNG VOI TRANG KHAC GAN TREN THANH DIA CHI OF MENU
        // THAM SO THU 5 GOI DEN HAM HIEN THI GIAO DIEN TRONG MENU
        $icon = PART_ICON . '/schedule16x16.png';  // THAM SO THU 6 LA LINK DEN ICON DAI DIEN
        $position = 2; // VI TRI HIEN THI TRONG MENU

        add_menu_page($page_title, $menu_title, $capability, $menu_slug, array($this, 'dispatchActive'), $icon, $position);
    }

    // Phan dieu huong 
    public function dispatchActive()
    {
                $this->displayPage();
    }

    public function createUrl()
    {
        echo $url = 'admin.php?page=' . getParams('page');

        //filter_status
        if (getParams('filter_status') != '0') {
            $url .= '&filter_status=' . getParams('filter_status');
        }

        if (mb_strlen(getParams('s'))) {
            $url .= '&s=' . getParams('s');
        }

        return $url;
    }

    //---------------------------------------------------------------------------------------------
    // Cmt CAC CHUC NANG THEM XOA SUA VA HIEN THI
    //---------------------------------------------------------------------------------------------
    // CAC DISPLAY PAGE
    public function displayPage()
    {
        // LOC DU LIEU KHI action = -1 CO NGHIA LA DANG LOI DU LIEU (CHO 2 TRUONG HOP search va filter)
        if (getParams('action') == -1) {
            $url = $this->createUrl();
            wp_redirect($url);
        }
        if (isPost()) {
             update_post_meta(1, '_about_address_cn', $_POST['txt-address-cn']);
             update_post_meta(1, '_about_address_en', $_POST['txt-address-en']);
             update_post_meta(1, '_about_phone', $_POST['txt-phone']);
             update_post_meta(1, '_about_email', $_POST['txt-email']);
             update_post_meta(1, '_about_uniform', $_POST['txt-uniform']);
             update_post_meta(1, '_about_fb', $_POST['txt-uniform']);
             update_post_meta(1, '_about_instagram', $_POST['txt-instagram']);

             update_option('_page_count', $_POST['txt-page-count']);
             update_option('_more_count', $_POST['txt-more-count']);
        }
        // NEN TACH ROI HTML VA CODE WP RA CHO DE QUAN LY
        require_once(DIR_VIEW . 'view-setting.php');
    }



 
}
