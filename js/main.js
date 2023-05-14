$(document).ready(function() {
    //Tooltip
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
    })
    
    //Custom Sidebar Category Links
    const customCategories = document.querySelectorAll('.custom-category');

    customCategories.forEach(customCategory => {
        const categorytBtn = customCategory.querySelector('.category-btn');
        
        categorytBtn.addEventListener('click', () => {
            customCategory.classList.toggle('active');
        });
    });

    //Sidebar
    const menuButton = document.querySelector('.btn-menu');
    const sidebar = document.getElementById('sidebar');
    menuButton.addEventListener('click', () => {
        sidebar.classList.toggle('sidebar-open');
    });

    //Profile Menu
    const profileBtn = document.getElementById('profile-btn');
    const profileMenu = document.querySelector('.profile-menu');

    profileBtn.addEventListener('click', () => {
        profileBtn.classList.toggle('active');
    });

    // Add click event listener to document
    document.addEventListener('click', event => {
        // Check if clicked element is inside the menu
        if (!profileMenu.contains(event.target) && !profileBtn.contains(event.target)) {
            profileBtn.classList.remove('active');
        }
    });


    //responsive sidebar
    const mediaQuery = window.matchMedia('(max-width: 768px)');

    function handleResize() {
        if (mediaQuery.matches) {
            sidebar.classList.remove('sidebar-open');
        } else {
            sidebar.classList.add('sidebar-open');
        }
    }

    // Call handleResize on page load
    handleResize();

    // Listen for the window resize event
    window.addEventListener('resize', handleResize);


    //Custom Select Script 
    var customSelectList = document.querySelectorAll(".custom-select");

    customSelectList.forEach(function(customSelect, e) {
        
        const selectBtn = customSelect.querySelector(".select-btn");
        const selectBtnText = customSelect.querySelector(".sbtn-text");
        const selectOptions = customSelect.querySelectorAll(".select-menu li");
        const hiddenInput = customSelect.querySelector('.select-name');

        selectBtn.addEventListener("click", function () {
            customSelect.classList.toggle("active");
        });

        selectOptions.forEach(function(option) {
            option.addEventListener("click", function() {
                const selectValue = option.dataset.value;
                const selectedText = option.textContent;

                hiddenInput.value = selectValue;
                selectBtnText.textContent = selectedText;
                customSelect.classList.remove("active");    
            });
        });

        document.addEventListener("click", function(event) {
            if (!customSelect.contains(event.target)) {
                customSelect.classList.remove("active");
            }
        });
    });

    //File upload

    $('.file-upload input[type="file"]').change(function () {
        var val = $(this).val().toLowerCase(),
            regex = new RegExp("(.*?)\.(csv)$");
    
        if (!(regex.test(val))) {
          $(this).val('');
          alert('Please select a CSV file.');
        } 
        else {
          $('.file-upload span').text($(this).val().split('\\').pop());
        }
    });

    
    
})