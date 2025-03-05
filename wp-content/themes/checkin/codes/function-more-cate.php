<?php
function getMoreCate($cate_name)
{
    global $post;
    $postType = $post->post_type;
    $terms = get_the_terms($post->ID, $cate_name);
    if (!empty($terms)) {
        $cateName = $terms[0]->taxonomy;
        $cateValue = $terms[0]->slug;
    } else {
        // echo 'rong';
    }
?>
    <div class="single-more">
        <div class="article-list">
            <?php
            $loop = my_get_more_cate($postType, $post->ID, $cateName, $cateValue);

            //===== 2 phan trang xac dinh so trang E========

            if ($loop->have_posts()) :
                $stt = 1;
                while ($loop->have_posts()) :
                    $loop->the_post();
                    //     $images = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full');
                    //  $objImageData = get_post(get_post_thumbnail_id(get_the_ID()));
                    //  $strAlt = get_post_meta(get_post_thumbnail_id(get_the_ID()), '_wp_attachment_image_alt', true);


            ?>
                    <div class="article-list-item" data-id="<?php echo $stt ?>">
                        <div>
                            <div class="title">
                                <a class="my-link" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </div>
                        </div>
                        <div class="date">
                            <?php
                            $date = explode('-', get_the_date('d-m-Y'));
                            ?>
                            <div><?php echo $date[2] . ' / ' . $date[1] ?></div>
                            <div><?php echo $date[0] ?></div>
                        </div>
                    </div>
            <?php
                    $stt += 1;
                endwhile;
            endif;
            wp_reset_postdata();
            wp_reset_query();
            ?>
        </div>
        <div id="load-more">
            <i class="fa fa-angle-double-down" aria-hidden="true"></i>
        </div>


    </div>
    <script>
        jQuery(document).ready(function() {
            jQuery('#load-more').click(function() {

                // Phần chạy xuống đến phần cuối trang và cách trang là 20px
                // jQuery('html, body').animate({
                //     scrollTop: jQuery(document).height() - 20
                // }, 'slow');

                // phần chạy tại điểm hiện tại dịch xuống 300px
                // 获取当前滚动位置
                var currentScroll = $(window).scrollTop();
                // 计算目标滚动位置
                var targetScroll = currentScroll + 300;
                // 滚动到目标位置
                $('html, body').animate({
                    scrollTop: targetScroll
                }, 800);


                var lastID = jQuery(".article-list > .article-list-item:last-child").attr("data-id");
                var currentID = '<?php echo $post->ID ?>';
                var postType = '<?php echo $postType ?>';
                var cateName = '<?php echo $cateName ?>';
                var cateValue = '<?php echo $cateValue ?>';

                jQuery.ajax({
                    url: '<?php echo get_template_directory_uri() . '/ajax/load-more-single-cate.php' ?>', // lay doi tuong chuyen sang dang array
                    type: 'post', //                data: $(this).serialize(),
                    data: {
                        lastID: lastID,
                        currentID: currentID,
                        postName: postType,
                        cateName: cateName,
                        cateValue: cateValue
                    },
                    dataType: 'json',
                    success: function(data) { // set ket qua tra ve  data tra ve co thanh phan status va message
                        if (data.status === 'done') {
                            jQuery(".article-list").append(data.html);
                        } else if (data.status === 'empty') {
                            jQuery("#load-more").hide();
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr.reponseText);
                        //console.log(data.status);
                    }
                });
            });
        });
    </script>
<?php
}
