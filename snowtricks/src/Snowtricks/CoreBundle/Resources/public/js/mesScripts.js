$(function(){
   $(".next-btn").click(function(){
      var currentFirstResult = $("#trick_search_form_firstResult").val();
      var numberPerPage = $("#trick_search_form_number").val();
      var firstResult = currentFirstResult + numberPerPage;
      $("#trick_search_form_firstResult").attr("value", firstResult);
      $("#sort").click();
   });

    $(".prev-btn").click(function(){
        var currentFirstResult = $("#trick_search_form_firstResult").val();
        var numberPerPage = $("#trick_search_form_number").val();
        var firstResult = currentFirstResult - numberPerPage;
        $("#trick_search_form_firstResult").attr("value", firstResult);
        $("#sort").click();
    });

    $(".search-btn").click(function () {
        $("#sort").click();
    });
});