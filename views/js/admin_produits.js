/*
* @category Prestashop
* @category Module
* @author Olivier CLEMENCE <manit4c@gmail.com>
* @copyright  Op'art
* @license Tous droits réservés / Le droit d'auteur s'applique (All rights reserved / French copyright law applies)
**/
$(document).ready(function() {

    $("#load_search").hide();

    $('#contrat_product_autocomplete_input').autocomplete(
        'index.php?controller=AdminContrat&ajax_product_list',
        {
            minChars: 3,
            autoFill: true,
            max: 200,
            matchContains: true,
            scroll: false,
            cacheLength: 0,
            formatItem: function (item) {
                return item[0] + ' - ' + item[1] + ' - ' + item[2];
            },
            extraParams: {
                token: contrat_token
            },
            search : function (e, i) {
                $("#load_search").show();
            }
        }).result(function (e, i) {

            if (i != undefined) {
                $("#load_search").hide();
                $('#contrat_product_name_text').html(i[1]);
                $('#contrat_product_id_input').html(i[0]);
            }

       });
       $(this).val('');


});

