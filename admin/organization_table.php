<?php 
    require_once '../config/connection.php';

    $allOrg = $organization->getOrganizations();
?>
<table class="table table-hover text-center">
    <thead>
        <tr>
            <td>#</td>
            <td>Organization</td>
            <td>Action</td>
        </tr>
    </thead>
    <?php $count = 1; while($org_row = $allOrg->fetch(PDO::FETCH_ASSOC)): ?>
        <tr>
            <td><?php echo $count; ?></td>
            <td><?php echo $org_row['organization_name']; ?></td>
            <td>
                <button class="btn btn-primary btn-sm rounded">Edit</button>
                <button class="btn btn-danger btn-sm rounded">Delete</button>
            </td>
        </tr>
    <?php $count++; endwhile; ?>
</table>
