<?php $itemsPerPage = 10;
$userId = $_SESSION["id"];

if (isset($_GET['page'])) {
    $currentPage = intval($_GET['page']);
} else {
    $currentPage = 1;
}

$offset = ($currentPage - 1) * $itemsPerPage;
?>