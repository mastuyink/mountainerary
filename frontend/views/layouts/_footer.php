<?php 
use yii\helpers\Html;
?>
<!--footer start from here-->
<footer>
  <div class="container">
    <div class="row">
      <div class="col-md-3 col-sm-6 footer-col">
        <div class="logofooter"><?=Html::a(Html::img('/img/logo-white.png', ['id'=>'logo-footer','alt' => 'footer-logo']), Yii::$app->homeUrl, ['option' => 'value']); ?>
        </div>
        <p class="align-justify">Sketch out your itinerary based on preferred trip criteria. Hit us on email or whatsapp if you need any assistance with your itinerary planning.
Plan your holiday with Us</p>
        <p><i class="glyphicon glyphicon-map-marker"></i> Jl. Gersikan VI No. 9,Pacar Keling, Tambaksari,  Surabaya, 6013</p>
        <p><?= Html::a('<i class="fa fa-phone"></i> +6281382595239 (Click To Call)', 'tel:+6281382595239',['class'=>'hyperlink-footer',"data-toggle"=>"tooltip","title"=>"Phone Call"]); ?></p>
        <p><a class="hyperlink-footer" href="mailto:mountaineray@gmail.com" target="_top"><i class="glyphicon glyphicon-envelope"></i> mountaineray@gmail.com</a></p>
      </div>
      <div class="col-md-3 col-sm-6 footer-col">
        <h6 class="heading7">Related Links</h6>
        <ul class="footer-ul">
          <li><?= Html::a('About Us', ['/about-us']); ?></li>
          <li><?= Html::a('Contact us', ['/contact-us']); ?></li>
          
          
          
        </ul>
      </div>
      <div class="col-md-3 col-sm-6 footer-col">
        <h6 class="heading7">Popular Destination</h6>
        <div class="post footer-ul">
          <ul class="footer-ul">
            <li><?= Html::a('Mount Bromo', ['/package/mount-bromo']); ?></li>
            <li><?= Html::a('Mount Ijen', ['/package/mount-ijen']); ?></li>
         
        </div>
      </div>
     <!--  <div class="col-md-3 col-sm-6 footer-col">
        <h6 class="heading7">Follow Us</h6>
        <ul class="footer-social">
          <li><a target="_blank" href="https://www.facebook.com/Gilitransferscom/"><i class="fa fa-facebook social-icon facebook" aria-hidden="true"></i></a></li>
          <li><a target="_blank" href="https://www.youtube.com/channel/UC_NtnHWVkbECkOqAB-2tWcA"><i class="fa fa-youtube social-icon youtube" aria-hidden="true"></i></a></li>
          <li><a target="_blank" href="https://plus.google.com/114019474249953149637"><i class="fa fa-google-plus social-icon google" aria-hidden="true"></i></a></li>
        </ul>
      </div> -->
       <div class="col-md-3 col-sm-6 footer-col">
        <h6 class="heading7">Payment Channel</h6>
        <ul class="footer-social row font-39">
          <li class="col-xs-3" data-toggle="tooltip" title="Paypal"><i class="fa fa-cc-paypal"></i></li>
          <li class="col-xs-3" data-toggle="tooltip" title="Credit Card"><i class="fa fa-credit-card"></i></li>
          <li class="col-xs-3" data-toggle="tooltip" title="Visa"><i class="fa fa-cc-visa"></i></li>
          <li class="col-xs-3" data-toggle="tooltip" title="Master Card"><i class="fa fa-cc-mastercard"></i></li>
        </ul>
         <h6 class="heading7">Keep In Touch</h6>
        <ul class="footer-social row font-39">
          <li class="col-xs-3"><?= Html::a('<i class="fa fa-whatsapp"></i>', 'https://api.whatsapp.com/send?phone=6281382595239',['class'=>'hyperlink-footer',"data-toggle"=>"tooltip","title"=>"Whatsapp Direct Chat"]); ?></li>
          <li class="col-xs-3"><i class="fa fa-instagram"></i></li>
          <li class="col-xs-3"><i class="fa fa-facebook"></i></li>
        </ul>
      </div>
    </div>
  </div>
</footer>
<!--footer start from here-->


<?php
$this->registerCss("
#logo-footer{
     height: 65px;
     width: auto;
}
 .hyperlink-footer{
     color: #FAFAFA;
}
 .img-footer{
     padding-bottom: 10px;
}

 ul,li{
     padding:0;
     margin:0;
}
 li{
     list-style-type:none;
}
 .footer-col {
     margin-top:50px;
}
 .logofooter {
     margin-bottom:10px;
     font-size:25px;
     color:#fff;
     font-weight:700;
}
 .footer-col p {
     color:#fff;
     font-size:12px;
     margin-bottom:15px;
}
 .footer-col p i {
     width:20px;
     color:#fff;
}
 .footer-ul {
     list-style-type:none;
     padding-left:0;
     margin-left:2px;
}
 .footer-ul li {
     line-height:29px;
     font-size:12px;
}
 .footer-ul li a {
     color:#fff;
     transition: color 0.2s linear 0s, background 0.2s linear 0s;
}
 .footer-ul i {
     margin-right:10px;
}
 .footer-ul li a:hover {
    transition: color 0.2s linear 0s, background 0.2s linear 0s;
     color:#fff;
}

 .heading7 {
     font-size:21px;
     font-weight:700;
     margin-bottom:22px;
}

  ");
?>