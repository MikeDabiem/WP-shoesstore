<!-- <div class="showcase__items-item">
    <a href="#" class="item__thumb">
        <img src="<?php echo $card["image"]; ?>" alt="sneaker">
    </a>
    <a href="#" class="item__title"><?php echo $card["name"]; ?></a>
    <p class="item__price">$<?php echo number_format($card["price"], 2, '.', ' '); ?></p>
    <div class="item__buttons">
        <a href="#" class="item__buttons-view">View item</a>
        <input class="item__buttons-heart" type="checkbox" name="heart" <?php echo $card["liked"] ? "checked" : null ?>>
    </div>
</div> -->
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
