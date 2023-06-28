<?php
$letter_id   = isset( $_GET['letterid'] ) ? intval( $_GET['letterid'] ) : 0;
$template_id = isset( $_GET['templateid'] ) ? intval( $_GET['templateid'] ) : 0;

if ( $letter_id > 0 ) {
	$args = array(
		'post_type' => 'letters',
		'post__in'  => array( $letter_id )
	);

	$letter_posts = get_posts( $args );


	if ( ! empty( $letter_posts ) ) {
		$whats_on_your_mind              = get_post_meta( $letter_id, 'whats_on_your_mind', true );
		$choose_your_tone                = get_post_meta( $letter_id, 'choose_your_tone', true );
		$context_corner                  = get_post_meta( $letter_id, 'context_corner', true );
		$add_on_emotion                  = get_post_meta( $letter_id, 'add_on_emotion', true );
		$personal_touch                  = get_post_meta( $letter_id, 'personal_touch', true );
		$personalized_greetings_signoffs = get_post_meta( $letter_id, 'personalized_greetings_signoffs', true );

		$letter_post    = $letter_posts[0]; // Get the first post object
		$letter_content = $letter_post->post_content;

		?>
        <script>
            jQuery(document).ready(function () {
                jQuery("#letter-content").html(`<?php echo $letter_content;  ?>`);
            });
        </script>
		<?php

	}

} elseif ( $template_id > 0 ) {
	$tem_args = array(
		'post_type' => 'template',
		'post__in'  => array( $template_id )
	);

	$template_posts = get_posts( $tem_args );

	if ( ! empty( $template_posts ) ) {
		$template_post    = $template_posts[0]; // Get the first post object
		$template_content = $template_post->post_content;
	}
}
?>

<div id="d-leter-generation">
    <div class="p-leter-generation">
        <div class="content">
            <div class="heading">
                <div class="icon">
                    <i class='bx bx-food-menu'></i>
                </div>
                <span>Letter Generation</span>
            </div>

            <form class="form">
                <!-- Form inputs -->
                <div class="form-group">
                    <label for="woym">What's On Your Mind?</label>
                    <input type="text" class="form-control" id="woym" placeholder="Purpose of the letter"
                           value="<?php echo isset( $whats_on_your_mind ) ? $whats_on_your_mind : ''; ?>">
                    <small>Maximum 80 words</small>
                </div>

                <div class="form-group">
                    <label for="cyt">Choose Your Tone</label>
                    <select class="form-control" id="cyt">
                        <option <?php echo isset( $choose_your_tone ) && $choose_your_tone == 'Formal' ? 'selected' : ''; ?>>
                            Formal
                        </option>
                        <option <?php echo isset( $choose_your_tone ) && $choose_your_tone == 'Informal' ? 'selected' : ''; ?>>
                            Informal
                        </option>
                        <option <?php echo isset( $choose_your_tone ) && $choose_your_tone == 'Persuasive' ? 'selected' : ''; ?>>
                            Persuasive
                        </option>
                        <option <?php echo isset( $choose_your_tone ) && $choose_your_tone == 'Humorous' ? 'selected' : ''; ?>>
                            Humorous
                        </option>
                        <option <?php echo isset( $choose_your_tone ) && $choose_your_tone == 'Serious' ? 'selected' : ''; ?>>
                            Serious
                        </option>
                        <option <?php echo isset( $choose_your_tone ) && $choose_your_tone == 'Friendly' ? 'selected' : ''; ?>>
                            Friendly
                        </option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="cc">Context Corner</label>
                    <textarea class="form-control" id="cc" rows="3"
                              placeholder="Enter key points and words you want to be included"><?php echo isset( $context_corner ) ? $context_corner : ( isset( $template_content ) ? $template_content : '' ); ?>
</textarea>
                    <small>Maximum 80 words</small>
                </div>

                <div class="form-group">
                    <label for="aoe">Add-On Emotion</label>
                    <select class="form-control" id="aoe">
                        <option <?php echo isset( $add_on_emotion ) && $add_on_emotion == 'Concern' ? 'selected' : ''; ?>>
                            Concern
                        </option>
                        <option <?php echo isset( $add_on_emotion ) && $add_on_emotion == 'Empathy' ? 'selected' : ''; ?>>
                            Empathy
                        </option>
                        <option <?php echo isset( $add_on_emotion ) && $add_on_emotion == 'Compassion' ? 'selected' : ''; ?>>
                            Compassion
                        </option>
                        <option <?php echo isset( $add_on_emotion ) && $add_on_emotion == 'Worry' ? 'selected' : ''; ?>>
                            Worry
                        </option>
                        <option <?php echo isset( $add_on_emotion ) && $add_on_emotion == 'Anxiety' ? 'selected' : ''; ?>>
                            Anxiety
                        </option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="pt">Personal Touch</label>
                    <textarea class="form-control" id="pt" rows="3"
                              placeholder="Please include specific phrases, idioms, or words that you or the recipient frequently use to make the letter more personal."><?php echo isset( $personal_touch ) ? $personal_touch : ''; ?></textarea>
                    <small>Maximum 80 words</small>
                </div>

                <div class="form-group">
                    <label for="pgas">Personalized Greetings and Signoffs</label>
                    <textarea class="form-control" id="pgas" rows="3"
                              placeholder="Add personalized based on the recipient's name and relationship with the sender."><?php echo isset( $personalized_greetings_signoffs ) ? $personalized_greetings_signoffs : ''; ?></textarea>
                    <small>Maximum 80 words</small>
                </div>

                <div class="text-center">
                    <button type="button" class="gs-btn" id="bttn-generate">Generate AI Content <i style="display: none"
                                                                                                   class="fa fa-spinner fa-spin loading-icon"></i>
                    </button>
                </div>
            </form>

        </div>
    </div>


    <div class="chat-section">
        <div class="content">
            <div id="letter-content"></div>
        </div>
    </div>
</div>


<script>

    jQuery(document).ready(function () {


        jQuery('#letter-content').summernote({
            placeholder: `Select a template or write a prompt to get started. Or start typing here...`,
            tabsize: 2,
            height: jQuery('.content').height()
        });

        jQuery('#bttn-generate').click(function () {
            const letter = jQuery('.content .note-editor .note-editable');
            const letterContent = jQuery("#letter-content");
            const initialContent = letterContent.html(); // Store the initial content

            const wnym = jQuery('#woym');
            const cyt = jQuery('#cyt');
            const cc = jQuery('#cc');
            const aoe = jQuery('#aoe');
            const pt = jQuery('#pt');
            const pgas = jQuery('#pgas');

            const params = new URLSearchParams({
                wnym: wnym.val(),
                cyt: cyt.val(),
                cc: cc.val(),
                aoe: aoe.val(),
                pt: pt.val(),
                pgas: pgas.val(),
            });


            letter.html("");
            letterContent.html(initialContent); // Restore the initial content

            jQuery('.content .note-editor .note-placeholder').hide();
            jQuery(".loading-icon").show();

            let receivedData = '';

            let source = new SSE("<?php echo plugin_dir_url( __DIR__ ); ?>ai-request-stream.php?" + params.toString());
            source.addEventListener('message', function (e) {
                if (e.data) {
                    if (e.data != '[DONE]') {
                        let dataObj = JSON.parse(e.data);
                        if (dataObj['choices'] && dataObj['choices'][0]['delta']['content']) {
                            let content = dataObj['choices'][0]['delta']['content'];
                            content = content.replace(/\n/g, "<br>");
                            receivedData += content;
                            letter.append(content);
                        }
                    } else {
                        console.log('Completed');

                        let paramsArray = {
                            whats_on_your_mind: wnym.val(),
                            choose_your_tone: cyt.val(),
                            context_corner: cc.val(),
                            add_on_emotion: aoe.val(),
                            personal_touch: pt.val(),
                            personalized_greetings_signoffs: pgas.val(),
                            letter_content: receivedData,
                        };

                        jQuery.ajax({
                            type: 'POST',
                            url: '<?php echo plugin_dir_url( __DIR__ ); ?>letter-create-cpt.php',
                            data: paramsArray,
                            success: function (response) {
                                console.log(response);
                                jQuery(".loading-icon").hide();
                            }
                        });
                    }
                }
            });
            source.stream();
        });

    });


</script>
<script src="<?php echo plugin_dir_url( __DIR__ ); ?>js/sse.js"></script>