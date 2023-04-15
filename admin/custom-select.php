<?php 
    require_once '../includes/main_header.php'; 
?>
<div class="p-5">
    <div class="custom-select">
        <input type="hidden" class="select-name" name="nameOfSelect">
        <button class="select-btn"> 
            <span class="sbtn-text">Select</span>
            <i class="bx bx-chevron-down"></i>
        </button>
        <ul class="select-menu">
            <li data-value="0">Select</li>
            <li data-value="1">Option 2</li>
            <li data-value="2">Option 3</li>
        </ul>
    </div>
</div>

<?php 
    require_once '../includes/main_footer.php'; 
?>