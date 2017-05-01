
$(function(){

    /* Carousel back-ground definition
     =========================================================*/

    var nbreImgCarousel = $('.car-img').length;

    for(var i=0; i < nbreImgCarousel; i++){
        var action = $('.car-img:eq('+i+')');
        var ficherACharger = action.attr('data-src');
        var type = action.attr('data-type');
        if (type == 'picture'){
            action.css('background-image','url("'+ficherACharger+'")');
        } else if (type == 'video') {
            action.append(ficherACharger);
            $(action.firstChild).attr('class', 'carousel-caption');
        }


    }

    /* ===========================Carousel height definition==============================*/

    function redimHauteur(){
        var hauteur_fenetre = $(window).height();
        var hauteur_dispo = hauteur_fenetre-360;
        var hauteur_fleche = (hauteur_dispo/2)-25;
        $('.car-img').height(hauteur_dispo);
        $('.item > div > iframe').height(hauteur_dispo);
        $('.fleche-car').css('margin-top', hauteur_fleche+'px');
        $('.full-size').height(hauteur_fenetre);
    }

    // un appel de la fonction quand on redimentionne la fenètre
    $(window).resize(function(){
        redimHauteur();
    });

    // un appel à la fin du chargement de la page
    redimHauteur();


    /*=======================================================*/

    /* Carousel picture big size
    =========================================================*/
    $('.car-img').click(function (){
        var $picture = $(this).clone();
        var containerSec = $('#container-secondaire');
        containerSec.empty();
        containerSec.append($picture);
        $picture.attr('title', 'Cliquez pour fermer');
        $picture.attr('class', 'full-size');
        $picture.css({
                'max-width': '100%',
                'background-repeat': 'no-repeat',
                'background-size': '100%'
        });
        redimHauteur();
        containerSec.show(500);
        $('#container-principal').hide(500);
    });

    $('#container-secondaire').click(function (){
        $('#container-principal').show(500);
        $('#container-secondaire').hide(500);
    });

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

    $('#msg-prev-btn').click(function () {
        var currentFirstResult = $("#message_search_form_firstResult").val();
        var numberPerPage = $("#message_search_form_number").val();
        var firstResult = currentFirstResult - numberPerPage;
        $('#message_search_form_firstResult').val(firstResult);
        $('#message_search_form_ok').click();
    });

    $('#msg-next-btn').click(function () {
        var currentFirstResult = $("#message_search_form_firstResult").val();
        var numberPerPage = $("#message_search_form_number").val();
        var firstResult = currentFirstResult + numberPerPage;
        $('#message_search_form_firstResult').val(firstResult);
        $('#message_search_form_ok').click();
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

    /*=======================================================*/

    /* picture preview in account
    =========================================================*/
    $('#user_registration_form_picture_file').on('change', function (e) {

        var files = $(this)[0].files;
        var thumbnail = $('#image_preview');
        var fileInput = $('#user_registration_form_picture_file');

        if (files[0].type != "image/jpeg"){
            alert('Ce fichier n\'est pas du bon type, il ne sera donc pas ajouté. (Image jpg ou jpeg seulement)');
            fileInput.val('');
            return;
        }
        if (files[0].size > 1024000){
            alert('Ce fichier est trop volumineux, il ne sera donc pas ajouté. (Maximum 1 Mo)');
            fileInput.val('');
            return;
        }

        if (files.length > 0) {
            var file = files[0];

            thumbnail.attr('src', window.URL.createObjectURL(file));

            thumbnail.Jcrop({
                onSelect: function(c){showUserPreview(c);},
                onChange: function(c){showUserPreview(c);},
                setSelect: [ 100, 100, 50, 50],
                aspectRatio: 1
            });

        }
    });

    function showUserPreview(c) {

        var cropHolder = $('#user-picture > .jcrop-holder');
        var originalHeight = cropHolder.css('height');
        var originalWidth = cropHolder.css('width');
        index--;
        $('#user_registration_form_picture_cropData_cropSizeWidth').val(c.w);
        $('#user_registration_form_picture_cropData_cropSizeHeight').val(c.h);
        $('#user_registration_form_picture_cropData_cropPositionTop').val(c.y);
        $('#user_registration_form_picture_cropData_cropPositionLeft').val(c.x);
        $('#user_registration_form_picture_cropData_cropHolderWidth').val(originalWidth);
        $('#user_registration_form_picture_cropData_cropHolderHeight').val(originalHeight);
    }
    /*=======================================================*/

    /* picture preview + add form file field in trick creation
     =========================================================*/
    var $container = $('#trick_form_uploadPictures');
    if ($container.length > 0){
        var index = $container.find(':input').length;

        if (index == 0) {
            addCategory($container);
        } else {
            $container.children('div').each(function() {
                addDeleteLink($(this));
            });
        }
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
            img = new Image();
            img.src = window.URL.createObjectURL(files[0]);
            if (files[0].type != "image/jpeg"){
                alert('Ce fichier n\'est pas du bon type, il ne sera donc pas ajouté. (Image jpg ou jpeg seulement)');
                fileInput.val('');
                return;
            }
            if (files[0].size > 1024000){
                alert('Ce fichier est trop volumineux, il ne sera donc pas ajouté. (Maximum 1 Mo)');
                fileInput.val('');
                return;
            }

            if (files.length > 0) {

                $('#pictures-preview').append('<div class="col-md-4 text-center preview" id="pic-prev-'+index+'" ><div class="col-xs-12" id="picture-holder-'+index+'">' +
                    '<img class="picture-preview" id="picture-preview-'+index+'" src="" /><div class="col-xs-12 btn btn-warning delete-picture-btn" data-id="'+index+'">Supprimer</div></div>' +
                    '</div>');
                var thumbnail = $('#picture-preview-'+index);
                thumbnail.attr('src', img.src);
                thumbnail.Jcrop({
                    onSelect: function(c){showPreview(thumbnail, c);},
                    onChange: function(c){showPreview(thumbnail, c);},
                    setSelect: [ 100, 100, 50, 50],
                    aspectRatio: 16 / 9
                });

                $('.delete-picture-btn').click(function (e) {
                    var id = $(this).attr('data-id');
                    $('#pic-prev-'+id).remove();
                    id--;
                    $('#trick_form_uploadPictures_'+id).parent().remove();
                    e.preventDefault();
                });
                $container.children('div').each(function() {
                    $(this).attr('hidden', true);
                });

                addCategory($container);

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

    function showPreview(thumbnail, c) {

        var index = thumbnail.attr('id').replace('picture-preview-', '');
        var $holder = $('#picture-holder-'+index+' > .jcrop-holder');
        var originalHeight = $holder.height();
        var originalWidth = $holder.width();
        index--;
        $('#trick_form_uploadPictures_'+index+'_cropData_cropSizeWidth').val(c.w);
        $('#trick_form_uploadPictures_'+index+'_cropData_cropSizeHeight').val(c.h);
        $('#trick_form_uploadPictures_'+index+'_cropData_cropPositionTop').val(c.y);
        $('#trick_form_uploadPictures_'+index+'_cropData_cropPositionLeft').val(c.x);
        $('#trick_form_uploadPictures_'+index+'_cropData_cropHolderWidth').val(originalWidth);
        $('#trick_form_uploadPictures_'+index+'_cropData_cropHolderHeight').val(originalHeight);
    }

    /*=======================================================*/

    /* video delete in update page
     =========================================================*/
    delVideoTrigger();

    function delVideoTrigger(){
        $('.del-video').click(function (){
            var button = $(this);
            var delUrl = button.attr('data-url');
            var loader = '<div class="col-xs-12"><div class="loader" id="loader-7"></div></div>';
            button.replaceWith(loader);

            $.ajax({
                url : delUrl,
                dataType: 'html',
                success: function (html, status) {
                    if (status == 'success'){
                        var videoContent = $('#video-content');
                        videoContent.empty();
                        videoContent.append(html);
                    }
                    delVideoTrigger();
                }
            });
        });
    }
    /*=======================================================*/

    /* picture delete in update page
     =========================================================*/
    delPictureTrigger();

    function delPictureTrigger(){
        $('.del-picture').click(function (){
            var button = $(this);
            var delUrl = button.attr('data-url');
            var loader = '<div class="col-xs-12"><div class="loader" id="loader-7"></div></div>';
            button.replaceWith(loader);

            $.ajax({
                url : delUrl,
                dataType: 'html',
                success: function (html, status) {
                    if (status == 'success'){
                        var pictureContent = $('#picture-content');
                        pictureContent.empty();
                        pictureContent.append(html);
                    }
                    delPictureTrigger();
                }
            });
        });
    }
    /*=======================================================*/

    /* video preview + add form field in trick creation
     =========================================================*/
    var $videoContainer = $('#trick_form_videos');
    if ($videoContainer.length > 0){
        var videoIndex = $('#trick_form_videos > *').length;
        var firstLoop = true;

        if (videoIndex == 0){
            addVideoCategory($videoContainer);

        } else {
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
                    '<div class="btn btn-warning del-vid-btn" id="vid_del_btn_' + currentIndex + '">Supprimer</div></div>'
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

    /* form messages moderation
     =========================================================*/
    $('.msg-moderate').click(function (e){
        var id = $(this).attr('id');
        $('#message-form').hide(500);
        $('#moderate-form').show(500);
        $('#updateMessage_id').val(id);
        e.preventDefault();
    });
    /*=======================================================*/

});