<?php

// chi doi ten mac dinh cua POST sang 1 ten moi  =========================================
add_action('init', 'cp_change_post_object');
// Change dashboard Posts to News
function cp_change_post_object()
{
    $get_post_type = get_post_type_object('post');
    $labels = $get_post_type->labels;
    $labels->name = '最新消息';
    $labels->singular_name = '最新消息';
    $labels->add_new = '新增';
    $labels->add_new_item = '新增';
    $labels->edit_item = '編輯';
    $labels->new_item = '最新消息';
    $labels->view_item = '';
    $labels->search_items = '搜索';
    $labels->not_found = '找到任何資料';
    $labels->not_found_in_trash = '回收桶中未找到任何資料';
    $labels->all_items = '全部';
    $labels->menu_name = '最新消息';
    $labels->name_admin_bar = '最新消息';
}

//==== QUAN LI CAC COT MAC DINH TRONG POST ===================================================================

add_filter('manage_posts_columns', 'set_custom_edit_columns');

function set_custom_edit_columns($columns)
{
    unset($columns['tags']);
    unset($columns['comments']);
    unset($columns['date']);
    unset($columns['author']);
    unset($columns['categories']);
    $columns['language'] = __('Language');
    $columns['order'] = __('Order');
    $columns['cate'] = __('Category');
    $columns['postdate'] = __('Date');
    //    $columns['author'] = __('Author');
    return $columns;
}


add_action('manage_posts_custom_column', 'Custom_Post_RenderCols');

function Custom_post_RenderCols($columns)
{
    global $post;
    switch ($columns) {

        case 'home':
            if ((get_post_meta($post->ID, '_metabox_home', true))) {
                echo "<div class='show-home'></div>";
            }
            break;

        case 'cate':

            $terms = wp_get_post_terms($post->ID, 'post_category');
            if (!is_wp_error($terms) && count($terms) > 0) {
                foreach ($terms as $key => $term) {
                    echo '<a href=' . custom_redirect($term->slug) . ' &' . $term->taxonomy . '=' . $term->slug . '>' . $term->name . '</a></br>';
                }
            }
            break;

        case 'language':
            _e(get_post_meta($post->ID, '_meta_box_language', true));
            break;

        case 'order':
            echo get_post_meta($post->ID, '_meta_box_order', true);
            break;

        case 'postdate':
            echo get_the_date('d-m-Y');
            break;
        default:
            break;
    }
}


add_filter('manage_edit-column-order_sortable_columns', 'set_custom_mycpt_sortable_columns');

function set_custom_mycpt_sortable_columns($columns)
{
    $columns['order'] = 'custom_taxonomy';


    return $columns;
}


// không cho tạo ra nhiều file ảnh ở các kich thước khi upload ảnh lên ==========================
function remove_default_image_sizes($sizes)
{
    unset($sizes['large']);
    unset($sizes['thumbnail']);
    unset($sizes['medium']);
    unset($sizes['medium_large']);
    unset($sizes['1536x1536']);
    unset($sizes['2048x2048']);
    return $sizes;
}
add_filter('intermediate_image_sizes_advanced', 'remove_default_image_sizes');

function create_qrcode()
{
    $num = str_pad(mt_rand(1, 99999999), 8, '0', STR_PAD_LEFT);
    $code = date("md") . $num;
    return $code;
}
