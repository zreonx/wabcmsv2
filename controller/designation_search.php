<?php 
    if(isset($_POST['search_data'])) {

        $search_data = $_POST['search_data'];

        require_once '../config/connection.php';

        $result = $designation->searchSignatory($search_data);
        $resultCheck = $designation->searchSignatory($search_data);
        $check = $resultCheck->fetch(PDO::FETCH_ASSOC);
        if($search_data == "" || empty($check)) {
            echo '<h1 class="display-6 fs-6 text-center text-success">Signatory does not exist.</h1>';
        }else{
       
?> 

    <ul class="list-group ">
        <?php while($sig_row = $result->fetch(PDO::FETCH_ASSOC)): ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <button data-id="<?php echo $sig_row['id']?>" class="btn assign-btn btn-sm btn-success rounded btnsm">Assign</button>
                <span><?php echo $sig_row['last_name'] . " " . $sig_row['first_name'] . " " . strtoupper(substr($sig_row['middle_name'], 0, 1)) ."." ?></span>
                <span><?php //echo ($sig_row['workplace'] != "") ? '<span class="badge bg-success">Occupied</span>' : '<span class="badge bg-secondary">Unassigned</span>' ; ?></span>
            </li>
        <?php endwhile; ?>
    </ul>
     
<?php 
        }   
    } else {
    //404
}
?>