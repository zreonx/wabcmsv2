<?php 
    require_once '../includes/main_header.php'; 
    $allUser = $user->getAllUser();
    $studentUser = $user->getStudentAccount();
?>
<style>
    body {
        background-color: #f8f9fa;
    }
</style>
    <div class="page">
        <?php if(isset($_GET['update'])){ echo '<div class="alert alert-success" id="err">Oranization has been updated.</div>'; } ?>
        <?php if(isset($_GET['delete'])){ echo '<div class="alert alert-success" id="err">Oranization has been deleted.</div>'; } ?>
        <h1 class="page-title fs-5 display-6">Reports</h1>
        <div class="page-content p-2 rounded ">
           <div class="p-2">
            <div>
            <button class="btn btn-search btn-success btn-sm btn-rounded">Student</button>
            <button class="btn btn-search btn-success btn-sm btn-rounded">Signatory</button>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>Student ID</th>
                        <th>Email</th>
                        <th>Password</th>
                    </tr>
                </thead>
                    <tbody>
                        <?php while($stud = $studentUser->fetch(PDO::FETCH_ASSOC)): ?>
                            <tr>
                                <td><?php echo $stud['user_id']; ?> </td>
                                <td><?php echo $stud['email']; ?> </td>
                                <td><?php echo $stud['password']; ?> </td>
                            </tr>
                        <?php endwhile; ?>
                        
                    </tbody>
            </table>

           </div>
        </div>
    </div>
<?php require_once '../includes/main_footer.php' ?>