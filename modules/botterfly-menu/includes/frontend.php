<div id="d-sidebar">
    <!-- Sidebar -->
    <div class="toggle-btn-open">
        <i class='bx bx-food-menu'></i>
    </div>

    <nav>
        <!-- Sidebar Top Section -->
        <div class="sidebar-top">
                <span class="shrink-btn">
                    <i class='bx bx-chevron-left'></i>
                </span>
            <span class="shrink-btn">
                    <i class='bx bx-chevron-left'></i>
                </span>
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                <img src="<?php echo plugin_dir_url( __DIR__ ); ?>/img/logo.png" id="logo" class="logo" alt="">
            </a>


        </div>

        <!-- Sidebar Links Section -->
        <div id="sidebar-links" class="sidebar-links">
            <ul>
                <li>
                    <a href="<?php echo esc_url( home_url( '/app/ai-art' ) ); ?>">
                        <div class="icon">
                            <i class='bx bx-cube'></i>
                        </div>
                        <span class="link hide">AI Art</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo esc_url( home_url( '/app/letter' ) ); ?>">
                        <div class="icon">
                            <i class='bx bx-message-square-detail'></i>
                        </div>
                        <span class="link hide">Letter</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo esc_url( home_url( '/app/letter-copy' ) ); ?>">
                        <div class="icon">
                            <i class='bx bx-briefcase-alt-2'></i>
                        </div>
                        <span class="link hide">Bulk Letters</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo esc_url( home_url( '/app/template' ) ); ?>">
                        <div class="icon">
                            <i class='bx bx-food-menu'></i>
                        </div>
                        <span class="link hide">Templates</span>
                    </a>
                </li>
            </ul>

			<?php
			$current_user = wp_get_current_user();
			$username     = $current_user->user_login;

			// Query to retrieve letters based on the current username
			$letters_query = new WP_Query( array(
				'post_type'      => 'letters',
				'post_status'    => 'publish',
				'meta_query'     => array(
					array(
						'key'     => 'username',
						'value'   => $username,
						'compare' => '=',
					),
				),
				'posts_per_page' => - 1,
			) );

			if ( $letters_query->have_posts() ) {
				?>
                <h4 class="hide">Letters</h4>
                <ul>
					<?php
					while ( $letters_query->have_posts() ) {
						$letters_query->the_post();
						$post_title = get_the_title();
						$post_id    = get_the_ID();
						?>
                        <li>
                            <a class="letters-menu-item" data-postid="<?php echo $post_id; ?>" href="#">
                                <div class="icon">
                                    <i style="color: #C69AFF;" class='bx bxs-square-rounded'></i>
                                </div>
                                <span class="link hide"><?php echo esc_html( $post_title ); ?></span>
                            </a>
                        </li>
						<?php
					}
					?>
                </ul>
				<?php
				wp_reset_postdata();
			}
			?>

        </div>

        <!-- Sidebar Footer -->
        <div class="sidebar-footer">
            <div class="admin-user tooltip-element">
                <div class="admin-profile hide">
                    <!--                    <img src="-->
					<?php //echo plugin_dir_url( __DIR__ ); ?><!--/img/face-1.png" alt="">-->
                    <div class="admin-info ">
                        <h3>
							<?php
							$current_user = wp_get_current_user();
							$display_name = $current_user->display_name;
							echo esc_html( $display_name );
							?>
                            <span class="free">Paid</span>
                        </h3>
                        <h5><?php echo esc_html( $current_user->user_email ); ?></h5>
                    </div>

                </div>
                <a href="/handlers/stripe-customer-portal-handler.php" target="_blank" class="upgrade-to-pro">
                    Manage billing & invoices
                </a>
            </div>
        </div>
    </nav>
</div>

<script>
    jQuery(document).ready(function () {
        const shrink_btn = jQuery(".shrink-btn");
        const sidebar_links = jQuery(".sidebar-links a");
        const active_tab = jQuery(".active-tab");
        const logo = jQuery("#logo");
        const shortcuts = jQuery(".sidebar-links h4");
        const toggle_btn_open = jQuery(".toggle-btn-open");
        const toggle_btn_close = jQuery(".toggle-btn-close");
        const sidebar_footer = jQuery(".sidebar-footer");

        toggle_btn_open.on("click", function () {
            jQuery("#d-sidebar").addClass("mobile");
        });

        toggle_btn_close.on("click", function () {
            jQuery("#d-sidebar").removeClass("mobile");
        });

        shrink_btn.on("click", function () {
            jQuery("#logo").toggleClass("logo-hide");
            sidebar_footer.toggle();
            jQuery("#d-sidebar").toggleClass("shrink");
            setTimeout(moveActiveTab, 400);

            shrink_btn.addClass("hovered");

            setTimeout(function () {
                shrink_btn.removeClass("hovered");
            }, 500);
        });

        jQuery('.letters-menu-item').on('click', function () {
            var postId = jQuery(this).data('postid');
            var url = '<?php echo home_url(); ?>/app/letter/?letterid=' + encodeURIComponent(postId);
            window.location.href = url;
        });

    });

</script>