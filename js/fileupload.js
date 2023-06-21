 $(document).ready(function(){

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