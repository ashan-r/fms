<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->  
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->  
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->  

    <head>
        <title>RMK | Welcome...</title>

        <!-- Meta -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <!-- Favicon -->
        <link rel="shortcut icon" href="png.png">

        <!-- CSS Global Compulsory -->
        <link rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/css/style.css">

        <!-- CSS Implementing Plugins -->
        <link rel="stylesheet" href="assets/plugins/line-icons/line-icons.css">
        <link rel="stylesheet" href="assets/plugins/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="assets/plugins/flexslider/flexslider.css">     
        <link rel="stylesheet" href="assets/plugins/parallax-slider/css/parallax-slider.css">

        <!-- CSS Theme -->    
        <link rel="stylesheet" href="assets/css/themes/default.css" id="style_color">

        <!-- CSS Customization -->
        <link rel="stylesheet" href="assets/css/custom.css">
    </head>	

    <body>
        

        <div class="wrapper">
            <!--=== Header ===-->    
            <div class="header">
                <!-- Topbar -->
                <div class="topbar">
                    <div class="container">
                        <!-- Topbar Navigation -->
                        <ul class="loginbar pull-right">

                            <li><a href="page_faq.php">Help</a></li>  
                            <li class="topbar-devider"></li>   
                            <li><a href="page_login.php">Login</a></li>   
                        </ul>
                        <!-- End Topbar Navigation -->
                    </div>
                </div>
                <!-- End Topbar -->

                <?php include'./inc/navBar.php'; ?>
            </div>
            <!--=== End Header ===-->    

            <!--=== Slider ===-->
            <div class="slider-inner">
                <div id="da-slider" class="da-slider">
                    
                     <div class="da-slide">
                        <h2><i>Lathe machines</i> <br /> <i>Performing various</i> <br /> <i>operations</i></h2>
                        <p><i>cutting</i> <br /> <i>sanding,knurling,drilling</i> <br /> <i>deformation,facing,turning</i></p>
                        <div class="da-img"><img src="assets/plugins/parallax-slider/img/1.png" alt="" /></div>
                    </div>
                    
                    <div class="da-slide">
                        <h2><i>Milling Machines</i> <br /> <i>Wide Range of tools</i> <br /> <i>MANY MORE</i></h2>
                        <p><i>Milling cutters</i> <br /> <i>Surface finish, Gang milling</i></p>
                        <div class="da-img">
                            <div class="da-img" style="margin-bottom: 80px"><img src="assets/plugins/parallax-slider/img/milling machine.png" alt="" /></div>
                        </div>
                    </div>
                   

                    <div class="da-slide">
                        <h2><i>Grinding Machines</i> <br /> <i>High Quality</i> <br /> <i>surfaces</i></h2>
                        <p><i>High Accuracy of Shape</i> <br /> <i>Dimensions</i> <br /> <i>Smart Finishing </i></p>
                        <div class="da-img"><img src="assets/plugins/parallax-slider/img/2.png" alt="image01" /><img src="assets/img/index page/Rotating_grinder.gif" alt="grinding gif" /></div>
                    </div>
                    <div class="da-arrows">
                        <span class="da-arrows-prev"></span>
                        <span class="da-arrows-next"></span>		
                    </div>
                </div>
            </div><!--/slider-->
            <!--=== End Slider ===-->

            <!--=== Purchase Block ===-->
            <div class="purchase">
                <div class="container">
                    <div class="row">
                        <div class="col-md-9 animated fadeInLeft">
                            <span>RMK Engineering provides you best services with latest technology.</span> We use quality assuarance and controlling mechanisams to provide the best engineering solutions for your business</div>
                    </div>
                </div>
            </div><!--/row-->
            <!-- End Purchase Block -->

            <!--=== Content Part ===-->
            <div class="container content">	
                <!-- Service Blocks -->
                <div class="row margin-bottom-30">
                    <div class="col-md-4">
                        <div class="service">
                            <i class="fa fa-compress service-icon"></i>
                            <div class="desc">
                                <h4>Abrasive machining</h4>
                                <p>material is removed from a workpiece using a multitude of small abrasive particles. Common examples include grinding, honing, and polishing. Abrasive processes are usually expensive, but capable of tighter tolerances and better surface finish than other machining processes..</p>
                            </div>
                        </div>	
                    </div>
                    <div class="col-md-4">
                        <div class="service">
                            <i class="fa fa-cogs service-icon"></i>
                            <div class="desc">
                                <h4>Cutting Fluids</h4>
                                <p>Cutting fluids are used in metal machining for a variety of reasons such as improving tool life, reducing workpiece thermal deformation, improving surface finish and flushing away chips from the cutting zone. Practically all cutt ing fluids presently in use fall into one of four categories:
Straight oils,
Soluble oils,
Semisynthetic fluids,
Synthetic fluids</p>
                            </div>
                        </div>	
                    </div>
                    <div class="col-md-4">
                        <div class="service">
                            <i class="fa fa-rocket service-icon"></i>
                            <div class="desc">
                                <h4>Electrical discharge machining (EDM)</h4>
                                <p>park machining, spark eroding, burning, die sinking, wire burning or wire erosion,
                                    is a manufacturing process whereby a desired shape is obtained using electrical discharges (sparks).
                                    Material is removed from the workpiece by a series of rapidly recurring current discharges between two electrodes,
                                    separated by a dielectric liquid and subject to an electric voltage. </p>
                            </div>
                        </div>	
                    </div>			    
                </div>
                <!-- End Service Blokcs -->



                <?php //include 'inc/clients.php'; ?>

            </div><!--/container-->		
            <!-- End Content Part -->

            <?php include 'inc/footer.php'; ?>
            <?php include 'inc/footerBar.php'; ?>
        </div><!--/wrapper-->


        <!--[if lt IE 9]>
            <script src="assets/plugins/respond.js"></script>
        <![endif]-->



    </body>
</html>	