<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php"); ?>


<!doctype html>
<html lang="en">
<head>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.4.1.min.js"  ></script>

    <title>Update Content</title>
    </head>
    <body>

    <?php global $USER;  ?>
    <?php if ($USER->IsAdmin() ) { ?>

    <?php
//    $arGroupAvalaible = array(1,7); // массив групп, которые в которых нужно проверить доступность пользователя
//    $arGroups = CUser::GetUserGroup($USER->GetID()); // массив групп, в которых состоит пользователь
//    $result_intersect = array_intersect($arGroupAvalaible, $arGroups);// далее проверяем, если пользователь вошёл хотя бы в одну из групп, то позволяем ему что-либо делать
//
//
//    if(!empty($result_intersect)){

    ?>

    <div class = "container-md">
        <div class="row"> <h2>Обновление картинок</h2> </div>

        <div class = "row">
            <div class="col-md-4  " id = "contentXMLPics" >
                Сгенерировать XML для картинок
            </div>
            <div class="col-md-4 ">
                <button type="button" id = "btnGenerateXMLPics" class="btn btn-primary"> Сгенерировать </button>
            </div>
        </div>
        <br>
        <div class = "row">
            <div class="col-md-4 " id = "content_pics">
                Обновить превью и картинки     </div>
            <div class="col-md-4 ">
                <button type="button" id = "updatePics" class="btn btn-primary "> Обновить </button>
            </div>
        </div>

        <hr>
    </div>

    <div class = "container-md">
            <div class="row"> <h2>Обновление html файлов</h2> </div>

            <div class = "row">
                <div class="col-md-4  " id = "contentXMLFiles" >
                    Сгенерировать XML для файлов
                </div>
                <div class="col-md-4 ">
                    <button type="button" id = "btnGenerateXMLFiles" class="btn btn-primary"> Сгенерировать </button>
                </div>
            </div>
            <br>
            <div class = "row">
                <div class="col-md-4 " id = "content_files">
                    Обновить файлы </div>
                <div class="col-md-4 ">
                    <button type="button" id = "updateFiles" class="btn btn-primary "> Обновить </button>
                </div>
            </div>

            <hr>

            <div class = "row">
                <div class="col-md-4 " id = "content_manufact">
                    Обновить производителей </div>
                <div class="col-md-4 ">
                    <button type="button" id = "updateManufact" class="btn btn-primary "> Обновить </button>
                </div>
            </div>
            <br>
            <div class = "row">
                <div class="col-md-4 " id = "empty_manufact">
                    Производители без товаров
                </div>
                <div class="col-md-4 ">
                    <button type="button" id = "emptyManufact" class="btn btn-primary "> Обновить </button>
                </div>
            </div>


        </div>

    <div class = "container-md">
        <hr>
            <div class="row"> <h2>Обновление VK описаний </h2> </div>

            <div class = "row">
                <div class="col-md-4  " id = "generateVKFiles" >
                    Сгенерировать XML
                </div>
                <div class="col-md-4 ">
                    <button type="button" id="btnGenerateVKFiles" class="btn btn-primary"> Сгенерировать </button>
                </div>
            </div>
            <br>
            <div class = "row">
                <div class="col-md-4 " id = "content_vk_files">
                    Обновить описание </div>
                <div class="col-md-4 ">
                    <button type="button" id = "btnUpdateVKFiles" class="btn btn-primary "> Обновить </button>
                </div>
            </div>



        </div>

    <div class = "container-md">
            <hr>
            <div class="row"> <h2>Дополнительный материал от производителей </h2> </div>

            <div class = "row">
                <div class="col-md-4  " id = "generateXmlMaterialImg" >
                    Сгенерировать XML для картинок
                </div>
                <div class="col-md-4 ">
                    <button type="button" id="btnGenerateXmlMaterialImg" class="btn btn-primary"> Сгенерировать </button>
                </div>
            </div>
            <br>
            <div class = "row">
                <div class="col-md-4 " id = "uploadAddMaterialImg">
                    Обновить картинки </div>
                <div class="col-md-4 ">
                    <button type="button" id = "btnUploadAddMaterialImg" class="btn btn-primary "> Обновить </button>
                </div>
            </div>



        </div>

 <?php   } else { echo 'ДОСТУП ЗАПРЕЩЕН'; } ?>


    <script>
    $(function(){
        let $btnGenerateVKFiles = $('#btnGenerateVKFiles');

        $btnGenerateVKFiles.on('click', function(e){
            e.preventDefault();

            var $generateVKFiles = $('#generateVKFiles');

             $.ajax({
                 type: "GET",
                 url: 'https://zoosat.ru/local/dev/update_vk/generateVk.php?test=123',
                 beforeSend: function() {
                     $btnGenerateVKFiles.prop('disabled', true);
                 },
                 success: function(data) {
                     $generateVKFiles.html( data );
                     $btnGenerateVKFiles.text('Сгенерировать еще раз');
                     $btnGenerateVKFiles.prop('disabled', false);
                 },

             });

        });


        let $btnUpdateVKFiles = $('#btnUpdateVKFiles');

        $btnUpdateVKFiles.on('click', function(e){
            e.preventDefault();

            console.log('ttt');

            var $content_vk_files = $('#content_vk_files');

            $.ajax({
                 type: "GET",
                 url: 'https://zoosat.ru/local/dev/update_vk/updateVk.php?test=123',
                 beforeSend: function() {
                     $btnUpdateVKFiles.prop('disabled', true);
                 },
                 success: function(data) {
                     $content_vk_files.html( data );

                     $btnUpdateVKFiles.prop('disabled', false);
                 },

             });
        });




        // ОБНОВЛЕНИЕ КАРТИНОК
        var $btnGenerateXMLPics = $('#btnGenerateXMLPics');

        $btnGenerateXMLPics.on('click', function(e){
             e.preventDefault();
             var $content = $('#contentXMLPics');

             $.ajax({
                 type: "GET",
                 url: 'https://zoosat.ru/local/dev/update_pics/generateXmlPics.php?test=123',
                 beforeSend: function() {
                     console.log(  );
                     $btnGenerateXMLPics.prop('disabled', true);
                 },
                 success: function(data) {
                     $content.html( data );
                     $btnGenerateXMLPics.text('Сгенерировать еще раз');
                     $btnGenerateXMLPics.prop('disabled', false);
                 },

             });
        });

        var $updatePics = $('#updatePics');

        $updatePics.on('click', function(e){

            e.preventDefault();
            var $content = $('#content_pics');

            $.ajax({
                type: "GET",
                url: 'https://zoosat.ru/local/dev/update_pics/updatePics.php?test=123',
                beforeSend: function() {
                    $updatePics.prop('disabled', true);
                },
                success: function(data) {
                    $content.html( data );
                    $updatePics.text('Обновить еще раз');
                    $updatePics.prop('disabled', false);
                },

            });

        });



        // ОБНОВЛЕНИЕ ФАЙЛОВ
        var $btnGenerateXMLFiles = $('#btnGenerateXMLFiles');
        $btnGenerateXMLFiles.on('click', function(e){
            e.preventDefault();
            var $contentFiles = $('#contentXMLFiles');

            $.ajax({
                type: "GET",
                url: 'https://zoosat.ru/local/dev/update_files/generateXmlFiles.php?test=123',
                beforeSend: function() {
                    console.log(  );
                    $btnGenerateXMLFiles.prop('disabled', true);
                },
                success: function(data) {
                    $contentFiles.html( data );
                    $btnGenerateXMLFiles.text('Сгенерировать еще раз');
                    $btnGenerateXMLFiles.prop('disabled', false);
                },

            });
        });

        var $updateFiles = $('#updateFiles');

        $updateFiles.on('click', function(e){
            e.preventDefault();
            var $content_files = $('#content_files');

            $.ajax({
                type: "GET",
                url: 'https://zoosat.ru/local/dev/update_files/updateFiles.php?test=123',
                beforeSend: function() {
                    $updateFiles.prop('disabled', true);
                },
                success: function(data) {
                    $content_files.html( data );
                    $updateFiles.text('Обновить еще раз');
                    $updateFiles.prop('disabled', false);
                },

            });
        });


       // Обновление производителей
       var $updateManufact = $('#updateManufact');


        $updateManufact.on('click', function(e){
            e.preventDefault();
            var $content_manufact = $('#content_manufact');

            $.ajax({
                type: "GET",
                url: 'https://zoosat.ru/local/dev/update_manufact/updateManufact.php?test=123',
                beforeSend: function() {
                    $updateManufact.prop('disabled', true);
                },
                success: function(data) {
                    $content_manufact.html( data );
                    $updateManufact.text('Обновить еще раз');
                    $updateManufact.prop('disabled', false);
                },

            });
        });



       // "Пустые" производители
       var $emptyManufact = $('#emptyManufact');

       //console.log($updateManufact);

        $emptyManufact.on('click', function(e){
            e.preventDefault();
            var $empty_manufact = $('#empty_manufact');

            $.ajax({
                type: "GET",
                url: 'https://zoosat.ru/local/dev/update_manufact/emptyManufact.php?test=123',
                beforeSend: function() {
                    $emptyManufact.prop('disabled', true);
                },
                success: function(data) {
                    $empty_manufact.html( data );
                    $emptyManufact.text('Обновить еще раз');
                    $emptyManufact.prop('disabled', false);
                },

            });
        });







        // ОБНОВЛЕНИЕ Дополнительных материалов
        var $btnGenerateXmlMaterialImg = $('#btnGenerateXmlMaterialImg');

        $btnGenerateXmlMaterialImg.on('click', function(e){
             e.preventDefault();
             var $generateXmlMaterialImg = $('#generateXmlMaterialImg');

             $.ajax({
                 type: "GET",
                 url: 'https://zoosat.ru/local/dev/update_add_material/generateXmlImgs.php?test=123',
                 beforeSend: function() {
                     $btnGenerateXmlMaterialImg.prop('disabled', true);
                 },
                 success: function(data) {
                     $generateXmlMaterialImg.html( data );
                     $btnGenerateXmlMaterialImg.text('Сгенерировать еще раз');
                     $btnGenerateXmlMaterialImg.prop('disabled', false);
                 },

             });
        });

        var $btnUploadAddMaterialImg = $('#btnUploadAddMaterialImg');

        $btnUploadAddMaterialImg.on('click', function(e){

            e.preventDefault();
            var $uploadAddMaterialImg = $('#uploadAddMaterialImg');

            $.ajax({
                type: "GET",
                url: 'https://zoosat.ru/local/dev/update_add_material/updateImgs.php?test=123',
                beforeSend: function() {
                    $btnUploadAddMaterialImg.prop('disabled', true);
                },
                success: function(data) {
                    $uploadAddMaterialImg.html( data );
                    $btnUploadAddMaterialImg.text('Обновить еще раз');
                    $btnUploadAddMaterialImg.prop('disabled', false);
                },

            });

        });



    });



    </script>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    </body>
    </html>



