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
        <?php require('components/sidebar.php'); ?>
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
                        require "components/single-card.php";
                    }
                    wp_reset_postdata();
                // $cards = [
                //     ["name" => "Nike Air Force 1 Medium Blue", "image" => "assets/img/sneaker1.png", "price" => 77.98, "liked" => false],
                // ];
                // foreach($cards as $card) {
                //     require "components/single-card.php";
                // }
                ?>
            </div>
            <div class="catalog__pagination">
                <button class="pagination__item">1</button>
                <button class="pagination__item">2</button>
                <button class="pagination__item selected">3</button>
                <div class="pagination__item dots">...</div>
                <button class="pagination__item">16</button>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>