<?php
$sorts = [
    'Name A-Z',
    'Name Z-A',
    'Price Ascending',
    'Price Descending',
    'Topseller'
];

$badges = [
    'Top',
    'New',
    'Deal'
];

$colors = [
    'blue' => '#00F', 
    'green' => '#008000',
    'brown' => '#A52A2A',
    'grey' => '#808080',
    'red' => '#F00',
    'white' => '#FFF',
    'pink' => '#FFC0CB',
    'yellow' => '#FF0',
    'black' => '#00',
    'beige' => '#F5F5DC',
    'navy blue' => '#000080',
    'maroon' => '#800000',
    'purple' => '#800080',
    'orange' => '#FFA500',
    'aqua' => '#0FF'
];

$imageUrl = 'https://via.placeholder.com/350/000000/FFFFFF/?text=Product';

$numberOfProducts = random_int(7, 20);

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function generateRandomText($words = 10) {
    $randomText = '';

    for ($i = 0; $i < $words; $i++) {
        $randomText .= generateRandomString(random_int(5, 10)) . ' ';
    }

    return $randomText;
}

function getProductData() {
    global $badges, $colors;

    $productData = [];

    // badge
    $hasBadge = random_int(1, 100) < 20;
    $productBadges = [];
    if ($hasBadge) {
        shuffle($badges);

        for ($j = 0; $j < random_int(1, 3); $j++) {
            $productBadges[] = $badges[$j];
        }
    }
    $productData['badges'] = $productBadges;

    // title
    $productData['name'] = generateRandomString(random_int(10, 30));

    // description
    $productData['desc'] = generateRandomText(random_int(5, 20));

    //colors
    $hasColors = random_int(1, 100) < 60;
    $productColors = [];
    if ($hasColors) {
        $colorKeys = array_keys($colors);

        shuffle($colorKeys);

        for ($j = 0; $j < random_int(1, count($colorKeys)); $j++) {
            $productColors[$colorKeys[$j]] = $colors[$colorKeys[$j]];
        }
    }
    $productData['colors'] =  $productColors;

    // rating
    $hasRating = random_int(1, 100) < 60;
    $productData['rating'] = $hasRating ? random_int(1, 4) + round(lcg_value(), 2) : 0;

    // price
    $hasPrice = random_int(1, 100) < 80;
    $productData['price'] = $hasPrice ? random_int(5, 199) + round(lcg_value(), 2) : 0;
    $hasSpecialPrice = $hasPrice && random_int(1, 100) < 50;

    $discounts = [0.05, 0.1, 0.15, 0.2, 0.25, 0.5];
    $discount = $discounts[array_rand($discounts, 1)];

    $productData['discount'] = $hasSpecialPrice ? (int)($discount * 100) . '%' : null;
    $productData['specialPrice'] = $hasSpecialPrice ?  round($productData['price'] * $discount, 2) : null;

    return $productData;
}

?>

<div class="cms-block pos-2 cms-block-product-listing">
    <div class="container">
        <div class="product-listing-actions">
            <div class="sorting">
                <select class="sorting" id="sorting">
                    <?php foreach ($sorts as $sort): ?>
                        <option value="<?= $sort ?>"><?= $sort ?></option>
                    <?php endforeach; ?>
                </select>
                <label for="sorting">
                    Sorting
                </label>
            </div>
        </div>
        <div class="product-listing-wrapper">
            <?php for ($i = 0; $i < $numberOfProducts; $i++): ?>
                <?php $productData = getProductData(); ?>
                <?php //var_dump($productData); ?>

                <div class="product-wrapper">
                    <div class="card product-box">
                        <div class="card-body">
                            <div class="product-badges">
                                <?php foreach ($productData['badges'] as $badge): ?>
                                    <div class="badge-wrapper">
                                        <div class="product-badge badge-<?= $badge ?>">
                                            <span><?= $badge ?></span>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                                <?php if ($productData['discount']):?>
                                    <div class="badge-discount discount">
                                        <span><?= $productData['discount'] ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="product-image-wrapper">
                                <a href="product-<?= $i ?>"></a>
                                <img src="<?= $imageUrl . '_' . $i ?>" class="product-img"/>
                            </div>
                            <div class="product-info">
                                <div class="product-name" title="<?= $productData['name'] ?>">
                                    <a href="product-<?= $i ?>"></a>
                                    <span><?= $productData['name'] ?></span>
                                </div>
                                <div class="product-variants">
                                    <div class="product-variant-colors">
                                        <div class="swatch-container swatches">
                                            <?php foreach ($productData['colors'] as $color => $colorHex): ?>
                                                <div class="swatch-wrapper swatch">
                                                    <div class="product-swatch" title="<?= $color ?>" style="background-color: <?= $colorHex ?>">
                                                        <span class="swatch-text"><?= $color ?></span>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-description">
                                    <p><?= $productData['desc'] ?></p>
                                </div>
                                <div class="product-rating">
                                    <div class="rating-container">
                                        <div class="rating-wrapper">
                                            <span class="rating rating-<?= $productData['rating'] ?>" style="width: <?= ($productData['rating'] / 5) * 100?>%;"></span>
                                        </div>
                                        
                                        <span class="rating-text"><?= $productData['rating'] . '/5' ?></span>
                                    </div>
                                </div>
                                <div class="product-price-info">
                                    <?php if ($productData['specialPrice']):?>
                                        <div class="special-price-wrapper">
                                            <span class="product-special-price"><?= $productData['specialPrice'] ?></span>
                                            <span class="price-unit">€</span>
                                        </div>
                                    <?php endif; ?>
                                    <div class="price-wrapper">
                                        <span class="product-price"><?= $productData['price'] ?></span>
                                        <span class="price-unit">€</span>
                                    </div>
                                </div>
                                <div class="product-action">
                                    <form class="to-pds-form" action="/catalog/product/view/id/<?= $i ?>">
                                        <button class="btn primary to-pds" type="submit" title="View product">View Product</button>
                                    </form>
                                    <form class="to-pds-form" action="/contact-us">
                                        <button class="btn secondary contact" type="submit" title="contact-us">Contact us</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            <?php endfor; ?>
        </div>
    </div>
</div>