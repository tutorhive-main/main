<?php 
error_reporting(0);
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;
require '../../vendor/autoload.php';
ob_start();
ini_set('session.gc_maxlifetime', '28800');
session_start();
if( !isset($_SESSION['market_emailID']))
 {
   header("Location: login.php");
 }
include("common/connection.php");

$date=date('Y-m-d H:i:s');

 $s3Client = new S3Client([
    'region' => 'eu-west-2',
    'version' => 'latest',
    'credentials' => [
        'key'  => "AKIA2KHLYWYGMG6UVH5P",
        'secret' => "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"
    ]
]);
$bucketName = 'product-imagesv1';
$_SESSION['product_imgeid']="";
if(isset($_POST['submit'])){

  $cat_id=$_POST['cat_id']; 
  $typeofproduct=$_POST['typeofproduct'];
  $sub_cat_name=$_POST['sub_cat_name'];
  $productname=$_POST['productname'];
  $productprice=$_POST['productprice'];
  if($typeofproduct=="Physical"){
  $tracking=$_POST['tracking'];
  $productprice1=$_POST['productprice1'];
  }else {
  $tracking="No";
  $productprice1=0;   
  }
  $Quantity=$_POST['Quantity'];
  $shortdesc=$_POST['shortdesc'];
  $description=$_POST['description'];
  $tags=$_POST['tagval'];
 $user_id=$_SESSION['market_admin_id'];
 $totalprice=$productprice+$productprice1;
 
 $product_images=$_POST['imageval'];

 if($tags==""){
 $tags="00";
 }

$hive_qry = $tutor_db->prepare("INSERT INTO marketplace_products (user_id,cat_id,sub_cat_name,productname,productprice,Quantity,shortdesc,description,tags,typeofproduct,productprice1,totalprice,tracking,product_images,status,added_date) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
$hive_qry->execute(array($user_id, $cat_id, $sub_cat_name, $productname, $productprice, $Quantity, $shortdesc, $description, $tags, $typeofproduct, $productprice1, $totalprice, $tracking, $product_images, 0, $tutor_date));

$imagename=$SEVER_NAME."/assets/images/tutorhive-logo.png";
$insta=$SEVER_NAME."/assets/images/instagramIconf.png";
$linkedin=$SEVER_NAME."/assets/images/ic-linkedin.png";
$subject = 'MARKETPLACE ITEM UPLOADED AND IT’S WAITING FOR REVIEW';
           $bodyHtml ='
    <body style="margin:0px;">
<table>
                                <tr>
                                    <td style="padding:0px" valign="top"></td>
                                    <td  width="600" style="  display: block !important; max-width: 600px !important; clear: both !important;" valign="top">
                                        <div>
                                            <table  width="100%" cellpadding="0" cellspacing="0" style="border: 25px solid #ffd142;border-radius: 5px;background: #FFD142;">
                                                <tr>
                                                    <td  style="background:#fff;border-radius: 5px;" align="center" valign="top">
                                                        <table width="100%" cellpadding="0" cellspacing="0">
                                                            <tr>
                                                                <td style="padding: 20px 10px;border-bottom: 1px solid #ffd142;">
                                                                    <a href="'.$SEVER_NAME.'"><img src="'.$imagename.'" style="height: 50px; margin-left: auto; margin-right: auto; display:block;"></a>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td  style="padding: 0 0 20px;" valign="top">
                                                                    <h2  style="font-family:Helvetica,Arial,sans-serif;font-size: 24px; line-height: 1.2em; font-weight: 600; text-align: center;padding-top:20px" align="center"><span style="color: #FFD142; font-weight: 700;">MARKETPLACE ITEM UPLOADED </span> AND IT’S WAITING FOR REVIEW!</h2>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td  style="padding: 0 0 20px;" align="center" valign="top">
                                                                    <table  style="width: 90%;">
                                                                        <tr>
                                                                            <td style="padding: 5px 0;" valign="top">
                                                                                <table  cellpadding="0" cellspacing="0" style="width: 100%;">
                                                                                    <tr>
                             <td style="font-weight:bold;font-family:Helvetica,Arial,sans-serif; font-size: 14px; vertical-align: top; margin: 0; padding: 10px 0;" valign="top">
                                <p >Hey  TutorHive,</p>
								<p >Dear tutorHive marketplace item uploaded by seller and its waiting for your review</p>
								<p ><b>The Product details are:</b></p>
								 <p ><span style="color:#ffd142;">Product Name : </span> '.$productname.'</p>
								 <p ><span style="color:#ffd142;">Product Type : </span> '.$typeofproduct.'</p>
								 
								
								  <p ><span style="color:#ffd142;">TutorHive Team</span></p>
								   <p style="text-align: center;">
		<a href="'.$SEVER_NAME.'" style="background: #FFD142;color: #000;text-decoration: none;padding: 10px 10px 8px 10px;font-size: 20px;border-radius: 5px;">tutorhive.co.uk</a>
	
		<a href="https://www.instagram.com/tutor.hive/" style="background: #FFD142;color: #000;text-decoration: none;padding: 17px 8px 9px 8px;border-radius: 5px;"><img src="'.$insta.'"></a>
		<a href="https://www.linkedin.com/uas/login?session_redirect=%2Fcompany%2F34928667" style="background: #FFD142;color: #000;text-decoration: none;padding: 17px 8px 9px 8px;border-radius: 5px;"><img src="'.$linkedin.'"></a>
		</p>  
		<p ><span style="color:#ffd142;">#BeeTheChange</span></p>
							
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="font-weight:bold;color: #FFD142;font-family:Helvetica,Arial,sans-serif;padding: 20px 10px;border-top: 1px solid #ffd142;" align="center" valign="top">&copy; Copyright'.date("Y").' - TutorHive</td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>                                            
                                        </div>
                                    </td>
                                    <td style="font-family:Helvetica,Arial,sans-serif; font-size: 14px; vertical-align: top; margin: 0;" valign="top"></td>
                                </tr>
                            </table> </body>';
							

$recipient = 'Info@tutorhive.co.uk';
$mail = new PHPMailer(true);

try {
    // Specify the SMTP settings.
    $mail->isSMTP();
    $mail->setFrom($sender, $senderName);
    $mail->Username   = $usernameSmtp;
    $mail->Password   = $passwordSmtp;
    $mail->Host       = $host;
    $mail->Port       = $port;
    $mail->SMTPAuth   = true;
    $mail->SMTPSecure = 'tls';
  
    // Specify the message recipients.
    $mail->addAddress($recipient);
    // You can also add CC, BCC, and additional To recipients here.

    // Specify the content of the message.
    $mail->isHTML(true);
    $mail->Subject    = $subject;
    $mail->Body       = $bodyHtml;
    $mail->Send();
   // echo "Email sent!" , PHP_EOL;
} catch (phpmailerException $e) {
    echo "An error occurred. {$e->errorMessage()}", PHP_EOL; //Catch errors from PHPMailer.
} catch (Exception $e) {
    echo "Email not sent. {$mail->ErrorInfo}", PHP_EOL; //Catch errors from Amazon SES.
}

header("Location:add_products.php?succ=add");
exit();
}
?>
<!doctype html>
<html lang="en" dir="ltr">

    <head>
        <meta charset="utf-8" />
        <title>TutorHive - Admin Products</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Premium Bootstrap 5 Landing Page Template" />
        <meta name="keywords" content="Saas, Software, multi-uses, HTML, Clean, Modern" />
        <meta name="author" content="Shreethemes" />
        <meta name="email" content="support@shreethemes.in" />
        <meta name="website" content="https://shreethemes.in" />
        <meta name="Version" content="v4.2.0" />

       <?php include('common/headerlinks.php');?>
	    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/css/bootstrap-select.min.css" integrity="sha512-mR/b5Y7FRsKqrYZou7uysnOdCIJib/7r5QeJMFvLNHNhtye3xJp1TdJVPLtetkukFn227nKpXD9OjUc09lx97Q==" crossorigin="anonymous"
  referrerpolicy="no-referrer" />
	<link rel="stylesheet" href="https://unpkg.com/dropzone/dist/dropzone.css" />
		<link href="https://unpkg.com/cropperjs/dist/cropper.css" rel="stylesheet"/>
		<script src="https://unpkg.com/dropzone"></script>
		<script src="https://unpkg.com/cropperjs"></script>
         <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<style>
@media (max-width: 767px) {
p {
   font-size: 12px;
}
.h6, h6 {
    font-size: 14px;
}
.h5, h5 {
    font-size: 16px;
}
.mt-4 {
    margin-top: 0.7rem!important;
}
.form-control {
    font-size: 12px;
    line-height: 18px;
}
.p-4 {
    padding: 1.0rem!important;
}
.p-3 {
    padding: 0.3rem!important;
}
th, td {
font-size:10px;
}
.btn-group-sm>.btn, .btn.btn-sm {
    padding: 2px 6px;
    font-size: 8px;
}
}            

</style>
    </head>

    <body>
        <!-- Loader -->
        <!-- <div id="preloader">
            <div id="status">
                <div class="spinner">
                    <div class="double-bounce1"></div>
                    <div class="double-bounce2"></div>
                </div>
            </div>
        </div> -->
        <!-- Loader -->

        <div class="page-wrapper toggled">
            <!-- sidebar-wrapper -->
           <?php include('common/mleftmenum.php');?>
            <!-- sidebar-wrapper  -->

            <!-- Start Page Content -->
            <main class="page-content bg-light">
                <!-- Top Header -->
                <?php include('common/mheaderm.php');?>
                <!-- Top Header -->

                <div class="container-fluid">
                    <div class="layout-specing">
                        <div class="d-flex align-items-center justify-content-between">
                            <h5 class="mb-4">Add Product </h5>

                            <a href="view_products" class="btn btn-sm btn-primary">View Product</a>
                            </div>
                            
<div align="center" style="color:#006600; font-size:16px;">
                             <?php if($_GET['succ']=='add'){?>
			  Successfully added product. Our busy bees are now reviewing it. Once it has been approved you will receive a notification.
			  <?php } ?>
			  </div>
                            
<form name="Tutorhiveform" action=""  enctype="multipart/form-data" method="post" onSubmit="return myFun()">
    <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                         <label class="form-label">Select Category <span class="text-danger">*</span></label>
                                            <select class="form-control" id="cat_id" name="cat_id"  >
                                                <option value="">Select Category</option>
                                                <?php 
                                    $statementtutr = $tutor_db->prepare("SELECT category_name,cat_id FROM market_life_categories WHERE status=?");
                                     $statementtutr->execute([1]); 
                                    $tutorInterest = $statementtutr->fetchAll(PDO::FETCH_ASSOC); 
                                    if ($tutorInterest) {
                                    foreach ($tutorInterest as $tutrInterest) { ?>
                                    <option value="<?php echo $tutrInterest['cat_id']; ?>"><?php echo $tutrInterest['category_name']; ?></option>
                                       <?php } } ?>
                                            </select>
                                        </div>
                                    </div>
                                     </div>
									 <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                         <label class="form-label">Select Type of Product <span class="text-danger">*</span> <a data-bs-toggle="modal" data-bs-target="#tooltip1" class="btn m-1" style="padding:0px;"> <img src="assets/images/tooltip-2.svg"  style="height: 30px;width: 30px;"></a></label>
                                            <select class="form-control" id="typeofproduct" name="typeofproduct"  onChange="showUser2(this.value)">
                                                <option value="Digital">Digital</option>
                                                <option value="Physical">Physical</option>
                                            </select>
                                        </div>
                                    </div>
                                     </div>
                                     <div id="subdetsils">
                                         <input name="sub_cat_name" id="sub_cat_name" type="hidden" value="No" >
                                     </div>
                                      
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Product Name <span class="text-danger">*</span></label>
                                                        <div class="form-icon position-relative">
                                                            <input name="productname" id="productname" type="text" class="form-control" placeholder="Product Name" >
                                                            
                                                        </div>
                                                    </div>
                                                </div><!--end col--> 
                                            </div><!--end row-->
											<div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Product Price "£" <span class="text-danger">*</span></label>
                                                        <div class="form-icon position-relative">
                                                            <input name="productprice" id="productprice" type="number" class="form-control" placeholder="Product Price" >
                                                           
                                                        </div>
                                                    </div>
                                                </div><!--end col-->
                                            </div>
                                             <div class="row" id="digilet" style="display: none;">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                         <label class="form-label">Select Postage Type <span class="text-danger">*</span></label>
                                            <select class="form-control" id="tracking" name="tracking" >
                                                <option value="">Select Postage Type</option>
                                                <option value="First class">First class</option>
                                                <option value="Second class">Second class</option>
                                                <option value="Tracked">Tracked</option>
                                                <option value="Signed for">Signed for</option>
                                                <option value="None">None</option>
                                            </select>
                                        </div>
                                    </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Postage Cost "£" <span class="text-danger">*</span></label>
                                                        <div class="form-icon position-relative">
                                                            <input name="productprice1" id="productprice1" type="number" class="form-control" placeholder="Product Price1" >
                                                            <!--<span style="color:#ff0000;font-size: 15px;">Shipping is included in the price</span>-->
                                                        </div>
                                                    </div>
                                                </div><!--end col-->
                                            </div>
                                           
                                     </div>
                                     	<div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Availability Quantity <span class="text-danger">*</span><a data-bs-toggle="modal" data-bs-target="#tooltip2" class="btn m-1" style="padding:0px;"> <img src="assets/images/tooltip-2.svg"  style="height: 30px;width: 30px;"></a></label>
                                                        <div class="form-icon position-relative">
                                                            <input name="Quantity" id="Quantity" type="number" class="form-control" placeholder="Product Quantity" >
                                                           
                                                        </div>
                                                    </div>
                                                </div><!--end col-->
											<div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Short Description <span class="text-danger">*</span> <a data-bs-toggle="modal" data-bs-target="#tooltip3" class="btn m-1" style="padding:0px;"> <img src="assets/images/tooltip-2.svg"  style="height: 30px;width: 30px;"></a></label>
                                                        <div class="form-icon position-relative">
                                                            <textarea type="text" name="shortdesc" id="shortdesc" class="form-control" rows="3" placeholder="Short Description" ></textarea>
                                                            <span id="Message" style="color:red; font-size:16px;" ></span>
                                                        </div>
                                                    </div>
                                                </div><!--end col-->
                                            </div>
											<div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Description <span class="text-danger">*</span></label>
                                                        <div class="form-icon position-relative">
                                                            <textarea type="text" name="description" id="description" class="form-control" rows="5" placeholder="Description" ></textarea>
                                                             <span id="Message1" style="color:red; font-size:16px;" ></span>
                                                        </div>
                                                    </div>
                                                </div><!--end col-->
                                            </div>
											
											<div class="row">
                                                <div class="col-md-4">
													 <label class="form-label">&nbsp;<span class="text-danger"></span></label>
                                                  <div class="form-icon position-relative">
												 <a class="btn btn-primary" onClick="return selectimg()" style="padding: 7px 10px;width: 100%;">ADD IMAGE</a>
												 <span style="color:#ff0000;font-size: 12px;">Image Size Must be  in 400*550</span>
												 </div>  
                                                </div><!--end col-->
												 <div class="col-md-2">
												 
												 </div> 
												 <div class="row">
												  <div class="col-md-4">
												 <div id="geteresult1" style="margin-bottom: 20px;">
												<div class="col-md-12">
												<div style="display: block; overflow-x: auto; -webkit-overflow-scrolling: touch; border-radius: 6px; box-shadow: 0 0 3px rgba(60, 72, 88, 0.15);">
                                <table cellpadding="0" cellspacing="0" style="width: 100%;font-size: 14px;">
                                    <thead class="bg-light">
                                        <tr>
                                            <th scope="col" style="text-align: left; vertical-align: bottom; border-top: 1px solid #dee2e6; padding: 6px;">No.</th>
                                            <th scope="col" style="text-align: left; vertical-align: bottom; border-top: 1px solid #dee2e6; padding: 6px;">Images</th>
                                            <th scope="col" style="text-align: end; vertical-align: bottom; border-top: 1px solid #dee2e6; padding: 6px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<input name="countimga" id="countimga" type="hidden" value="0" >
                                       
                                    </tbody>
                                </table>
								<input name="imageval" id="imageval" type="hidden" value="" >
                            </div>	
												</div>
												</div>
												</div>
												</div>
                                            </div>
											
									
											
											<div class="row">
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label">Tags<span class="text-danger">*</span></label>
                                                        <div class="form-icon position-relative">
														 <input name="tags" id="tags" type="text" class="form-control" placeholder="Add Tags" >
                                                             <span style="color:#ff0000;font-size: 12px;">Please enter each tag separately and press
add<a data-bs-toggle="modal" data-bs-target="#tooltip5" class="btn m-1" style="padding:0px;"> <img src="assets/images/tooltip-2.svg"  style="height: 30px;width: 30px;"></a></span>
                                                        </div>
                                                    </div>
                                                </div><!--end col-->
												 <div class="col-md-2">
												  <label class="form-label">&nbsp;<span class="text-danger"></span></label>
                                                        <div class="form-icon position-relative">
												 <a class="btn btn-primary" onClick="return ADDtags()" style="padding: 7px 10px;width: 100%;">ADD</a>
												 </div>  
												 </div> 
												 <div class="row">
												  <div class="col-md-4">
												 <div id="geteresult" style="margin-bottom: 20px;">
												<div class="col-md-12">
												<div style="display: block; overflow-x: auto; -webkit-overflow-scrolling: touch; border-radius: 6px; box-shadow: 0 0 3px rgba(60, 72, 88, 0.15);">
                                <table cellpadding="0" cellspacing="0" style="width: 100%;font-size: 14px;">
                                    <thead class="bg-light">
                                        <tr>
                                            <th scope="col" style="text-align: left; vertical-align: bottom; border-top: 1px solid #dee2e6; padding: 6px;">No.</th>
                                            <th scope="col" style="text-align: left; vertical-align: bottom; border-top: 1px solid #dee2e6; padding: 6px;">Tags</th>
                                            <th scope="col" style="text-align: end; vertical-align: bottom; border-top: 1px solid #dee2e6; padding: 6px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       
                                    </tbody>
                                </table>
								<input name="tagval" id="tagval" type="hidden" value="" >
                            </div>	
												</div>
												</div>
												</div>
												</div>
												 
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <input type="submit" id="submit" name="submit" class="btn btn-primary" value="Submit" style="display:none;" readonly>
													<input onClick="return validate1();"  class="btn btn-primary" value="Submit" readonly>
													<a data-bs-toggle="modal" data-bs-target="#tooltip6" class="btn m-1" style="padding:0px;"> <img src="assets/images/tooltip-2.svg"  style="height: 30px;width: 30px;"></a>
                                                </div><!--end col-->
                                            </div><!--end row-->
                                        </form><!--end form-->
 
                            
                        </div>
                   
                </div><!--end container-->

                <!-- Footer Start -->
                <footer class="shadow py-3">
                    <div class="container-fluid">
                        <div class="row align-items-center">
                            <div class="col">
                                <div class="text-sm-start text-center mx-md-2">
                                    <p class="mb-0 text-center">Copyright © 2022 TutorHive. All Rights Reserved</p>
                                </div>
                            </div><!--end col-->
                        </div><!--end row-->
                    </div><!--end container-->
                </footer><!--end footer-->
                <!-- End -->
            </main>
            <!--End page-content" -->
        </div>
        <!-- page-wrapper -->

        <!-- Offcanvas Start -->
        
        <!-- Offcanvas End -->
        
        <!-- javascript -->
        <!-- JAVASCRIPT -->
		 <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		 
      <?php include('common/footerlinks.php');?>
	  <a class="button" id="ClickModal3" data-bs-toggle="modal" data-bs-target="#wishlist" style="display:none">Let me Pop up</a>
	  <div class="modal fade" id="wishlist" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered popwithdstyle">
                                            <div class="modal-content rounded shadow border-0">
                                                 <button type="button" class="btn btn-icon btn-close" data-bs-dismiss="modal" id="closserrrr" style="float: right;"><i class="uil uil-times fs-4 text-dark"></i></button>
                                                <div class="modal-body py-5" style="background-color: #ffd85d;">
                                                    <div class="text-center">
                                         <div class="row">
				<div class="col-md-2">&nbsp;</div>
				<div class="col-md-8" >
				    <p style="font-size: 22px;font-weight: 600;">Upload Your Profile Pic here</p>
					<div class="image_area" id="hidetapafc">
						<form method="post">
							<label for="upload_image" >
								<div class="overlay">
									<div class="text">Click to Change Profile Image</div>
								</div>
								<input type="file" name="image" class="image" id="upload_image" style="display:none" />
							</label>
						</form>
						
					
					</div>
			    </div>
    					
		</div>
                                         
                                                    <div class="mt-4">
                                                             <div class="form-floating mb-2" id="closeid" style="display: none;">
                                  <button class="btn btn-primary " data-bs-dismiss="modal" id="close-modal">Done</button>
                                </div>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
									
									<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
			  	<div class="modal-dialog modal-lg" role="document">
			    	<div class="modal-content">
			      		<div class="modal-header">
			        		<h5 class="modal-title">Crop Image Before Upload</h5>
			        		<button type="button" class="close" data-bs-dismiss="modal" id="incloseeeee" aria-label="Close">
			          			<span aria-hidden="true">×</span>
			        		</button>
			      		</div>
			      		<div class="modal-body" style="padding: 10px 33px 10px 10px;!important;">
			        		<div class="img-container">
			            		<div class="row">
			                		<div class="col-md-12">
			                    		<img src="" id="sample_image" style="width:100%; height:100%;" />
			                		</div>
			                		<div class="col-md-12">
			                    		<div class="preview"></div>
			                		</div>
			            		</div>
			        		</div>
			      		</div>
			      		<div class="modal-footer">
			      			<button type="button" id="crop" class="btn btn-primary">Crop</button>
			        		<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="close-modal">Cancel</button>
			      		</div>
			    	</div>
			  	</div>
			</div>
	  
	  
	  
	  
	  <div class="modal fade" id="tooltip1" tabindex="-1" aria-labelledby="LoginForm-title" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content rounded shadow border-0">
                                                <div class="modal-header">
												<p class="text-muted mb-0">Digital products can only be sent as a file via TutorHive</p>                                 
                                                    <button type="button" class="btn btn-icon btn-close" data-bs-dismiss="modal" id="close-modal"><i class="uil uil-times fs-4 " style="color:#FF0000;"></i></button>
													       
                                                </div>
                                            </div>
                                        </div>
                                    </div>
									<div class="modal fade" id="tooltip2" tabindex="-1" aria-labelledby="LoginForm-title" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content rounded shadow border-0">
                                                <div class="modal-header">
												<p class="text-muted mb-0">The number of the same product you are selling. Shows the buyers how many are available</p>                                 
                                                    <button type="button" class="btn btn-icon btn-close" data-bs-dismiss="modal" id="close-modal"><i class="uil uil-times fs-4 " style="color:#FF0000;"></i></button>
													       
                                                </div>
                                            </div>
                                        </div>
                                    </div>
									<div class="modal fade" id="tooltip3" tabindex="-1" aria-labelledby="LoginForm-title" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content rounded shadow border-0">
                                                <div class="modal-header">
												<p class="text-muted mb-0">Please describe the item you are selling</p>                                 
                                                    <button type="button" class="btn btn-icon btn-close" data-bs-dismiss="modal" id="close-modal"><i class="uil uil-times fs-4 " style="color:#FF0000;"></i></button>
													       
                                                </div>
                                            </div>
                                        </div>
                                    </div>
									<div class="modal fade" id="tooltip4" tabindex="-1" aria-labelledby="LoginForm-title" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content rounded shadow border-0">
                                                <div class="modal-header">
												<p class="text-muted mb-0">Please upload clear images of your product</p>                                 
                                                    <button type="button" class="btn btn-icon btn-close" data-bs-dismiss="modal" id="close-modal"><i class="uil uil-times fs-4 " style="color:#FF0000;"></i></button>
													       
                                                </div>
                                            </div>
                                        </div>
                                    </div>
									<div class="modal fade" id="tooltip5" tabindex="-1" aria-labelledby="LoginForm-title" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content rounded shadow border-0">
                                                <div class="modal-header">
												<p class="text-muted mb-0">Please add relevant tags to the item you are selling so buyers can search according to the tags. Example; Selling a maths book would have tags such as Book Maths MathsDegree, don't use # and special characters</p>                                 
                                                    <button type="button" class="btn btn-icon btn-close" data-bs-dismiss="modal" id="close-modal"><i class="uil uil-times fs-4 " style="color:#FF0000;"></i></button>
													       
                                                </div>
                                            </div>
                                        </div>
                                    </div>
									<div class="modal fade" id="tooltip6" tabindex="-1" aria-labelledby="LoginForm-title" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content rounded shadow border-0">
                                                <div class="modal-header">
												<p class="text-muted mb-0">Once you have added a product and clicked submit. Your item will be shown as in-active up until the TutorHive team has reviewed your product. Once reviewed, your product will go live and will be shown as active.</p>                                 
                                                    <button type="button" class="btn btn-icon btn-close" data-bs-dismiss="modal" id="close-modal"><i class="uil uil-times fs-4 " style="color:#FF0000;"></i></button>
													       
                                                </div>
                                            </div>
                                        </div>
                                    </div>
									 <script>
			  function selectimg(){
			  document.getElementById("upload_image").click();
			  }
			  </script>
<script>
$(document).ready(function(){
var $modal = $('#modal');
var image = document.getElementById('sample_image');
var cropper;
$('#upload_image').change(function(event){
var files = event.target.files;
var done = function(url){
image.src = url;
$modal.modal('show');
document.getElementById("closserrrr").click();
};
if(files && files.length > 0)
{
reader = new FileReader();
reader.onload = function(event)
{
done(reader.result);
};
reader.readAsDataURL(files[0]);
}
});
$modal.on('shown.bs.modal', function() {
cropper = new Cropper(image, {
aspectRatio: 1,
viewMode: 3,
preview:'.preview'
});
}).on('hidden.bs.modal', function(){
cropper.destroy();
cropper = null;
});
$('#crop').click(function(){
canvas = cropper.getCroppedCanvas({
			width:400,
			height:550
		});
canvas.toBlob(function(blob){
	url = URL.createObjectURL(blob);
   var reader = new FileReader();
	reader.readAsDataURL(blob);
	reader.onloadend = function(){
	var base64data = reader.result;
	//alert(base64data);
	document.getElementById("incloseeeee").click();
	
				$.ajax({
					url:'upload_image.php',
					method:'POST',
					data:{image:base64data},
					success:function(data)
					{ 
					  // alert(data);
		                $('#geteresult1').html(data);	
						document.getElementById("closeid").style.display = "block";
					}
				});
			};
		});
	});
	
});
</script>									
<script>
function Deleteimage(val){
//alert(val);
 if(confirm("Are you sure want to delete this Image ?"))
{
var imageval = $('#imageval').val();
 var dataString33 = 'dectionid='+ val +'&imageval='+imageval;
 // alert(dataString33);
$.ajax
		({
		type: "POST",
		url: "ajax_deleteimagesp.php",
		data: dataString33,
		cache: false,
		success: function(html)
		{
		//alert(html);
		$('#geteresult1').html(html);	
		}
});
}
} 
</script>									
									
      <script>
	  function showUser2(val){
   // alert(val);
if(val=="Physical"){
 document.getElementById("digilet").style.display = "block";
}else {
    document.getElementById("digilet").style.display = "none";
  
}
	var dataString = 'cat_id='+ val;
//	alert(dataString);
	$.ajax
		({
		type: "POST",
		url: "ajax_getsuncategory.php",
		data: dataString,
		cache: false,
		success: function(data)
		{
		//alert(data)
		$("#subdetsils").html(data);
		}
			});
}
	  </script>
	   <script>
function ADDtags(){
var tags = $('#tags').val();
var tagval = $('#tagval').val();

  if(tags==""){
      alert("Please enter Tag");
      subject.focus();
        return false;
  }
  var dataString22 = 'tags='+ tags +'&tagval='+tagval ;
  //alert(dataString22);
$.ajax
		({
		type: "POST",
		url: "ajax_addtagprod.php",
		data: dataString22,
		cache: false,
		success: function(html)
		{
		//alert(html)
		 document.getElementById("tags").value = "";
		$('#geteresult').html(html);	
		}
});
}
</script>
<script>
function Deleteeduct(val){
//alert(val);
 if(confirm("Are you sure want to delete this Tag ?"))
{
var tagval = $('#tagval').val();
 var dataString33 = 'dectionid='+ val +'&tagval='+tagval;
 // alert(dataString22);
$.ajax
		({
		type: "POST",
		url: "ajax_deletetags.php",
		data: dataString33,
		cache: false,
		success: function(html)
		{
		//alert(html)
		 document.getElementById("tags").value = "";
		$('#geteresult').html(html);	
		}
});
}
} 
</script>


<script language="javascript">
function validate1(){
var cat_id = $('#cat_id').val(); 
var typeofproduct = $('#typeofproduct').val();
var sub_cat_name = $('#sub_cat_name').val();
var productname = $('#productname').val(); 
var productprice = $('#productprice').val();
var tracking = $('#tracking').val();
var productprice1 = $('#productprice1').val(); 
var Quantity = $('#Quantity').val();
var shortdesc = $('#shortdesc').val();
var description = $('#description').val();
var countimga = $('#countimga').val();

var tags = $('#tags').val();
if(cat_id==""){
alert("Please select category");
cat_id.focus();
return false; 
}
if(typeofproduct==""){
alert("Please select Product Type");
typeofproduct.focus();
return false; 
}
if(sub_cat_name=="" || sub_cat_name=="0"){
alert("Please select Condition for Physical");
sub_cat_name.focus();
return false; 
}
if(productname==""){
alert("Please Enter Product Name");
productname.focus();
return false; 
}
if(productprice==""){
alert("Please Enter Product Price ");
productprice.focus();
return false; 
}
if(typeofproduct=="Physical"){
if(tracking==""){
alert("Please select Tracking");
tracking.focus();
return false; 
}
if(productprice1==""){
alert("Please Enter Postage cost");
productprice1.focus();
return false; 
}
}
if(Quantity==""){
alert("Please Enter Quantity");
Quantity.focus();
return false; 
}
if(shortdesc==""){
alert("Please enter short description");
shortdesc.focus();
return false; 
}
if(description==""){
alert("Please enter description");
description.focus();
return false; 
}
if(countimga<1){
alert("Please add minimum one image");
countimga.focus();
return false; 
}
document.getElementById("submit").click();
}
</script>

<script type="text/javascript">
    $(function () {
        $("#shortdesc").keypress(function (e) {
            var keyCode = e.keyCode || e.which;
 
            $("#Message").html("");
 
            //Regex for Valid Characters i.e. Alphabets and Numbers.
            var regex = /^[A-Za-z0-9&£!@., ]+$/;
 
            //Validate TextBox value against the Regex.
            var isValid = regex.test(String.fromCharCode(keyCode));
            if (!isValid) {
                $("#Message").html("Only Only & £ ! @, Alphabets and Numbers allowed.");
            }
 
            return isValid;
        });
    });
</script>

<script type="text/javascript">
    $(function () {
        $("#description").keypress(function (e) {
            var keyCode = e.keyCode || e.which;
 
            $("#Message1").html("");
 
            //Regex for Valid Characters i.e. Alphabets and Numbers.
            var regex = /^[A-Za-z0-9&£!@., ]+$/;
 
            //Validate TextBox value against the Regex.
            var isValid = regex.test(String.fromCharCode(keyCode));
            if (!isValid) {
                $("#Message1").html("Only & £ ! @ , Alphabets and Numbers allowed.");
            }
 
            return isValid;
        });
    });
</script>
    </body>

</html>
<?php mysqli_close($tutor_db);?>