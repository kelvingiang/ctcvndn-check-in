<?php
function my_presidents($post, $cate_name, $cate, $count, $year)
{
?>
   <div class="president-box animation-item">
      <div class="president-year">
         <?php echo $year ?>
      </div>
      <div class="president-item ">
         <?php
         $loop = my_custom_post_cat($post, $cate_name, $cate, $count);
         if ($loop->have_posts()) :
            while ($loop->have_posts()) :
               $loop->the_post();
               $img = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full');
               $terms = wp_get_post_terms(get_the_ID(), 'president_category');
         ?>
               <div class="president-cell">
                  <div class="president-title">
                     <label><?php echo ProfessionalTitle(get_post_meta(get_the_ID(), "_meta_box_professional", true)) ?></label>
                  </div>
                  <div class="president-text">
                     <?php if (!empty($img[0])) {  ?>
                        <div class="president-img ">
                           <img src="<?php echo $img[0] ?>" />
                        </div>
                        <label><?php the_title(); ?></label>
                     <?php } else { ?>
                        <label><?php the_content() ?></label>
                     <?php } ?>
                  </div>

               </div>
         <?php
            endwhile;
         endif;
         wp_reset_postdata()
         ?>
      </div>

   </div>

<?php
}
