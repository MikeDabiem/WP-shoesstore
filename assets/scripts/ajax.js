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
            resp_arr = JSON.parse(response);
            console.log(resp_arr);

            $('.showcase__items')
                .empty()
                .animate({opacity: 1}, 300);

            resp_arr.shoes.forEach(item => {
                $('.showcase__items').append(`<div class="showcase__items-item">
                        <a href="#" class="item__thumb">
                            ${item.thumbnail}
                        </a>
                        <a href="#" class="item__title">${item.title}</a>
                        <p class="item__price">$${item.price}</p>
                        <div class="item__buttons">
                            <a href="#" class="item__buttons-view">View item</a>
                            <input class="item__buttons-heart" type="checkbox" id="heart_${item.id}" name="heart">
                        </div>
                    </div>`
                );
            });
            heartsHandler();

            // price min/max
            
            $('.gender__option').css('display', 'none');
            resp_arr.gender.forEach(gender => {
                $('.gender__option').find(`#${gender.slug}`).parent().removeAttr('style');
            });
            
            $('.peculiarities__option').css('display', 'none');
            resp_arr.peculiarities.forEach(pec => {
                $('.peculiarities__option').find(`#${pec.slug}`).parent().removeAttr('style');
            });

            // colors

            // sizes
        });
    });
});