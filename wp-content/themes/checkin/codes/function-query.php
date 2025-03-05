<?php

function my_custom_post_home($post, $count)
{
    // die($_SESSION['languages']);
    // post__not_in' => array(159), 159 là ID của bài post 青商會介紹
    // $youthID =   $_SESSION['languages'] == 'en' ? '164' : '159';
    $args = array(
        'post_type' => $post,
        'posts_per_page' => $count,
        // 'post__not_in' => array($youthID),
        'order' => 'DESC',
        'orderby' => 'ID',
        'meta_query'    => array(
            array(
                'key'       => '_meta_box_language',
                'value'     =>  $_SESSION['languages'],
                'compare'   => '=',
            ),
        )
    );
    return new WP_Query($args);
}




function my_custom_post($post, $count)
{
    // die($_SESSION['languages']);
    // post__not_in' => array(159), 159 là ID của bài post 青商會介紹
    $youthID =   $_SESSION['languages'] == 'en' ? '164' : '159';
    $args = array(
        'post_type' => $post,
        'posts_per_page' => $count,
        'post__not_in' => array($youthID),
        'orderby' => 'meta_value_num',
        'order' => 'DESC',
        'meta_key' => '_meta_box_order',
        'meta_query'    => array(
            array(
                'key'       => '_meta_box_language',
                'value'     =>  $_SESSION['languages'],
                'compare'   => '=',
            ),
        )
    );
    return new WP_Query($args);
}


function my_custom_post_cat($post, $catName, $cat, $count)
{

    $args = array(
        'post_type' => $post,
        'posts_per_page' => $count,
        $catName => $cat,
        'orderby' => 'meta_value_num',
        'order' => 'DESC',
        'meta_key' => '_meta_box_order',
        // get cac bai trong category
        'meta_query'    => array(
            array(
                'key'       => '_meta_box_language',
                'value'     =>  $_SESSION['languages'],
                'compare'   => '=',
            ),
        )
    );
    return new WP_Query($args);
}


function getCategories($cate)
{
    $arr = array();
    $argsCate = array(
        'type' => 'post',
        'posts_per_page' => -1,
        'taxonomy' => $cate,
        'hide_empty' => 0,
        'parent' => 0,
    );
    $categories = get_categories($argsCate);

    if ($categories) {
        foreach ($categories as $key => $value) {
            $option = get_option("option_" . $cate . "_" . $value->term_id . "");
            /*  echo "option_" . $cate . "_" . $value->term_id . "";
            echo "<pre>";
            print_r($option);
            echo "</pre>";*/
            $arr[$value->term_id] = array(
                'ID' => $value->term_id,
                'name' => $option['cate_' . $_SESSION['languages']],
                'class' => 'menu-main-sub-1-item',
                'order' => $option['cate_order'],
                'sub' => '',
            );
        }
    }

    usort($arr, "cmp");

    return $arr;
}


function my_get_more($post, $not_id)
{
    // lay cac tin trong ban 
    $args = array(
        'post_type' => $post,
        'post__not_in' => array($not_id, 159),
        'posts_per_page' => get_option('_more_count'),
        'orderby' => 'meta_value_num',
        'order' => 'DESC',
        'meta_key' => '_meta_box_order',
        'meta_query'    => array(
            array(
                'key'       => '_meta_box_language',
                'value'     =>  $_SESSION['languages'],
                'compare'   => '=',
            ),
        )
    );

    return  new WP_Query($args);
}

function my_get_more_cate($post, $not_id, $cate_name,  $cate)
{
    // lay cac tin trong ban 
    $args = array(
        'post_type' => $post,
        'post__not_in' => array($not_id, 159),
        $cate_name => $cate,
        'posts_per_page' => get_option('_more_count'),
        'orderby' => 'meta_value_num',
        'order' => 'DESC',
        'meta_key' => '_meta_box_order',
        'meta_query'    => array(
            array(
                'key'       => '_meta_box_language',
                'value'     =>  $_SESSION['languages'],
                'compare'   => '=',
            ),
        )
    );

    return  new WP_Query($args);
}


function my_get_post_by_cate_slug($isPost, $cateName, $cate, $count = '')
{
    $count == '' ? get_option('_page_count') : $count;
    $arg = array(
        'post_type' => $isPost,
        'posts_per_page' => $count,
        'orderby' => 'meta_value_num',
        'order' => 'DESC',
        'meta_key' => '_meta_box_order',
        'meta_query'    => array(
            array(
                'key'       => '_meta_box_language',
                'value'     =>  $_SESSION['languages'],
                'compare'   => '=',
            ),
        ),
        'tax_query' => array(
            array(
                'taxonomy' => $cateName,
                'field' => 'slug',
                'terms' => $cate,
            )
        )
    );
    $loop = new WP_Query($arg);
    return $loop;
}

function vn_to_str($str)
{

    $unicode = array(

        'a' => 'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',

        'd' => 'đ',

        'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',

        'i' => 'í|ì|ỉ|ĩ|ị',

        'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',

        'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',

        'y' => 'ý|ỳ|ỷ|ỹ|ỵ',

        'A' => 'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',

        'D' => 'Đ',

        'E' => 'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',

        'I' => 'Í|Ì|Ỉ|Ĩ|Ị',

        'O' => 'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',

        'U' => 'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',

        'Y' => 'Ý|Ỳ|Ỷ|Ỹ|Ỵ',

    );

    foreach ($unicode as $nonUnicode => $uni) {

        $str = preg_replace("/($uni)/i", $nonUnicode, $str);
    }
    $str = str_replace(' ', '_', $str);

    return $str;
}

// function getCustomPostCateAtHome($postType, $cateSlug, $postCount)
// {
//     $arr = array(
//         'post_type' => $postType,
//         'resources_category' => $cateSlug,
//         'posts_per_page' => $postCount,
//         'orderby' => 'meta_value_num',
//         'order' => 'DESC',
//         'meta_key' => '_metabox_order',

//         // get cac bai trong category
//         'meta_query'    => array(
//             array(
//                 'key'       => '_metabox_langguage',
//                 'value'     =>  $_SESSION['languages'],
//                 'compare'   => '=',
//             ),

//             // array(
//             //     'key'       => '_metabox_home',
//             //     'value'     =>  true,
//             //     'compare'   => '=',
//             // ),

//         ),
//     );

//     $wp_query = new WP_Query($arr);
//     return $wp_query;
// }
