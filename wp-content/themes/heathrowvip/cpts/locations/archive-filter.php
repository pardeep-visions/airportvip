<div class="archive-filter-form-wrapper">

    <form action="/locations">

        <?php foreach ($filters as $filter_name => $data) : ?>

            <label for="<?php echo $data['nicename']; ?>"><?php echo ucfirst($data['nicename']); ?></label>

            <select name="<?php echo $data['nicename']; ?>" id="">

                <option value="">All <?php echo ucfirst($data['plural_label']); ?></option>

                <?php foreach ($data['terms'] as $term) : ?>
                    <?php

                    $is_selected = ($_GET[$data['nicename']] ===  $term->slug);

                    ?>
                    <option value="<?php echo $term->slug; ?>" <?php if ($is_selected) {
                                                                    echo 'selected';
                                                                } ?>>
                        <?php echo $term->name; ?>
                    </option>

                <?php endforeach; ?>

            </select>

        <?php endforeach; ?>

        <?php
        $cpd_points = [
            '' => 'All CPD points',
            '1' => '1+',
            '2' => '2+',
            '3' => '3+',
            '4' => '4+',
            '5' => '5+',
        ]; ?>
        <label for="cpd-points-filter"></label>

        <select name="cpd-points" id="cpd-points-filter">
            <?php foreach ($cpd_points as $value => $label) : ?>
                <option value="<?php echo $value; ?>" <?php echo (isset($_GET['cpd-points']) && $_GET['cpd-points'] == $value) ? 'selected' : ''; ?>><?php echo $label; ?></option>
            <?php endforeach; ?>
        </select>

        <?php $prices = [
            '' => 'All prices',
            'free' => 'Free',
            'paid' => 'Paid',
        ]; ?>
        <label for="price-filter"></label>

        <select name="price" id="price-filter">
            <?php foreach ($prices as $value => $label) : ?>
                <option value="<?php echo $value; ?>" <?php echo (isset($_GET['price']) && $_GET['price'] == $value) ? 'selected' : '';   ?>><?php echo $label; ?></option>
            <?php endforeach; ?>
        </select>

        <input type="submit" value="Search Media Assets">

    </form>

</div>