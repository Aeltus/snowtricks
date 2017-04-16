
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

    $("#user-deletion-btn").click(function(){
        if(window.confirm('Voulez-vous vraiment supprimer votre compte ? (Cette opération est irréverssible, personne n\'aura plus jamais accès à votre compte.)')){
            var target = $("#user-deletion-btn").attr("data-target");
            document.location.href=target;

        }
    });

    $(".update-group-btn").click(function(){
        var groupToUpdate = this.getAttribute('id');
        $("#"+groupToUpdate).hide();
        $('#form-'+groupToUpdate).show();
    });
});