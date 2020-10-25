<?php

require dirname(__DIR__, 3) . '/include/cp_header.php';
xoops_cp_header();

$table1 = 'xoops_link2us_master';
$table2 = 'xoops_link2us_banners';

if ('view' != $_POST[op]) {
    //haven't seen the selection form, so show it

    $display_block = '<h1>Select a Category</h1>';

    //get parts of records

    $get_list = "select id, concat_ws(', ', banner_id) as display_name from $table1 order by banner_id";

    $get_list_res = $GLOBALS['xoopsDB']->queryF($get_list) || die($GLOBALS['xoopsDB']->error());

    if ($GLOBALS['xoopsDB']->getRowsNum($get_list_res) < 1) {
        //no records

        $display_block .= '<p><em>Sorry, no records to select!</em></p>';
    } else {
        //has records, so get results and print in a form

        $display_block .= "
		<form method=\"post\" action=\"$_SERVER[PHP_SELF]\">
		<P><strong>Select a Record to View:</strong><br>
		<select name=\"sel_id\">
		<option value=\"\">-- Select One --</option>";

        while (false !== ($recs = $GLOBALS['xoopsDB']->fetchBoth($get_list_res))) {
            $id = $recs['id'];

            $display_name = stripslashes($recs['display_name']);

            $display_block .= "<option value=\"$id\">$display_name</option>";
        }

        $display_block .= '
		</select>
		<input type="hidden" name="op" value="view">
		<p><input type="submit" name="submit" value="View Selected Entry"></p>
		</FORM>';
    }
} elseif ('view' == $_POST[op]) {
    //check for required fields

    if ('' == $_POST[sel_id]) {
        header('Location: view_banners.php');

        exit;
    }

    //get master_info

    $get_master = "select concat_ws(' ', banner_id) as display_name from $table1 where id = $_POST[sel_id]";

    $get_master_res = $GLOBALS['xoopsDB']->queryF($get_master);

    $display_name = stripslashes(mysql_result($get_master_res, 0, 'display_name'));

    $display_block = "<h1>Showing Record for $display_name</h1>";

    //get all banners

    $get_banners = "select id, image_url, click_url, date_added from $table2 where master_id = $_POST[sel_id]";

    $get_banners_res = $GLOBALS['xoopsDB']->queryF($get_banners);

    if ($GLOBALS['xoopsDB']->getRowsNum($get_banners_res) > 0) {
        $display_block .= '<P><strong>Banners:</strong><br>
		<ul>';

        while (false !== ($add_info = $GLOBALS['xoopsDB']->fetchBoth($get_banners_res))) {
            $imgurl = $add_info[image_url];

            $clurl = $add_info[click_url];

            $date_added = $add_info[date_added];

            //$id =$add_info[banner_id];

            $display_block .= "<b>Image URL:</b> $imgurl</p><p><b>Click URL:</b> $clurl</p><p><b>Date Added:</b> $date_added<p><hr></p>";
        }

        $display_block .= '</ul>';
    }

    $display_block .= "<P align=center>
	<a href=\"add_banner.php?master_id=$_POST[sel_id]\">Add additional banners to this category.</a> ...
	<a href=\"$_SERVER[PHP_SELF]\">select another</a></p>";
}

?>
<HTML>
<HEAD>
    <TITLE>My Banners</TITLE>
</HEAD>
<BODY>
<?php echo $display_block;
xoops_cp_footer(); ?>
</BODY>
</HTML>	
