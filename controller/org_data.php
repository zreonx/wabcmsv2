<?php 

    require_once '../config/connection.php';

    $result = $organization->getOrganizations();

    $org_data = $result->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($org_data);

?>