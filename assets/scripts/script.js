document.addEventListener('DOMContentLoaded', () => {
    const pricingFilter = document.querySelector('.catalog__filter-pricing');
    const rangeMin = document.querySelector('#pricing__range-min');
    const rangeMax = document.querySelector('#pricing__range-max');
    const priceMin = document.querySelector('.pricing__min');
    const priceMax = document.querySelector('.pricing__max');

    function rangeWidth() {
        rangeMin.style.width = `calc(${(rangeMax.value - rangeMin.min) / (rangeMax.max - rangeMin.min) * 100}% + ${12 - (12 / 50 * ((rangeMax.value - rangeMin.min) / (rangeMax.max - rangeMin.min) * 100))}px`;
        rangeMax.style.width = `calc(${100 - (rangeMin.value - rangeMin.min) / (rangeMax.max - rangeMin.min) * 100}% - ${12 - (12 / 50 * ((rangeMin.value - rangeMin.min) / (rangeMax.max - rangeMin.min) * 100))}px)`;
    }
    rangeWidth();
    rangeMin.max = rangeMax.value;
    rangeMax.min = rangeMin.value;

    pricingFilter.addEventListener('change', (e) => {
        if (priceMin.value === '$') {
            priceMin.value = '$' + 0;
        }
        if (priceMax.value === '$') {
            priceMax.value = '$' + 0;
        }

        if (e.target) {
            if (e.target.classList.contains('pricing__min')) {
                if (priceMin.value > priceMax.value) {
                    priceMin.value = '$' + (priceMax.value.slice(1) - 1);
                }
                rangeMin.value = priceMin.value.slice(1);
                rangeMax.min = rangeMin.value;
                rangeWidth();
            }
            if (e.target.classList.contains('pricing__max')) {
                if (priceMax.value < priceMin.value) {
                    priceMax.value = '$' + (Number(priceMin.value.slice(1)) + 1);
                }
                rangeMax.value = priceMax.value.slice(1);
                rangeMin.max = rangeMax.value;
                rangeWidth();
            }
        }
    });

    pricingFilter.addEventListener('input', (e) => {
        if (e.target) {
            if (e.target.classList.contains('pricing__min') && e.target.value === '' || e.target.classList.contains('pricing__max') && e.target.value === '') {
                e.target.value = '$';
            }
            if (e.target === rangeMin) {
                priceMin.value = '$' + rangeMin.value;
                priceMin.focus();
                rangeMax.min = rangeMin.value;
                priceMax.value = '$' + rangeMax.value;
                if (rangeMin.value === rangeMax.value) {
                    rangeMax.value = Number(rangeMax.value) + 1;
                    rangeMin.max = rangeMax.value;
                }
            }
            if (e.target === rangeMax) {
                priceMax.value = '$' + rangeMax.value;
                priceMax.focus();
                rangeMin.max = rangeMax.value;
                if (rangeMax.value === rangeMin.value) {
                    rangeMin.value -= 1;
                    priceMin.value = '$' + rangeMin.value;
                    rangeMax.min = rangeMin.value;
                }
            }
        }
        rangeWidth();
    });

    const checkbox = document.querySelectorAll('.checkbox');
    checkbox.forEach(item => {
        item.addEventListener('change', () => {
            if (item.checked) {
                item.previousElementSibling.classList.add('checked');
                item.classList.add('checked');
            } else {
                item.previousElementSibling.classList.remove('checked');
                item.classList.remove('checked');
            }
        });
    });

    const sizeSection = document.querySelector('.catalog__filter-size');
    const sizeStdBtn = document.querySelectorAll('.size__standart-btn');
    sizeSection.addEventListener('click', (e) => {
        if (e.target && e.target.classList.contains('size__standart-btn')) {
            sizeStdBtn.forEach(item => {
                if (item.classList.contains('selected')) {
                    item.classList.remove('selected');
                }
            });
            e.target.classList.add('selected');
        }
        if (e.target && e.target.classList.contains('size__option')) {
            e.target.classList.toggle('selected');
        }
    });

    const labelsOption = document.querySelectorAll('.labels__option');
    labelsOption.forEach(item => {
        item.addEventListener('change', () => {
            item.classList.toggle('selected');
        });
    });

    const sortSection = document.querySelector('.sort');
    const sortSelect = document.querySelector('.sort__select');
    const sortList = document.querySelector('.sort__list');
    const sortItem = document.querySelectorAll('.sort__list-item')
    sortSection.addEventListener('click', (e) => {
        sortSelect.classList.toggle('active');
        sortList.classList.toggle('active');
        if (sortSelect.classList.contains('active')) {
            const close = (e) => {
                if (!e.target.closest('.sort')) {
                    sortSelect.classList.remove('active');
                    sortList.classList.remove('active');
                    window.removeEventListener('click', close);
                }
            }
            window.addEventListener('click', close);
        }
        if (e.target && e.target.classList.contains('sort__list-item')) {
            sortItem.forEach(item => {
                if (item.classList.contains('selected')) {
                    item.classList.remove('selected');
                }
            });
            e.target.classList.add('selected');
            sortSelect.innerHTML = e.target.innerHTML;
        }
    });

    const sortFilterBtn = document.querySelector('.sort__filter-btn');
    const catalog = document.querySelector('.catalog');
    const catalogFilter = document.querySelector('.catalog__filter');
    sortFilterBtn.addEventListener('click', () => {
        catalogFilter.classList.add('active');
        catalog.classList.add('active');
        if (catalogFilter.classList.contains('active')) {
            setTimeout(() => {
                const close = (e) => {
                    if (!e.target.closest('.catalog__filter')) {
                        catalogFilter.classList.remove('active');
                        catalog.classList.remove('active');
                        window.removeEventListener('click', close);
                    }
                }
                window.addEventListener('click', close);
            }, 10);
        }
    });

    const pagination = document.querySelector('.catalog__pagination');
    const paginBtns = document.querySelectorAll('.pagination__item');
    pagination.addEventListener('click', (e) => {
        if (e.target && e.target.classList.contains('pagination__item') && !e.target.classList.contains('dots')) {
            paginBtns.forEach(item => {
                if (item.classList.contains('selected')) {
                    item.classList.remove('selected');
                }
            });
            e.target.classList.add('selected');
        }
    });
});