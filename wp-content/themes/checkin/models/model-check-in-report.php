<?php

class Model_Check_In_Report
{
    private $_table_member;
    private $_table_event;
    private $_table_detail;
    private $_event_id;

    public function __construct()
    {
        global $wpdb;
        $this->_table_member = $wpdb->prefix . 'check_in_member';
        $this->_table_detail = $wpdb->prefix . 'check_in_detail';
        $this->_table_event = $wpdb->prefix . 'check_in_event';
        $this->_getEventID();
    }


    /* =========================================================
    LAY ID CUA EVENT HIEN HAN
    ========================================================= */
    private function _getEventID()
    {
        global $wpdb;
        $sql = "SELECT * FROM $this->_table_event WHERE status = 1 AND trash = 0";
        $row = $wpdb->get_row($sql, ARRAY_A);
        $this->_event_id = $row['ID'];
    }

    public function getActionEvent()
    {
        global $wpdb;
        $sql = "SELECT * FROM $this->_table_event WHERE status = 1 AND trash = 0";
        $row = $wpdb->get_row($sql, ARRAY_A);
        return $row;
    }

    public function getActionEventById($id)
    {
        global $wpdb;
        $sql = "SELECT * FROM $this->_table_event WHERE ID = $id";
        $row = $wpdb->get_row($sql, ARRAY_A);
        return $row;
    }

    public function ReportView()
    {
        global $wpdb;
        $sql = "SELECT * FROM $this->_table_member WHERE status = 1 AND trash = 0";
        $row = $wpdb->get_results($sql, ARRAY_A);
        return $row;
    }

    public function RegisterTotal()
    {
        global $wpdb;
        $sql = "SELECT COUNT(ID) FROM $this->_table_member WHERE trash = 0";
        $row = $wpdb->get_row($sql, ARRAY_A);
        return $row;
    }

    public function ReportJoinView()
    {
        global $wpdb;
        $sql = "SELECT * FROM $this->_table_member AS A LEFT JOIN $this->_table_detail AS B ON A.ID = B.member_ID
                  WHERE A.trash = 0 AND B.event_id = $this->_event_id
                  GROUP BY B.member_ID
                  ORDER BY B.time DESC";
        $row = $wpdb->get_results($sql, ARRAY_A);
        return $row;
    }

    public function ReportJoinViewByID($id)
    {
        global $wpdb;
        $sql = "SELECT * FROM $this->_table_member AS A LEFT JOIN $this->_table_detail AS B ON A.ID = B.member_ID
                  WHERE A.trash = 0 AND B.event_id = $id
                  GROUP BY B.member_ID
                  ORDER BY B.time DESC";
        $row = $wpdb->get_results($sql, ARRAY_A);
        return $row;
    }

    public function getAllMember()
    {
        global $wpdb;
        $sql = "SELECT * FROM $this->_table_member order by member_code ASC";
        $row = $wpdb->get_results($sql, ARRAY_A);
        return $row;
    }
}
