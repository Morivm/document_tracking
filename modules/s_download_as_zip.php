<?php

    $orderofbusiness_code = $_GET['orderofbusinesscode'];


    $zip_file = "filestodownload/test.zip";
    touch($zip_file);

    $zip = new ZipArchive;
    $this_zip = $zip->open($zip_file);


    if($this_zip) {

        $folder = opendir("pr");

        if($folder) {

            // while( false !== ($details = readdir($folder)) ) {
            //     if($details !== "." && $details !== "..") {

                    $file_with_path = "pr/$orderofbusiness_code.pdf";

                    $zip->addFile($file_with_path);

            //     }
            // }
            closedir($folder);
        }
    }


?>