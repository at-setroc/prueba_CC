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
        $(".pagination").append('<li class="page-item"><div class="page-link" data-page="'+(parseInt(params.page)-1).toString()+'"><i class="bi bi-chevron-double-left"></i></div></li>');
    } else {
        $(".pagination").append('<li class="page-item invisible"><div class="page-link"><i class="bi bi-chevron-double-left"></i></div></li>');
    }

    $(".pagination").append('<li class="page-item active noselect"><div class="page-link active" data-page="'+params.page+'">'+params.page+'</div></li>');

    if (parseInt(params.page) < parseInt(params.total_pages)) {
        $(".pagination").append('<li class="page-item"><div class="page-link" data-page="'+(parseInt(params.page)+1).toString()+'"><i class="bi bi-chevron-double-right"></i></div></li>');
    } else {
        $(".pagination").append('<li class="page-item invisible"><div class="page-link"><i class="bi bi-chevron-double-right"></i></div></li>');
    }
}