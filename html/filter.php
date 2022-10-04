<?php
$filters = [
    'brand' => [
        'Originals',
        'DerDieDas',
        'Tierax',
        'Why 3',
        'S-Tier Mac Retney',
    ],
    'color' => [
        'blue',
        'green',
        'brown',
        'grey',
        'red',
        'white',
        'pink',
        'yellow',
        'black',
        'beige',
        'navy blue',
        'maroon',
        'purple',
        'orange',
        'aqua'
    ],
    'material' => [
        'cotton',
        'leather',
        'polyester'
    ],
    'size' => [
        's',
        'm',
        'l',
        'xl'
    ],
    'free shipping' => 'free shipping'
];
?>

<div class="cms-block  pos-1 cms-block-sidebar-filter">

    <?php foreach ($filters as $key => $filter): ?>
        <div class="filter-container">
            <?php if (is_array($filter)) : ?>
                <select name="<?= $key ?>" id="<?= $key ?>" class="filter">
                    <?php foreach ($filter as $option): ?>
                        <option value="<?= $option ?>"><?= $option ?></option>
                    <?php endforeach; ?>
                </select>
                <label for="<?= $key ?>"><?= $key ?></label>

            <?php elseif (is_string($filter)): ?>
                
                <input type="checkbox" id="<?= $key ?>" class="filter" name="<?= $key ?>"/>
                <label for="<?= $key ?>"><?= $key ?></label>

            <?php endif; ?>
        </div>
    <?php endforeach; ?>

</div>
