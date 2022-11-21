<form class="catalog__filter">
    <section class="catalog__filter-header">
        <h2 class="filter__title">Filter</h2>
        <a href="#" class="filter__clear-btn">Clear Filter</a>
        <div class="filter__choosed">
            <h4 class="filter__choosed-title">You choosed</h4>
            <div class="choosed__items"></div>
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
                // $colors = ["red", "white", "grey", "yellow", "orange", "green", "black", "pink", "brown", "blue"];
                // foreach ($colors as $color) {
                //     echo "<label id=\"color-$color-label\" class=\"color__option\"><input type=\"checkbox\" id=\"color-$color\" name=\"color-$color\"></label>";
                // }
            ?>
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
        </div>
    </section>
    <section class="catalog__filter-size">
        <h4 class="size__title">Size</h4>
        <div class="size__standarts">
            <?php
                $size__standarts = ["UA", "EU", "UK"];
                foreach ($size__standarts as $standart) {
                    echo "<button type=\"button\" class=\"size__standart-btn\">$standart</button>";
                }
            ?>
        </div>
        <div class="size__options">
            <?php
                $sizes = [22, 22.5, 23, 23.5, 24, 24.5, 25, 25.5, 26, 26.5, 27, 27.5, 28, 28.5, 29, 29.5, 30, 30.5];
                foreach ($sizes as $size) {
                    echo "<label class=\"size__option\"><input type=\"checkbox\" id=\"size-option-$size\" name=\"size-option-$size\">$size</label>";
                }
            ?>
        </div>
    </section>
    <div class="catalog__filter-labels">
        <?php
            $label_options = ["Novelties", "Sale"];
            foreach ($label_options as $label_option) {
                echo "<label class=\"labels__option\"><input type=\"checkbox\" name=\"labels-option-$label_option\" id=\"labels-option-$label_option\">$label_option</label>";
            }
        ?>
    </div>
</form>