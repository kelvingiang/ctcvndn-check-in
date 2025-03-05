<?php

class Model_Check_In_Event_Function
{
    private $_table_event;
    private $_table_detail;

    public function __construct()
    {
        global $wpdb;
        $this->_table_event = $wpdb->prefix . 'check_in_event';
        $this->_table_detail = $wpdb->prefix . 'check_in_detail';
    }

    public function getAll()
    {
        global $wpdb;
        $sql = "SELECT * FROM $this->_table_event";
        $row = $wpdb->get_results($sql, ARRAY_A);
        return $row;
    }

    public function getItem($id)
    {
        global $wpdb;
        $sql = "SELECT * FROM $this->_table_event WHERE ID = $id";
        $row = $wpdb->get_row($sql, ARRAY_A);
        return $row;
    }

    public function getActiveItem()
    {
        global $wpdb;
        $sql = "SELECT * FROM $this->_table_event WHERE status = 1";
        $row = $wpdb->get_row($sql, ARRAY_A);
        return $row;
    }

    public function saveItem($arrData = array(), $option = array())
    {
        global $wpdb;
        $data = array(
            'title' => $arrData['txt_title'],
        );

        if ($option == 'edit') {
            // thêm phần tử vào array 
            $data['update_date'] = date('Y-m-d');
            $where = array('ID' => absint($arrData['hidden_ID']));
            $wpdb->update($this->_table_event,  $data, $where);
        } else if ($option == 'add') {
            $data['create_date'] = date('Y-m-d');
            $wpdb->insert($this->_table_event, $data);
        }
    }

    public function activeItem($arrData = array(), $option = array())
    {
        global $wpdb;

        $sql = "UPDATE $this->_table_event SET `status` =  '0' ";
        $wpdb->query($sql);

        $data = array('status' => 1);
        $where = array('id' => absint($arrData['id']));
        $wpdb->update($this->_table_event, $data, $where);
    }

    public function trashItem($arrData = array(), $option = array())
    {
        global $wpdb;

        // KIEM TRA PHAN  CÓ PHAN DANG CHUOI HAY KHONG
        if (!is_array($arrData['id'])) {
            $data = array('trash' => 1);
            $where = array('id' => absint($arrData['id']));
            $wpdb->update($this->_table_event, $data, $where);
        } else {
            // $arrData['id] chuyen qua ID-barcode  vidu : 1111-22222222
            // do su dung array_map('absint) no chi lay so cho nen khi lay de dau '-' khong tiep tuc lay
            // vay la no chi lay phan dau la ID dung voi gi muon
            // khong can tach chuoi
            $arrData['id'] = array_map('absint', $arrData['id']);
            $ids = join(',', $arrData['id']);
            $sql = "UPDATE $this->_table_event SET `trash` =  '1'   WHERE ID IN ($ids)";
            $wpdb->query($sql);
        }
    }

    public function restoreItem($arrData = array(), $option = array())
    {
        global $wpdb;
        // KIEM TRA PHAN DELETE CÓ PHAN DANG CHUOI HAY KHONG
        if (!is_array($arrData['id'])) {
            $data = array('trash' => 0);
            $where = array('id' => absint($arrData['id']));
            $wpdb->update($this->_table_event, $data, $where);
        } else {
            // $arrData['id] chuyen qua ID-barcode  vidu : 1111-22222222
            // do su dung array_map('absint) no chi lay so cho nen khi lay de dau '-' khong tiep tuc lay
            // vay la no chi lay phan dau la ID dung voi gi muon
            // khong can tach chuoi
            $arrData['id'] = array_map('absint', $arrData['id']);
            $ids = join(',', $arrData['id']);
            $sql = "UPDATE $this->_table_event SET `trash` =  '0'   WHERE ID IN ($ids)";
            $wpdb->query($sql);
        }
    }

    public function deleteItem($arrData = array(), $option = array())
    {
        global $wpdb;

        if (!is_array($arrData['id'])) {
            $where = array('ID' => absint($arrData['id']));
            $wpdb->delete($this->_table_event, $where);
            // delete detail 
            $where = array('event_id' => absint($arrData['id']));
            $wpdb->delete($this->_table_detail, $where);
        } else {
            // $arrData['id] chuyen qua ID-barcode  vidu : 1111-22222222
            // do su dung array_map('absint) no chi lay so cho nen khi lay de dau '-' khong tiep tuc lay
            // vay la no chi lay phan dau la ID dung voi gi muon
            // khong can tach chuoi
            // $arrData['id'] = array_map('absint', $arrData['id']);
            // $ids = join(',', $arrData['id']);
            // $sql = "DELETE FROM $this->_table_event WHERE ID IN ($ids)";
            // $wpdb->query($sql);
        }
    }
}
