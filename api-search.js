(function ($) {
    $(document).ready(function () {

        var url = action_url_ajax.ajax_url;

        $(".api_search_info").on('keyup', function () {
            var input_value = $(".api_search_info").val();
            var input_value_length = input_value.length;

            if (input_value_length > 0) {
                $(".api_search_bottom").css({ 'display': 'block' });
                $.ajax({
                    url: url,
                    data: {
                        action: 'api_search_action',
                        input_value: input_value,
                    },
                    type: 'post',
                    dataType: 'JSON',
                    success: function (data) {
                        if (data.error == true) {
                            $(".api_search_bottom").css({ 'display': 'block' });
                            $(".api_search_bottom").html('No item found');
                        } else {
                            $(".api_search_bottom").css({ 'display': 'block' });
                            $(".api_search_bottom").html(data.data);
                        }
                    },
                });
            } else {
                $(".api_search_bottom").css({ 'display': 'none' });
            }

            if (input_value == '') {
                $(".api_search_bottom").css({ 'display': 'none' });
            }
        });


        // start to set title in form 
       $(".show_hide_blw_form").on('click', function (e) {
            e.preventDefault();
            let pro_id_no = $(this).attr('pro_id_no');
            $("#enq_form_" + pro_id_no).slideToggle();;
            let search_title = $(".search_title_" + pro_id_no).html();
            $('div#enq_form_' + pro_id_no + ' .product-form-group:first input[readonly]').val(search_title);
            console.log(pro_id_no);
        });


        // $('.show_hide_blw_form').click(function () {
        //     let pro_id_no = $(this).attr('pro_id_no');
        //     $("#enq_form_" + pro_id_no).css({ 'display': 'block' });
        //     let search_title = $(".search_title_" + pro_id_no).html();
        //     $('.product-form-group:first input[readonly]').val(search_title);
        // });

    });

})(jQuery)