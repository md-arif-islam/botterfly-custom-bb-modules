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
            <img src="<?php echo plugin_dir_url( __DIR__ ); ?>/img/logo.png" id="logo" class="logo" alt="">

        </div>

        <!-- Sidebar Links Section -->
        <div id="sidebar-links" class="sidebar-links">
            <ul>
                <li>
                    <a href="#" class="active">
                        <div class="icon">
                            <i class='bx bx-home-alt'></i>
                        </div>
                        <span class="link hide">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <div class="icon">
                            <i class='bx bx-cube'></i>
                        </div>
                        <span class="link hide">AI Art</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <div class="icon">
                            <i class='bx bx-message-square-detail'></i>
                        </div>
                        <span class="link hide">Letter</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <div class="icon">
                            <i class='bx bx-briefcase-alt-2'></i>
                        </div>
                        <span class="link hide">Bulk Letters</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <div class="icon">
                            <i class='bx bx-food-menu'></i>
                        </div>
                        <span class="link hide">Templates</span>
                    </a>
                </li>
            </ul>
            <h4 class="hide">Letters</h4>
            <ul>
                <li>
                    <a href="#">
                        <div class="icon">
                            <i style="color: #C69AFF;" class='bx bxs-square-rounded'></i>
                        </div>
                        <span class="link hide">Letter_test1</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <div class="icon">
                            <i style="color: #9AC8FF;" class='bx bxs-square-rounded'></i>
                        </div>
                        <span class="link hide">Letter_test2</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Sidebar Footer -->
        <div class="sidebar-footer">
            <div class="admin-user tooltip-element">
                <div class="admin-profile hide">
                    <img src="<?php echo plugin_dir_url( __DIR__ ); ?>/img/face-1.png" alt="">
                    <div class="admin-info">
                        <h3>John Carter <span class="free">Free</span> </h3>
                        <h5>johncarter@botterfly.io</h5>
                    </div>
                </div>
                <a href="#" class="upgrade-to-pro">
                    Upgrade to Pro
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

        // Using jQuery
        jQuery("a").on("click", function () {
            jQuery(this).toggleClass("active");
        });

    });

</script>