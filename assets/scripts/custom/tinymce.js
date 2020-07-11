tinymce.init({
    selector: "textarea.tinymce_rtl",
    theme: "modern",
    plugins: [
        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars code fullscreen",
        "insertdatetime media nonbreaking save table contextmenu directionality",
        "emoticons template paste textcolor colorpicker textpattern moxiemanager"
        
    ],
    toolbar1: "insertfile undo redo | styleselect | bold italic  forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist | link image media | preview",
    menubar: true,
    relative_urls : true,
    directionality : 'rtl',
    content_css : "assets/plugins/tinymce/custom_content.css",
    image_advtab: true
});

tinymce.init({
    selector: "textarea.tinymce_ltr",
    theme: "modern",
    plugins: [
        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars code fullscreen",
        "insertdatetime media nonbreaking save table contextmenu directionality",
        "emoticons template paste textcolor colorpicker textpattern moxiemanager"
        
    ],
    toolbar1: "insertfile undo redo | styleselect | bold italic  forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist | link image media | preview",
    menubar: true,
    relative_urls : true,
    directionality : 'ltr',    
    content_css : "assets/plugins/tinymce/custom_content.css",
    image_advtab: true
});