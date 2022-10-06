$(document).ready(function () {
    $(".category-with-form").on("click", function () {
        window.location.href = "./categories/"+$(this).data("num")+"/features"
    });    
});