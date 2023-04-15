$(document).ready(function() {
    
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
        console.log(sidebar);
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
    
    
})