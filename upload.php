<?php
if(isset($_POST['submit'])){
    $currentDirectory = getcwd();
    //$whereUpload = $_POST['repertoire'];
    $errors = [];
    $_REQUEST = [];

    if (!empty($whereUpload)){
        $uploadDirectory = "/uploads/"/*. $whereUpload ."/"*/;
    } else {
        $uploadDirectory = "/uploads/";
    }

    $fileExtensionsAllowed = array('torrent');

    // Velidate if files exist
    if (!empty(array_filter($_FILES['torrent_file']['name']))) {

        // Loop through file items
        foreach($_FILES['torrent_file']['name'] as $id=>$val){

            $fileName = $_FILES['torrent_file']['name'][$id];
            $fileError = $_FILES['torrent_file']['error'][$id];
            $fileSize = $_FILES['torrent_file']['size'][$id];
            $fileTmpName  = $_FILES['torrent_file']['tmp_name'][$id];
            $fileType = $_FILES['torrent_file']['type'][$id];
            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $uploadPath = $currentDirectory . $uploadDirectory . basename($fileName);
            $isDir = $currentDirectory . $uploadDirectory;

            if (!is_dir($isDir)) {
                mkdir($isDir, 0777, true);
            }

            // Check file extension
            if (!in_array($fileExtension,$fileExtensionsAllowed)) {
                $errors[] = "Extension non autorisée " . $fileName;
                $fileError = $fileError + 1;
            }

            // Check file true mime type
            $fi = new finfo(FILEINFO_MIME_TYPE);
            $mime = $fi->file($fileTmpName);

            if ($mime !== 'application/x-bittorrent'){
                $errors[] = "Type MIME incorrect " . $fileName;
                $fileError = $fileError + 1;
            }

            // Check file size (bit)
            if ($fileSize > 4000000) {
                $errors[] = "Fichier trop lourd (4 MO) " . $fileName;
                $fileError = $fileError + 1;
            }

            // Check if file exist
            if (file_exists($uploadPath)) {
                $errors[] = "Le fichier existe déjà " . $fileName;
                $fileError = $fileError + 1;
            }

            // If no error, upload
            if ($fileError < 1 ) {
                $didUpload = move_uploaded_file($fileTmpName, $uploadPath);

                if ($didUpload) {
                    echo "Le fichier <b>" . basename($fileName) . "</b> a été upload <br>";
                    $_FILES['torrent_file']['tmp_name'] = $uploadPath;
                    $_REQUEST['result'] = "";
                    $_REQUEST['name'] = $_FILES['torrent_file']['name'][$id];
                    require_once("/var/www/rutorrent/php/addtorrent.php");
                }
            }
        }

        // Display all errors
        if (!empty($errors)) {
            if (sizeof($errors) == 1){
                echo "Erreur trouvé <br>";
            } else {
                echo "Erreurs trouvées <br>";
            }
            foreach ($errors as $error) {
                echo  $error . "<br>";
            }
        }
    }
}

echo "<link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css'>";
echo "<a href='index.php' class='btn btn-primary btn-lg active' role='button' aria-pressed='true'>Retour</a>";