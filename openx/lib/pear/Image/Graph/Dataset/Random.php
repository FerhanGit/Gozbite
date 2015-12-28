<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Image_Graph - PEAR PHP OO Graph Rendering Utility.
 *
 * PHP versions 4 and 5
 *
 * LICENSE: This library is free software; you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation; either version 2.1 of the License, or (at your
 * option) any later version. This library is distributed in the hope that it
 * will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty
 * of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser
 * General Public License for more details. You should have received a copy of
 * the GNU Lesser General Public License along with this library; if not, write
 * to the Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
 * 02111-1307 USA
 *
 * @category   Images
 * @package    Image_Graph
 * @subpackage Dataset
 * @author     Jesper Veggerby <pear.nosey@veggerby.dk>
 * @copyright  Copyright (C) 2003, 2004 Jesper Veggerby Hansen
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version    CVS: $Id: Random.php 6 2006-12-15 17:27:27Z  $
 * @link       http://pear.php.net/package/Image_Graph
 */

/**
 * Include file Image/Graph/Dataset/Trivial.php
 */
require_once 'Image/Graph/Dataset/Trivial.php';

/**
 * Random data set, points are generated by random.
 *
 * This dataset is mostly (if not solely) used for demo-purposes.
 *
 * @category   Images
 * @package    Image_Graph
 * @subpackage Dataset
 * @author     Jesper Veggerby <pear.nosey@veggerby.dk>
 * @copyright  Copyright (C) 2003, 2004 Jesper Veggerby Hansen
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version    Release: 0.7.2
 * @link       http://pear.php.net/package/Image_Graph
 */
class Image_Graph_Dataset_Random extends Image_Graph_Dataset_Trivial
{

    /**
     * RandomDataset [Constructor]
     *
     * @param int $count The number of points to create
     * @param double $minimum The minimum value the random set can be
     * @param double $maximum The maximum value the random set can be
     * @param bool $includeZero Whether 0 should be included or not as an X
     *   value, may be omitted, default: false</false>
     */
    function Image_Graph_Dataset_Random($count, $minimum, $maximum, $includeZero = false)
    {
        parent::Image_Graph_Dataset_Trivial();
        $i = 0;
        while ($i < $count) {
            $this->addPoint(
                $ixc = ($includeZero ? $i : $i +1),
                rand($minimum, $maximum)
            );
            $i ++;
        }
    }

}

?>