<?php
function menu_main_list()
{
    // THIS ARRAY KEY APPLY LINK OF WEB 
    $arr = array(
        // $GLOBALS['about'] => array(
        //     'name' => "About",
        //     'class' => 'menu-main-item', // neu co sub menu phai them sub Class
        //     // 'subClass' => 'menu-main-sub-1',
        //     'sub' => '',
        //     //'sub' => $homeArr,
        // ),
        // 'cases' => array(
        //     'name' => "Cases Tudies",
        //     'class' => 'menu-main-item ',
        //     //'subClass' => 'menu-main-sub-1', // neu co sub menu phai them sub Class
        //     'sub' => '',
        //     //'sub' => getCategories('casestudies_category'),
        // ),
        // 'industry' => array(
        //     'name' => "Industries",
        //     'class' => 'menu-main-item ',
        //     'subClass' => 'menu-main-sub-1', // neu co sub menu phai them sub Class
        //     // 'sub' => 'getCategories('industries_category')',
        //     'sub' => '',
        // ),
        'about-us' => array(
            'name' => "about us",
            'class' => 'menu-main-item ',
            'subClass' => 'menu-main-sub-1', // neu co sub menu phai them sub Class
            'sub' => [
                array('ID' => 'ab-01', 'name' => 'history and purpose', 'class' => 'menu-main-sub-1-item', 'link' => "about-us/#history"),
                array('ID' => 'ab-02', 'name' => 'organizations and meetings', 'class' => 'menu-main-sub-1-item', 'link' => "about-us/#meetings"),
                array('ID' => 'ab-03', 'name' => 'organizational chart', 'class' => 'menu-main-sub-1-item', 'link' => "about-us/#chart"),
                array('ID' => 'ab-04', 'name' => 'former presidents', 'class' => 'menu-main-sub-1-item', 'link' => "presidents"),
                array('ID' => 'ab-05', 'name' => 'former presidents and directors', 'class' => 'menu-main-sub-1-item', 'link' => "directors"),
                array('ID' => 'ab-06', 'name' => 'continental chambers', 'class' => 'menu-main-sub-1-item', 'link' => "continental-chambers"),
                array('ID' => 'ab-07', 'name' => 'continental youth', 'class' => 'menu-main-sub-1-item', 'link' => "continental-youth"),
            ]
        ),
        'regulation' => array(
            'name' => "regulation",
            'class' => 'menu-main-item',
            'subClass' => 'menu-main-sub-1', // neu co sub menu phai them sub Class
            'sub' => [
                array('ID' => 're-01', 'name' => 'constitution', 'class' => 'menu-main-sub-1-item', 'link' => "constitution"),
                array('ID' => 're-02', 'name' => 'regulations', 'class' => 'menu-main-sub-1-item', 'link' => "regulation"),
                array('ID' => 're-03', 'name' => 'rules of procedure', 'class' => 'menu-main-sub-1-item', 'link' => "regulation-cate/cate/procedure"),
                array('ID' => 're-04', 'name' => 'rules of procedure for the working committee', 'class' => 'menu-main-sub-1-item', 'link' => "regulation-cate/cate/working"),
                array('ID' => 're-05', 'name' => 'guidelines for meeting management', 'class' => 'menu-main-sub-1-item', 'link' => "regulation-cate/cate/guidelines"),
                array('ID' => 're-06', 'name' => 'taipei office management guidelines', 'class' => 'menu-main-sub-1-item', 'link' => "regulation-cate/cate/taipei-points"),
            ],
        ),
        'news' => array(
            'name' => "news",
            'class' => 'menu-main-item',
            'subClass' => 'menu-main-sub-1', // neu co sub menu phai them sub Class
            'sub' => [
                array('ID' => 'news-01', 'name' => 'wtcc news', 'class' => 'menu-main-sub-1-item', 'link' => "news-cate/cate/wtcc"),
                array('ID' => 'news-02', 'name' => 'tccna news', 'class' => 'menu-main-sub-1-item', 'link' => "news-cate/cate/tccna"),
                array('ID' => 'news-03', 'name' => 'astcc news', 'class' => 'menu-main-sub-1-item', 'link' => "news-cate/cate/astcc"),
                array('ID' => 'news-04', 'name' => 'etcc news', 'class' => 'menu-main-sub-1-item', 'link' => "news-cate/cate/etcc"),
                array('ID' => 'news-05', 'name' => 'atcc news', 'class' => 'menu-main-sub-1-item', 'link' => "news-cate/cate/atcc"),
                array('ID' => 'news-06', 'name' => 'twccla news', 'class' => 'menu-main-sub-1-item', 'link' => "news-cate/cate/twccla"),
                array('ID' => 'news-07', 'name' => 'tcco news', 'class' => 'menu-main-sub-1-item', 'link' => "news-cate/cate/tcco"),
                array('ID' => 'news-08', 'name' => 'wtccjc news', 'class' => 'menu-main-sub-1-item', 'link' => "news-cate/cate/wtccjc"),
            ],
        ),
        'affairs' => array(
            'name' => "affairs",
            'class' => 'menu-main-item',
            'subClass' => 'menu-main-sub-1', // neu co sub menu phai them sub Class
            // 'sub' => getCategories('active_category'),
        ),
        'activitys' => array(
            'name' => "newsletters and magazine",
            'class' => 'menu-main-item',
            'subClass' => 'menu-main-sub-1', // neu co sub menu phai them sub Class
            'sub' => [
                array('ID' => 'letter-01', 'name' => 'newsletters', 'class' => 'menu-main-sub-1-item', 'link' => "activity-cate/cate/newsletter"),
                array('ID' => 'letter-02', 'name' => 'magazine', 'class' => 'menu-main-sub-1-item', 'link' => "activity-cate/cate/magazine"),
            ],
        ),
        'registration' => array(
            'name' => "registration form",
            'class' => 'menu-main-item',
            'sub' => ''
        ),
        // '30thregistration' => array(
        //     'name' => "30th registration form",
        //     'class' => 'menu-main-item',
        //     'sub' => ''
        // ),
        'calendar' => array(
            'name' => "calendar",
            'class' => 'menu-main-item',
            'sub' => ''
        ),
        'files' => array(
            'name' => "files",
            'class' => 'menu-main-item',
            'sub' => ''
        ),
    );
    return $arr;
}



function ProfessionalTitle($id)
{
    switch ($id) {
        case '01':
            $val = "總會長";
            break;
        case '02':
            $val = "監事長";
            break;
        case '03':
            $val = "副總會長";
            break;
        case '04':
            $val = "秘書長";
            break;
        case '05':
            $val = "財務長";
            break;
    }

    return $val;
}


function languageName($id)
{
    switch ($id) {
        case 'cn':
            $val = "中文";
            break;
        case 'en':
            $val = "英文";
            break;
    }

    return $val;
}
