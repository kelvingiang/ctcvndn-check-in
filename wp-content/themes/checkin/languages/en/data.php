<?php

function getTranslate()
{
    $data = array(
        'history and purpose' => 'History and Purpose',
        'organizations and meetings' => 'Organizations and Meetings',
        'organizational chart' => 'Organizational Chart',
        'former presidents' => 'Former Presidents',
        'former presidents and directors' => 'Former Presidents and Directors',
        'continental chambers' => ' About Continental Chambers',
        'continental youth' => 'About WTCCJC',
        'regulation'=> 'Regulations',
        'constitution' => 'Constitution',
        'regulations'=>'章程施行細則暨選舉辦法',
        'rules of procedure'=>'Rules of Procedure',
        'rules of procedure for the working committee' => 'Rules of Procedure for the Working Committee',
        'guidelines for meeting management'=> 'Guidelines for Meeting Management',
        'taipei office management guidelines' => 'Taipei Office Management Guidelines',
        'news' => 'News',
        'wtcc news' => 'WTCC News',
        'tccna news'=>'WTCC News',
        'astcc news'=>'ASTCC News',
        'etcc news'=>'ETCC News',
        'atcc news'=>'ATCC News',
        'twccla news'=> 'TWCCLA News',
        'tcco news'=> 'TCCO News',
        'wtccjc news'=> 'WTCCJC News',
        'affairs' => 'Affairs',
        'newsletters and magazine'=> 'Newsletters and Magazine',
        'registration form' => 'Registration Form',
        'calendar'=> 'Calendar',
        'files'=> 'Files',
        'newsletters' => 'Newsletters',
        'magazine' => 'Magazine',
    );

    $data_menu = array(
        'home' => 'Home',
        'about us' => 'About Us',
        'test' => 'Test',
    );

    return array_merge($data, $data_menu);
}
