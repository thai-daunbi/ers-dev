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
echo '  <input type="submit" name="submit_search"  value="search">';
echo '</form>';

$search_condition = '';
if (!empty($search)) {
    $search_condition = 'zipcode LIKE ?';
    $bind = array("%$search%");
}

$sql = "SELECT * FROM tokyo1_csv WHERE 1 ";
if (!empty($search_condition)) {
    $sql .= "AND ($search_condition)";
}
$sql .= " ORDER BY code DESC";

if (!empty($search_condition)) {
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $bind[0]); 
    $stmt->execute();
    $result = $stmt->get_result();
    $pager = new Pager($mysqli, $result, PAGER_LIMIT, 'page');
} else {
    $pager = new Pager($mysqli, $sql, PAGER_LIMIT, 'page');
}


# paging
$set->pager = $pager->show();
