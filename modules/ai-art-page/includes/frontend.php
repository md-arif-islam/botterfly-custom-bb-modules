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
            <div class="form-section">
                <div class="r-art-box">
                    <form class="form" id="ai-content-form">
                        <div class="form-group">
                            <label for="wad">Write a detailed descriptions with instructions for the
                                modifications</label>
                            <textarea class="form-control" id="acf-wad" rows="3"
                                      placeholder="Enter key points and words you want to be included"></textarea>
                            <small>Maximum 80 words</small>
                        </div>
                        <div class="form-group">
                            <label for="aoe-resolution">Image resolution</label>
<<<<<<< HEAD
                            <select class="form-control" id="acf-resolution">
=======
                            <select class="form-control" id="aoe-resolution">
>>>>>>> 6b59724ec650233050a78c1fd30abd2433afb0e5
                                <option>512x512</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="aoe-samples">No. of samples</label>
<<<<<<< HEAD
                            <select class="form-control" id="acf-samples">
=======
                            <select class="form-control" id="aoe-samples">
>>>>>>> 6b59724ec650233050a78c1fd30abd2433afb0e5
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
<<<<<<< HEAD
                            <button type="submit" class="gs-btn" id="generate-ai-content-btn">Generate AI Content
=======
                            <button type="button" class="gs-btn" id="generate-ai-content-btn">Generate AI Content
>>>>>>> 6b59724ec650233050a78c1fd30abd2433afb0e5
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
                <div class="col-md-6 col-sm-12">
                    <div class="image-box">
                        <div class="image">
                            <img src="<?php echo plugin_dir_url( __DIR__ ); ?>/img/Rectangle 277.png" alt="">
                        </div>
                        <div class="buttons">
                            <a href="">Download <i class='bx bx-download'></i></a>
                            <p>Delivered on 12.06.2023 <i class='bx bx-calendar'></i></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="image-box">
                        <div class="image">
                            <img src="<?php echo plugin_dir_url( __DIR__ ); ?>/img/Rectangle 277.png" alt="">
                        </div>
                        <div class="buttons">
                            <a href="">Download <i class='bx bx-download'></i></a>
                            <p>Delivered on 12.06.2023 <i class='bx bx-calendar'></i></p>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    import {cleanFilterUrl} from "../../../../woocommerce/packages/woocommerce-blocks/assets/js/blocks/active-filters/utils";

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

        jQuery("#image-upload").on("change", function (event) {
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

<<<<<<< HEAD
        // Send form data using Ajax
        jQuery('#ai-content-form').submit(function (event) {
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
                url: 'http://botterflyai.local/wp-content/plugins/botterfly-custom-bb-modules-master/modules/ai-art-page/generate-ai-content.php',
                data: formData,
                success: function (response) {
                    console.log(response);
                }
            });
        });


=======

        jQuery('#generate-ai-content-btn').click(function () {


            const wadValue = document.querySelector('#wad');
            const aoeResolutionValue = document.querySelector('#aoe-resolution');
            const aoeSamplesValue = document.querySelector('#aoe-samples');
            const woumValue = document.querySelector('#woum');

            const params = new URLSearchParams({
                wadValue: wadValue.value,
                aoeResolutionValue: aoeResolutionValue.value,
                aoeSamplesValue: aoeSamplesValue.value,
                woumValue: woumValue.value,
            });


            // use SSE to get server Events
            var source = new SSE("<?php echo plugin_dir_url( __DIR__ ); ?>generate-ai-content.php?" + params.toString());
            source.addEventListener('message', function (e) {
                if (e.data) {
                    console.log("Okay");
                } else {
                    console.log("Not Okay");
                }

            })
            source.stream()

        });

>>>>>>> 6b59724ec650233050a78c1fd30abd2433afb0e5
    });


</script>
<script src="<?php echo plugin_dir_url( __DIR__ ); ?>js/sse.js"></script>