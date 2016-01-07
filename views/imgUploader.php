<?php

require_once '../class/systemSetting.php';
require_once '../include/image_functions.inc.php';

if (isset($_POST['upload'])) {
    $uploaddir = "../vehicle_img";
    $vehicle_id = $_POST['vh_id'];
    /*
     * Supported image formats
     *
     * image/jpeg
     * image/png
     * image/gif
     */
    $imgtype = $_FILES['upld_picture']['type'];

    if ($imgtype == 'image/jpeg' || $imgtype == 'image/png' || $imgtype == 'image/gif') {
        /*
          using the original file name for the file name in the server - deprecated due to security reasons
          $uploadfile = $uploaddir . basename($_FILES['image_file']['name']);
         */


        if ($imgtype == 'image/jpeg') {
            $ext = '.jpg';
        }
        if ($imgtype == 'image/gif') {
            $ext = '.gif';
        }
        if ($imgtype == 'image/png') {
            $ext = '.png';
        }

        /* Using the server's timestamp hashed for the file name */
        $hashedfilename = strtoupper(uniqid() . "_" . $vehicle_id) . $ext;
        $uploadfile = $uploaddir . $hashedfilename;

        $veh_folder = $uploaddir . "/" . $vehicle_id;

//        echo "Creating folder at " . $veh_folder;
        if (!file_exists($veh_folder)) {
            $createFolder = mkdir($veh_folder);
            if (!$createFolder) {
                $error_message = "Cannot create image derectory !";
                exit;
            }
//            echo "Folder successfully created at " . $veh_folder;
        }


        //move the uploaded file to the uploads directory
        if (move_uploaded_file($_FILES['upld_picture']['tmp_name'], $uploadfile)) {
            //prepare the thumbnail image
            $basename_1 = "L_" . basename($uploadfile);
            $basename_2 = "M_" . basename($uploadfile);
            $basename_3 = "S_" . basename($uploadfile);
            if ($imgtype == 'image/jpeg') {
                writeToJpegImageFile($uploadfile, 700, 700, "{$veh_folder}/" . $basename_1);
                writeToJpegImageFile($uploadfile, 500, 500, "{$veh_folder}/" . $basename_2);
                writeToJpegImageFile($uploadfile, 150, 150, "{$veh_folder}/" . $basename_3);
            }

            if ($imgtype == 'image/png') {
                writeToPngImageFile($uploadfile, 700, 700, "{$veh_folder}/" . $basename_1);
                writeToPngImageFile($uploadfile, 500, 500, "{$veh_folder}/" . $basename_2);
                writeToPngImageFile($uploadfile, 150, 150, "{$veh_folder}/" . $basename_3);
            }

            if ($imgtype == 'image/gif') {
                writeToGifImageFile($uploadfile, 700, 700, "{$veh_folder}/" . $basename_1);
                writeToGifImageFile($uploadfile, 500, 500, "{$veh_folder}/" . $basename_2);
                writeToGifImageFile($uploadfile, 150, 150, "{$veh_folder}/" . $basename_3);
            }


            //send the data to the database
            //collect fields to the query here....
            MainConfig::connectDB();
            $updq = "INSERT INTO `vehicle_photo` ( `vh_id`, `p_title`, `p_desc`, `file_1`, `file_2`, "
                    . "`file_3`, `date_added`, `order`, `p_visible`, `p_status` ) "
                    . "VALUES ( '{$vehicle_id}', '', '', '{$basename_1}', '{$basename_2}', '{$basename_3}', CURDATE(), 1, 1, 1 )";
            $result = mysql_query($updq);
            if ($result) {
                if (mysql_affected_rows() == 1) {
                    echo json_encode(true); // success ********************
                } else {
//                    unlink($uploadfile);
                    unlink("{$uploaddir}/L_" . basename($uploadfile));
                    unlink("{$uploaddir}/M_" . basename($uploadfile));
                    unlink("{$uploaddir}/S_" . basename($uploadfile));
                    $error = 1;
                }
            } else {
//                unlink($uploadfile);
                unlink("{$uploaddir}/L_" . basename($uploadfile));
                unlink("{$uploaddir}/M_" . basename($uploadfile));
                unlink("{$uploaddir}/S_" . basename($uploadfile));
                $error = 1;
            }
        } else {
            $error = 1;
            $error_message = "Invalid image. Please upload jpg/jpeg, png, gif or bmp image file only.";
        }
    } else {
        $error = 1;
        $error_message = "Invalid image. Please upload jpg/jpeg, png, gif or bmp image file only.";
    }
}