<?php 
    if(isset($_POST['table_name'])) {

        $table_name = $_POST['table_name'];
        $column_name = $_POST['column_name'];
        $filter_value = strtolower($_POST['filter_value']) ;
        $status_label = $_POST['status_label'];

        require_once '../config/connection.php';

        
        $filter_result = $filter->getStudentBy($table_name, $column_name, $filter_value, $status_label);


        echo "<thead>
                <tr>
                    <th>#</th>
                    <th>Student ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Contact</th>
                    <th>Course / Strand</th>
                    <th>Education Level</th>
                    <th>Academic Level</th>
                    <th>Status</th>
                    <!-- <th>Action</th> -->
                </tr>
            </thead><tbody>";

        $count = 1;
        foreach($filter_result as $stud_row): ?>
            <
            <tr>
                <td><?php echo $count; ?></td>
                <td><?php echo $stud_row['student_id']; ?></td>
                <td><?php echo $stud_row['last_name'] . ", " . $stud_row['first_name'] . " " . $stud_row['middle_name'] //strtoupper(substr($stud_row['middle_name'], 0, 1)) ."." ?></td>
                <td><?php echo $stud_row['email']; ?></td>
                <td><?php echo $stud_row['contact_number']; ?></td>
                <td><?php echo $stud_row['program_course']; ?></td>
                <td><?php echo $stud_row['academic_level']; ?></td>
                <td><?php echo $stud_row['year_level']; ?></td>
                <td class="text-center align-middle"><?php echo ($stud_row['status'] == "imported") ? '<div class="badge-green"><i class="fas fa-circle i-dot i-success "></i> <span>Enrolled</span></div>' : ''; ?></td>
                <!-- <td><button data-id="<?php //echo $sig_row['id']?>" class="btn btn-delete btn-sm btn-success rounded btnsm" data-bs-toggle="modal" data-bs-target="#deleteModal">Delete</button></td> -->
            </tr>
            
<?php   
        $count++;
        endforeach;
        echo "</tbody>";

    }else {
        //404
    }
?>