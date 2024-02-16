<?php include 'head.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>About Us</title>
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
      border:3px #fff solid;
    padding-top: 20px;
    border-radius: 40px;
    background-color: rgba(0, 0, 0, 0.98); 
    font-family: OstrichSansreg;
    font-size: 30px;
    margin: 20px;
}
.content h1 {
    color: #f9004d;
    text-align: center;
    font-size: 40px;
    margin-bottom: 20px;
}

.content p {
  position: relative; 
  left:190px;
  max-width: 150vh;
  text-align: center;
  font-size: 25px;
    margin-bottom: 30px;
}
.ship, .fast{
    border-top: 3px #fff solid;
    border-radius: 10px;
}

.ship h1 {
    position:relative;
    bottom:170px;
    left:20px;
  width:130vh;
  font-size: 40px;
    color: #f9004d;
}
.ship p {
    position:absolute;
    bottom:50px;
    left:430px;
  width:130vh;
  font-size: 25px;
}
.ship img {
  position: relative; 
  left:150px;
  top:10px;
  max-width: 150vh;
  font-size: 25px;
  margin-top:30px;

}
.fast h1 {
    position:relative;
    bottom:170px;
    right:190px;
  width:130vh;
  font-size: 40px;
    color: #f9004d;
}
.fast p {
    position:absolute;
    bottom:-220px;
    left:180px;
  width:130vh;
  text-align: left;
  font-size: 25px;
}
.fast img {
  position: relative; 
  left:150vh;
  top:10px;
  max-width: 150vh;
  font-size: 25px;
  margin-top:30px;

}
.best{
    max-height: 300px;
    border-top: 3px #fff solid;
    border-radius: 10px;
}
.best h1 {
    position:relative;
    bottom:170px;
    left:20px;
  width:130vh;
  font-size: 40px;
    color: #f9004d;
}
.best p {
    text-align: left;
    position:relative;
    bottom:175px;
    left:390px;
  width:130vh;
  font-size: 25px;
}
.best img {
  position: relative; 
  left:120px;
  max-width: 150vh;
  font-size: 25px;
  margin-top:30px;

}
</style>
</head>
<body background="pic3.png">
    <div class="container">
    <section class="details">
        <div class="content">
            <h1>About Us</h1>
            <p>If you love tech, you’ll love the Retech Store!</p>
            <p>We’ve got thousands of devices including the latest tech, certified refurbished to the best possible standard. Plus, our cell phones, tablets, games consoles and MacBooks are all at amazing prices so you save on cost but not quality!</p>
            <p>Why shop with the Retech Store?</p>
            <div class="ship">
            <img src="free2.png" width="200" height="200">
            <h1>FREE Shipping!</h1>
            <p>
            At Retch, we understand the hassle of shipping costs, which is why we're delighted to provide you with a fantastic perk: FREE shipping on every order.
             enjoy the convenience of no shipping fees and a smooth, worry-free process.</p>
            </div>
            <div class="fast">
            <img src="fast.png" width="200" height="200">
            <h1>Fast & Free Process</h1>
            <p>
            At Retech, we value your time. Our Fast & Free Process ensures that whether you're selling your pre-Owned electronics or buying from us,
            No unnecessary delays, no hidden charges.</p>
            </div>
            <div class="best">
            <img src="best.png" width="230" height="200">
            <h1>Get the Best Price</h1>
            <p>
            Discover unbeatable value with us. Our commitment to offering you the best price ensures that every buying and selling experience is a rewarding one,
            leaving you satisfied and delighted.</p>
            </div>
        </div>
    </section>
</div>
    <?php include 'footer.php'; ?>
</body>
</html>
