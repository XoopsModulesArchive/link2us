<?php

//  ------------------------------------------------------------------------ //
//                XOOPS - LINK 2 US Module                                   //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
// ------------------------------------------------------------------------- //
// Author: Anthony Meyer		                                             //
// Site: http://www.blacksixdesigns.com                                      //
//                                                                           //
// ------------------------------------------------------------------------- //

include '../../mainfile.php';
require XOOPS_ROOT_PATH . '/header.php';

$sql = 'SELECT * FROM xoops_link2us_banners';
$result = $GLOBALS['xoopsDB']->queryF($sql) || die($GLOBALS['xoopsDB']->error());
echo '<table align="center" width="100%">
<tr><td align="center"><h1>Please use the HTML code below to select a banner to link your site to ours.</h1></td></tr></table>';

while (false !== ($newArray = $GLOBALS['xoopsDB']->fetchBoth($result))) {
    $imageurl = $newArray['image_url'];

    $clickurl = $newArray['click_url'];

    echo "			
<blockquote>
<p>&nbsp;</p>
<p><img src=\"$imageurl\"></p>
<textarea cols=\"50\" class=\"code\" rows=\"3\" readonly=\"readonly\" onFocus=\"this.select()\">
&lt;a&nbsp;href=&quot;$clickurl&quot;target=&quot;_blank&quot;&gt;$clickurl&lt;/a&gt;</textarea>
</blockquote>";
}

require_once XOOPS_ROOT_PATH . '/footer.php';
