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
echo '</form';

$search_condition = '';
$search_results = [];

if (!empty($search)) {
    if(is_numeric($search)){
        $search = str_replace(' ', '', $search) . "%";
    } else {
        $search = "%" . str_replace(' ', '', $search) . "%";
    }
    

    $sql = "SELECT * FROM ken_all WHERE (zipcode LIKE ? OR City LIKE ? OR `State` LIKE ? OR `Street Address` LIKE ? OR (City LIKE ? AND State LIKE ?))";

    $stmt = $mysqli->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ssssss", $search, $search, $search, $search, $search, $searchWithSpace);
        $stmt->execute();
        $result = $stmt->get_result();
        $search_results = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
    } else {
        echo "Query preparation failed: " . $mysqli->error;
    }
}

$set->search_results = $search_results;
#----------------------------------------------------------------------

$sql = "SELECT * FROM ken_all WHERE 1 ";

if (!empty($search)) {
    $sql .= "AND (zipcode LIKE '$search' OR City LIKE '$search' OR `State` LIKE '$search' OR `Street Address` LIKE '$search' OR CONCAT(City, `State`,`Street Address`) LIKE '$search' OR CONCAT(City, `State`) LIKE '$search' OR CONCAT(`State`,`Street Address`) LIKE '$search')";
}

$sql .= " ORDER BY code DESC";


$pager = new Pager($mysqli, $sql, PAGER_LIMIT);

$set->ken_all = $db->pager($pager);

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
$db->update('ken_all', $fields, 'id = 9');

#- Update -------
$fields = array(
    'name' => 'update name',
);
$db->update('ken_all', $fields, 'id = 9');

#- View =============================================================
view('index', $set);

#- Function =========================================================
