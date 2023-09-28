<?php

/**
 * @author  wpWax
 * @since   6.6
 * @version 7.4.0
 */

if (!defined('ABSPATH')) exit;
$searchform = new Directorist\Directorist_Listing_Search_Form('search_form', 2);
$selected_item = $searchform->get_selected_location_option_data();
?>

<?php
$parents = get_terms(array(
    'taxonomy'   => ATBDP_LOCATION,
    'hide_empty' => false,
    'parent' => 0
));

$children = [];
$children_options = [];

$cities = [];
$city_options = [];

foreach ($parents as $parent) {
    $children_temrs = get_terms(
        array(
            'taxonomy' => ATBDP_LOCATION,
            'parent' => $parent->term_id,
            'hide_empty' => false,
        )
    );
    if (!empty($children_temrs)) {
        $children[$parent->term_id] = $children_temrs;
        foreach ($children_temrs as $children_term) {
            $children_options[] = $children_term;

            // City
            $city_terms = get_terms(
                array(
                    'taxonomy' => ATBDP_LOCATION,
                    'parent' => $children_term->term_id,
                    'hide_empty' => false,
                )
            );
            if (!empty($city_terms)) {
                $cities[$children_term->term_id] = $city_terms;
                foreach ($city_terms as $city_term) {
                    $city_options[] = $city_term;
                }
            }
        }
    }
}

?>

<div class="directorist-search-field">
    <div class="directorist-select directorist-search-location">
        <select name="in_country" class="<?php echo esc_attr($searchform->location_class); ?>" data-placeholder="Country" <?php echo !empty($data['required']) ? 'required="required"' : ''; ?> data-isSearch="true" data-selected-id="<?php echo esc_attr($selected_item['id']); ?>" data-selected-label="<?php echo esc_attr($selected_item['label']); ?>">
            <option value="0">Country</option>
            <?php
            foreach ($parents as $parent) {
            ?>
                <option value="<?php echo $parent->term_id; ?>"><?php echo $parent->name ?></option>
            <?php
            }
            ?>
        </select>
    </div>
</div>

<div class="directorist-search-field">
    <div class="directorist-select directorist-search-location">
        <input type="hidden" id="location_children" value='<?php echo json_encode($children); ?>' />
        <select name="in_state" class="<?php echo esc_attr($searchform->location_class); ?>" data-placeholder="State" <?php echo !empty($data['required']) ? 'required="required"' : ''; ?> data-isSearch="true" data-selected-id="<?php echo esc_attr($selected_item['id']); ?>" data-selected-label="<?php echo esc_attr($selected_item['label']); ?>">
            <option value="0">State</option>
            <?php
            foreach ($children_options as $child_option) {
            ?>
                <option value="<?php echo $child_option->term_id; ?>"><?php echo $child_option->name ?></option>
            <?php
            }
            ?>
        </select>
    </div>
</div>

<div class="directorist-search-field">
    <div class="directorist-select directorist-search-location">
        <input type="hidden" id="location_city" value='<?php echo json_encode($cities); ?>' />
        <select name="in_city" class="<?php echo esc_attr($searchform->location_class); ?>" data-placeholder="City" <?php echo !empty($data['required']) ? 'required="required"' : ''; ?> data-isSearch="true" data-selected-id="<?php echo esc_attr($selected_item['id']); ?>" data-selected-label="<?php echo esc_attr($selected_item['label']); ?>">
            <option value="0">City</option>
            <?php
            foreach ($city_options as $city_option) {
            ?>
                <option value="<?php echo $city_option->term_id; ?>"><?php echo $city_option->name ?></option>
            <?php
            }
            ?>
        </select>
    </div>
</div>

<input type="hidden" value="" name="in_loc" />