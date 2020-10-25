<?php

require dirname(__DIR__, 3) . '/include/cp_header.php';
xoops_cp_header();

$table1 = 'xoops_link2us_master';
$table2 = 'xoops_link2us_banners';

if ('delete' != $_POST[op]) {
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
		<P><strong>Select a Record to Delete:</strong><br>
		<select name=\"sel_id\">
		<option value=\"\">-- Select One --</option>";

        while (false !== ($recs = $GLOBALS['xoopsDB']->fetchBoth($get_list_res))) {
            $id = $recs['id'];

            $display_name = stripslashes($recs['display_name']);

            $display_block .= "<option value=\"$id\">$display_name</option>";
        }

        $display_block .= '
		</select>
		<input type="hidden" name="op" value="delete">
		<p><input type="submit" name="submit" value="Delete Selected Entry"></p>
		</FORM>';
    }
} elseif ('delete' == $_POST[op]) {
    //check for required fields

    if ('' == $_POST[sel_id]) {
        header('Location: delete_banners.php');

        exit;
    }

    //issue queries

    $del_master = "delete from $table1 where id = $_POST[sel_id]";

    $GLOBALS['xoopsDB']->queryF($del_master);

    $del_banners = "delete from $table2 where id = $_POST[sel_id]";

    $GLOBALS['xoopsDB']->queryF($del_banners);

    $display_block = "<h1>Record(s) Deleted</h1>
	<P>Would you like to
	<a href=\"$_SERVER[PHP_SELF]\">delete another</a>?</p>";
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
