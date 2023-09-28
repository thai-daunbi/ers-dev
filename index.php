<?php
#- default include
include(__DIR__.'/inc/default.inc.php');


#- Html header
$title = 'ERS Dev' ;
html_header($title);


#- Controller =======================================================

$search = isset($_GET['search']) ? $_GET['search'] : '';
echo '<form method="get" action="index.php" style="margin-bottom: 20px;">';
echo '  <label for="search">search:</label>';
echo '  <input type="text" id="search" name="search" value="' . htmlspecialchars($search) . '">';
echo '  <input type="submit" value="search">';
echo '</form>';

#- 検索結果 -------
$bind = array(":search" => "%$search%");
$set->search = $db->select('tokyo_csv', 'name LIKE :search', $bind);

#- Pager example of use -------
$sql = "SELECT * FROM tokyo_csv WHERE 1 ";
if (!empty($search)) {
    $sql .= "AND (name LIKE :search OR code LIKE :search)";
}

$sql .= " ORDER BY code DESC";

$pager = new Pager($mysqli, $sql, PAGER_LIMIT);
//debug($pager);

# list 取得
$set->tokyo_csv = $db->pager($pager);

# paging
$set->pager = $pager->show();

#- Insert -------
$fields = array(
	'name' => 'LName FName',
);
//$db->insert('list', $fields);

#- Update -------
$fields = array(
	'name' => 'LName FName',
);
$db->update('tokyo_csv', $fields, 'id = 9');

#- Update -------
$fields = array(
    'name' => 'update name',
);
$db->update('tokyo_csv', $fields, 'id = 9');


#- View =============================================================
view('index', $set);



#- Function =========================================================

