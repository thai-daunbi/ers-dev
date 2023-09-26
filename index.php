<?php
#- default include
include(__DIR__.'/inc/default.inc.php');


#- Html header
$title = 'ERS Dev' ;
html_header($title);


#- Controller =======================================================


<form method="post" action="search.php">
	<label for="search">search:</label>
	<input type="text" id="search" name="search">
	<input type="submit" value="search">
</form>


#- 検索結果 -------
$bind = array(":search" => "a%");
$set->search = $db->select('employee', 'name LIKE :search', $bind);

#- Pager example of use -------
$sql = "SELECT * FROM employee WHERE 1 ORDER BY id DESC";
$pager = new Pager($mysqli, $sql, PAGER_LIMIT);
//debug($pager);

# list 取得
$set->employee = $db->pager($pager);

# paging
$set->pager = $pager->show();

#- Insert -------
$fields = array(
	'name' => 'LName FName',
);
//$db->insert('list', $fields);

#- Update -------
$fields = array(
	'name' => 'update name',
);
$db->update('employee', $fields, 'id = 9');


#- View =============================================================
view('index', $set);



#- Function =========================================================

