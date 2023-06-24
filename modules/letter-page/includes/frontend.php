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
                    <button type="button" class="gs-btn" id="bttn-generate">Generate AI Content</button>
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

        const storedTemplateContent = localStorage.getItem('templateContent');
        if (storedTemplateContent) {
            const decodedTemplateContent = decodeURIComponent(storedTemplateContent);
            jQuery('#cc').val(decodedTemplateContent);
            localStorage.removeItem('templateContent');
        }

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

            jQuery('.content .note-editor .note-placeholder').hide();

            // use SSE to get server Events
            var source = new SSE("<?php echo plugin_dir_url( __DIR__ ); ?>ai-request-stream.php?" + params.toString());
            source.addEventListener('message', function (e) {
                if (e.data) {
                    if (e.data != '[DONE]') {

                        dataObj = JSON.parse(e.data);

                        if (dataObj['choices'] && dataObj['choices'][0]['delta']['content']) {
                            var content = dataObj['choices'][0]['delta']['content'];
                            content = content.replace(/\n/g, "<br>");
                            letter.innerHTML += content;
                        }

                    } else {
                        console.log('Completed');
                    }
                }
            })
            source.stream()

        });

    });


</script>
<script src="<?php echo plugin_dir_url( __DIR__ ); ?>js/sse.js"></script>