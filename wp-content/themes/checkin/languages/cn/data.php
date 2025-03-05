<?php

function getTranslate()
{
    $data = array(
        'history and purpose' => '沿革與宗旨',
        'organizations and meetings' => '組織與會議',
        'organizational chart' => '總會組織圖',
        'former presidents' => '歷屆會長',
        'former presidents and directors' => '歷屆總會長，理監事名錄',
        'continental chambers' => '洲際總會介紹',
        'continental youth' => '青商會介紹',
        'regulation'=> '規章彙編',
        'constitution' => '章程',
        'regulations'=>'章程施行細則暨選舉辦法',
        'rules of procedure'=>'議事簡則',
        'rules of procedure for the working committee' => '工作委員會辦事細則',
        'guidelines for meeting management'=> '會務管理準則',
        'taipei office management guidelines' => '台北辦事處管理要點',
        'news' => '最新消息',
        'wtcc news' => '世界台商總會消息',
        'tccna news'=>'北美洲台商總會消息',
        'astcc news'=>'亞洲台商總會消息',
        'etcc news'=>'歐洲台商總會消息',
        'atcc news'=>'非洲台商總會消息',
        'twccla news'=> '中南美洲台商總會消息',
        'tcco news'=> '大洋洲台商總會消息',
        'wtccjc news'=> '世界台商總會青商會消息',
        'affairs' => '會務公文',
        'newsletters and magazine'=> '活動紀錄',
        'registration form' => '會議報名表',
        'calendar'=> '行事曆',
        'files'=> '下載檔案',
        'newsletters' => '電子報',
        'magazine' => '會刊'

    );

    $data_menu = array(
       'home' => '首頁',
       'about us' => '關於商會',
       'address'=> '地址',
       'phone'=> '電話',
       'e-mail'=> 'E-mail',
       'uniform numbers'=> '統一編號',
    );


    return array_merge($data, $data_menu);
}
