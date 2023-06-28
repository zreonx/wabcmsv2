<?php 
    if(isset($_POST['signatory_id'])) {

        $signatory_id = $_POST['signatory_id'];
        $clearance_id = $_POST['clearance_id'];

        require_once '../config/connection.php';

        $result = $clearance->getClearanceSignatoryDesignationTable($clearance_id, $signatory_id);

?> 


    <div class="d-flex flex-wrap gap-2 justify-content-center align-items-center">
        <?php $count = 1; foreach($result as $sigDesTable): ?>
            <a href="clearance_signatory_designation.php?clearance_id=<?php echo $clearance_id; ?>&workplace=<?php echo $sigDesTable['workplace'] ?>&designation_workplace=<?php echo $sigDesTable['designation_table']; ?>" class="btn btn-outline-success rounded py-3 px-5 w-100 d-flex justify-content-between"><span class="badge bg-success mx-2"><?php echo $count; ?></span> <span><?php  echo strtoupper(str_replace("_", " ", substr($sigDesTable['designation_table'], 3, -2))); ?></span></a>
        <?php $count++; endforeach; ?>
    </div>    


<?php 
    
    //404
}
?>