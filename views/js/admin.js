/*
* @category Prestashop
* @category Module
* @author Olivier CLEMENCE <manit4c@gmail.com>
* @copyright  Op'art
* @license Tous droits réservés / Le droit d'auteur s'applique (All rights reserved / French copyright law applies)
**/
$(document).ready(function() {

    $(".load_save").hide();



    $('#calcul_date_next_cmd').click(function(){
        if($('#periode').val() == '' && $('#date_last_cmd').val() == ''){
            alert("Vous devez d'abord renseigner la période et la date de dernière commande !");
            return false;
        }

        var date = new Date($('#date_last_cmd').val());
        date.setDate(date.getDate() + (7 * $('#periode').val())  );

        var d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();

        if (month.length < 2)
            month = '0' + month;
        if (day.length < 2)
            day = '0' + day;

        $('#date_next_cmd').val([year, month, day].join('-'));

        e.preventDefault();

    });

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
            }
        }).result(function (e, i) {
        console.log(i);
        if (i != undefined) {
            //AddLigneContrat(i[0],i[1],1);
            $('#contrat_product_name_text').html(i[1]);
            $('#contrat_product_id_input').val(i[0]);
        }
        $(this).val('');
    });

    $('#add_new_contrat_ligne_button').click(function (e) {
        $("#load").show();
        var id_pdt = $('#contrat_product_id_input').val();
        var qte = $('#contrat_product_qte_input').val();
        if (qte == "") {
            alert('Vous devez renseigner une quantité !');
            $("#load").hide();
            return false;
        }
        $.ajax({
            type: 'POST',
            url: 'index.php?controller=AdminContrat&ajax_add_contrat_ligne&token=' + contrat_token,

            data: 'id_contrat=' + id_contrat + '&id_produit=' + id_pdt + '&qte=' + qte,
            success: function (data) {
                alert('Les données ont été enregistrees. La page va être rechargée, merci de patienter...');
                window.location.reload();
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                $("#load").hide();
                alert('Une erreur est survenue !');
            }
        });
    });


    $('.delete_contrat_ligne_input').click(function (e) {
        var id_contrat_ligne = $(this).attr('data-id');

        if (confirm("Voulez-vous vraiment supprimer ce produit du contrat ?")) {
            $("#load_save_" + id_contrat_ligne).show();
            $.ajax({
                type: 'POST',
                url: 'index.php?controller=AdminContrat&ajax_delete_contrat_ligne&token=' + contrat_token,

                data: 'id_contrat_ligne=' + id_contrat_ligne,
                success: function (data) {
                    alert('Les données ont bien été enregistrées');
                    $("tr#id_" + id_contrat_ligne).hide();
                    $("#load_save_" + id_contrat_ligne).hide();
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    alert('Une erreur est survenue !');
                    $("#load_save_" + id_contrat_ligne).hide();
                }
            });
        }
        e.preventDefault();

    });

    $('.update_contrat_ligne_input').click(function (e) {


        var id_contrat_ligne = $(this).attr('data-id');
        $("#load_save_" + id_contrat_ligne).show();
        var qte = $("#update_contrat_ligne_input_" + id_contrat_ligne).val();
        $.ajax({
            type: 'POST',
            url: 'index.php?controller=AdminContrat&ajax_update_contrat_ligne&token=' + contrat_token,

            data: 'id_contrat_ligne=' + id_contrat_ligne + '&qte=' + qte,
            success: function (data) {
                alert('Les données ont bien été enregistrées.');
                $("#load_save_" + id_contrat_ligne).hide();

            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                alert('Une erreur est survenue !');
                $("#load_save_" + id_contrat_ligne).hide();
            }
        });

        e.preventDefault();
    });

    var boolForLine = 1;

    function AddLigneContrat(prodId, prodName, qty) {
        OpartToggleSubmitBtn(0);
        randomId = new Date().getTime();
        boolForLine = (boolForLine == 1) ? 0 : 1;

        var newTr = '<tr class="line_' + boolForLine + '" id="trProd_' + randomId + '" style="display:none;">';
        newTr += '<td id="tdIdprod_' + randomId + '">' + prodId + '<input type="hidden" name="whoIs[' + randomId + ']" value="' + prodId + '" id="whoIs_' + randomId + '"/></td>';
        newTr += '<td>' + prodName + '</td>';
        newTr += '<td class="productPrice">';
        newTr += '<input id="inputQty_' + randomId + '" type="' + qtyInputType + '" value="' + qty + '" name="add_prod[' + randomId + ']" class="opartDevisAddProdInput calcTotalOnChange"/>';
        newTr += '</td>';
        newTr += '<td>';
        if (!customization_datas) {
            newTr += '<a href="#" onclick="opartDevisDeleteProd(\'' + randomId + '\'); return false;"><i class="icon-trash"></i></a>';
        }
        newTr += '</td>';
        newTr += '</tr>';
        $('#opartDevisProdList').append(newTr);
        $('#trProd_' + randomId).show('slow');
        //$('#trSpecificPrice_'+randomId).show('slow');
        //load declinaison

    }

});

