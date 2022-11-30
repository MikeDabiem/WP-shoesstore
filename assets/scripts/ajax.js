jQuery(function jq_filter($) {
    $('.catalog__filter').on('change', function() {
        $('.showcase__items').animate({opacity: .5}, 300);
        const form = $(this);
        let data = {
            action: 'filter',
            data: form.serialize(),
            price_min: $('#pricing__range-min').val(),
            price_max: $('#pricing__range-min').val() === $('#pricing__range-max').val() ? `${+$('#pricing__range-min').val() + 1}` : $('#pricing__range-max').val()
        }
        $.post(ajaxurl.url, data, function(response) {
            console.log(response);
            $('.catalog')
                .html(response)
                .animate({opacity: 1}, 300);
            data.data.split("&").forEach(item => {
                $(`#${item.slice(0, -3)}`).attr('checked', 'checked');
            });
            main_js();
            jq_filter($);
        });
    });
});