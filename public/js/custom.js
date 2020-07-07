$(document).ready(function(){
    
    $('.any-form').on('submit', function(){
        $('.spinner').show();
        $('.any-submit-button').attr('disabled', 'true');
    });

    $('.any-delete-button').on('click', function(){
        return confirm('Tem certeza que deseja fazer isso?');
    });

    $('#form-remessa').on('submit', function(){
        $('#submit-remessa').show();
    });
});