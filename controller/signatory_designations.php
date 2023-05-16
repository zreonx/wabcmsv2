<?php 
    if(isset($_POST['signatory_id'])) {

        $signatory_id = $_POST['signatory_id'];
        $clearance_id = $_POST['clearance_id'];

        require_once '../config/connection.php';

        $result = $clearance->getSignatoryDesignationTable($signatory_id);

?> 


    <div class="d-flex flex-wrap gap-2 justify-content-center align-items-center">
        <?php $count = 1; foreach($result as $sigDesTable): ?>
            <a href="clearance_signatory_designation.php?clearance_id=<?php echo $clearance_id; ?>&workplace=<?php echo $sigDesTable['signatory_workplace_name'] ?>&designation_workplace=<?php echo $sigDesTable['signatory_clearance_table_name']; ?>" class="btn btn-outline-success rounded py-3 px-5 w-75"><span class="badge bg-success mx-2"><?php echo $count; ?></span> <?php  echo strtoupper(str_replace("_", " ", substr($sigDesTable['signatory_clearance_table_name'], 3, -1))); ?></a>
        <?php endforeach; ?>
    </div>    


<?php 
    
    //404
}
?>