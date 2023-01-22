<script>

    var stack_top_left = {"dir1": "down", "dir2": "left", "push": "top"};

    function print_ajax_error(text) {
        // Solid danger
        new PNotify({
            title: 'خطا',
            text: text,
            addclass: 'bg-danger stack-top-left',
            stack: stack_top_left
        });
    }

    function print_ajax_success_msg(text) {

        // Solid success
        new PNotify({
            title: 'تایید',
            text: text,
            addclass: 'bg-success stack-top-left',
            stack: stack_top_left
        });
    }

    // Modal template
    var modalTemplate = '<div class="modal-dialog modal-lg" role="document">\n' +
        '  <div class="modal-content">\n' +
        '    <div class="modal-header">\n' +
        '      <div class="kv-zoom-actions btn-group">{toggleheader}{fullscreen}{borderless}{close}</div>\n' +
        '      <h6 class="modal-title">{heading} <small><span class="kv-zoom-title"></span></small></h6>\n' +
        '    </div>\n' +
        '    <div class="modal-body">\n' +
        '      <div class="floating-buttons btn-group"></div>\n' +
        '      <div class="kv-zoom-body file-zoom-content"></div>\n' + '{prev} {next}\n' +
        '    </div>\n' +
        '  </div>\n' +
        '</div>\n';
    // Buttons inside zoom modal
    var previewZoomButtonClasses = {
        toggleheader: 'btn btn-default btn-icon btn-xs btn-header-toggle',
        fullscreen: 'btn btn-default btn-icon btn-xs',
        borderless: 'btn btn-default btn-icon btn-xs',
        close: 'btn btn-default btn-icon btn-xs'
    };
    // Icons inside zoom modal classes
    var previewZoomButtonIcons = {
        prev: '<i class="icon-arrow-left32"></i>',
        next: '<i class="icon-arrow-right32"></i>',
        toggleheader: '<i class="icon-menu-open"></i>',
        fullscreen: '<i class="icon-screen-full"></i>',
        borderless: '<i class="icon-alignment-unalign"></i>',
        close: '<i class="icon-cross3"></i>'
    };
    // File actions
    var fileActionSettings = {
        zoomClass: 'btn btn-link btn-xs btn-icon',
        zoomIcon: '<i class="icon-zoomin3"></i>',
        dragClass: 'btn btn-link btn-xs btn-icon',
        dragIcon: '<i class="icon-three-bars"></i>',
        removeClass: 'btn btn-link btn-icon btn-xs',
        removeIcon: '<i class="icon-trash"></i>',
        indicatorNew: '<i class="icon-file-plus text-slate"></i>',
        indicatorSuccess: '<i class="icon-checkmark3 file-icon-large text-success"></i>',
        indicatorError: '<i class="icon-cross2 text-danger"></i>',
        indicatorLoading: '<i class="icon-spinner2 spinner text-muted"></i>'
    };
    $('.file_input_user_logo').fileinput({
        browseLabel: 'Browse',
        browseIcon: '<i class="icon-file-plus"></i>',
        uploadIcon: '<i class="icon-file-upload2"></i>',
        removeIcon: '<i class="icon-cross3"></i>',
        layoutTemplates: {
            icon: '<i class="icon-file-check"></i>',
            modal: modalTemplate
        },
        initialCaption: "No file selected",
        previewZoomButtonClasses: previewZoomButtonClasses,
        previewZoomButtonIcons: previewZoomButtonIcons,
        fileActionSettings: fileActionSettings
    });

    $(document).off('click', '#btn_save_form_user_template').on('click', '#btn_save_form_user_template', function ()
    {
        var formData = new FormData($("#user_template")[0]);
        console.log(formData);
        //formData.append('file_input_user_logo',  dataa.AdvertisingId);
        formData.append('text_footer',  $('.text_footer').val());
        formData.append('theme_nav',  $('.theme_nav').val());
        formData.append('theme_sidebar',  $('.theme_sidebar').val());
        var l = Ladda.create(this);
        l.start();
        $.ajax({
            type: 'post',
            url: '{{ route('ltm.backend.templates.save_user_template')}}',
            dataType: 'json',
            data: formData,
            cache:false,
            async:false,
            contentType: false,
            processData: false,
            success: function(result)
            {
                if (result.success == true) {
                    print_ajax_success_msg(result.message);
                    $('.jsglyph-close').click();
                    l.stop();
                }
                else {
                    $.each(result.error,function (index,value) {
                        print_ajax_error(value);
                    });
                    l.stop();
                }
            }
        });
    });
    function showLogoUser(result)
    {
        $('#show_area_user').html(result.logo_user.view.medium) ;
    }

</script>