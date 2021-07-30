<script>
    "use strict";

    // Upload Ad Image

    $(document).on('click', '.upload-msg', function() {
        $("#upload").trigger("click");
    });

    $('#reset').on("click", function() {
        $('#display').removeAttr('hidden');
        $('#reset').attr('hidden');
        $('.upload-image').removeClass('ready result');
        $('#image_preview_container').attr('src', '#');
    });

    function readFile(input) {
        const reader = new FileReader();
        reader.onload = (e) => {
            let image = new Image();
            image.onload = function() {
                $('input[name=width]').val(image.width);
                $('input[name=height]').val(image.height);
            };
            image.src = reader.result;
            $('.upload-image').addClass('ready');
            $('#image_preview_container').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }

    $('#upload').on('change', function() {
        readFile(this);
    });

    // Ad Type

    $('input[type="radio"]').on('click', function() {
        let ads_type = $(this).attr("value");
        if (ads_type == 'image') {
            $('#ad_image').removeAttr('hidden');
            $('#ad_ga').attr('hidden',true);
            $('#ad_script_code').attr('hidden',true);
            $('input[name=ad_width]').removeAttr('required');
            $('input[name=ad_height]').removeAttr('required');
        } else if (ads_type == 'ga') {
            $('#ad_image').attr('hidden',true);
            $('#ad_ga').removeAttr('hidden');
            $('#ad_script_code').attr('hidden',true);
            $('form#advertisementForm').attr('novalidate',true);
            $('input[name=ad_width]').attr('required', 'required');
            $('input[name=ad_height]').attr('required', 'required');
        } else {
            $('#ad_image').attr('hidden',true);
            $('#ad_ga').attr('hidden',true);
            $('#ad_script_code').removeAttr('hidden');
            $('form#advertisementForm').attr('novalidate',true);
            $('input[name=ad_width]').removeAttr('required');
            $('input[name=ad_height]').removeAttr('required');
            editor1.refresh();
        }
    });

    $("select#ad_size").on('change', function() {
        if ( this.value == 'fixed') {
            $("#display_fixed").show();
            $("#display_responsive").hide();
            $('input[name=ad_width]').attr('required', 'required');
            $('input[name=ad_height]').attr('required', 'required');
        } else {
            $("#display_fixed").hide();
            $("#display_responsive").show();
            $('input[name=ad_width]').removeAttr('required');
            $('input[name=ad_height]').removeAttr('required');
        }
    });

    //Codemirror

    let editor1 = CodeMirror.fromTextArea(document.getElementById("custom"), {
        mode: "htmlmixed",
        styleActiveLine: true,
        lineNumbers: true,
        lineWrapping: true
    });
    editor1.setSize(null, 100);
</script>
