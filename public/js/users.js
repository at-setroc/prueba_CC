$(document).ready(function(){
    
    $(document).on("click", ".page-link:not(.active)", function () { 

        let page    = $(this).data("page");
        let perPage = $("#select-per-page").val();

        updateUsersList(page, perPage);
    });

    $("#select-per-page").change(function () { 
        
        let page    = 1;
        let perPage = $(this).val();
        
        updateUsersList(page, perPage);
    });

});

function updateUsersList(page, perPage) {
    let queryResult;

    $.ajax({
        type: "POST",
        url: $("#refresh_list_path").val(),
        async: false,
        data: {
            "page": page,
            "per_page": perPage
        },
        dataType: "json",
        success: function (response) {
            queryResult = response;
        }
    });
    
    if (queryResult) {
        updateData(queryResult);
        updatePagination(queryResult);
    }
}

function updateData(params) {
    
    $("#users-list").empty();

    $.each(params.data, function (index, value) { 
        $("#users-list").append('<div class="user-card"><img class="user-avatar noselect" src="'+value["avatar"]+'"><span class="fw-bold mt-3 text-break">'+value["first_name"]+' '+value["last_name"]+'</span><span class="user-card-email text-break">'+value["email"]+'</span></div>');
    });

}

function updatePagination(params) {

    $("#select-per-page").val(params.per_page);
    $(".pagination").empty();
    
    if (parseInt(params.page) > 1) {
        $(".pagination").append('<li class="page-item"><a class="page-link" data-page="'+(parseInt(params.page)-1).toString()+'" href="#">Anterior</a></li>');
    }

    $(".pagination").append('<li class="page-item active noselect"><a class="page-link active" data-page="'+params.page+'">'+params.page+'</a></li>');

    if (parseInt(params.page) < parseInt(params.total_pages)) {
        $(".pagination").append('<li class="page-item"><a class="page-link" data-page="'+(parseInt(params.page)+1).toString()+'" href="#">Siguiente</a></li>');
    }
}