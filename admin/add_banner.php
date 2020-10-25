<?php

require dirname(__DIR__, 3) . '/include/cp_header.php';
xoops_cp_header();
$table1 = 'xoops_link2us_master';
$table2 = 'xoops_link2us_banners';
if (('add' != $_POST[op]) || ('' != $_GET[master_id])) {
    //haven't seen the form, so show it

    $display_block = "<h1>Add a Banner</h1><form method=\"post\" action=\"$_SERVER[PHP_SELF]\">";

    if ('' != $_GET[master_id]) {
        //get category information for display/test validity

        $get_bannercat = "select concat_ws(' ', banner_id) as display_name from $table1 where id = $_GET[master_id]";

        $get_bannercat_res = $GLOBALS['xoopsDB']->queryF($get_bannercat) || die($GLOBALS['xoopsDB']->error());

        if (1 == $GLOBALS['xoopsDB']->getRowsNum($get_bannercat_res)) {
            $display_name = mysql_result($get_bannercat_res, 0, 'display_name');
        }
    }

    if ('' != $display_name) {
        $display_block .= "<P><b>Add Banner information for Category:</b>$display_name:</p>";
    } else {
        $display_block .= '<p><b>Banner Category:</b></p>
<input type="text" name="banner_cat" size=50 maxlength=150>';
    }

    $display_block .= "
<p><b>Image URL:</b></p>
<input type=\"text\" name=\"imageurl\" size=50 maxlength=150>

<p><b>Click URL:</b></p>
<input type=\"text\" name=\"clickurl\" size=50 maxlength=150>
<input type=\"hidden\" name=\"op\" value=\"add\">
<input type=\"hidden\" name=\"master_id\" value=\"$_GET[master_id]\">

	<p><input type=\"submit\" name=\"submit\" value=\"Add Entry\"></p>
	</FORM>";
} elseif ('add' == $_POST[op]) {
    //time to add to tables so check for required fields.

    if (('' == $_POST[banner_cat]) && ('' == $_POST[master_id])) {
        header('Location: add_banner.php');

        exit;
    }

    //add to link2us_master (master table).

    if ('' == $_POST[master_id]) {
        //add to master_name table

        $add_master = "insert into $table1 values ('', now(), now(), '$_POST[banner_cat]')";

        $GLOBALS['xoopsDB']->queryF($add_master) || die($GLOBALS['xoopsDB']->error());

        //get master id for use with other tables.

        $master_id = $GLOBALS['xoopsDB']->getInsertId();
    } else {
        $master_id = $_POST[master_id];
    }

    //add to link2us_banners.

    if (($_POST[imageurl]) || ($_POST[clickurl])) {
        //something relevant, so add to link2us_banners table

        $add_banner = "insert into $table2 values ('', $master_id, now(), now(), '$_POST[imageurl]','$_POST[clickurl]')";

        $GLOBALS['xoopsDB']->queryF($add_banner) || die($GLOBALS['xoopsDB']->error());
    }

    $display_block = '<h1>Banner added.</h1><p>Your banner has been added.  Would you like to <a href="add_banner.php">add another</a></p>';
}
?>
<html>
<body>
<?php echo $display_block;
xoops_cp_footer(); ?>
</body>
</html>
