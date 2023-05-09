$(document).ready(function(){
    var table = $('#my-datable').DataTable({
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search Student"
        },
    
        buttons: [
            'excel', 'pdf', 'print'
        ],
        
        "pageLength": 10,
        "lengthChange": false,
        responsive: true,
        "targets": 'no-sort',
        "bSort": true,
        "order": [],
    
    });
    
    // Append export buttons container to .export-btn container
    $('.export-btn').append(table.buttons().container());
    
    $('#searchBtn').click(function() {
        var searchTerm = $('#search-val').val();
        table.search(searchTerm).draw();
    });

    $('#search-val').on('keyup', function() {
        var searchTerm = $('#search-val').val();
        table.search(searchTerm).draw();
    });
})

