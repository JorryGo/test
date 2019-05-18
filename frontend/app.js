$( document ).ready(function() {

    $('#submitForm').on('submit', function (e) {
        let form = $(this);
        $.ajax({
            type: "POST",
            url: form.attr('action'),
            data: form.serialize(), // serializes the form's elements.
            success: function(data)
            {
                form.find("input, textarea").val("");

                if (data.error) {
                    $('#info').addClass('error show').html(data.error);
                } else {
                    $('#info').addClass('success show').html('Your post successfully sended');
                }

                setTimeout(() => {
                    $('#info').removeClass('error success show');
                }, 4000);

                getReviews();
            }(form)
        });


        return false;
    });

    function getReviews() {
        $.get('/posts', function(data) {
            $('#reviews').html(data);
        });
    }

    getReviews();
});