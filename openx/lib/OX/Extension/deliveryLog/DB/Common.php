<?php

/*
+---------------------------------------------------------------------------+
| OpenX v2.8                                                                |
| ==========                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
|                                                                           |
| This program is free software; you can redistribute it and/or modify      |
| it under the terms of the GNU General Public License as published by      |
| the Free Software Foundation; either version 2 of the License, or         |
| (at your option) any later version.                                       |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA |
+---------------------------------------------------------------------------+
$Id: Common.php 37157 2009-05-28 12:31:10Z andrew.hill $
*/

/**
 * A default deliveryLog extension database layer class. Is both used as an
 * ancestor class for any databases that require special database support
 * functionality to allow the deliveryLog extension to work effectively, and
 * also as a default class when no database-specific class exists.
 *
 * @package    OpenXExtension
 * @subpackage DeliveryLog
 * @author     Radek Maciaszek <radek.maciaszek@openx.org>
 */
class OX_Extension_DeliveryLog_DB_Common
{

    /**
     * A method to install whatever database support functionality
     * is required to allow the deliveryLog extension to operate
     * effectively.
     *
     * @param Plugins_DeliveryLog $oComponent The plugin component being installed
     *                                        that requires the special database
     *                                        layer support.
     * @return boolean True on success, false otherwise.
     */
    public function install(Plugins_DeliveryLog $oComponent)
    {
        return true;
    }

    /**
     * A method to uninstall whatever database support functionality
     * was required to allow the deliveryLog extension to operate
     * effectively.
     *
     * @param Plugins_DeliveryLog $oComponent The plugin component being uninstalled
     *                                        that requires the special database
     *                                        layer support.
     * @return boolean True on success, false otherwise.
     */
    public function uninstall(Plugins_DeliveryLog $oComponent)
    {
        return true;
    }

}

?>