<?php

require_once '../class/systemSetting.php';

if (isset($_POST['file_upload'])) {
    if (isset($_POST['vh_id'])) {
        $vehicle_id = intval($_POST['vh_id']);
        MainConfig::connectDB();
        $vh_code_res = mysql_query("SELECT vehicle.vh_code FROM vehicle WHERE vehicle.vh_id = '{$vehicle_id}'");
        $vh_data_arr = mysql_fetch_assoc($vh_code_res);
        $vh_dir = $vh_data_arr['vh_code'] . '_' . $vehicle_id;
        MainConfig::closeDB();
        $uploaddir = "../vehicle_img/" . $vh_dir;

        if ($_FILES['file']['error'] !== UPLOAD_ERR_OK) {
            echo json_encode($_FILES['file']['error']);
            exit();
        }
        /** The proper method for validating uploads is to use server-side mime-type determination, e.g. via fileinfo
         *  This extension is enabled by default as of PHP 5.3.0
         *  Windows users must include the bundled php_fileinfo.dll DLL file in php.ini to enable this extension.
         */
//        $finfo = finfo_open(FILEINFO_MIME_TYPE);
//        $mime = finfo_file($finfo, $_FILES['file']['tmp_name']);
        $mime = $_FILES['file']['type'];
//        echo $mime;
        $ok = false;
        if ($mime == 'application/pdf') {
            $filename = $vehicle_id . ".pdf";
            $uploadfile = $uploaddir . "/" . $filename;
            if (!file_exists($uploaddir)) {
                $createFolder = mkdir($uploaddir, 755);
                if (!$createFolder) {
                    $error_message = "Cannot create directory !";
                    echo $error_message;
                    exit;
                }
//            echo "Folder successfully created at " . $veh_folder;
            }
            $upload_ok = move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile);
            if ($upload_ok) {
                MainConfig::connectDB();
                $updq = "UPDATE `vehicle` SET `pdf_file` = '{$filename}' WHERE (`vh_id` = '{$_POST['vh_id']}');";
                mysql_query($updq);
                echo json_encode(100);
                MainConfig::closeDB();
            } else {
                echo json_encode(900);
            }
        } else {
            echo json_encode(800);
        }
    }
} elseif (isset($_POST['web_home_data'])) {
//    $data = $_POST['text_data'];
//    echo $_POST['section'];
//    print_r($data);
    if (isset($_POST['section'])) {
        $uploaddir = "../images/web";
//        $vehicle_id = $_POST['vh_id'];
        if ($_FILES['file']['error'] !== UPLOAD_ERR_OK) {
            echo json_encode($_FILES['file']['error']);
            exit();
        }
        /** The proper method for validating uploads is to use server-side mime-type determination, e.g. via fileinfo
         *  This extension is enabled by default as of PHP 5.3.0
         *  Windows users must include the bundled php_fileinfo.dll DLL file in php.ini to enable this extension.
         */
//        $finfo = finfo_open(FILEINFO_MIME_TYPE);
//        $mime = finfo_file($finfo, $_FILES['file']['tmp_name']);
        $mime = $_FILES['file']['type'];
//        echo $mime;
        $ok = false;
        if ($mime == 'image/jpeg') {
            $filename = strtoupper(uniqid()) . ".jpg";
            $uploadfile = $uploaddir . "/" . $filename;
            if (!file_exists($uploaddir)) {
                $createFolder = mkdir($uploaddir, 755);
                if (!$createFolder) {
                    $error_message = "Cannot create directory !";
                    echo $error_message;
                    exit;
                }
//            echo "Folder successfully created at " . $veh_folder;
            }
            $upload_ok = move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile);
            if ($upload_ok) {
                MainConfig::connectDB();
//                foreach ($data as $key => $value) {
//                    $data[$key] = mysql_real_escape_string($data[$key]);
//                }
                $updq = "INSERT INTO web_homepg (wh_section,wh_image,wh_head1,wh_head2,wh_content,`order`,`status` ) VALUES ( '{$_POST['section']}', '{$filename}','{$_POST['heading_1']}','{$_POST['heading_2']}', '{$_POST['description']}', {$_POST['content_order']}, '1' );";
                mysql_query($updq) or die(mysql_error());
                echo json_encode(100);
                MainConfig::closeDB();
            } else {
                echo json_encode(900);
            }
        } else {
            echo json_encode(800);
        }
    } else {
        echo 'fasfaffs';
    }
} elseif (isset($_POST['web_news_data'])) {
    if (isset($_POST['news_head'])) {
        $uploaddir = "../images/web_news";
//        $vehicle_id = $_POST['vh_id'];
        if ($_FILES['file']['error'] !== UPLOAD_ERR_OK) {
            echo json_encode($_FILES['file']['error']);
            exit();
        }
        /** The proper method for validating uploads is to use server-side mime-type determination, e.g. via fileinfo
         *  This extension is enabled by default as of PHP 5.3.0
         *  Windows users must include the bundled php_fileinfo.dll DLL file in php.ini to enable this extension.
         */
//        $finfo = finfo_open(FILEINFO_MIME_TYPE);
//        $mime = finfo_file($finfo, $_FILES['file']['tmp_name']);
        $mime = $_FILES['file']['type'];
        $ImageName = $_FILES['file']['name'];
        $ImageSize = $_FILES['file']['size'];
        $TempSrc = $_FILES['file']['tmp_name'];
        $ImageType = $_FILES['file']['type'];
        $Quality = 90;
//        echo $mime;
        $ok = false;
        $processImage = true;
        //Validate file + create image from uploaded file.
        switch (strtolower($ImageType)) {
            case 'image/png':
                $CreatedImage = imagecreatefrompng($TempSrc);
                break;
            case 'image/gif':
                $CreatedImage = imagecreatefromgif($TempSrc);
                break;
            case 'image/jpeg':
            case 'image/pjpeg':
                $CreatedImage = imagecreatefromjpeg($TempSrc);
                break;
            default:
                $processImage = false; //image format is not supported!
        }

        //get Image Size
        list($CurWidth, $CurHeight) = getimagesize($TempSrc);
        //
        if ($processImage) {
            $filename = strtoupper(uniqid()) . ".jpg";
            $uploadfile = $uploaddir . "/" . $filename;
            if (!file_exists($uploaddir)) {
                $createFolder = mkdir($uploaddir);
                if (!$createFolder) {
                    $error_message = "Cannot create directory !";
                    echo $error_message;
                    exit;
                }
            }
            if (cropImage($CurWidth, $CurHeight, 150, $uploadfile, $CreatedImage, $Quality, $ImageType)) {
                MainConfig::connectDB();
                $news_head = mysql_real_escape_string($_POST['news_head']);
                $news_content = mysql_real_escape_string($_POST['news_content']);

                $ins = mysql_query("INSERT INTO `web_news` (`heading_1`, `content_all`, `posted_date`, `news_status`,`image`) VALUES ('{$news_head}', '{$news_content}', '{$_POST['news_date']}','1','{$filename}')")or die(mysql_error());
                if ($ins) {
                    echo json_encode(100);
                }
                MainConfig::closeDB();
            } else {
                echo json_encode(900);
            }
        } else {
            echo json_encode(800);
        }
    } else {
        echo 'fasfaffs';
    }
} elseif (isset($_POST['pdf_file_upload'])) {
    //  DEVELOPMENT ONGOING
    if (isset($_POST['vh_id'])) {
        $vehicle_id = intval($_POST['vh_id']);
        MainConfig::connectDB();
        $vh_code_res = mysql_query("SELECT vehicle.vh_code FROM vehicle WHERE vehicle.vh_id = '{$vehicle_id}'");
        $vh_data_arr = mysql_fetch_assoc($vh_code_res);
        $vh_dir = $vh_data_arr['vh_code'] . '_' . $vehicle_id;
        MainConfig::closeDB();
        $uploaddir = "../vehicle_img/" . $vh_dir;

        if ($_FILES['file']['error'] !== UPLOAD_ERR_OK) {
            echo json_encode($_FILES['file']['error']);
            exit();
        }
        /** The proper method for validating uploads is to use server-side mime-type determination, e.g. via fileinfo
         *  This extension is enabled by default as of PHP 5.3.0
         *  Windows users must include the bundled php_fileinfo.dll DLL file in php.ini to enable this extension.
         */
//        $finfo = finfo_open(FILEINFO_MIME_TYPE);
//        $mime = finfo_file($finfo, $_FILES['file']['tmp_name']);
        $mime = $_FILES['file']['type'];
//        echo $mime;
        $ok = false;
        if ($mime == 'application/pdf') {
            $filename = $vehicle_id . ".pdf";
            $uploadfile = $uploaddir . "/" . $filename;
            if (!file_exists($uploaddir)) {
                $createFolder = mkdir($uploaddir, 755);
                if (!$createFolder) {
                    $error_message = "Cannot create directory !";
                    echo $error_message;
                    exit;
                }
//            echo "Folder successfully created at " . $veh_folder;
            }
            $upload_ok = move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile);
            if ($upload_ok) {
                MainConfig::connectDB();
                $updq = "UPDATE `vehicle` SET `pdf_file` = '{$filename}' WHERE (`vh_id` = '{$_POST['vh_id']}');";
                mysql_query($updq);
                echo json_encode(100);
                MainConfig::closeDB();
            } else {
                echo json_encode(900);
            }
        } else {
            echo json_encode(800);
        }
    }
}

//*****************************************************************************************************
//This function corps image to create exact square images, no matter what its original size!
function cropImage($CurWidth, $CurHeight, $iSize, $DestFolder, $SrcImage, $Quality, $ImageType) {
    //Check Image size is not 0
    if ($CurWidth <= 0 || $CurHeight <= 0) {
        return false;
    }

    //abeautifulsite.net has excellent article about "Cropping an Image to Make Square"
    //http://www.abeautifulsite.net/blog/2009/08/cropping-an-image-to-make-square-thumbnails-in-php/
    if ($CurWidth > $CurHeight) {
        $y_offset = 0;
        $x_offset = ($CurWidth - $CurHeight) / 2;
        $square_size = $CurWidth - ($x_offset * 2);
    } else {
        $x_offset = 0;
        $y_offset = ($CurHeight - $CurWidth) / 2;
        $square_size = $CurHeight - ($y_offset * 2);
    }

    $NewCanves = imagecreatetruecolor($iSize, $iSize);
    if (imagecopyresampled($NewCanves, $SrcImage, 0, 0, $x_offset, $y_offset, $iSize, $iSize, $square_size, $square_size)) {
        switch (strtolower($ImageType)) {
            case 'image/png':
                imagepng($NewCanves, $DestFolder);
                break;
            case 'image/gif':
                imagegif($NewCanves, $DestFolder);
                break;
            case 'image/jpeg':
            case 'image/pjpeg':
                imagejpeg($NewCanves, $DestFolder, $Quality);
                break;
            default:
                return false;
        }
        if (is_resource($NewCanves)) {
            imagedestroy($NewCanves);
        }
        return true;
    }
}
