<?php get_header();
$query = new WP_Query([
    'post_type' => 'shoes',
    'posts_per_page' => 12,
    'order_by' => 'date',
    'order' => 'asc'
]);
?>
<div class="wrapper">
    <div class="catalog">
        <form class="catalog__filter">
            <section class="catalog__filter-header">
                <h2 class="filter__title">Filter</h2>
                <button class="filter__clear-btn">Clear Filter</button>
                <div class="filter__choosed">
                    <h4 class="filter__choosed-title">You choosed</h4>
                    <div class="choosed__item">
                        <span class="choosed__item-text">Men</span>
                        <button class="choosed__item-x">&#128937;</button>
                    </div>
                    <div class="choosed__item">
                        <span class="choosed__item-text">Sport shoes</span>
                        <button class="choosed__item-x">&#128937;</button>
                    </div>
                    <div class="choosed__item">
                        <span class="choosed__item-text">Sport shoes</span>
                        <button class="choosed__item-x">&#128937;</button>
                    </div>
                </div>
            </section>
            <section class="catalog__filter-pricing">
                <?php
                    $price = [];
                    while ( $query->have_posts() ) {
                        $query->the_post();
                        array_push($price, get_field('price'));
                    }
                ?>
                <h4 class="pricing__title">Pricing</h4>
                <input type="text" class="pricing__min" value="$<?php echo min($price); ?>">
                <input type="text" class="pricing__max" value="$<?php echo max($price); ?>">
                <div class="pricing__range">
                    <input type="range" min="<?php echo min($price); ?>" value="<?php echo min($price); ?>" max="<?php echo max($price); ?>" id="pricing__range-min">
                    <input type="range" min="<?php echo min($price); ?>" value="<?php echo max($price); ?>" max="<?php echo max($price); ?>" id="pricing__range-max">
                </div>
            </section>
            <section class="catalog__filter-gender">
                <h4 class="gender__title">Gender</h4>
                <?php 
                    $gender = get_terms(['taxonomy' => 'gender', 'orderby' => 'none']);
                    if ($gender) {
                        foreach ($gender as $gender) {
                            echo "<div class=\"gender__option option\">
                                <label for=\"{$gender->slug}\" class=\"gender__option-label option-label\">{$gender->name}</label>
                                <input type=\"checkbox\" name=\"{$gender->slug}\" id=\"{$gender->slug}\" class=\"gender__option-check checkbox\">
                            </div>";
                        }
                    }
                ?>
            </section>
            <section class="catalog__filter-peculiarities">
                <h4 class="peculiarities__title">Peculiarities</h4>
                <?php 
                    $peculiarities = get_terms(['taxonomy' => 'peculiarities', 'orderby' => 'none']);
                    if ($peculiarities) {
                        foreach ($peculiarities as $pec) {
                            echo "<div class=\"peculiarities__option option\">
                                <label for=\"{$pec->slug}\" class=\"peculiarities__option-label option-label\">{$pec->name} shoes</label>
                                <input type=\"checkbox\" name=\"{$pec->slug}\" id=\"{$pec->slug}\" class=\"peculiarities__option-check checkbox\">
                            </div>";
                        }
                    }
                ?>
            </section>
            <section class="catalog__filter-color">
                <h4 class="color__title">Colors</h4>
                <div class="color__select">
                <?php
                    while ( $query->have_posts() ) {
                        $query->the_post();
                        if(get_field('color')) {
                            foreach(get_field('color') as $array) {
                                foreach($array as $key => $value) {
                                    if($value) {
                                        echo "<label id=\"color-$key-label\" class=\"color__option\"><input type=\"checkbox\" id=\"color-$key\" name=\"color-$key\"></label>";
                                    }
                                }
                            }
                        }
                    }
                ?>
                    <!-- <label id="color-red-label" class="color__option"><input type="checkbox" id="color-red" name="color-red"></label>
                    <label id="color-white-label" class="color__option"><input type="checkbox" id="color-white" name="color-white"></label>
                    <label id="color-grey-label" class="color__option"><input type="checkbox" id="color-grey" name="color-grey"></label>
                    <label id="color-yellow-label" class="color__option"><input type="checkbox" id="color-yellow" name="color-yellow"></label>
                    <label id="color-orange-label" class="color__option"><input type="checkbox" id="color-orange" name="color-orange"></label>
                    <label id="color-green-label" class="color__option"><input type="checkbox" id="color-green" name="color-green"></label>
                    <label id="color-black-label" class="color__option"><input type="checkbox" id="color-black" name="color-black"></label>
                    <label id="color-pink-label" class="color__option"><input type="checkbox" id="color-pink" name="color-pink"></label>
                    <label id="color-brown-label" class="color__option"><input type="checkbox" id="color-brown" name="color-brown"></label>
                    <label id="color-blue-label" class="color__option"><input type="checkbox" id="color-blue" name="color-blue"></label> -->
                </div>
            </section>
            <section class="catalog__filter-size">
                <h4 class="size__title">Size</h4>
                <div class="size__standarts">
                    <button type="button" class="size__standart-btn selected">UA</button>
                    <button type="button" class="size__standart-btn">EU</button>
                    <button type="button" class="size__standart-btn">UK</button>
                </div>
                <div class="size__options">
                    <label class="size__option"><input type="checkbox" id="size-option-22" name="size-option-22">22</label>
                    <label class="size__option"><input type="checkbox" id="size-option-22.5" name="size-option-22.5">22.5</label>
                    <label class="size__option"><input type="checkbox" id="size-option-23" name="size-option-23">23</label>
                    <label class="size__option"><input type="checkbox" id="size-option-23.5" name="size-option-23.5">23.5</label>
                    <label class="size__option"><input type="checkbox" id="size-option-24" name="size-option-24">24</label>
                    <label class="size__option"><input type="checkbox" id="size-option-24.5" name="size-option-24.5">24.5</label>
                    <label class="size__option"><input type="checkbox" id="size-option-25" name="size-option-25">25</label>
                    <label class="size__option"><input type="checkbox" id="size-option-25.5" name="size-option-25.5">25.5</label>
                    <label class="size__option"><input type="checkbox" id="size-option-26" name="size-option-26">26</label>
                    <label class="size__option"><input type="checkbox" id="size-option-26.5" name="size-option-26.5">26.5</label>
                    <label class="size__option"><input type="checkbox" id="size-option-27" name="size-option-27">27</label>
                    <label class="size__option"><input type="checkbox" id="size-option-27.5" name="size-option-27.5">27.5</label>
                    <label class="size__option"><input type="checkbox" id="size-option-28" name="size-option-28">28</label>
                    <label class="size__option"><input type="checkbox" id="size-option-28.5" name="size-option-28.5">28.5</label>
                    <label class="size__option"><input type="checkbox" id="size-option-29" name="size-option-29">29</label>
                    <label class="size__option"><input type="checkbox" id="size-option-29.5" name="size-option-29.5">29.5</label>
                    <label class="size__option"><input type="checkbox" id="size-option-30" name="size-option-30">30</label>
                    <label class="size__option"><input type="checkbox" id="size-option-30.5" name="size-option-30.5">30.5</label>
                </div>
            </section>
            <div class="catalog__filter-labels">
                <label class="labels__option"><input type="checkbox" name="labels-option-novelties" id="labels-option-novelties">Novelties</label>
                <label class="labels__option"><input type="checkbox" name="labels-option-sale" id="labels-option-sale">Sale</label>
            </div>
        </form>
        <div class="catalog__showcase">
            <div class="sort-wrapper">
                <button class="sort__filter-btn"><img src="<?php bloginfo('template_url'); ?>/assets/svg/filter-logo.svg" alt="filter">Filter</button>
                <div class="sort">
                    <div class="sort__select">Sort by</div>
                    <ul class="sort__list">
                        <li class="sort__list-item">Price increase</li>
                        <li class="sort__list-item">Price reduction</li>
                        <li class="sort__list-item">The most popular</li>
                        <li class="sort__list-item">Biggest discount</li>
                    </ul>
                </div>
            </div>
            <div class="showcase__items">
                <?php
                    while ( $query->have_posts() ) {
                        $query->the_post();
                        ?>
                        <div class="showcase__items-item">
                            <a href="#" class="item__thumb">
                                <?php the_post_thumbnail() ?>
                            </a>
                            <a href="#" class="item__title"><?php the_title(); ?></a>
                            <p class="item__price">$<?php the_field('price'); ?></p>
                            <div class="item__buttons">
                                <a href="#" class="item__buttons-view">View item</a>
                                <input class="item__buttons-heart" type="checkbox" name="heart">
                            </div>
                        </div>
                        <?php
                    }
                    wp_reset_postdata();
                ?>
            </div>
            <div class="catalog__pagination">
                <button class="pagination__item">1</button>
                <button class="pagination__item">2</button>
                <button class="pagination__item selected">3</button>
                <button class="pagination__item dots">...</button>
                <button class="pagination__item">16</button>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>