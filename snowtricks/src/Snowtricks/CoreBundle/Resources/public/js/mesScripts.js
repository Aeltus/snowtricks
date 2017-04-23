
$(function(){

    /* set height attribute for the iframe agree with current width
     =========================================================*/
    var iframeWidth = $('iframe').attr('width');
    iframeResizer(iframeWidth);

    $(window).resize(function(){
        iframeWidth = $('iframe').attr('width');
        iframeResizer(iframeWidth);
    });

    function iframeResizer(iframeWidth){
        var iframeHeigth = iframeWidth * 0.5625;
        $('iframe').attr('height', iframeHeigth);
    }
    /*=======================================================*/

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
        $("#"+groupToUpdate).hide(500);
        $('#form-'+groupToUpdate).show(500);
    });

    $('.close-update-form').click(function(){
        $('.forms-update-group').hide(500);
        $('.update-group-btn').show(500);
    });

    /* pictures in trick page
     =========================================================*/
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
    /*=======================================================*/

    /* picture preview in account
    =========================================================*/
    $('#my_form').find('input[name="user_registration_form[file]"]').on('change', function (e) {

        var files = $(this)[0].files;

        if (files.length > 0) {
            var file = files[0];
            $('#image_preview').attr('src', window.URL.createObjectURL(file));
        }
    });
    /*=======================================================*/

    /* picture preview + add form file field in trick creation
     =========================================================*/

    var $container = $('#trick_form_uploadPictures');
    var index = $container.find(':input').length;

    if (index == 0) {
        addCategory($container);
    } else {
        $container.children('div').each(function() {
            addDeleteLink($(this));
        });
    }

    function addCategory($container) {

        var template = $container.attr('data-prototype')
                .replace(/__name__label__/g, '')
                .replace(/__name__/g,        index)
            ;

        var $prototype = $(template);
        addDeleteLink($prototype);
        $container.append($prototype);
        fileInput = $('#trick_form_uploadPictures_'+index+'_file');
        //updating preview picture
        fileInput.on('change', function (e) {

            var files = $(this)[0].files;
            if (files[0].size > 1024000){
                alert('Ce fichier est trop volumineux, il ne sera donc pas ajouté. (Maximum 1 Mo)');
                fileInput.val('');
                return;
            }

            if (files.length > 0) {
                var pictureUrl = window.URL.createObjectURL(files[0]);
                $('#pictures-preview').append('<div class="col-md-2 text-center preview" id="pic-prev-'+index+'" ><img class="trash" id="trash-'+index+'" src="https://openclipart.org/image/600px/svg_to_png/228856/1443908522.png" /><img class="picture-preview" id="picture-preview-'+index+'" src="" /></div>');
                $('#picture-preview-'+index).attr('src', pictureUrl);
                $container.children('div').each(function() {
                    $(this).attr('hidden', true);
                });
                $('#trash-'+index).hide();
                addCategory($container);

                var preview = $('.preview');
                preview.click(function () {
                    var id = $(this).attr('id').replace('pic-prev-', '');
                    id--;
                    $('#del-link-'+id).get(0).click();
                });
                preview.hover(function(){
                    var id = $(this).attr('id').replace('pic-prev-', '');
                    $('#trash-'+id).show(500);
                    $('#picture-preview-'+id).hide(500);

                }, function (){
                    var id = $(this).attr('id').replace('pic-prev-', '');
                    $('#picture-preview-'+id).show(500);
                    $('#trash-'+id).hide(500);
                });
            }
        });

        index++;
    }

    function addDeleteLink($prototype) {

        var $deleteLink = $('<a href="#" id="del-link-'+index+'"></a>');
        $prototype.append($deleteLink);
        $deleteLink.click(function(e) {

            var id = $(this).attr('id');
            id = id.replace('del-link-', '');
            id++;
            $('#pic-prev-'+id).remove();

            $prototype.remove();

            e.preventDefault();
            return false;
        });
    }
    /*=======================================================*/

    /* video preview + add form field in trick creation
     =========================================================*/
    var $videoContainer = $('#trick_form_videos');
    var videoIndex = $('#trick_form_videos > *').length;
    var firstLoop = true;

    if (videoIndex == 0){
        addVideoCategory($videoContainer);

    } else {
        var currentIndex = 0;
        $videoContainer.children('div').each(function() {

            var currentContainer = $(this);
            var textarea = currentContainer.children('div').children('div').children('textarea');
            var textAreaContent = textarea.val();
            if (textAreaContent != ""){
                currentContainer.hide();
                if (firstLoop === true){
                    firstLoop = false;
                    addVideoCategory($videoContainer);
                }
            }
        })
    }


    function addVideoCategory($videoContainer) {

        var videoTemplate = $videoContainer.attr('data-prototype')
                .replace(/__name__label__/g, '')
                .replace(/__name__/g,        videoIndex)
            ;

        var $videoPrototype = $(videoTemplate);
        $videoContainer.append($videoPrototype);

        //updating preview video
        $('#add_video').mousedown(function (e) {

            var currentIndex = videoIndex - 1;
            $('#trick_form_videos_'+currentIndex).parent().hide();
            var textAreaContent = $('#trick_form_videos_'+currentIndex+'_address').val();

            if (textAreaContent != "") {
                $('#videos-preview').append(
                    '<div class="col-sm-6 add-video top10" id="vid_prev_' + currentIndex + '">' +
                    '<p>' + textAreaContent + '</p>' +
                    '<div class="btn btn-danger del-vid-btn" id="vid_del_btn_' + currentIndex + '">Supprimer</div></div>'
                );
                $('#vid_del_btn_' + currentIndex).click(function(){
                    var id = $(this).attr('id');
                    id = id.replace('vid_del_btn_', '');
                    $('#vid_prev_'+id).remove();
                    $('#trick_form_videos_'+currentIndex).parent().remove();
                });

            }

            addVideoCategory($videoContainer);
            return false;


        });

        videoIndex++;
    }


    /*=======================================================*/

    /* how to use video preview + add form field in trick creation
     =========================================================*/
    $('#about-add-video').hover(function(){
        $('#add-video-help').show(500);
    }, function(){
        $('#add-video-help').hide(500);
    });
    /*=======================================================*/

    /* picture and video deletion advertissement
     =========================================================*/
    $(".deletion-btn").click(function(){
        if(window.confirm('Cette zone est dangereuse, la suppression est irreversible. Etes vous sûr de vouloir continuer ?')){
            target = $(this).attr("data-target");
            document.location.href=target;
        }
    });
    /*=======================================================*/

});