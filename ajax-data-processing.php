<?php
function api_search_action()
{

    $input_value = $_POST['input_value'] ?? '';
    $message = '';

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
    $results            = curl_exec($ch);
    $api_product_results    = json_decode($results, true);
    // end API code 

    global $wpdb;
    $rda_posts             = $wpdb->prefix . 'posts';
    $title_to_search       = $input_value;

    $query = $wpdb->prepare(" SELECT * FROM $rda_posts WHERE post_title LIKE %s AND post_type = 'product' AND  post_status = 'publish'", '%' . $wpdb->esc_like($title_to_search) . '%');

    $normal_results        = $wpdb->get_results($query);

    $total_posts    = count($normal_results);
    $norml_products   = [];

    if ($total_posts > 0) {
        $i = 0;
        foreach ($normal_results as $single_product) {
            $product_id     = $single_product->ID ?? '';
            $post_name     = $single_product->post_name ?? '';

            $norml_products[$i]['product_id']     = $product_id;
            $norml_products[$i]['pntx_product']   = 'sfty_product';
            $norml_products[$i]['title']          = get_the_title($product_id);
            $norml_products[$i]['product_slug']   = $post_name;
            $norml_products[$i]['product_url']    = '';
            $norml_products[$i]['thumbnail']      = get_the_post_thumbnail_url($product_id);
            $i++;
        }
    }

    $final_results      = array_merge($norml_products, $api_product_results);
    $final_total_post   =   count($final_results);

    $response['error']      = true;
    $response['message']    = 'Not found';
    $response['data']       = '';

    $search_single_item = '';

    if ($final_total_post > 0) {
        foreach ($final_results as $single_product) {

            $product_id     = $single_product['product_id'] ?? '';
            $sft_prnt_check = $single_product['pntx_product'] ?? '';
            $title          = $single_product['title'] ?? '';
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

            if ($sft_prnt_check == 'sfty_product') {
                $site_url = site_url();
                $final_product_url = $site_url . '/results/?product-title=' . $title;
            }

            if ($sft_prnt_check == 'pntx_product') {
                $target_attr = 'target="_blank"';
                $final_product_url = $product_url;
            }

            $search_single_item .= '
                <div class="api_single_search">
                    <a ' . $target_attr . ' href="' . $final_product_url . '"></a>
                    <div class="api_search_left">
                        <img src="' . $thumbnail . '" alt="">
                    </div>
                    <div class="api_search_right">
                        <p>' . $title . '</p>
                    </div>
                </div>
            ';
        }

        $response['error']      = false;
        $response['message']    = 'Success';
        $response['data']       = $search_single_item;
    }

    echo  json_encode($response);
    die;
}


add_action('wp_ajax_api_search_action', 'api_search_action');
add_action('wp_ajax_nopriv_api_search_action', 'api_search_action');
