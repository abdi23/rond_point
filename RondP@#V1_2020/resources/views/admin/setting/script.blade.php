<script>
    "use strict";

    function readImage(input) {
        let reader = new FileReader();
        let name = $(input).attr('name');
        console.log(name);
        reader.onload = (e) => {
            // $(this).addClass('ready');
            $('#image_preview_'+name).attr('src', e.target.result);
            $('#image_'+name).hide();
        }
        reader.readAsDataURL(input.files[0]);
    }

    $(function() {
        bsCustomFileInput.init()
    });

    let editor = CodeMirror.fromTextArea(document.getElementById("credit_footer"), {
        mode: "htmlmixed",
        styleActiveLine: true,
        lineNumbers: true,
        lineWrapping: true
    });
    editor.setSize(null, 100);
    editor.on('change', (editor) => {
        const text = editor.doc.getValue()
        console.log(text);
        $('#credit_footer').html(text);
    });


    $(document).on("click", "#submit-web-properties", function(e) {
        e.preventDefault();
        $("#submit-web-properties").html("<div class=\"spinner-grow spinner-grow-sm\" role=\"status\"><span class=\"sr-only\">Loading...</span></div> Sending...");
        $.ajax({
            url: "{{ route('settings.update') }}",
            method: "POST",
            data: $("#form-web-information").serialize(),
            success: function(response) {
                if (response.errors) {
                    $(".spinner-grow").attr("hidden", true);
                    $("#submit-web-properties").html("Save");
                    toastr.error(response.errors);
                } else if (response.info) {
                    $(".spinner-grow").attr("hidden", true);
                    toastr.info(response.info);
                    $("#submit-web-properties").html("Save");
                } else {
                    $(".spinner-grow").attr("hidden", true);
                    toastr.success(response.success);
                    $("#submit-web-properties").html("Save");
                }
            }
        });
    });

    $(document).on("click", "#submit-web-contact", function(e) {
        e.preventDefault();
        $("#submit-web-contact").html("<div class=\"spinner-grow spinner-grow-sm\" role=\"status\"><span class=\"sr-only\">Loading...</span></div> Sending...");
        $("#name").removeClass("is-invalid")
        $(".msg-error-name").html("");
        $.ajax({
            url: "{{ route('settings.update') }}",
            method: "POST",
            data: $("#form-web-contact").serialize(),
            success: function(response) {
                if (response.errors) {
                    $(".spinner-grow").attr("hidden", true);
                    $("#submit-web-contact").html("Save");
                    toastr.error(response.errors);
                } else if (response.info) {
                    $(".spinner-grow").attr("hidden", true);
                    toastr.info(response.info);
                    $("#submit-web-contact").html("Save");
                } else {
                    $(".spinner-grow").attr("hidden", true);
                    toastr.success(response.success);
                    $("#submit-web-contact").html("Save");
                }
            }
        });
    });

    $(document).on("click", "#submit-web-permalinks", function(e) {
        e.preventDefault();
        $("#submit-web-permalinks").html("<div class=\"spinner-grow spinner-grow-sm\" role=\"status\"><span class=\"sr-only\">Loading...</span></div> Sending...");
        $("#name").removeClass("is-invalid")
        $(".msg-error-name").html("");
        $.ajax({
            url: "{{ route('settings.update') }}",
            method: "POST",
            data: $("#form-web-permalinks").serialize(),
            success: function(response) {
                if (response.errors) {
                    $(".spinner-grow").attr("hidden", true);
                    $("#submit-web-permalinks").html("Save");
                    toastr.error(response.errors);
                } else if (response.info) {
                    $(".spinner-grow").attr("hidden", true);
                    toastr.info(response.info);
                    $("#submit-web-permalinks").html("Save");
                } else {
                    $(".spinner-grow").attr("hidden", true);
                    toastr.success(response.success);
                    $("#submit-web-permalinks").html("Save");
                }
            }
        });
    });

    $(document).on("change", "#customSwitch1", function(e) {
        let active = $(this).prop("checked") == true ? "y" : "n";
        $.ajax({
            type: "PATCH",
            dataType: "json",
            url: "/changeStatusMaintenance",
            data: {
                "active": active
            },
            success: function(data) {
                if(data.info) {
                    toastr.info(data.info);
                } else {
                    toastr.success(data.success);
                }
            }
        })
    });

    $(document).on("change", "#customSwitch2", function(e) {
        let active = $(this).prop("checked") == true ? "y" : "n";
        $.ajax({
            type: "PATCH",
            dataType: "json",
            url: "/changeRegisterMember",
            data: {
                "active": active
            },
            success: function(data) {
                if(data.info) {
                    toastr.info(data.info);
                } else if(data.success){
                    toastr.success(data.success);
                }else{
                    toastr.error(data.abort);
                }
            }
        })
    });

    $(document).ready(() => {
        let url = location.href.replace(/\/$/, "");

        if (location.hash) {
            const hash = url.split("#");
            $('#vert-tabs-tab a[href="#' + hash[1] + '"]').tab("show");
            url = location.href.replace(/\/#/, "#");
            history.replaceState(null, null, url);
            setTimeout(() => {
                $(window).scrollTop(0);
            }, 400);
        }

        $('a[data-toggle="pill"]').on("click", function() {
            let newUrl;
            const hash = $(this).attr("href");
            newUrl = url.split("#")[0] + hash;
            newUrl += "/";
            history.replaceState(null, null, newUrl);
        });
    });

    $('input[type=file]#InputFileBackup').change(function(){
        if($('input[type=file]#inputFileBackup').val()==''){
            $('button#uploadFileBackup').attr('disabled',true)
        }
        else{
            $('button#uploadFileBackup').attr('disabled',false);
        }
    })

    $(document).on("click", "#btn-export", function(e) {
        e.preventDefault();
        $("#btn-export").html("<div class=\"spinner-grow spinner-grow-sm\" role=\"status\"><span class=\"sr-only\">{{__('Loading')}}...</span></div> {{__('Sending')}}...");
        $.ajax({
            url: "{{ route('export') }}",
            method: "GET",
            xhrFields: {
                responseType: 'blob'
            },
            success: function(response){
                let blob = new Blob([response]);
                let link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = "laramagz-backup.xlsx";
                link.click();
                $(".spinner-grow").attr("hidden", true);
                $("#btn-export").html("<i class='fas fa-file-excel'></i> {{ __('Download Export File Data') }}");
            }
        });
    })

    $(document).on("click", "#btn-export-storage", function(e) {
        e.preventDefault();
        $("#btn-export-storage").html("<div class=\"spinner-grow spinner-grow-sm\" role=\"status\"><span class=\"sr-only\">{{__('Loading')}}...</span></div> {{__('Sending')}}...");
        $.ajax({
            url: "{{ route('export.storage') }}",
            method: "GET",
            xhrFields: {
                responseType: 'blob'
            },
            success: function(response){
                let blob = new Blob([response]);
                let link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = "laramagz-storage.zip";
                link.click();
                $(".spinner-grow").attr("hidden", true);
                $("#btn-export-storage").html("<i class='fas fa-file-excel'></i> {{ __('Download Export File Data') }}");
            }
        });
    })

    $(document).on("click", "#uploadFileBackup", function(e) {
        e.preventDefault();
        $("#uploadFileBackup").html("<div class=\"spinner-grow spinner-grow-sm\" role=\"status\"><span class=\"sr-only\">{{ __('Loading')}}...</span></div> {{ __('Sending') }}...");
        let url = $("form#formUploadImport").attr("action");
        var form = $('form#formUploadImport')[0];
        var data = new FormData(form);
        $.ajax({
            type: "POST",
            processData: false,
            contentType: false,
            enctype: "multipart/form-data",
            url: url,
            data: data,
            success: function(response) {
                $(".spinner-grow").attr("hidden", true);
                $("#formUploadImport")[0].reset();
                $("#uploadFileBackup").html("{{__('Upload')}}");
                if (response.errors) {
                    toastr.error(response.errors.import);
                } else if (response.info) {
                    toastr.info(response.info);
                } else {
                    toastr.success(response.success);
                }
            }
        })
    })
</script>
