$(document).ready(function () {

    $(".feature-parent").change(function() {

        var form  = $(this).closest("form");
        var fieldName = $(this).attr("name");

        var data = {};
        data[fieldName] = $(this).val();

        $.ajax({
            url : form.attr('action'),
            type: form.attr('method'),
            data : data,
            success: function(html) {

                let auxFieldName = fieldName.substring(form.attr("name").length+1, fieldName.length-1);
                let elementId;

                $(".child_"+auxFieldName).each(function (index, element) {
                    
                    elementId = "#" + element.getAttribute("id");

                    element.replaceWith(
                        $(html).find(elementId)[0]
                    );

                });

            }
        });

    });

});