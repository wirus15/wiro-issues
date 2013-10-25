$(document).ready(function() {
    $('#issue-tabs a, #issue-filters a').on('click', function(e) {
        var filter = $(this).attr('data-filter') !== undefined
                ? $(this).attr('data-filter')
                : $(this).parents('[data-filter]').attr('data-filter');
        var clear = $(this).attr('data-clear') !== undefined
                ? $(this).attr('data-clear')
                : $(this).parents('[data-clear]').attr('data-clear');
        var value = $(this).attr('data-value');

        if (clear !== undefined) {
            $.each(clear.split(','), function(i, c) {
                $('#' + c).val('').prop('selected', false);
            });
        }

        if (filter !== undefined) {
            $.each(filter.split(','), function(i, f) {
                $('#' + f).val(value).prop('selected', true).change();
            });
        }
    });
    
    $('body').on('click', '#issue-grid tbody td:not(:last-child)', function(e) {
        var url = $(this).parent().find('td:first-child a').attr('href');
        location.href = url;
        return false;
    });
    
    $('#activity-list-options a').on('click', function(e) {
       $.fn.yiiListView.update('activity-list-view', {url: $(this).attr('href')}); 
       e.preventDefault();
    });
});
