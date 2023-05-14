$(document).ready(function(){
    $('#filter-all').on('click', function(){
        filterBy("students", "academic_level", "", "imported")
    });

    $('#filter-college').on('click', function(){
        let filter_value = $('#filter-college').text();
        filterBy("students", "academic_level", filter_value, "imported")
    });
    
    $('#filter-shs').on('click', function(){
        let filter_value = $('#filter-shs').text();
        filterBy("students", "academic_level", filter_value, "imported")
    });

    var initialize = reenitializeTable();
    function filterBy(table_name, column_name, filter_value, status_label){

        $.ajax({
            type: "POST",
            url: "../controller/filter_student.php",
            data: {
                table_name : table_name,
                column_name : column_name,
                filter_value : filter_value,
                status_label : status_label,
            },

            beforeSend:function(){
                
            },

            success: function(result) {

                $('#my-datable').DataTable().destroy();
                $('#my-datable').html(result);
                $('#my-datable').DataTable().destroy();

                $('#my-datable').html(result);
                let filtered_table = $('#my-datable').DataTable({
                    language: {
                        search: "_INPUT_",
                        searchPlaceholder: "Search Student"
                    },
                
                    buttons: [
                        'excel', 'pdf', 'print'
                    ],
                    
                    "pageLength": 9,
                    "lengthChange": false,
                    responsive: true,
                    "targets": 'no-sort',
                    "bSort": true,
                    "order": [],
                
                });

                $('.export-btn').append(filtered_table.buttons().container());

                $('#search-val').on('keyup', function() {
                    var searchTerm = $('#search-val').val();
                    filtered_table.search(searchTerm).draw();
                });
            }
        })
    }
})

