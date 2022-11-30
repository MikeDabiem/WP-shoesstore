<div class="showcase__items-item">
    <a href="#" class="item__thumb">
        <?php the_post_thumbnail() ?>
    </a>
    <a href="#" class="item__title"><?php the_title(); ?></a>
    <p class="item__price">$<?php number_format(the_field('price'), 2, '.', ' '); ?></p>
    <div class="item__buttons">
        <a href="#" class="item__buttons-view">View item</a>
        <input class="item__buttons-heart" type="checkbox" id="heart_<?php echo get_the_ID(); ?>" name="heart">
    </div>
</div>
