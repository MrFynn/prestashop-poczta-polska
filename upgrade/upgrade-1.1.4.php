<?php
/*
* 2007-2016 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Open Software License (OSL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/osl-3.0.php
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
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2016 PrestaShop SA
*  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

if (!defined('_PS_VERSION_'))
	exit;

function upgrade_module_1_1_4($module)
{
	$module->sendInformationEmail(false);
    $sql = "CREATE TABLE IF NOT EXISTS `"._DB_PREFIX_."pocztapolskaen_profile_address` (
                `id_profile_address` int(11) unsigned NOT NULL auto_increment,
              `id_en` int(11) DEFAULT NULL,
              `name` varchar(255) DEFAULT NULL,
              `friendly_name` varchar(255) DEFAULT NULL,
              `street` varchar(255) DEFAULT NULL,
              `house_number` varchar(128) DEFAULT NULL,
              `premises_number` varchar(128) DEFAULT NULL,
              `city` varchar(255) DEFAULT NULL,
              `postal_code` varchar(8) DEFAULT NULL,
              `date_add` datetime DEFAULT NULL,
              `date_upd` datetime DEFAULT NULL,
              PRIMARY KEY (`id_profile_address`)
            ) ENGINE="._MYSQL_ENGINE_." DEFAULT CHARSET=utf8";
    if (Db::getInstance()->execute($sql))
    return true;
}
