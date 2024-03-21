<?php get_header(); ?>

<div id="main-content">
	<div class="container no-divider">
		<div id="content-area" class="clearfix">
      <article id="post-0" <?php post_class( 'page-404 et_pb_post not_found s-search' ); ?>>
        <?php 
          global $et_no_results_heading_tag;
          if ( empty( $et_no_results_heading_tag ) ){
            $et_no_results_heading_tag = 'h1';
          }
        ?>
        <div class="et_pb_row w-100">
          <div class="et_pb_column et_pb_column_4_4 et_pb_column_0  et_pb_css_mix_blend_mode_passthrough et-last-child">
            <<?php echo $et_no_results_heading_tag; ?> class="not-found-title font-medium"><?php esc_html_e('This Page Does Not Exist','Divi'); ?></<?php echo $et_no_results_heading_tag; ?>>
          </div>
        </div>

        <div class="et_pb_row w-100">
          <div class="et_pb_column et_pb_column_1_2 et_pb_column_1  et_pb_css_mix_blend_mode_passthrough">
            <div class="entry">
              <p>Sorry, the page you are looking for doesn't exist <br>or has been moved.</p>
              <p>Here are some helpful links:</p>

              <?php echo do_shortcode('[et_pb_search _builder_version=”4.21.0″ _module_preset=”default” theme_builder_area=”post_content” hover_enabled=”0″ sticky_enabled=”0″][/et_pb_search]'); ?>

              <ul class="btn-group">
                <li><a href="/" onclick="goBackOrHome()">← Go back</a></li>
                <li><a href="<?php echo home_url( '/' ); ?>" class="dark">Take me home →</a></li>
              </ul>

              <?php
                // wp_nav_menu([
                //   'theme_location'  => 'primary-menu',
                //   'container'       => false,
                //   'container_class' => false,
                //   'menu_id'         => false,
                //   'menu_class'      => 'navbar-nav',
                //   'depth'           => 1,
                // ]);
              ?>
            </div>
          </div>

          <div class="et_pb_column et_pb_column_1_2 et_pb_column_2  et_pb_css_mix_blend_mode_passthrough et-last-child s-search">
          
          </div>
        </div>
      </article>
		</div>
	</div>
</div>

<script>
  function goBackOrHome() {
    const currentSite = 'croptrak.com';
    console.log
    if (document.referrer.indexOf(currentSite) !== -1) {
      history.back();
    } else {
      window.location.href = '/';
    }
  }
</script>

<?php

get_footer();
