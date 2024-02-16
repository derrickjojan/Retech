<html>
<html>
    <head>
        <title>cyberpunk css</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
        <style>
    @font-face {
        font-family: 'OstrichSansreg';
        src: url(fonts/OstrichSans-Heavy.otf);
      }

      @font-face {
        font-family: 'OstrichSans';
        src: url(fonts/OstrichSans-Bold.otf);
      }
*{
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}
body{
  color: #fff;
  margin: 0;
}
*::-webkit-scrollbar{
   height: .5rem;
   width: 10px;
}

*::-webkit-scrollbar-track{
   background-color: rgba(17, 11, 28, 0.9);
}

*::-webkit-scrollbar-thumb{
   background-color: black;
}

.footer{
   position: relative;
   background-color: #f9004d;
}
.footer .box-container{

   display: flex;
   flex-wrap: wrap;
  justify-content: center;
  padding-top: 20px;
}

.boxx {
  width: 350px;
  height: 280px;
  text-align: center;
}

.footer .box-container h3{
  font-family: OstrichSansreg;
   text-transform: uppercase;
   color:#000;
   margin-bottom: 10px;
   font-size: 40px;
}

.footer .box-container a,
.footer .box-container p{
  font-family: OstrichSansreg;
  text-decoration: none;
   display: block;
   padding: 10px;
   font-size:25px;
   color:#fff;
}

.footer .box-container a i,
.footer .box-container  p i{
   color:#000;
   padding-right: 10px;
}

.footer .credit{
  font-family: OstrichSansreg;
  border-top: #fff solid;
  padding-top: 20px;
   padding-bottom: 25px;
   text-align: center;
   font-size: 25px;
   color: #000;
}
.cyber-razor-top
{
    margin-top: 30px;
    position: relative;
}


.cyber-razor-top:before
{
    content: " ";
    background-color: var(--bg);
    -webkit-mask-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="1920px" height="40px"><path d="M1827.156,15.021 L1827.129,14.994 L1833.785,14.994 L1833.759,15.021 L1827.156,15.021 ZM1824.965,24.036 L1835.969,24.036 L1830.461,18.558 L1833.759,15.021 L1920.000,15.021 L1920.000,39.075 L0.001,39.075 L0.001,15.013 L271.884,15.013 L279.537,6.930 L292.458,6.930 L308.426,24.036 L308.449,24.013 L308.467,24.036 L317.638,15.021 L463.241,15.021 L466.539,18.558 L461.031,24.036 L472.035,24.036 L466.539,18.558 L469.844,15.021 L551.557,15.021 L556.251,10.578 L565.497,1.358 L571.663,7.066 L602.910,7.055 L607.919,7.055 L620.578,19.983 L654.209,19.983 L661.448,12.957 L735.709,12.995 L741.480,18.554 L750.129,9.930 L753.020,12.995 L918.181,12.957 L930.942,0.066 L954.993,24.036 L955.000,24.024 L955.012,24.036 L964.064,15.013 L967.906,15.013 L970.005,17.106 L966.670,20.419 L973.326,20.419 L970.005,17.106 L972.067,15.055 L1050.000,15.023 L1050.000,15.013 L1064.030,15.017 L1072.000,15.013 L1072.000,15.019 L1225.933,15.055 L1227.994,17.106 L1224.674,20.419 L1231.331,20.419 L1227.994,17.106 L1230.094,15.013 L1233.936,15.013 L1242.989,24.036 L1243.000,24.024 L1243.007,24.036 L1267.058,0.066 L1279.819,12.957 L1368.980,12.995 L1371.871,9.930 L1380.520,18.554 L1386.290,13.057 L1635.552,13.019 L1642.790,19.983 L1676.422,19.983 L1689.080,6.992 L1725.337,7.003 L1731.502,1.358 L1740.749,10.578 L1745.443,15.021 L1827.156,15.021 L1830.461,18.558 L1824.965,24.036 ZM341.624,18.857 L339.889,18.857 L339.889,24.036 L341.624,24.036 L341.624,18.857 ZM344.248,18.857 L342.518,18.857 L342.518,24.036 L344.248,24.036 L344.248,18.857 ZM356.370,18.857 L354.640,18.857 L354.640,24.036 L356.370,24.036 L356.370,18.857 ZM377.168,18.857 L371.973,18.857 L371.973,24.036 L377.168,24.036 L377.168,18.857 ZM584.675,12.348 L582.941,12.348 L582.941,14.073 L584.675,14.073 L584.675,12.348 ZM591.316,12.348 L589.582,12.348 L589.582,17.526 L591.316,17.526 L591.316,12.348 ZM604.751,12.348 L603.017,12.348 L603.017,14.073 L604.751,14.073 L604.751,12.348 ZM604.751,15.802 L603.017,15.802 L603.017,17.526 L604.751,17.526 L604.751,15.802 ZM1693.983,12.348 L1692.249,12.348 L1692.249,14.073 L1693.983,14.073 L1693.983,12.348 ZM1693.983,15.802 L1692.249,15.802 L1692.249,17.526 L1693.983,17.526 L1693.983,15.802 ZM1707.418,12.348 L1705.683,12.348 L1705.683,17.526 L1707.418,17.526 L1707.418,12.348 ZM1714.059,12.348 L1712.324,12.348 L1712.324,14.073 L1714.059,14.073 L1714.059,12.348 ZM463.214,14.994 L469.871,14.994 L469.844,15.021 L463.241,15.021 L463.214,14.994 ZM754.222,5.976 L750.129,9.930 L746.025,5.976 L754.222,5.976 ZM1375.975,5.976 L1371.871,9.930 L1367.778,5.976 L1375.975,5.976 Z"/></svg>');
    -webkit-mask-repeat: repeat-x;
    -webkit-mask-position: top;
    mask-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="1920px" height="40px"><path d="M1827.156,15.021 L1827.129,14.994 L1833.785,14.994 L1833.759,15.021 L1827.156,15.021 ZM1824.965,24.036 L1835.969,24.036 L1830.461,18.558 L1833.759,15.021 L1920.000,15.021 L1920.000,39.075 L0.001,39.075 L0.001,15.013 L271.884,15.013 L279.537,6.930 L292.458,6.930 L308.426,24.036 L308.449,24.013 L308.467,24.036 L317.638,15.021 L463.241,15.021 L466.539,18.558 L461.031,24.036 L472.035,24.036 L466.539,18.558 L469.844,15.021 L551.557,15.021 L556.251,10.578 L565.497,1.358 L571.663,7.066 L602.910,7.055 L607.919,7.055 L620.578,19.983 L654.209,19.983 L661.448,12.957 L735.709,12.995 L741.480,18.554 L750.129,9.930 L753.020,12.995 L918.181,12.957 L930.942,0.066 L954.993,24.036 L955.000,24.024 L955.012,24.036 L964.064,15.013 L967.906,15.013 L970.005,17.106 L966.670,20.419 L973.326,20.419 L970.005,17.106 L972.067,15.055 L1050.000,15.023 L1050.000,15.013 L1064.030,15.017 L1072.000,15.013 L1072.000,15.019 L1225.933,15.055 L1227.994,17.106 L1224.674,20.419 L1231.331,20.419 L1227.994,17.106 L1230.094,15.013 L1233.936,15.013 L1242.989,24.036 L1243.000,24.024 L1243.007,24.036 L1267.058,0.066 L1279.819,12.957 L1368.980,12.995 L1371.871,9.930 L1380.520,18.554 L1386.290,13.057 L1635.552,13.019 L1642.790,19.983 L1676.422,19.983 L1689.080,6.992 L1725.337,7.003 L1731.502,1.358 L1740.749,10.578 L1745.443,15.021 L1827.156,15.021 L1830.461,18.558 L1824.965,24.036 ZM341.624,18.857 L339.889,18.857 L339.889,24.036 L341.624,24.036 L341.624,18.857 ZM344.248,18.857 L342.518,18.857 L342.518,24.036 L344.248,24.036 L344.248,18.857 ZM356.370,18.857 L354.640,18.857 L354.640,24.036 L356.370,24.036 L356.370,18.857 ZM377.168,18.857 L371.973,18.857 L371.973,24.036 L377.168,24.036 L377.168,18.857 ZM584.675,12.348 L582.941,12.348 L582.941,14.073 L584.675,14.073 L584.675,12.348 ZM591.316,12.348 L589.582,12.348 L589.582,17.526 L591.316,17.526 L591.316,12.348 ZM604.751,12.348 L603.017,12.348 L603.017,14.073 L604.751,14.073 L604.751,12.348 ZM604.751,15.802 L603.017,15.802 L603.017,17.526 L604.751,17.526 L604.751,15.802 ZM1693.983,12.348 L1692.249,12.348 L1692.249,14.073 L1693.983,14.073 L1693.983,12.348 ZM1693.983,15.802 L1692.249,15.802 L1692.249,17.526 L1693.983,17.526 L1693.983,15.802 ZM1707.418,12.348 L1705.683,12.348 L1705.683,17.526 L1707.418,17.526 L1707.418,12.348 ZM1714.059,12.348 L1712.324,12.348 L1712.324,14.073 L1714.059,14.073 L1714.059,12.348 ZM463.214,14.994 L469.871,14.994 L469.844,15.021 L463.241,15.021 L463.214,14.994 ZM754.222,5.976 L750.129,9.930 L746.025,5.976 L754.222,5.976 ZM1375.975,5.976 L1371.871,9.930 L1367.778,5.976 L1375.975,5.976 Z"/></svg>');
    mask-repeat: repeat-x;
    mask-position: top;
    position: absolute;
    left: 0;
    top: -30px;
    width: 100%;
    height: 30px;
    z-index: 1;
}
:root 
{
    --root-font-size: 18px;

    --yellow: #f8ef02;
    --cyan: #00ffd2;
    --red: #ff003c;
    --blue: #136377;
    --green: #446d44;
    --purple: purple;
    --black: #000;
    --white: #fff;
    --dark: #333;
}
.bg-red { --bg: #f9004d; background-color: #f9004d; }

</style>
    </head>

    <body>
    <div class="cyber-razor-top bg-red">
<footer class="footer">
   <section class="box-container">
      <div class="boxx">
         <h3>quick links</h3>
         <a href="home.php"> <i class="fas fa-angle-right"></i> home</a>
         <a href="product.php"> <i class="fas fa-angle-right"></i> shop</a>
         <a href="about.php"> <i class="fas fa-angle-right"></i> about</a>
         <a href="contacts.php"> <i class="fas fa-angle-right"></i> contact</a>
      </div>
      <div class="boxx">
         <h3>extra links</h3>
         <a href="cart.php"> <i class="fas fa-angle-right"></i> cart</a>
         <a href="login.php"> <i class="fas fa-angle-right"></i> login</a>
         <a href="register.php"> <i class="fas fa-angle-right"></i> register</a>
      </div>
      <div class="boxx">
         <h3>contact info</h3>
         <p> <i class="fas fa-phone"></i> +123-456-7890 </p>
         <p> <i class="fas fa-phone"></i> +111-222-3333 </p>
         <p> <i class="fas fa-envelope"></i> Retech@gmail.com </p>
         <p> <i class="fas fa-map-marker-alt"></i> Kochi India - 682001 </p>
      </div>
      <div class="boxx">
         <h3>follow us</h3>
         <a> <i class="fab fa-facebook-f"></i> facebook </a>
         <a> <i class="fab fa-twitter"></i> twitter </a>
         <a> <i class="fab fa-instagram"></i> instagram </a>
         <a> <i class="fab fa-linkedin"></i> linkedin </a>
      </div>
   </section>
   <p class="credit"> &copy;  <?= date('Y'); ?> <spp>Retech,</spp>  all rights reserved! </p>
</footer>
</div>
                    </body>
</html>