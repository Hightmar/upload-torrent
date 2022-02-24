<?php
// Database
if(isset($_POST['submit'])){
    $currentDirectory = getcwd();
    //$whereUpload = $_POST['repertoire'];
    $errors = [];

    if (!empty($whereUpload)){
        $uploadDirectory = "/uploads/"/*. $whereUpload ."/"*/;
    } else {
        $uploadDirectory = "/uploads/";
    }

    $fileExtensionsAllowed = array('torrent');

    print("<pre>".print_r($_FILES,true)."</pre>");

    // Velidate if files exist
    if (!empty(array_filter($_FILES['torrent_file']['name']))) {

        // Loop through file items
        foreach($_FILES['torrent_file']['name'] as $id=>$val){

            $fileName = $_FILES['torrent_file']['name'][$id];
            $fileError = $_FILES['torrent_file']['error'][$id];
            $fileSize = $_FILES['torrent_file']['size'][$id];
            $fileTmpName  = $_FILES['torrent_file']['tmp_name'][$id];
            $fileType = $_FILES['torrent_file']['type'][$id];
            $fileExtensionExplode = explode('.',$fileName);
            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $uploadPath = $currentDirectory . $uploadDirectory . basename($fileName);

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

            if ($fileSize > 4000000) {
                $errors[] = "Fichier trop lourd (4 MO) " . $fileName;
                $fileError = $fileError + 1;
            }

            if (file_exists($uploadPath)) {
                $errors[] = "Le fichier existe déjà " . $fileName;
                $fileError = $fileError + 1;
            }


            if ($fileError < 1 ) {
                $didUpload = move_uploaded_file($fileTmpName, $uploadPath);

                if ($didUpload) {
                    echo "Le fichier <b>" . basename($fileName) . "</b> a été upload <br>";
                    //require_once("/var/www/rutorrent/php/addtorrent.php");
                }

            }
        }
        if (!empty($errors)) {
            if (sizeof($errors) > 1){
                echo "Erreurs trouvées <br>";
            } else {
                echo "Erreur trouvée <br>";
            }
            foreach ($errors as $error) {
                echo  $error . "<br>";
            }
        }
    }
}