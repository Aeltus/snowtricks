
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

    var picture_0 = $("#picture-0").attr('src');
    var length = $('#list-pictures > *').length;

    var pictures = [];
    for (var i = 0; i <= length; i++){
        var url = $('#pic-'+i).attr('src');
        pictures.push(url);
    }
    if (picture_0 == ""){
        $('#picture-0').attr({
            src: pictures[0],
            data_number: '0'
        });
        $('#picture-1').attr({
            src: pictures[1],
            data_number: '1'
        });
        $('#picture-2').attr({
            src: pictures[2],
            data_number: '2'
        });
        $('#picture-3').attr({
            src: pictures[3],
            data_number: '3'
        });
    }

    $('.labelled-picture').click(function(){
        var src = this.getAttribute('src');
        $('#picture-0').attr('src', src);
    });

    $('#arrow-down').click(function(){
        var number = $('#picture-1').attr('data_number');
        for (var i = 1; i < 4; i++){
            number++;

            if (number >= length){
                number = 0;
            }
            $('#picture-'+i).attr({
                src: pictures[number],
                data_number: number
            });
        }
    });

    $('#arrow-up').click(function(){
        var number = $('#picture-3').attr('data_number');
        for (var i = 3; i > 0; i--){
            number--;
            if (number < 0){
                number = length -1;
            }
            $('#picture-'+i).attr({
                src: pictures[number],
                data_number: number
            });
        }
    });

    $('#pictures-button').click(function(){
        $('#video-container').hide();
        $('#picture-container').show();
        $('#video-button').css('background-color', '#b1b9c1');
        $('#pictures-button').css('background-color', '#C1CAD3');
    });

    $('#video-button').click(function(){
        $('#picture-container').hide();
        $('#video-container').show();
        $('#pictures-button').css('background-color', '#b1b9c1');
        $('#video-button').css('background-color', '#C1CAD3');
    });

});