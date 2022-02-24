<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>

    <title>PHP 8 Upload Torrent</title>
    <style>
        .container {
            max-width: 450px;
        }
        .imgGallery img {
            padding: 8px;
            max-width: 100px;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <form action="upload.php" method="post" enctype="multipart/form-data" class="mb-3">
        <h3 class="text-center mb-5">Upload torrent</h3>
        <div class="user-image mb-3 text-center">
            <div class="imgGallery">
                <!-- Image preview -->
            </div>
        </div>

        <div class="custom-file mt-2">
            <input type="file" name="torrent_file[]" class="custom-file-input" id="chooseFile" multiple>
            <label class="custom-file-label" for="chooseFile">
                <span class="d-inline-block text-truncate w-75">Sélectionner fichiers</span>
            </label>
        </div>

<!--        --><?php
//            $currentDirectory = getcwd();
//            $uploadDirectory = "/uploads";
//            $uploadPath = $currentDirectory . $uploadDirectory;
//
//            $directories = glob($uploadPath . '/*' , GLOB_ONLYDIR);
//
//            echo "<select name='repertoire' id='repertoire' class='custom-select'>";
//            echo "<option value=''> Root </option>";
//            foreach ($directories as $directory){
//                $directory = strstr($directory, 'dir');
//                echo "<option value='".$directory."'>".$directory."</option>" ;
//            }
//
//            echo "</select><br>";
//        ?>
        <button type="submit" name="submit" class="btn btn-primary btn-block mt-4">
            Upload Torrents
        </button>
    </form>
    <!-- Display response messages -->
    <?php if(!empty($response)) {?>
        <div class="alert <?php echo $response["status"]; ?>">
            <?php echo $response["message"]; ?>
        </div>
    <?php }?>
</div>
<!-- jQuery -->
<!--<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>-->
<!--<script>-->
<!--    $(function() {-->
<!--        // Multiple images preview with JavaScript-->
<!--        var multiImgPreview = function(input, imgPreviewPlaceholder) {-->
<!--            if (input.files) {-->
<!--                var filesAmount = input.files.length;-->
<!--                for (i = 0; i < filesAmount; i++) {-->
<!--                    var reader = new FileReader();-->
<!--                    reader.onload = function(event) {-->
<!--                        $($.parseHTML('<img>')).attr('src', event.target.result).appendTo(imgPreviewPlaceholder);-->
<!--                    }-->
<!--                    reader.readAsDataURL(input.files[i]);-->
<!--                }-->
<!--            }-->
<!--        };-->
<!--        $('#chooseFile').on('change', function() {-->
<!--            multiImgPreview(this, 'div.imgGallery');-->
<!--        });-->
<!--    });-->
<!--</script>-->
<script>
    $(document).ready(function () {
        bsCustomFileInput.init()
    })
</script>
</body>
</html>
