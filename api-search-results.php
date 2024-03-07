<?php

/**
 * Template name: API Search Result
 */

get_header();

global $wpdb;
$rda_posts      = $wpdb->prefix . 'posts';

$product_title  = $_GET['product-title'] ?? '';
$pro_query      = $wpdb->prepare(
    "SELECT ID FROM {$rda_posts} WHERE post_title = %s AND post_type = 'product'",
    $product_title
);
$search_pro_id      = $wpdb->get_var($pro_query);
$final_s_pro_id     = intval($search_pro_id);

$input_value        = $_GET['title'] ?? '';
$common_title       = '';

if ($product_title) {
    $common_title = $product_title;
}
if ($input_value) {
    $common_title = $input_value;
}

$data = [
    'sk_display_products'   => 'AA4174BAACB9A082B6974B856B28D3951DF54F4955FFF1D18C4893B004AF08C3',
    'input_value'           => $input_value,
];

$ch = curl_init();

$options = [
    CURLOPT_URL             => 'https://www.prontex.it/api-products/',
    CURLOPT_CUSTOMREQUEST   => 'POST',
    CURLOPT_POSTFIELDS      => $data,
    CURLOPT_RETURNTRANSFER  => true,
];

curl_setopt_array($ch, $options);
$results                = curl_exec($ch);
$api_product_results    = json_decode($results, true);

// end API code 

$title_to_search       = $input_value;
$query                 = $wpdb->prepare(" SELECT * FROM $rda_posts WHERE post_title LIKE %s AND post_type = 'product' AND  post_status = 'publish'", '%' . $wpdb->esc_like($title_to_search) . '%');
$normal_results        = $wpdb->get_results($query);
$total_posts           = count($normal_results);
$norml_products        = [];

if ($total_posts > 0) {
    $i = 0;
    foreach ($normal_results as $single_product) {
        $product_id     = $single_product->ID ?? '';
        $post_name     = $single_product->post_name ?? '';

        $norml_products[$i]['product_id']     = $product_id;
        $norml_products[$i]['pntx_product']   = 'sfty_product';
        $norml_products[$i]['title']          = get_the_title($product_id);
        $norml_products[$i]['description']    = '';
        $norml_products[$i]['product_slug']   = $post_name;
        $norml_products[$i]['product_url']    = '';
        $norml_products[$i]['thumbnail']      = get_the_post_thumbnail_url($product_id);
        $i++;
    }
}

$final_results      = array_merge($norml_products, $api_product_results);


$final_total_post   =   count($final_results);

if ($product_title) {
    $term_ids           = wp_get_post_terms($final_s_pro_id, 'product_cat', array('fields' => 'ids'));
    $final_term_id      = $term_ids[0] ?? '';
    $term_name          = get_term($final_term_id);
    $final_term_name    = $term_name->name ?? '';
    $term_url           = get_term_link($final_term_id);
?>
    <div class="breadcrumbs" typeof="BreadcrumbList" vocab="https://schema.org/">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <div class="breadcrumbs-inner">
                        <span property="itemListElement" typeof="ListItem">
                            <a property="item" typeof="WebPage" title="Go to Safety®." href="<?php echo home_url(); ?>" class="home">
                                <span property="name">Safety®</span>
                            </a>
                            <meta property="position" content="1">
                        </span> &gt; <span property="itemListElement" typeof="ListItem"><a property="item" typeof="WebPage" title="Go to Products." href="<?php echo home_url(); ?>/shop/" class="archive post-product-archive"><span property="name">Products</span></a>
                            <meta property="position" content="2">
                        </span> &gt; <span property="itemListElement" typeof="ListItem">
                            <a property="item" typeof="WebPage" title="Go to the Aghi e Infusione Category archives." href="<?php echo $term_url; ?>" class="taxonomy product_cat"><span property="name"><?php echo $final_term_name; ?>
                                </span>
                            </a>
                            <meta property="position" content="3">
                        </span> &gt; <span property="itemListElement" typeof="ListItem">
                            <span property="name" class="archive taxonomy product_cat current-item"><?php echo $product_title; ?></span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
} else {
?>
    <div class="breadcrumbs" typeof="BreadcrumbList">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <div class="breadcrumbs-inner">
                        <span property="itemListElement" typeof="ListItem">
                            <a property="item" typeof="WebPage" title="Go to Safety®." href="<?php echo home_url(); ?>" class="home">
                                <span property="name">Safety®</span>
                            </a>
                            <meta property="position" content="1">
                        </span> &gt; <span class="search current-item">Search results for '<?php echo $common_title; ?>'</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
}
?>


<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12">
            <header class="woocommerce-products-header">
                <h1 class="woocommerce-products-header__title page-title">
                    Search results: “<?php echo $common_title; ?>” </h1>
                <div class="category__sub_titlewrap"></div>
            </header>
        </div>
    </div>
</div>

<div class="container">
    <?php
    // $final_results // All data list in array
    if ($input_value) {
        if ($final_total_post > 0) {
            $data = $final_results;
            $itemsPerPage       = 8;
            $currentPage        = isset($_GET['pagi']) ? $_GET['pagi'] : 1;
            $startIndex         = ($currentPage - 1) * $itemsPerPage;
            $currentPageData    = array_slice($data, $startIndex, $itemsPerPage);

            foreach ($currentPageData as $single_product) {

                $product_id     = $single_product['product_id'] ?? '';
                $sft_prnt_check = $single_product['pntx_product'] ?? '';
                $title          = $single_product['title'] ?? '';
                $description    = $single_product['description'] ?? '';
                $product_slug   = $single_product['product_slug'] ?? '';
                $pro_thumbnail  = $single_product['thumbnail'] ?? '';
                $product_url    = $single_product['product_url'] ?? '';

                if ($pro_thumbnail) {
                    $thumbnail      = $single_product['thumbnail'] ?? '';
                } else {
                    $thumbnail      = '/wp-content/uploads/2024/03/default.png';
                }

                $target_attr        = '';
                $final_product_url  = '';

    ?>

                <?php
                if ($sft_prnt_check == 'sfty_product') {


                    $thumbnail_id       = get_post_thumbnail_id($product_id);
                    $srch_thumbnail_url = wp_get_attachment_url($thumbnail_id);
                    $r_product_gallery  = get_post_meta($search_pro_id, 'r_product_gallery', true);

                    $safety_gallery_one     = [];
                    $safety_gallery_one[]   = $srch_thumbnail_url;
                    $safety_gallery_two     = [];

                    if (!empty($r_product_gallery)) {
                        foreach ($r_product_gallery as $single_gl_id) {
                            $single_gallery_url     = wp_get_attachment_image_url($single_gl_id, 'full');
                            $safety_gallery_two[]   = $single_gallery_url;
                        }
                    }
                    $safety_final_gallery = array_merge($safety_gallery_one, $safety_gallery_two);

                ?>

                    <div class="col-md-12 single-product-bundles sp_single_item">
                        <div class="row">
                            <div class="col-sm-12 col-md-4 col-lg-4 text-center">
                                <div class="safety_product_img_slider owl-carousel">
                                    <?php
                                    foreach ($safety_final_gallery as $single_item) {
                                        if ($single_item) {
                                    ?>
                                            <div class="safety_product_img">
                                                <img src="<?php echo $single_item; ?>" alt="">
                                            </div>
                                    <?php
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-8 col-lg-8">
                                <div class="informationwrappar">
                                    <h3 class="search_title_<?php echo $product_id; ?>"><?php echo $title; ?></h3>
                                    <?php
                                    $codice_paraf   = get_post_meta($product_id, 'codice_paraf', true);
                                    $codice_interno = get_post_meta($product_id, 'codice_interno', true);

                                    if ($codice_paraf) {
                                    ?>
                                        <div class="datainformation Paraf"><span>codice Paraf:</span> <?php echo $codice_paraf; ?> </div>
                                    <?php
                                    }
                                    if ($codice_interno) {
                                    ?>
                                        <div class="datainformation Paraf"><span>codice interno:</span> <?php echo $codice_interno; ?> </div>
                                    <?php
                                    }



                                    $az_column_name_one     = get_post_meta($product_id, 'az_column_name_one', true);
                                    $az_column_name_two     = get_post_meta($product_id, 'az_column_name_two', true);
                                    $az_column_name_three   = get_post_meta($product_id, 'az_column_name_three', true);
                                    $az_column_name_four    = get_post_meta($product_id, 'az_column_name_four', true);
                                    $az_column_name_five    = get_post_meta($product_id, 'az_column_name_five', true);

                                    $product_fields    = intval(get_post_meta($product_id, 'product_fields', true));


                                    if ($product_fields > 0) {
                                    ?>
                                        <br>
                                        <table class="table table-striped product-tabble" style="max-width:650px;">
                                            <thead>
                                                <tr>
                                                    <?php
                                                    if ($az_column_name_one) {
                                                    ?>
                                                        <th scope="col"><?php echo $az_column_name_one ?></th>
                                                    <?php
                                                    }
                                                    if ($az_column_name_two) {
                                                    ?>
                                                        <th scope="col"><?php echo $az_column_name_two ?></th>
                                                    <?php
                                                    }
                                                    if ($az_column_name_three) {
                                                    ?>
                                                        <th scope="col"><?php echo $az_column_name_three ?></th>
                                                    <?php
                                                    }
                                                    if ($az_column_name_four) {
                                                    ?>
                                                        <th scope="col"><?php echo $az_column_name_four ?></th>
                                                    <?php
                                                    }
                                                    if ($az_column_name_five) {
                                                    ?>
                                                        <th scope="col"><?php echo $az_column_name_five ?></th>
                                                    <?php
                                                    }
                                                    ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                for ($i = 0; $i < $product_fields; $i++) {
                                                    $item_one = get_post_meta($product_id, 'product_fields_' . $i . '_item_one', true);
                                                    $item_two = get_post_meta($product_id, 'product_fields_' . $i . '_item_two', true);
                                                    $item_three = get_post_meta($product_id, 'product_fields_' . $i . '_item_three', true);
                                                    $item_four = get_post_meta($product_id, 'product_fields_' . $i . '_item_four', true);
                                                    $item_five = get_post_meta($product_id, 'product_fields_' . $i . '_item_five', true);

                                                ?>
                                                    <tr>
                                                        <?php
                                                        if ($item_one) {
                                                        ?>
                                                            <td><?php echo $item_one; ?> </td>
                                                        <?php
                                                        }
                                                        if ($item_two) {
                                                        ?>
                                                            <td><?php echo $item_two; ?> </td>
                                                        <?php
                                                        }
                                                        if ($item_three) {
                                                        ?>
                                                            <td><?php echo $item_three; ?> </td>
                                                        <?php
                                                        }
                                                        if ($item_four) {
                                                        ?>
                                                            <td><?php echo $item_four; ?> </td>
                                                        <?php
                                                        }
                                                        if ($item_five) {
                                                        ?>
                                                            <td><?php echo $item_five; ?> </td>
                                                        <?php
                                                        }
                                                        ?>
                                                    </tr>
                                                <?php
                                                }
                                                ?>

                                            </tbody>
                                        </table>
                                    <?php
                                    }
                                    ?>





                                    <div class="descwrappar desc-top">
                                        <?php
                                        if (get_post_field('post_content', $product_id)) {
                                        ?>
                                            <h4>DESCRIZIONE</h4>
                                            <br>
                                        <?php
                                            echo get_post_field('post_content', $product_id);
                                        }
                                        ?>

                                        <div class="prodotto-item-extra clearfix">
                                            <div class="prodotto-item-dl"></div>
                                        </div>
                                    </div>
                                    <?php
                                    $cod_class_iso  = get_post_meta($product_id, 'cod_class_iso', true);
                                    if ($cod_class_iso) {
                                    ?>
                                        <div class="datainformation cod_class_iso ">
                                            <span>cod. class. ISO</span> <?php echo $cod_class_iso; ?>
                                        </div>
                                    <?php
                                    }
                                    $product_pdff  = intval(get_post_meta($product_id, 'product_pdff', true));
                                    $product_pdff_url = wp_get_attachment_url($product_pdff, 'full');

                                    ?>

                                    <div class="action_wrappar">
                                        <div class="btn-product-grp mt20 sfty_all_btn_dgn">
                                            <a pro_id_no="<?php echo $product_id; ?>" class="show_hide_blw_form button-cta-style-one custom_click_wrappar enq_form_click" href="">richiedi info</a>
                                            <a class="button-cta-style-one custom_click_wrappar" href="<?php echo get_field('store_locator_page', 'option');  ?>"> <?php echo __('scopri dove trovarlo', 'safety-it'); ?> </a>
                                            <?php
                                            if ($product_pdff_url) {
                                            ?>
                                                <div class="right_side_pdf_pos">
                                                    <div class="pdf-button-wrapper pdf_sz_dgn">
                                                        <a href="<?php echo $product_pdff_url; ?>" download>
                                                            <img src="<?php echo get_template_directory_uri(); ?>/img/tasto-scarica.png" alt="">
                                                        </a>
                                                    </div>
                                                </div>
                                            <?php
                                            }
                                            ?>

                                        </div>
                                        <div class="product_inquiryform inactiveclass" id="enq_form_<?php echo $product_id; ?>" style="display:none;">
                                            <?php echo do_shortcode('[contact-form-7 id="160" title="' . 'Product name' . '"]');; ?>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                }

                if ($sft_prnt_check == 'pntx_product') {
                ?>
                    <div class="col-md-12 single-product-bundles sp_single_item">
                        <div class="row">
                            <div class="col-sm-12 col-md-4 col-lg-4 text-center">

                                <div class="safety_product_img_slider owl-carousel">
                                    <div class="safety_product_img">
                                        <img src="<?php echo $thumbnail; ?>" alt="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-8 col-lg-8">
                                <div class="informationwrappar">
                                    <h3><?php echo $title; ?></h3>
                                    <div class="api_prontext_desc">
                                        <?php echo $description; ?>
                                    </div>
                                    <div class="action_wrappar">
                                        <div class="btn-product-grp mt20 sfty_all_btn_dgn">
                                            <a class="button-cta-style-one" target="_blank" href="<?php echo $product_url; ?>">vai al prodotto</a>
                                        </div>
                                        <div class="prontext_logo">
                                            <img src="https://www.prontex.it/wp-content/uploads/2021/06/prontex-logo.svg" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php
                }
            }

            $totalPages = ceil(count($data) / $itemsPerPage);

            $visiblePages = 5;
            ?>
            <div class="api_search_pagination">
                <?php
                if ($final_total_post >= 8) {
                    if ($currentPage > 1) {
                        $prevPage = $currentPage - 1;
                        echo '<a href="?title=' . $input_value . '&pagi=' . $prevPage . '">←</a> ';
                    }

                    for ($i = 1; $i <= $totalPages; $i++) {
                        $class = ($i == $currentPage) ? 'active' : 'no_active';

                        if ($i == $currentPage || $i == $currentPage - 1 || $i == $currentPage + 1 || ($i >= $currentPage - $visiblePages && $i <= $currentPage + $visiblePages)) {
                            echo '<a href="?title=' . $input_value . '&pagi=' . $i . '" class="' . $class . '">' . $i . '</a> ';
                        } elseif ($i == $currentPage - $visiblePages - 1 || $i == $currentPage + $visiblePages + 1) {
                            echo '... ';
                        }
                    }

                    if ($currentPage < $totalPages) {
                        $nextPage = $currentPage + 1;
                        echo '<a href="?title=' . $input_value . '&pagi=' . $nextPage . '">→</a> ';
                    }
                }

                ?>
            </div>
        <?php
        }
    }

    if ($product_title) {

        $thumbnail_id       = get_post_thumbnail_id($final_s_pro_id);
        $srch_thumbnail_url = wp_get_attachment_url($thumbnail_id);
        $r_product_gallery  = get_post_meta($search_pro_id, 'r_product_gallery', true);

        $safety_gallery_one     = [];
        $safety_gallery_one[]   = $srch_thumbnail_url;
        $safety_gallery_two     = [];

        if (!empty($r_product_gallery)) {
            foreach ($r_product_gallery as $single_gl_id) {
                $single_gallery_url     = wp_get_attachment_image_url($single_gl_id, 'full');
                $safety_gallery_two[]   = $single_gallery_url;
            }
        }
        $safety_final_gallery = array_merge($safety_gallery_one, $safety_gallery_two);

        ?>

        <div class="col-md-12 single-product-bundles">
            <div class="row">
                <div class="col-sm-12 col-md-4 col-lg-4 text-center">
                    <div class="safety_product_img_slider owl-carousel">
                        <?php
                        foreach ($safety_final_gallery as $single_item) {
                            if ($single_item) {
                        ?>
                                <div class="safety_product_img">
                                    <img src="<?php echo $single_item; ?>" alt="">
                                </div>
                        <?php
                            }
                        }
                        ?>
                    </div>
                </div>
                <div class="col-sm-12 col-md-8 col-lg-8">
                    <div class="informationwrappar">
                        <h3 class="search_title_<?php echo $final_s_pro_id; ?>"><?php echo $product_title; ?></h3>
                        <?php
                        $codice_paraf   = get_post_meta($final_s_pro_id, 'codice_paraf', true);
                        $codice_interno = get_post_meta($final_s_pro_id, 'codice_interno', true);

                        if ($codice_paraf) {
                        ?>
                            <div class="datainformation Paraf"><span>codice Paraf:</span> <?php echo $codice_paraf; ?> </div>
                        <?php
                        }
                        if ($codice_interno) {
                        ?>
                            <div class="datainformation Paraf"><span>codice interno:</span> <?php echo $codice_interno; ?> </div>
                        <?php
                        }



                        $az_column_name_one     = get_post_meta($final_s_pro_id, 'az_column_name_one', true);
                        $az_column_name_two     = get_post_meta($final_s_pro_id, 'az_column_name_two', true);
                        $az_column_name_three   = get_post_meta($final_s_pro_id, 'az_column_name_three', true);
                        $az_column_name_four    = get_post_meta($final_s_pro_id, 'az_column_name_four', true);
                        $az_column_name_five    = get_post_meta($final_s_pro_id, 'az_column_name_five', true);

                        $product_fields    = intval(get_post_meta($final_s_pro_id, 'product_fields', true));


                        if ($product_fields > 0) {
                        ?>
                            <br>
                            <table class="table table-striped product-tabble" style="max-width:650px;">
                                <thead>
                                    <tr>
                                        <?php
                                        if ($az_column_name_one) {
                                        ?>
                                            <th scope="col"><?php echo $az_column_name_one ?></th>
                                        <?php
                                        }
                                        if ($az_column_name_two) {
                                        ?>
                                            <th scope="col"><?php echo $az_column_name_two ?></th>
                                        <?php
                                        }
                                        if ($az_column_name_three) {
                                        ?>
                                            <th scope="col"><?php echo $az_column_name_three ?></th>
                                        <?php
                                        }
                                        if ($az_column_name_four) {
                                        ?>
                                            <th scope="col"><?php echo $az_column_name_four ?></th>
                                        <?php
                                        }
                                        if ($az_column_name_five) {
                                        ?>
                                            <th scope="col"><?php echo $az_column_name_five ?></th>
                                        <?php
                                        }
                                        ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    for ($i = 0; $i < $product_fields; $i++) {
                                        $item_one = get_post_meta($final_s_pro_id, 'product_fields_' . $i . '_item_one', true);
                                        $item_two = get_post_meta($final_s_pro_id, 'product_fields_' . $i . '_item_two', true);
                                        $item_three = get_post_meta($final_s_pro_id, 'product_fields_' . $i . '_item_three', true);
                                        $item_four = get_post_meta($final_s_pro_id, 'product_fields_' . $i . '_item_four', true);
                                        $item_five = get_post_meta($final_s_pro_id, 'product_fields_' . $i . '_item_five', true);

                                    ?>
                                        <tr>
                                            <?php
                                            if ($item_one) {
                                            ?>
                                                <td><?php echo $item_one; ?> </td>
                                            <?php
                                            }
                                            if ($item_two) {
                                            ?>
                                                <td><?php echo $item_two; ?> </td>
                                            <?php
                                            }
                                            if ($item_three) {
                                            ?>
                                                <td><?php echo $item_three; ?> </td>
                                            <?php
                                            }
                                            if ($item_four) {
                                            ?>
                                                <td><?php echo $item_four; ?> </td>
                                            <?php
                                            }
                                            if ($item_five) {
                                            ?>
                                                <td><?php echo $item_five; ?> </td>
                                            <?php
                                            }
                                            ?>
                                        </tr>
                                    <?php
                                    }
                                    ?>

                                </tbody>
                            </table>
                        <?php
                        }
                        ?>





                        <div class="descwrappar desc-top">
                            <?php
                            if (get_post_field('post_content', $final_s_pro_id)) {
                            ?>
                                <h4>DESCRIZIONE</h4>
                                <br>
                            <?php
                                echo get_post_field('post_content', $final_s_pro_id);
                            }
                            ?>

                            <div class="prodotto-item-extra clearfix">
                                <div class="prodotto-item-dl"></div>
                            </div>
                        </div>
                        <?php
                        $cod_class_iso  = get_post_meta($final_s_pro_id, 'cod_class_iso', true);
                        if ($cod_class_iso) {
                        ?>
                            <div class="datainformation cod_class_iso ">
                                <span>cod. class. ISO</span> <?php echo $cod_class_iso; ?>
                            </div>
                        <?php
                        }
                        $product_pdff  = intval(get_post_meta($final_s_pro_id, 'product_pdff', true));
                        $product_pdff_url = wp_get_attachment_url($product_pdff, 'full');

                        ?>

                        <div class="action_wrappar">
                            <div class="btn-product-grp mt20 sfty_all_btn_dgn">
                                <a pro_id_no="<?php echo $final_s_pro_id; ?>" class="show_hide_blw_form button-cta-style-one custom_click_wrappar enq_form_click" href="">richiedi info</a>
                                <a class="button-cta-style-one custom_click_wrappar" href="<?php echo get_field('store_locator_page', 'option');  ?>"> <?php echo __('scopri dove trovarlo', 'safety-it'); ?> </a>
                                <?php
                                if ($product_pdff_url) {
                                ?>
                                    <div class="right_side_pdf_pos">
                                        <div class="pdf-button-wrapper pdf_sz_dgn">
                                            <a href="<?php echo $product_pdff_url; ?>" download>
                                                <img src="<?php echo get_template_directory_uri(); ?>/img/tasto-scarica.png" alt="">
                                            </a>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>

                            </div>
                            <div class="product_inquiryform inactiveclass" id="enq_form_<?php echo $final_s_pro_id; ?>" style="display:none;">
                                <?php echo do_shortcode('[contact-form-7 id="160" title="' . 'Product name' . '"]');; ?>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }
    ?>


</div>

<br>
<br>
<br>


<?php
get_footer();
