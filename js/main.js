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
    
})