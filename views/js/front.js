/*
* @category Prestashop
* @category Module
* @author Olivier CLEMENCE <manit4c@gmail.com>
* @copyright  Op'art
* @license Tous droits réservés / Le droit d'auteur s'applique (All rights reserved / French copyright law applies)
**/
$(document).ready(function() {

    $(".load_save").hide();

    $('.update_date_next_cmd').click(function (e) {

        var dateLimite = $("#dateLimite").val();

        var id_contrat = $(this).attr('data-id');
        var date = $("#update_contrat_next_date_" + id_contrat).val();

       if(date == ""){
           alert("Vous devez renseigner une date.");
           return false;
       }
       if(new Date(date) < new Date(dateLimite)){
            alert("La nouvelle date doit être postérieure au " + dateLimite);
            return false;
        }
        $("#load_save_" + id_contrat).show();

         $.ajax({
            type: 'POST',
            url: 'index.php?fc=module&module=contrats&controller=list&ajax_edit_date_contrat',
            data: 'id_contrat=' + id_contrat + '&date=' + date,
            success: function (data) {
                $("#load_save_" + id_contrat).hide();
                alert('Les données ont été enregistrees. La page va être rechargée, merci de patienter...');
                window.location.reload();

            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                alert('Une erreur est survenue !');
                $("#load_save_" + id_contrat).hide();
            }
        });

        e.preventDefault();
    });



});

