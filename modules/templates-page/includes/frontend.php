<div id="template">
    <div class="row">
		<?php
		// WP Query arguments
		$args = array(
			'post_type'      => 'template',
			'posts_per_page' => - 1,
		);

		// The Query
		$query = new WP_Query( $args );

		// Loop through posts
		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();
				?>

                <div class="col-lg-3 col-md-4 col-sm-12 d-flex align-items-stretch">
                    <div class="template__card">
                        <div class="template__card--img">
							<?php
							if ( has_post_thumbnail() ) {
								the_post_thumbnail( 'thumbnail' );
							} else {
								?>
                                <img src="<?php echo plugin_dir_url( __DIR__ ); ?>/img/icon.png" alt="">
								<?php
							}
							?>
                        </div>

                        <div class="template__card--title">
                            <h1>
								<?php the_title(); ?>
                            </h1>
                        </div>

                        <div class="template__card--desc">
							<?php
							$excerpt         = get_the_excerpt();
							$words           = explode( ' ', $excerpt );
							$limited_excerpt = implode( ' ', array_slice( $words, 0, 10 ) );
							echo "<p>$limited_excerpt</p>";
							?>
                        </div>

                        <div class="template__card--desc--hiden" style="display: none">
							<?php the_content(); ?>
                        </div>
                    </div>
                </div>

				<?php
			}
		} else {
			// No posts found
			echo 'No templates found.';
		}

		wp_reset_postdata();
		?>
    </div>
</div>

<script>
    jQuery(document).ready(function () {
        jQuery('.template__card').on('click', function () {
            let templateContent = jQuery(this).find('.template__card--desc--hiden').text().trim();
            localStorage.setItem('templateContent', templateContent);
            window.location.href = 'http://botterflyai.local/app/letter/';
        });
    });
</script>
