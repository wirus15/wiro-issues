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
    
    $('.add-comment form').on('submit', function(e) {
        e.preventDefault();
        var form = $(this);
        var button = form.find('button[type="submit"]');
        
        button.prop('diabled', true).addClass('disabled');
        $.post(form.attr('action'), form.serialize(), function() {
            $.fn.yiiListView.update('activity-list-view');
            button.prop('diabled', false).removeClass('disabled');
            $('#Activity_activityData').redactor('set', '');
        });
    });
    
    $('body').on('click', '#activity-list-options a', function(e) {
        e.preventDefault();
        $.fn.yiiListView.update('activity-list-view', {url: $(this).attr('href')} );
    });
    
    $('body').on('click', '#activity-list-view .items a.delete', function(e) {
        e.preventDefault();
        if(confirm('Are you sure you want to delete this comment?')) {
            $.post($(this).attr('href'), function() {
                $.fn.yiiListView.update('activity-list-view');
            });
        };
    });
});
