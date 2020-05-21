<?php
/**
 * Module contrats
 *
 * @category Prestashop
 * @category Module
 * @author    Marie Diallo
 * @license   Tous droits réservés / Le droit d'auteur s'applique (All rights reserved / French copyright law applies)
 */

require_once _PS_MODULE_DIR_ . 'contrats/models/Contrat.php';
require_once _PS_MODULE_DIR_ . 'contrats/models/ContratLigne.php';

class ContratslistModuleFrontController extends ModuleFrontController {


    public function init() {
        $this->display_column_left = false;
        $this->display_column_right = false;
        parent::init();
    }

    
    public function getTemplateVarPage() {
        $page = parent::getTemplateVarPage();
        $page['body_classes']['page-customer-account'] = true;
        return $page;
    }
    
    public function initContent() {

        if (Tools::getIsset('ajax_edit_date_contrat')) {
            $contrat = new Contrat(Tools::getValue('id_contrat'));

          /*  $contrat->date_next_cmd = Tools::getValue('date');
            $contrat->modif_client = 1;*/

            $contrat->updateDateNextCmd(Tools::getValue('date'));

            die();

        }

        parent::initContent();

        $id_customer = $this->context->customer->id;

        /* Pas de suppression de contrat possible
         * if (Tools::getValue('action') == 'delete') {
            $id_opartdevis = (int) Tools::getValue('opartquotationId');
            if (Db::getInstance()->delete('opartdevis', 'id_customer =' . (int) $id_customer . ' AND id_opartdevis=' . (int) $id_opartdevis))
                $this->context->smarty->assign('deleted', 'success');
        }*/

        $sql = 'SELECT * FROM `' . _DB_PREFIX_ . 'contrat` WHERE id_client=' . (int) $id_customer;
        $contrats = Db::getInstance()->executeS($sql);

        $dateLimite = new DateTime();
        $dateLimite->add(new DateInterval('P14D')); // P1D veut dire 1 Jour, P2D veut dire 2 jours ...
        $dateLimite = $dateLimite->format('Y-m-d'); // ensuite ici on le formate au format voulu


       foreach ($contrats as &$contrat) {
            //$quotation['is_valid'] = $obj->isValid($quotation['date_add']);
            //update statut for quote nore more valid
            $obj = new Contrat($contrat['id_contrat']);

            if($contrat['date_next_cmd'] > $dateLimite){
                $contrat['editable'] = true;
            }else{
                $contrat['editable'] = false;
            }
           $contrat['lignes'] = $obj->getLigneContrat();
          /*  $contrat['statut'] = $obj->checkValidity($quotation['date_add']);
            $quotation['expire_date'] = OpartQuotation::calc_expire_date($quotation['date_add']);*/
       }
        
        $body_classes['page-customer-account'] = true;

        $this->context->smarty->assign(array(
            'contrats' => $contrats,
            'dateLimite' => $dateLimite,
            'body_classes' => $body_classes
            
        ));

        $this->setTemplate('list.tpl');

    }

}
?>