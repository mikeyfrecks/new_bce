<?php
/**
 * Template Name: Home Page
 */
?>


<?php include 'header.php'; ?>
<section class="hp top-content">
  <h1>
  <?php echo md_sc_parse($post->post_content);?>
  </h1>
</section>


  <?php

  $args = array(
    'post_type' 		=> 'project',
    'posts_per_page' => 4,
    'orderby' 			=> 'menu_order',
    'order' 			=> 'ASC'
  );
  $project_query = new WP_Query($args);
?>
<?php if ( $project_query->have_posts() ) :?>
<section class="hp projects clearfix">
<h2 class="hp sub-header">Projects</h2>
<?php $projects = $project_query->get_posts(); ?>

<?php
foreach($projects as $p) {
  $pid = $p->ID;

  ?>
  <article class="project above-line poster-img">
    <?php
    if(!has_post_thumbnail($pid)) {
      $socialImg = get_all_image_sizes(get_option( 'social_icon_image', '' ));
      echo '<img src="'.$socialImg['full']['url'].'" alt="'.get_the_title($pid).'" class="project-img"/>';
    } else {
      $imgs = get_all_image_sizes(get_post_thumbnail_id($pid));
      $srcset="";
      $looper = 0;
      foreach($imgs as $i) {
        if($looper > 0) {
          $srcset .= ',';
        }
        $srcset .= ($i['url'].' '.$i['width'].'w');

        $looper++;
      }
      ?>
      <img
      sizes="100vw"
      class="project-img"
      src="<?php echo $imgs['full']['url'];?>"
      srcset="<?php echo $srcset;?>"
      alt="<?php echo get_the_title($pid);?>"
      />
      <?php
    }

     ?>
    <h3>
    <a href="<?php echo get_the_permalink($pid);?>">
      <div class="callout ">
        <span class="title"><?php echo get_the_title($pid);?></span>
        <span class="tagline font-sans"><?php echo get_post_meta( $pid, 'tagline', true );?></span>
      </div>
    </a>
  </h3>
  </article>

  <?php

}

 ?>
 <a href="<?php echo $homeURL;?>/projects" class="button-style bottom-button">See All Projects <span class="bug "><?php echo file_get_contents($siteDir.'/assets/svgs/icon_arrow_right.svg');?></span></a>
</section>

<?php endif;?>
<?php
$pargs = array(
  'post_type' 		=> 'post',
  'posts_per_page' => 2
);
$post_query = new WP_Query($pargs);
 ?>
<?php if ( $post_query->have_posts() ) :?>
<section class="hp blog clearfix">
<h2 class="hp sub-header">From the Blog</h2>
<?php $posts = $post_query->get_posts(); ?>
<?php
foreach($posts as $p) {
  $pid = $p->ID;

  ?>
  <article class="post">
    <h3>
    <a href="<?php echo get_the_permalink($pid);?>"><span class="title"><?php echo get_the_title($pid);?></span></a>
    <span class="time font-sans">
      <?php echo human_time_diff( get_the_time('U', $pid), current_time('timestamp') ) . ' ago'; ?>
    </span>
    </h3>

  </article>

  <?php

}

 ?>

<a href="<?php echo $homeURL;?>/blog" class="button-style bottom-button">See All Blog Posts <span class="bug "><?php echo file_get_contents($siteDir.'/assets/svgs/icon_arrow_right.svg');?></span></a>
</section>
<?php endif;?>


<?php include 'footer.php'; ?>