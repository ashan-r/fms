<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
require_once './include/MainConfig.php';
include './config/dbc.php';
define("VEHICLE_REG", 12452);
?>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <!--load CSS styles-->
        <?php require_once './include/systemHeader.php'; ?> 
        <link href="css/image_upload.css" rel="stylesheet" type="text/css" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <!--<script src="js/jquery-1.10.2.min.js" type="text/javascript"></script>-->


    </head>
    <body class="green-back">
        <div id="wrap">
            <!--load navigation bar-->
            <?php require_once './include/navBar.php'; ?>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="page-header cutom-header">
                            <h3>Vehicle Image Upload</h3>
                        </div>
                        <div class="form-horizontal" id="uploaderform">
                            <form action="views/upload_image.php" method="post" enctype="multipart/form-data" name="UploadForm" id="UploadForm">
                                <h1>Select Images of the vehicle</h1>
                                <p>recommended maximum file size of each image is 1MB</p>

                                <label>Files
                                    <span class="small"><a href="#" id="AddMoreFileBox">Add More Files</a></span>
                                </label>
                                <div id="AddFileInputBox"><input id="fileInputBox" style="margin-bottom: 5px;" type="file"  multiple="multiple" name="file[]"/></div>
                                <div class="sep_s"></div>
                                <!--                                <label>Name
                                                                    <span class="small">Vehicle ID</span>
                                                                </label>-->
                                <div><input name="vh_id" type="hidden" id="vh_id" value="<?php
                                    if (isset($_POST['vh_id'])) {
                                        echo $_POST['vh_id'];
                                    }
                                    ?>" /></div>

                                <button type="submit" class="btn btn-custom-save" id="SubmitButton">Upload</button>
                                <a href="vehicle_reg.php" class="btn btn-custom-light" id="vh_back">Back</a>
                                <div id="progressbox"><div id="progressbar"></div ><div id="statustxt">0%</div ></div>
                            </form>
                        </div>
                        <div id="uploadResults">
                            <div align="center" style="margin:20px;"><a href="#" id="ShowForm">Toggle Form</a></div>
                            <div id="output"></div>
                        </div>
                    </div>
                </div>   
            </div>               

        </div>
        <!-- load JavaScript-->
        <?php require_once './include/systemFooter.php'; ?>
        <script type="text/javascript" src="js/jquery.form.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                //elements
                var progressbox = $('#progressbox'); //progress bar wrapper
                var progressbar = $('#progressbar'); //progress bar element
                var statustxt = $('#statustxt'); //status text element
                var submitbutton = $("#SubmitButton"); //submit button
                var myform = $("#UploadForm"); //upload form
                var output = $("#output"); //ajax result output element
                var completed = '0%'; //initial progressbar value
                var FileInputsHolder = $('#AddFileInputBox'); //Element where additional file inputs are appended
                var MaxFileInputs = 3; //Maximum number of file input boxs

                // adding and removing file input box
                var i = $("#AddFileInputBox div").size() + 1;
                $("#AddMoreFileBox").click(function () {
                    event.returnValue = false;
                    if (i < MaxFileInputs)
                    {
                        $('<span><input type="file" id="fileInputBox" size="20" name="file[]" class="addedInput" value=""/><a href="#" class="removeclass small2"><img src="images/close_icon.gif" border="0" /></a></span>').appendTo(FileInputsHolder);
                        i++;
                    }
                    return false;
                });

                $("body").on("click", ".removeclass", function (e) {
                    event.returnValue = false;
                    if (i > 1) {
                        $(this).parents('span').remove();
                        i--;
                    }

                });

                $("#ShowForm").click(function () {
                    $("#uploaderform").slideToggle(); //Slide Toggle upload form on click
                });

                $(myform).ajaxForm({
                    beforeSend: function () { //brfore sending form
                        submitbutton.attr('disabled', ''); // disable upload button
                        statustxt.empty();
                        progressbox.show(); //show progressbar
                        progressbar.width(completed); //initial value 0% of progressbar
                        statustxt.html(completed); //set status text
                        statustxt.css('color', '#000'); //initial color of status text

                    },
                    uploadProgress: function (event, position, total, percentComplete) { //on progress
                        progressbar.width(percentComplete + '%'); //update progressbar percent complete
                        statustxt.html(percentComplete + '%'); //update status text
                        if (percentComplete > 50)
                        {
                            statustxt.css('color', '#fff'); //change status text to white after 50%
                        } else {
                            statustxt.css('color', '#000');
                        }

                    },
                    complete: function (response) { // on complete
                        output.html(response.responseText); //update element with received data
                        myform.resetForm();  // reset form
                        submitbutton.removeAttr('disabled'); //enable submit button
                        progressbox.hide(); // hide progressbar
                        $("#uploaderform").slideUp(); // hide form after upload
                    }
                });
            });
        </script> 
    </body>
</html>
