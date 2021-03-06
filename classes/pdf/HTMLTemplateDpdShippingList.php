<?php
/**
 * 2014-2016 DPD
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 *  @author    Michiel Van Gucht <michiel.vangucht@dpd.be>
 *  @copyright 2014-2016 Michiel Van Gucht
 *  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 *
 *
 *                     N dyyh N
 *                   dhyyyyyyyyhd
 *              N hyyyyyyyyyyyyyyyyhdN
 *          N dyyyyyyyyyyyyyyyyyyyyyyyyd N
 *         hyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyh
 *         N dyyyyyyyyyyyyyyyyyyyyyyyyyyh
 *       d     Ndhyyyyyyyyyyyyyyyyyyyd      dN
 *       yyyh N   N dyyyyyyyyyyyyhdN   N hyyyN
 *       yyyyyyhd     NdhyyyyyyyN   NdhyyyyyyN
 *       yyyyyyyyyyh N   N hyyyyhddyyyyyyyyyyN
 *       yyyyyyyyyyyyyhd     yyyyyyyyyyyyyyyyN
 *       yyyyyyyyyyyyyyyyd   yyyyyyyyyyyyyyyyN
 *       yhhhyyyyyyyyyyyyd   yyyyyyyyyyyyyyyyN
 *       hhhhhyyyyyyyyyyyd   yyyyyyyyyyyyyyyyN
 *       hhhhhhhyyyyyyyyyd   yyyyyyyyyyyyyyyyN
 *       hhhhhhhhyyyyyyyyd   yyyyyyyyyyyyyyyyN
 *       N dhhhhhhhyyyyyyd   yyyyyyyyyyyyyh N
 *           Ndhhhhhyyyyyd   yyyyyyyyyyd
 *              N hhhhyyyh NdyyyyyyhdN
 *                 N dhhyyyyyyyyh N
 *                     Ndhyyhd N
 *                        NN
 */

class HTMLTemplateDpdShippingList extends HTMLTemplate
{
    public function __construct($object, $smarty)
    {
        $this->smarty = $smarty;
        $this->title = 'DPD Shipping List';
        $this->date = date('d-m-Y H:i:s');
        $this->object = $object;
    }

    public function getFilename()
    {
        return 'DpdShippingList' . date('dmY') . '.pdf';
    }
    
    public function getBulkFilename()
    {
        return 'DpdShippingList' . date('dmY') . '.pdf';
    }
    
    protected function getLogo()
    {
        
    }
    
    public function assignHookData($object)
    {
        //$template = Tools::ucfirst(str_replace('HTMLTemplate', '', get_class($this)));
        //$hook_name = 'displayPDF'.$template;

        $this->smarty->assign(array(
            'list' => $object
        ));
    }
    
    /**
     * Returns the template's HTML header
     *
     * @return string HTML header
     */
    public function getHeader()
    {
        $this->assignCommonHeaderData();

        return $this->smarty->fetch($this->getTemplate('header'));
    }
        
    /**
     * Returns the template's HTML content
     *
     * @return string HTML content
     */
    public function getContent()
    {
        return $this->smarty->fetch($this->getTemplate('content'));
    }
    
    
    /**
     * Returns the template's HTML footer
     *
     * @return string HTML footer
     */
    public function getFooter()
    {
        $shop_address = $this->getShopAddress();

        $id_shop = (int)$this->shop->id;

        $this->smarty->assign(array(
            'shop_address' => $shop_address,
            'shop_fax' => (string)Configuration::get('PS_SHOP_FAX', null, null, $id_shop),
            'shop_phone' => (string)Configuration::get('PS_SHOP_PHONE', null, null, $id_shop),
            'shop_email' => (string)Configuration::get('PS_SHOP_EMAIL', null, null, $id_shop),
            'free_text' => (string)Configuration::get(
                'PS_INVOICE_FREE_TEXT',
                (int)Context::getContext()->language->id,
                null,
                $id_shop
            )
        ));

        return $this->smarty->fetch($this->getTemplate('footer'));
    }
    
    protected function getTemplate($template_name)
    {
        return DpdHelper::getPDFTemplate((string)$template_name);
    }
    
    /**
     * Returns the template's HTML pagination block
     *
     * @return string HTML pagination block
     */
    public function getPagination()
    {
        return $this->smarty->fetch($this->getTemplate('pagination'));
    }
}
