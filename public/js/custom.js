$(document).ready(function(){
    
    $('.any-form').on('submit', function(){
        $('.spinner').show();
        $('.any-submit-button').attr('disabled', 'true');
    });

    $('.any-delete-button').on('click', function(){
        return confirm('Tem certeza que deseja fazer isso?');
    });

    tinymce.init({
        selector: 'textarea',
        plugin: 'a_tinymce_plugin',
        a_plugin_option: true,
        a_configuration_option: 400
    });

});