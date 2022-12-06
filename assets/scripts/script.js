document.addEventListener('DOMContentLoaded', main_js);
function main_js() {
    const pricingFilter = document.querySelector('.catalog__filter-pricing');
    const rangeMin = document.querySelector('#pricing__range-min');
    const rangeMax = document.querySelector('#pricing__range-max');
    const priceMin = document.querySelector('.pricing__min');
    const priceMax = document.querySelector('.pricing__max');

    function rangeWidth() {
        rangeMin.style.width = `calc(${(rangeMax.value - rangeMin.min) / (rangeMax.max - rangeMin.min) * 100}% + ${12 - (12 / 50 * ((rangeMax.value - rangeMin.min) / (rangeMax.max - rangeMin.min) * 100))}px)`;
        rangeMax.style.width = `calc(${100 - (rangeMin.value - rangeMin.min) / (rangeMax.max - rangeMin.min) * 100}% - ${12 - (12 / 50 * ((rangeMin.value - rangeMin.min) / (rangeMax.max - rangeMin.min) * 100))}px)`;
    }
    rangeWidth();
    rangeMin.max = rangeMax.value;
    rangeMax.min = rangeMin.value;

    pricingFilter.addEventListener('input', (e) => {
        if (e.target) {
            if (e.target.classList.contains('pricing__min') && e.target.value === '' || e.target.classList.contains('pricing__max') && e.target.value === '') {
                e.target.value = '$';
            }
            if (e.target === rangeMin) {
                rangeMax.min = rangeMin.value;
                if (rangeMin.value === rangeMax.value) {
                    rangeMax.value = Number(rangeMax.value) + 1;
                    rangeMin.max = rangeMax.value;
                    if (rangeMin.value === rangeMax.max) {
                        rangeMin.value = Number(rangeMax.max) - 1;
                        rangeMin.max = Number(rangeMax.max) - 1;
                    }
                }
                priceMin.value = '$' + Number(rangeMin.value).toFixed(2);
                priceMin.focus();
                priceMax.value = '$' + Number(rangeMax.value).toFixed(2);
            }
            if (e.target === rangeMax) {
                rangeMin.max = rangeMax.value;
                if (rangeMax.value === rangeMin.value) {
                    rangeMin.value -= 1;
                    priceMin.value = '$' + Number(rangeMin.value).toFixed(2);
                    if (rangeMax.value === rangeMin.min) {
                        rangeMax.value = Number(rangeMin.min) + 1;
                        rangeMax.min = Number(rangeMin.min) + 1;
                    } else {
                        rangeMax.min = rangeMin.value;
                    }
                }
                priceMax.focus();
                priceMax.value = '$' + Number(rangeMax.value).toFixed(2);
            }
        }
        rangeWidth();
    });

    if (priceMin.value === priceMax.value) {
        pricingFilter.dispatchEvent(new Event('input'));
    }

    const choosed = document.querySelector('.choosed__items');
    const choosedArr = [];
    const choosedTitle = document.querySelector('.filter__choosed-title');
    const checkbox = document.querySelectorAll('.checkbox');
    checkbox.forEach(chbox => {
        function chboxHandler() {
            if (chbox.checked) {
                chbox.previousElementSibling.classList.add('checked');
                chbox.classList.add('checked');
                choosedArr.push({name: chbox.previousElementSibling.innerHTML, id: chbox.id});
                choosed.insertAdjacentHTML('beforeend',
                    `<div class="choosed__item">
                        <span class="choosed__item-text">${choosedArr[choosedArr.length - 1].name}</span>
                        <label for="${choosedArr[choosedArr.length - 1].id}" class="choosed__item-x"><img src="wp-content/themes/shoesstore/assets/svg/close.svg" alt="close"></label>
                    </div>`
                );
            } else if (chbox.classList.contains('checked')) {
                    choosed.childNodes[choosedArr.findIndex(el => el.name === chbox.previousElementSibling.innerHTML)].remove();
                    chbox.previousElementSibling.classList.remove('checked');
                    chbox.classList.remove('checked');
                    choosedArr.splice(choosedArr.findIndex(el => el.name === chbox.previousElementSibling.innerHTML), 1);
            }
            if (choosedArr.length > 0 && !choosedTitle.classList.contains('active')) {
                choosedTitle.classList.add('active');
            } else if (choosedArr.length === 0 && choosedTitle.classList.contains('active')) {
                choosedTitle.classList.remove('active');
            }
        }
        chboxHandler();
        chbox.addEventListener('change', chboxHandler);
    });

    const sizeSection = document.querySelector('.catalog__filter-size');
    const sizeStdBtn = document.querySelectorAll('.size__standart-btn');
    const sizeOptions = document.querySelectorAll('.size__option');
    sizeStdBtn[0].classList.add('selected');
    document.querySelectorAll('.size__option input').forEach(item => {
        if (item.hasAttribute('checked')) {
            item.parentElement.classList.add('selected');
        }
    });
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

    const clearBtn = document.querySelector('.filter__clear-btn');
    const filterForm = document.querySelector('.catalog__filter');
    function selectedRemover(item) {
        if (item.classList.contains('selected')) {
            item.classList.remove('selected');
        }
    }
    clearBtn.addEventListener('click', e => {
        e.preventDefault();

        filterForm.reset();

        rangeWidth();
        rangeMin.max = rangeMax.value;
        rangeMax.min = rangeMin.value;

        checkbox.forEach(chbox => {
            chbox.dispatchEvent(new Event('change'));
        });

        sizeStdBtn.forEach(item => {
            selectedRemover(item);
        });
        sizeStdBtn[0].classList.add('selected');

        sizeOptions.forEach(item => {
            selectedRemover(item);
        });

        labelsOption.forEach(item => {
            selectedRemover(item);
        });

        filterForm.dispatchEvent(new Event('change'));
    });

    heartsHandler();
};

function heartsHandler() {
    hearts = document.querySelectorAll('.item__buttons-heart');
    hearts.forEach(item => {
        if (localStorage.getItem(item.id)) {
            item.setAttribute('checked', 'checked');
        }
        item.addEventListener('change', () => {
            if (item.checked) {
                localStorage.setItem(item.id, 1);
            } else {
                localStorage.removeItem(item.id);
            }
        });
    });
}