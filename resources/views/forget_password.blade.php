<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Reset Password</title>

  <!-- Tell the browser to be responsive to screen width -->

  <meta name="viewport" content="width=device-width, initial-scale=1">
<!-- /.login-box -->
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<!------ Include the above in your HEAD tag ---------->
<style type="text/css">
  
</style>
</head>
<body style="background-color: #f1f1f1;">

 <div class="form-gap"></div>
<div class="container" >
  <div class="row">
    <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default">
              <div class="panel-body">
                <div class="text-center">
                  <h3><i class="fa fa-lock fa-4x"></i></h3>
                  <h2 class="text-center">Forgot Password?</h2>
                  <p>You can reset your password here.</p>
                  <div class="panel-body">
                     <?php
                     $email=$_GET['email'];
                     ?>
                   <form id="contact_us" action="javascript:void(0)"  method="POST">
                   {{csrf_field()}}
                    <input type="hidden" name="_method" value="PATCH">
                      <div class="form-group">
                        <div class="input-group">
                          <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                          <input id="email" name="email" placeholder="email address" class="form-control" value="{{$email}}"  type="email">
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="input-group">
                          <span class="input-group-addon"><i class="fa fa-lock color-blue"></i></span>
                          <input id="password" name="password" placeholder="New Password" class="form-control"  type="password">
                        </div>
                      </div>
                      <div class="form-group">
                        <button type="submit"  id="send_form" name="{{$email}}" class="btn btn-primary btn-block" data-dismiss="modal">Update password</button>
                      </div>
        
                    </form>
    
                  </div>
                </div>
              </div>
            </div>
          </div>
  </div>
</div>
 <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
  <!-- Template Main JS File -->
  <script src="/elitemaker_updated/files/resources/views/assets/js/main.js"></script>
<script type="text/javascript">
  //-----------------
$(document).ready(function(){
$('#send_form').click(function(e){
 

$('#send_form').html('<i class="fa fa-circle-o-notch fa-spin"></i> Please wait..');

$.ajaxSetup({
headers: {
'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
}
});

e.preventDefault();
var form = document.forms.namedItem("contact_us"); // high importance!, here you need change "yourformname" with the name of yourform
var formData = new FormData(form); // high importance!
var id = $(this).attr('name');

$.ajax({
url: "{{ URL::to('/api/update_password/','') }}/"+parseInt(id),
method: 'post',
data: formData,
dataType: "json", // or html if you want...
contentType: false, // high importance!
processData: false, // high importance!
success: function(result){

$('#send_form').html('Update password');
if(result.status){

$('#res_message').html(result.msg);
toastr.success('Password Updated Successfully');
  document.getElementById("password").reset(); 

}else{
$('#res_message').html(result.msg);
toastr.error('Something Went Wrong! Please try again');
}

}});
});
});   
 

</script>
</body>
</html>
