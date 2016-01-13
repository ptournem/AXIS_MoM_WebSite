$(document).ready(function(){
    $('#button-filter-show-all').click(function(){
        $('#entities tbody tr').show();;
    });

    $('.button-filter-type').click(function(){
        var c = $(this).attr('data-class');
        $('#entities tbody tr').show();
        $('#entities tbody tr:not(.type-'+c+')').hide();
    }); 
});