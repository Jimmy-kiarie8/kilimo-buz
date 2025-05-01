	<link href="bootstrap-modal-carousel.css" rel="stylesheet" />

<script src="bootstrap-modal-carousel.js"/></script/>


<div id="myCarousel" class="carousel slide carousel-fit" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
    <?php foreach($photos as $photo):?>
    <li data-target="#myCarousel" data-slide-to="{{$photo->id}}"></li>
     <?php endforeach;?>
  </ol>

  <!-- Wrapper for slides -->
  <div class="carousel-inner">
    <div class="item active">
      <img data-src="http://asdspmarketinfo.kilimo.go.ke/uploads/164008331220X.jpg" src="http://asdspmarketinfo.kilimo.go.ke/uploads/164008331220X.jpg" alt="First slide">
      
    </div>
     <?php foreach($photos as $photo):?>
    <div class="item">
       <img data-src="{{asset('uploads/'.$photo->filename)}}" src="{{asset('uploads/'.$photo->filename)}}" alt="First slide"  >
      
    </div>
     <?php endforeach;?>
   
  </div>

  <!-- Controls -->
  <a class="left carousel-control" href="#myCarousel" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left"></span>
  </a>
  <a class="right carousel-control" href="#myCarousel" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right"></span>
  </a>
</div>


