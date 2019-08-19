$(document).ready(function(){
    
    $('.any-form').on('submit', function(){
        $('.any-submit-button').attr('disabled', 'true');
        $('.spinner').show();
    });

    $('.any-delete-button').on('click', function(){
        return confirm('Tem certeza que deseja fazer isso?');
    });

});