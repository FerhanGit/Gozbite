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
$Id: index.php 37157 2009-05-28 12:31:10Z andrew.hill $
*/

/**
 * This file is only called to redirect to somewhere else, however, if Openads
 * is not yet installed, we need to know that it was this file that was called,
 * so set a global variable.
 */
define('ROOT_INDEX', true);

// Require the initialisation file
require_once 'init.php';

// Required files
require_once LIB_PATH . '/Admin/Redirect.php';

// Redirect to the admin interface
//if ($conf['openads']['installed'])
if (OA_INSTALLATION_STATUS == OA_INSTALLATION_STATUS_INSTALLED)
{
    OX_Admin_Redirect::redirect();
}

?>
