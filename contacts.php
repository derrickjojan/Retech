<?php include 'head.php'; ?>
<?php
if(isset($_POST['submit'])){


  $email = mysqli_real_escape_string($conn,$_POST['email']);
  $name=mysqli_real_escape_string($conn,$_POST['name']);
  $number=mysqli_real_escape_string($conn,$_POST['number']);
  $msg=mysqli_real_escape_string($conn,$_POST['msg']);

  $insert = mysqli_query($conn, "INSERT INTO `tbl_message` (msg_id, name, email, number, message) VALUES (generate_msg_id(),'$name', '$email', '$number', '$msg')") or die('query failed');
 
        if($insert){
          echo '<script>window.location.href = "contacts.php";</script>';
        }else{
           echo 'registeration failed!';
        }
}
?>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title>Contact Us</title>
    <style>


        @font-face {
        font-family: 'OstrichSansreg';
        src: url(fonts/OstrichSans-Heavy.otf);
      }

      @font-face {
        font-family: 'OstrichSans';
        src: url(fonts/OstrichSans-Bold.otf);
      }

      .container{
  overflow: none;
  padding-top: 30px;
  padding-bottom: 30px;


}
.details {
  clip-path: polygon(0 0, 0 calc(100% - 50px), 50px 100%, 100% 100%, 100% 50px,calc(100% - 50px) 0);
      border:3px #f9004d solid;
    padding-top: 20px;
    border-radius: 10px;
    position: relative;
    left:41vh;
    background-color: #f9004d; 
    font-family: OstrichSansreg;
    font-size: 30px;
    height: 850px;
    width: 900px;
}
.details h1 {
    color: #fff;
    text-align: center;
    font-size: 60px;
    margin-bottom: 20px;
}

.contact form{
  clip-path: polygon(0 0, 0 calc(100% - 30px), 30px 100%, 100% 100%, 100% 30px,calc(100% - 30px) 0);
   margin:0 auto;
   max-width: 110vh;;
   padding:2rem;
   text-align: center;
   background: #000;
   border-radius: 10px;
}

.contact form .box{
   width: 100%;
   padding:18px 20px;
   border: #fff solid;
   margin:1rem 0;
   background-color: #000;
   font-size: 30px;
   color: #fff;
}
.contact form .box:hover{
  border: #f9004d solid;
}
.contact form textarea{
   height: 200px;
   resize: none;
}
.btn {
  font-family: OstrichSansreg;
  color:  #f9004d;
  text-align: center;
  padding: 10px 100px;
  text-decoration: none;
  font-size: 30px;
  background-color: transparent;
  border-radius: 2px;
  border: 2px  #f9004d solid;
}
.btn:hover{
background-color: #fff;
}
video {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      object-fit: cover;
      z-index: -1;
    }
</style>
</head>
<body>
<video autoplay loop muted>
    <source src="vid2.mp4" type="video/mp4">
  </video>
    <div class="container">
    <section class="details">
      <div class="contact">

   <h1 class="title">get in touch</h1>

   <form action="" method="POST">
      <input type="text" name="name" class="box" required placeholder="enter your name">
      <input type="email" name="email" class="box" required placeholder="enter your email">
      <input type="tel" name="number" maxlength="10" class="box" required placeholder="enter your number">
      <textarea name="msg" class="box" required placeholder="enter your message" cols="30" rows="10"></textarea>
      <input type="submit" value="send message" class="btn" name="submit">

   </form>
</div>
    </section>
</div>
    <?php include 'footer.php'; ?>
</body>
</html>
