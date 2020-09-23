$(document).ready(function(){
    $('.tabs-pilihan').click(function(){
        $('.tab-content').find('.tab-pane').removeClass('active');
        $($(this).attr('href')).addClass('active');
    })
})