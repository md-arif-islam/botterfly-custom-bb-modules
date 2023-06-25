<div id="d-image-generation">
    <div class="p-image-generation">
        <div class="heading">
            <div class="icon">
                <i class='bx bx-food-menu'></i>
            </div>
            <span>Image Generation</span>
        </div>
        <div class="container">
            <div class="slider"></div>
            <div class="btn">
                <button class="utm">Upload to modify</button>
                <button class="r-art">Request art</button>
            </div>
            <div id="feedback-status">

            </div>
            <div class="form-section" id="art-from">
                <div class="utm-box">
                    <form class="form" id="art-modify-form" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="amf-image-upload">Upload the image here</label>
                            <div class="upload-container">
                                <input type="file" id="amf-image-upload" accept="image/*" style="display: none;"
                                       onchange="handleFileSelect(event)">
                                <label for="amf-image-upload" class="upload-label" ondragover="handleDragOver(event)"
                                       ondragleave="handleDragLeave(event)" ondrop="handleDrop(event)">
                                    <span id="uploaded-text"><i class="fa fa-upload"></i>Click or drop image</span>
                                    <img id="preview-image" src="#" alt="Preview" style="display: none;">
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="wad">Write a detailed description with instructions for the
                                modifications</label>
                            <textarea class="form-control" id="amf-wad" rows="3"
                                      placeholder="Enter key points and words you want to be included"></textarea>
                            <small>Maximum 80 words</small>
                        </div>
                        <div class="form-group">
                            <label for="amf-nof">No. of letiations</label>
                            <select class="form-control" id="amf-nof">
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                            </select>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="gs-btn" id="amf-btn">
                                Modify Now <i style="display: none" class="fa fa-spinner fa-spin loading-icon"></i>
                            </button>

                        </div>
                    </form>
                </div>
                <div class="r-art-box">
                    <form class="form" id="art-request-form">
                        <div class="form-group">
                            <label for="wad">Write a detailed descriptions with instructions for the
                                modifications</label>
                            <textarea class="form-control" id="acf-wad" rows="3"
                                      placeholder="Enter key points and words you want to be included"></textarea>
                            <small>Maximum 80 words</small>
                        </div>
                        <div class="form-group">
                            <label for="aoe-resolution">Image resolution</label>

                            <select class="form-control" id="acf-resolution">

                                <option>512x512</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="aoe-samples">No. of samples</label>

                            <select class="form-control" id="acf-samples">

                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="woum">Add prompt</label>
                            <input type="text" class="form-control" id="acf-woum"
                                   placeholder="Type your prompt here...">
                            <small>Maximum 80 words</small>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="gs-btn" id="generate-ai-content-btn">Generate AI Content <i style="display: none" class="fa fa-spinner fa-spin loading-icon"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="generated-image-section">
        <div class="content">
            <div class="row">
				<?php
				$current_user = wp_get_current_user();
				$username     = $current_user->user_login;

				$args = array(
					'post_type'  => 'art_request',
					'meta_query' => array(
						array(
							'key'     => 'username', // Replace 'username' with the actual meta field key
							'value'   => $username,
							'compare' => '='
						)
					)
				);

				$query = new WP_Query( $args );

				if ( $query->have_posts() ) {
					while ( $query->have_posts() ) {
						$query->the_post();
						// Get the gallery images
						$art_images = get_field( 'art_images' );

						if ( $art_images ) {
							foreach ( $art_images as $image_id ) {
								$image_url = wp_get_attachment_image_url( $image_id, 'large' ); // Adjust the image size as needed
								$image_alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
								?>
                                <div class="col-md-6 col-sm-12">
                                    <div class="image-box">
                                        <div class="image">
                                            <img src="<?php echo esc_url( $image_url ); ?>"
                                                 alt="<?php echo esc_attr( $image_alt ); ?>">
                                        </div>
                                        <div class="buttons">
                                            <a href="<?php echo esc_url( $image_url ); ?>" download>Download <i
                                                        class='bx bx-download'></i></a>
                                            <p>Delivered on <?php echo get_the_date( 'd.m.Y' ); ?> <i
                                                        class='bx bx-calendar'></i></p>
                                        </div>
                                    </div>
                                </div>
								<?php
							}
						}
					}
					wp_reset_postdata();
				} else {
					// No matching posts found
				}
				?>
            </div>
        </div>
    </div>

</div>
<script>
    jQuery(document).ready(function () {
        let r_art = jQuery(".r-art");
        let utm = jQuery(".utm");
        let slider = jQuery(".slider");
        let formSection = jQuery(".form-section");

        r_art.on("click", function () {
            slider.addClass("moveslider");
            formSection.addClass("form-section-move");
        });

        utm.on("click", function () {
            slider.removeClass("moveslider");
            formSection.removeClass("form-section-move");
        });

        let activeIndex;

        jQuery(".upload-label").on("dragover", function (event) {
            event.preventDefault();
            jQuery(this).addClass("drag-over");
        });

        jQuery(".upload-label").on("dragleave", function (event) {
            event.preventDefault();
            jQuery(this).removeClass("drag-over");
        });

        jQuery(".upload-label").on("drop", function (event) {
            event.preventDefault();
            jQuery(this).removeClass("drag-over");

            let file = event.originalEvent.dataTransfer.files[0];
            displayPreview(file);
        });

        jQuery("#amf-image-upload").on("change", function (event) {
            let file = event.target.files[0];
            displayPreview(file);
        });

        function displayPreview(file) {
            let reader = new FileReader();

            reader.onload = function (e) {
                let previewImage = jQuery("#preview-image");
                previewImage.attr("src", e.target.result);
                previewImage.css("display", "block");

                let uploadedText = jQuery("#uploaded-text");
                uploadedText.text(file.name);
                uploadedText.addClass("uploaded");
            };

            reader.readAsDataURL(file);
        }

        jQuery('#art-request-form').submit(function (event) {
            event.preventDefault(); // Prevent form from submitting normally

            let acfWad = jQuery('#acf-wad').val();
            let acfResolution = jQuery('#acf-resolution').val();
            let acfSamples = jQuery('#acf-samples').val();
            let acfWoum = jQuery('#acf-woum').val();

            let formData = {
                acfWad: acfWad,
                acfResolution: acfResolution,
                acfSamples: acfSamples,
                acfWoum: acfWoum
            };

            jQuery.ajax({
                type: 'POST',
                url: '<?php echo plugin_dir_url( __DIR__ ); ?>generate-ai-content.php',
                data: formData,
                beforeSend: function () {
                    jQuery(".loading-icon").show();
                },
                success: function (response) {
                    if (response == 'success') {
                        jQuery('#art-from').hide();
                        jQuery('#feedback-status').html('<p>Your feedback was sent successfully. Thank you for getting in touch!</p>');
                    } else {
                        jQuery('#feedback-status').html('<p>Sorry, an error occurred while sending your feedback. Please try again later.</p>');
                    }
                },
                error: function (xhr, status, error) {
                    console.log(error);
                },
                complete: function () {
                    jQuery(".loading-icon").hide();
                }
            });
        });

        jQuery('#art-modify-form').submit(function (event) {
            event.preventDefault(); // Prevent form from submitting normally

            let formData = new FormData(); // Create a new FormData object

            let amfImageFile = jQuery("#amf-image-upload")[0].files[0];
            let amfWad = jQuery("#amf-wad").val();
            let amfNof = jQuery("#amf-nof").val();

            formData.append("amfImageFile", amfImageFile);
            formData.append("amfWad", amfWad);
            formData.append("amfNof", amfNof);


            // AJAX request to submit form data
            jQuery.ajax({
                type: "POST",
                url: "<?php echo plugin_dir_url( __DIR__ ); ?>modify-art.php",
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    jQuery(".loading-icon").show();
                },
                success: function (response) {
                    if (response == 'success') {
                        jQuery('#art-from').hide();
                        jQuery('#feedback-status').html('<p>Your feedback was sent successfully. Thank you for getting in touch!</p>');
                    } else {
                        jQuery('#feedback-status').html('<p>Sorry, an error occurred while sending your feedback. Please try again later.</p>');
                    }
                },
                error: function (xhr, status, error) {
                    console.log(error);
                },
                complete: function () {
                    jQuery(".loading-icon").hide();
                }
            });
        });

    });
</script>
