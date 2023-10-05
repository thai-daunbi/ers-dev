<?php
#- default include
include(__DIR__.'/inc/default.inc.php');

#- Html header
$title = 'ERS Dev';
html_header($title);

#- Controller =======================================================
$search = isset($_GET['search']) ? $_GET['search'] : '';

echo '<form method="get" action="index.php" style="margin-bottom: 20px;">';
echo '  <input type="text" id="search" name="search" value="' . htmlspecialchars($search) . '">';
echo '  <input type="submit" name="submit_search" value="search">';
echo '</form>';

$search_condition = '';
$search_results = [];

if (!empty($search)) {
    $search = "%$search%";
    $sql = "SELECT * FROM tokyo_csv___13tokyo_csv WHERE zipcode LIKE ? OR City LIKE ? OR `State` LIKE ? OR `Street Address` LIKE ?";
    $stmt = $mysqli->prepare($sql);
    $search = mb_convert_encoding($search, "UTF-8", "UTF-8");
    $stmt->bind_param("ssss", $search, $search, $search, $search);
    $stmt->execute();
    $result = $stmt->get_result();
    $search_results = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
}

$set->search_results = $search_results;
#----------------------------------------------------------------------


$sql = "SELECT * FROM tokyo_csv___13tokyo_csv WHERE 1 ";
if (!empty($search)) {
    $sql .= "AND (zipcode LIKE '$search' OR City LIKE '$search' OR `State` LIKE '$search' OR `Street Address` LIKE '$search')";
}
$sql .= " ORDER BY code DESC";


$pager = new Pager($mysqli, $sql, PAGER_LIMIT);

$set->tokyo_csv___13tokyo_csv = $db->pager($pager);

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
$db->update('tokyo_csv___13tokyo_csv', $fields, 'id = 9');

#- Update -------
$fields = array(
    'name' => 'update name',
);
$db->update('tokyo_csv___13tokyo_csv', $fields, 'id = 9');

#- View =============================================================
view('index', $set);

#- Function =========================================================
