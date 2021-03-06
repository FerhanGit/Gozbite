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
$Id: lib-banner.inc.php 37157 2009-05-28 12:31:10Z andrew.hill $
*/

require_once MAX_PATH . '/lib/max/other/common.php';

function phpAds_getBannerCache($banner)
{
    $aConf = $GLOBALS['_MAX']['CONF'];
    $aPref = $GLOBALS['_MAX']['PREF'];
    $buffer = $banner['htmltemplate'];

    // Strip slashes from urls
    $banner['url']      = stripslashes($banner['url']);
    $banner['imageurl'] = stripslashes($banner['imageurl']);

    // The following properties depend on data from the invocation process
    // and can't yet be determined: {zoneid}, {bannerid}
    // These properties will be set during invocation

    // Auto change HTML banner
    if ($banner['storagetype'] == 'html')
    {
        if ($buffer != '')
        {
            // Remove target parameters
            // The regexp should handle ", ', \", \' as delimiters
            $buffer = preg_replace('# target\s*=\s*(\\\\?[\'"]).*?\1#i', ' ', $buffer);

            // Put our click URL and our target parameter in all anchors...
            // The regexp should handle ", ', \", \' as delimiters
            $buffer = preg_replace('#<a(.*?)href\s*=\s*(\\\\?[\'"])http(.*?)\2(.*?) *>#is', "<a$1href=$2{clickurl}http$3$2$4  target=$2{target}$2>", $buffer);

            // Search: <\s*form (.*?)action\s*=\s*['"](.*?)['"](.*?)>
            // Replace:<form\1 action="{url_prefix}/{$aConf['file']['click']}" \3><input type='hidden' name='{clickurlparams}\2'>
            $target = (!empty($banner['target'])) ? $banner['target'] : "_self";

            // strip out the method from any <forms> these will be changed to GET
            $buffer = preg_replace(
                '#<\s*form (.*?)method\s*=\s*[\\\\]?[\'"](.*?)[\'"]#is',
                "<form $1 method='GET'", $buffer
            );

            $buffer = preg_replace(
                '#<\s*form (.*?)action\s*=\s*[\\\\]?[\'"](.*?)[\'\\\"][\'\\\"]?(.*?)>(.*?)</form>#is',
                "<form $1 action='{url_prefix}/{$aConf['file']['click']}' $3 target='{$target}'>$4<input type='hidden' name='{$aConf['var']['params']}' value='{clickurlparams}$2'></form>",
                $buffer
            );

            //$buffer = preg_replace("#<form*action='*'*>#i","<form target='{target}' $1action='{url_prefix}/{}$aConf['file']['click']'$3><input type='hidden' name='{clickurlparams}$2'>", $buffer);
            //$buffer = preg_replace("#<form*action=\"*\"*>#i","<form target=\"{target}\" $1action=\"{url_prefix}/{$aConf['file']['click']}\"$3><input type=\"hidden\" name=\"{clickurlparams}$2\">", $buffer);

            // In addition, we need to add our clickURL to the clickTAG parameter if present, for 3rd party flash ads
            $buffer = preg_replace('#clickTAG\s?=\s?(.*?)([\'"])#', "clickTAG={clickurl}$1$2", $buffer);

            // Detect any JavaScript window.open() functions, and prepend the opened URL with our logurl
            $buffer = preg_replace('#window.open\s?\((.*?)\)#i', "window.open(\\\'{logurl}&maxdest=\\\'+$1)", $buffer);
        }

        // Since we don't want to replace adserver noscript and iframe content with click tracking etc
        $noScript = array();

        //Capture noscript content into $noScript[0], for seperate translations
        preg_match("#<noscript>(.*?)</noscript>#is", $buffer, $noScript);
        $buffer = preg_replace("#<noscript>(.*?)</noscript>#is", '{noscript}', $buffer);

        // run 3rd party component
        if(!empty($banner['adserver'])) {
            require_once LIB_PATH . '/Plugin/Component.php';
            /**
              * @todo This entire function should be relocated to the DLL and should be object-ified
              *
             */
            PEAR::pushErrorHandling(null);
            $adServerComponent = OX_Component::factoryByComponentIdentifier($banner['adserver']);
            PEAR::popErrorHandling();
                if ($adServerComponent) {
                $buffer = $adServerComponent->getBannerCache($buffer, $noScript);
            } else {
                $GLOBALS['_MAX']['bannerrebuild']['errors'] = true;
            }
        }

        // Wrap the banner inside a link if it doesn't seem to handle clicks itself
        if (!empty($banner['url']) && !preg_match('#<(a|area|form|script|object|iframe) #i', $buffer)) {
            $buffer = '<a href="{clickurl}" target="{target}">'.$buffer.'</a>';
        }

        // Adserver processing complete, now replace the noscript values back:
        //$buffer = preg_replace("#{noframe}#", $noFrame[2], $buffer);
        if (isset($noScript[0])) {
            $buffer = preg_replace("#{noscript}#", $noScript[0], $buffer);
        }
    }

    return ($buffer);
}

?>
