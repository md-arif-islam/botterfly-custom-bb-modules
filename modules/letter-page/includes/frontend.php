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

                jQuery('#woym').val('<?php echo $whats_on_your_mind; ?>');
                jQuery('#cyt').val('<?php echo $choose_your_tone; ?>');
                jQuery('#cc').val('<?php echo $context_corner; ?>');
                jQuery('#aoe').val('<?php echo $add_on_emotion; ?>');
                jQuery('#pt').val('<?php echo $personal_touch; ?>');
                jQuery('#pgas').val('<?php echo $personalized_greetings_signoffs; ?>');

                jQuery("#letter-content").html('<?php echo $letter_content; ?>');

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
		?>

        <script>

            jQuery(document).ready(function () {
                jQuery('#cc').val(`<?php echo $template_content; ?>`);
            });
        </script>


		<?php
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
                    <label for="woum">What's On Your Mind?</label>
                    <input type="text" class="form-control" id="woym" placeholder="Purpose of the letter">
                    <small>Maximum 80 words</small>
                </div>

                <div class="form-group">
                    <label for="cut">Choose Your Tone</label>
                    <select class="form-control" id="cyt">
                        <option>Formal</option>
                        <option>Informal</option>
                        <option>Persuasive</option>
                        <option>Humorous</option>
                        <option>Serious</option>
                        <option>Friendly</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="cc">Context Corner</label>
                    <textarea class="form-control" id="cc" rows="3"
                              placeholder="Enter key points and words you want to be included"></textarea>
                    <small>Maximum 80 words</small>
                </div>

                <div class="form-group">
                    <label for="aoe">Add-On Emotion</label>
                    <select class="form-control" id="aoe">
                        <option>Concern</option>
                        <option>Empathy</option>
                        <option>Compassion</option>
                        <option>Worry</option>
                        <option>Anxiety</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="cc">Personal Touch</label>
                    <textarea class="form-control" id="pt" rows="3"
                              placeholder="Please include specific phrases, idioms, or words that you or the recipient frequently use to make the letter more personal."></textarea>
                    <small>Maximum 80 words</small>
                </div>

                <div class="form-group">
                    <label for="cc">Personalized Greetings and Signoffs</label>
                    <textarea class="form-control" id="pgas" rows="3"
                              placeholder="Add personalized based on the recipient's name and relationship with the sender."></textarea>
                    <small>Maximum 80 words</small>
                </div>

                <div class="text-center">
                    <button type="button" class="gs-btn" id="bttn-generate">Generate AI Content <i style="display: none" class="fa fa-spinner fa-spin loading-icon"></i></button>
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

            const letter = document.querySelector('.content .note-editor .note-editable p');
            const wnym = document.querySelector('#woym');
            const cyt = document.querySelector('#cyt');
            const cc = document.querySelector('#cc');
            const aoe = document.querySelector('#aoe');
            const pt = document.querySelector('#pt');
            const pgas = document.querySelector('#pgas');

            const params = new URLSearchParams({
                letter: letter.value,
                wnym: wnym.value,
                cyt: cyt.value,
                cc: cc.value,
                aoe: aoe.value,
                pt: pt.value,
                pgas: pgas.value,
            });

            letter.innerHTML = "";

            jQuery('.content .note-editor .note-placeholder').hide();
            jQuery(".loading-icon").show();


            let receivedData = ''; // letiable to store all the received data

            let source = new SSE("<?php echo plugin_dir_url( __DIR__ ); ?>ai-request-stream.php?" + params.toString());
            source.addEventListener('message', function (e) {
                if (e.data) {
                    if (e.data != '[DONE]') {
                        dataObj = JSON.parse(e.data);
                        if (dataObj['choices'] && dataObj['choices'][0]['delta']['content']) {
                            let content = dataObj['choices'][0]['delta']['content'];
                            content = content.replace(/\n/g, "<br>");
                            receivedData += content; // Append the content to the letiable
                            letter.innerHTML += content;
                        }
                    } else {
                        console.log('Completed');

                        let paramsArray = {
                            whats_on_your_mind: wnym.value,
                            choose_your_tone: cyt.value,
                            context_corner: cc.value,
                            add_on_emotion: aoe.value,
                            personal_touch: pt.value,
                            personalized_greetings_signoffs: pgas.value,
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