<?php

// KIEM TRA  WP_List_Table CO TON TAI CHUA NEU CHUA SE INCLUSE VAO
if (!class_exists('WP_List_Table')) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php ';
}



class Model_Check_In extends WP_List_Table
{

    private $_pre_page = 30;
    private $_sql;
    private $_stt = 1;
    private $_table = null;
    private $_table_event = null;
    private $_table_detail = null;

    public function __construct($args = array())
    {

        $args = array(
            'plural' => 'ID', // GIA TRI NAY TUONG UNG VOI key TRONG table
            'singular' => 'ID', // GIA TRI NAY TUONG UNG VOI key TRONG table
            'ajax' => FALSE,
            'screen' => null,
        );
        parent::__construct($args);

        global $wpdb;
        $this->_table =  $wpdb->prefix . 'check_in_member';
        $this->_table_event =  $wpdb->prefix . 'check_in_event';
        $this->_table_detail =  $wpdb->prefix . 'check_in_detail';
    }

    // HAM NAY BAT BUOT PHAI CO QUAN TRONG DE SHOW LIST RA
    //  CAC THONG SO VA DU LIEU CAN  CUNG CAP DE HIEN THI GIRDVIEW
    public function prepare_items()
    {
        $columns = $this->get_columns();  // NHUNG GI CAN HIEN THI TREN BANG 
        $hidden = $this->get_hidden_columns(); // NHUNG COT TA SE AN DI
        $sorttable = $this->get_sortable_columns(); // CAC COT DC SAP XEP TANG HOAC GIAM DAN

        $this->_column_headers = array($columns, $hidden, $sorttable); //DUA 3 GIA TRI TREN VAO DAY DE SHOW DU LIEU
        $this->items = $this->table_data(); // LAY DU LIEU TU DATABASE

        $total_items = $this->total_items(); // TONG SO DONG DA LIEU
        $per_page = $this->_pre_page; // SO TRANG 
        $total_pages = ceil($total_items / $per_page); // TONG SO TRANG
        // PHAN TRANG
        $args = array(
            'total_items' => $total_items,
            'per_page' => $per_page,
            'total_pages' => $total_pages
        );
        $this->set_pagination_args($args);
    }

    //---------------------------------------------------------------------------------------------
    // Cmt NHOM NHAT DINH  PHAI CO CHO LIST NAY
    //---------------------------------------------------------------------------------------------
    // LAY CAC COT TUONG UNG TRONG DATABASE DAN VAO CAC COT TREN LUOI
    public function get_columns()
    {
        $arr = array(
            'cb' => '<input type="checkbox" />',
            'serial'  => __('會員編碼'),
            'company_cn' => __('公司名稱'),
            'contact' => __('聯絡人'),
            'qr_code' => __('QR_code'),
            'phone' => __('Phone'),
            // 'check' => __('報到'),
            'checkin' => __('Check-In'),
            'create_date' => __('Date')
        );
        return $arr;
    }

    // KHIA BAO CAC COT BI AN DI TREN GRIDVIEW
    public function get_hidden_columns()
    {
        return array('');
    }

    // COLUMN SAP XEP THU TANG HOAC GIAM DAN
    public function get_sortable_columns()
    {
        return array(
            'checkin' => array('status', true),
            'serial' => array('member_code', true),
            'country' => array('country', true),
            'id' => array('id', true),
        );
    }

    //---------------------------------------------------------------------------------------------
    // Cmt NHOM GET DATA TU DATABASE
    //---------------------------------------------------------------------------------------------
    // GET DATA TRONG DATABASE 
    private function table_data()
    {
        $data = array();
        global $wpdb;
        // LAY GIA TRI SAP XEP DU LIEU TREN COT
        $orderby = (getParams('orderby') == ' ') ? 'id' : $_GET['orderby'];
        $order = (getParams('order') == ' ') ? 'DESC' : $_GET['order'];
        //$tblTest = $wpdb->prefix . 'check_in';
        $sql = 'SELECT m.* FROM ' . $this->_table . ' AS m ';
        $whereArr = array();  // TAO MANG WHERE

        if (getParams('customvar') == 'trash') {
            $whereArr[] = "(trash = 1)";
        } else {
            $whereArr[] = "(trash = 0)";
        }

        // if (getParams('filter_branch') != ' ') {
        //     $branch = getParams('filter_branch');
        //     $whereArr[] = "(m.country = $branch)";
        // }

        if (getParams('s') != ' ') {
            $s = esc_sql(getParams('s'));
            $whereArr[] = "(m.member_code  LIKE '%$s%' OR m.contact LIKE '%$s%' OR m.company_cn LIKE '%$s%')";
        }

        // CHUYEN CAC GIA TRI where KET VOI NHAU BOI and
        if (count($whereArr) > 0) {
            $sql .= " WHERE " . join(" AND ", $whereArr);
        }

        // orderby
        $sql .= 'ORDER BY m.' . esc_sql($orderby) . ' ' . esc_sql($order);

        $this->_sql = $sql;


        //LAY GIA TRI PHAN TRANG PAGEING
        $paged = max(1, @$_REQUEST['paged']);
        $offset = ($paged - 1) * $this->_pre_page;

        $sql .= ' LIMIT  ' . $this->_pre_page . ' OFFSET ' . $offset;

        // LAY KET QUA  THONG QUA CAU sql
        $data = $wpdb->get_results($sql, ARRAY_A);

        return $data;
    }

    // TINH TONG SO DONG DU LIEU  DE AP DUNG CHO VIEC PHAN TRANG
    public function total_items()
    {
        global $wpdb;
        return $wpdb->query($this->_sql);
    }

    // SO TONG ITEM DUNG DE PHAN TRANG
    public function total_list()
    {
        global $wpdb;
        return $wpdb->get_var("SELECT COUNT(*) FROM $this->_table");
    }

    // SO TONG ITEM TRONG TRASH(SO RAC)
    public function total_trash()
    {
        global $wpdb;
        return $wpdb->get_var("SELECT COUNT(*) FROM $this->_table WHERE trash = 1");
    }

    // SO TONG ITEM HIEN HANH
    public function total_publish()
    {
        global $wpdb;
        return $wpdb->get_var("SELECT COUNT(*) FROM $this->_table WHERE trash = 0");
    }

    //---------------------------------------------------------------------------------------------
    // Cmt NHOM CAC SELECT BOX O DAU CUA LIST
    //---------------------------------------------------------------------------------------------
    //
    // PHAN SHOW THONG KE SO ITEM O DAU LIST (tong so item, so item hien hanh, so item trong trash)
    function get_views()
    {
        $views = array();
        $current = (!empty($_REQUEST['customvar']) ? $_REQUEST['customvar'] : 'all');

        //All link
        $class = ($current == 'all' ? ' class="current"' : '');
        $all_url = remove_query_arg('customvar');
        $views['all'] = "<strong>" . __('All') . " (" . $this->total_list() . ")</strong>";

        //Foo link
        $foo_url = add_query_arg('customvar', 'published');
        $class = ($current == 'foo' ? ' class="current"' : '');
        $views['foo'] = "<a href='{$foo_url}' {$class} > " . __('Published') . " (" . $this->total_publish() . ")</a>";

        //Bar link
        $bar_url = add_query_arg('customvar', 'trash');
        $class = ($current == 'bar' ? ' class="current"' : '');
        $views['bar'] = "<a href='{$bar_url}' {$class} >" . __('Trash') . "(" . $this->total_trash() . ")</a>";

        return $views;
    }

    // CAC ITEM TRONG SELECT BOX CHUC NANG 'UNG DUNG'
    public function get_bulk_actions()
    {
        if (isset($_GET['customvar'])) {
            if ($_GET['customvar'] == 'trash') {
                $actions = array(
                    'restore' => __('Restore'),
                    'delete' => __('Delete Permanently'),
                );
            } else {
                $actions = array(
                    'trash' => __('Trash'),
                    'uncheckin' => __('Cancel Check-in')
                );
            }
            return $actions;
        }
    }

    //---------------------------------------------------------------------------------------------
    // Cmt NHOM THIET LAP GIA TRI CHO CAC CLOUMN
    //---------------------------------------------------------------------------------------------
    //
    // TAO CAC CHECK BOS O DAU DONG TRONG 
    public function column_cb($item)
    {
        $singular = $this->_args['singular'];
        $html = '<input type="checkbox" name="' . $singular . '[]" value="' . $item['ID'] .'"/>';
        return $html;
    }

    // THEM CAC PHAN CHINH SUA NHANH TAI COLUMN NAY
    //DAT TEN column_TEN COLUMN CAN TAO CAC CHINH SUA NHANH
    public function column_serial($item)
    {
        $page = getParams('page');
        $name = 'security_code';
        //        $linkDelete = add_query_arg(array('action' => 'delete', 'id' => $item['id']));
        //        $action = 'delete_id' . $item['id'];
        //        $linkDelete = wp_nonce_url($linkDelete, $action, $name);

        if ($_GET['customvar'] == 'trash') {
            $actions = array(
                'restore' => '<a href=" ?page=' . $page . '&action=restore&id=' . $item['ID'] . ' " >' . __('Restore') . '</a>',
                'delete' => '<a href=" ?page=' . $page . '&action=delete&id=' . $item['ID'] . ' " >' . __('Delete Permanently') . ' </a>',
                // 'view' => '<a href ="#">View</a>'
            );
        } else {
            $actions = array(
                'edit' => '<a href=" ?page=' . $page . '&action=edit&id=' . $item['ID'] . ' " >' . __('Edit') . '</a>',
                'trash' => '<a href=" ?page=' . $page . '&action=trash&id=' . $item['ID'] . ' " > ' . __('Trash') . ' </a>',
                // 'view' => '<a href ="#">View</a>'
            );
        }
        $html = '<strong> <a href="?page=' . $page . '&action=edit&id=' . $item['ID'] . ' ">' . $item['member_code'] . '</a> </strong>' . $this->row_actions($actions);
        return $html;
    }

    public function column_create_date($item)
    {
        echo $item['create_date'];
    }

    // public function column_checkin($item)
    // {
    //     global $wpdb;
    //     $sql = "SELECT * FROM $this->_table_event WHERE status != '0' AND trash = '0'";
    //     $event = $wpdb->get_row($sql, ARRAY_A);

    //     if ($item['status'] == $event['ID']) {
    //         // $action = 'inactive';
    //         $src = PART_ICON . 'active32x32.png';
    //     } else {
    //         // $action = 'active';
    //         $src = PART_ICON . 'inactive32x32.png';
    //     }

    //     // TAO SECURITY CODE
    //     $paged = max(1, @$_REQUEST['paged']);
    //     $name = 'security_code';
    //     $linkStatus = add_query_arg(array('action' => 'uncheckin', 'check' => $item['status'], 'id' => $item['ID'], 'barcode' => $item['barcode'], 'paged' => $paged));
    //     // $action = '';
    //     // $action = $action . '_id_' . $item['id'];
    //     // $linkStatus = wp_nonce_url($linkStatus, $action, $name);
    //     if (getParams('customvar') != 'trash') {
    //         $html = '<img alt="" src=" ' . $src . ' " />';
    //         $html = '<a href ="' . $linkStatus . ' ">' . $html . '</a>';
    //     } else {
    //         $html = '<img alt="" src=" ' . $src . ' " />';
    //         $html = '<a href ="#">' . $html . '</a>';
    //     }
    //     return $html;
    // }

    /* =========================================================
    check kieu kiem tra trong check-in-detail neu cai member_id bang voi $item['ID'] thi doi tuong do da check-in
    ========================================================= */
    public function column_checkin($item)
    {
        global $wpdb;
        $sql = "SELECT * FROM $this->_table_event WHERE status = '1' AND trash = '0'";
        $event = $wpdb->get_row($sql, ARRAY_A);

        $sqlDetail = "SELECT * FROM $this->_table_detail WHERE member_id = '" . $item['ID'] . "' AND event_id = '" . $event['ID'] . "' ";
        $detail = $wpdb->get_row($sqlDetail, ARRAY_A);


        if ($detail['event_id'] == $event['ID']) {
            $src = PART_ICON . 'active32x32.png';
        } else {
            $src = PART_ICON . 'inactive32x32.png';
        }

        // TAO SECURITY CODE
        $paged = max(1, @$_REQUEST['paged']);
        $name = 'security_code';

        $event_id = $event['ID'] != '' ? $event['ID'] : '0';

        $linkStatus = add_query_arg(array('action' => 'checkin', 'event_id' => $event_id, 'id' => $item['ID'], 'paged' => $paged));

        if (getParams('customvar') != 'trash') {
            $html = '<img alt="" src=" ' . $src . ' " />';
            $html = '<a href ="' . $linkStatus . ' ">' . $html . '</a>';
        } else {
            $html = '<img alt="" src=" ' . $src . ' " />';
            $html = '<a href ="#">' . $html . '</a>';
        }
        return $html;
    }






    //CAC COLUMN MAC DINH KHI LOAD TRANG SE SHOW LEN 
    public function column_default($item, $column_name)
    {
        return $item[$column_name];
    }
}
