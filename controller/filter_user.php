<?php 
    if(isset($_POST['table_name'])) {

        $table_name = $_POST['table_name'];
        $column_name = $_POST['column_name'];
        $filter_value = strtolower($_POST['filter_value']) ;
        $status_label = $_POST['status_label'];

        require_once '../config/connection.php';

        
        $filter_result = $filter->getTableByUser($table_name, $column_name, $filter_value, $status_label);


        echo "<thead>
                <tr>
                <th>ID</th>
                <th>Type</th>
                <th>Email</th>
                <!-- <th>Password</th> -->
                <th>Status</th>
                <th>Action</th>
                </tr>
            </thead><tbody>";

        $count = 1;
        foreach($filter_result as $user_row): ?>
            <
            <tr>
                <td><?php echo $user_row['user_id']; ?></td>
                <td><?php echo $user_row['user_type']; ?></td>
                <td><?php echo $user_row['email']; ?></td>
                <td class="text-center align-middle"><?php echo ($user_row['status'] == "active") ? '<div class="d-flex justify-content-center"><div class="badge-secondary"><i class="fas fa-circle i-dot i-success "></i> <span>Active</span></div></div>' : '<div class="d-flex justify-content-center"><div class="badge-danger"><i class="fas fa-circle i-dot i-danger "></i> <span>Deactivated</span></div></div>'; ; ?></td>
                <td>
                    <?php if($user_row['status'] == "active"): ?>
                        <button data-id="<?php echo $user_row['id'] ?>" data-bs-toggle="modal" data-bs-target="#deactivateModal" class="btn btn-sm btn-danger rounded btnsm deact-btn"><i class="fas fa-user-alt-slash"></i> <span class="btn-text">Deactivate</span></button>
                    <?php elseif($user_row['status'] == "deactivated"): ?>
                        <button data-id="<?php echo $user_row['id'] ?>" data-bs-toggle="modal" data-bs-target="#activateModal" class="btn btn-sm btn-success rounded btnsm activate-btn"><i class="fas fa-user-alt-slash"></i> <span class="btn-text">Activate</span></button>
                    <?php endif; ?>
                </td>
            </tr>
            
<?php   
        $count++;
        endforeach;
        echo "</tbody>";

    }else {
        //404
    }
?>