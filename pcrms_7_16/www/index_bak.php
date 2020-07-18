<?php require_once("connection.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>PCRMs</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <style>
    ul.timeline {
      list-style-type: none;
      position: relative;
    }
    ul.timeline:before {
      content: ' ';
      background: #d4d9df;
      display: inline-block;
      position: absolute;
      left: 29px;
      width: 2px;
      height: 100%;
      z-index: 400;
    }
    ul.timeline > li {
      margin: 20px 0;
      padding-left: 20px;
    }
    ul.timeline > li:before {
      content: ' ';
      background: white;
      display: inline-block;
      position: absolute;
      border-radius: 50%;
      border: 3px solid #22c0e8;
      left: 20px;
      width: 20px;
      height: 20px;
      z-index: 400;
    } 
  </style>
</head>

<body class="d-flex flex-column min-vh-100">

  <nav class="navbar py-1 navbar-expand-sm bg-light fixed-top">
		<a class="navbar-brand" href="">
		<img src="/images/UNCC.png" class="rounded" alt="Logo" style="width:80px">
		</a>
		<ul class="nav nav-pills">
		<li class="nav-item">
			<a class="nav-link active" href="index.php"><i class="fa fa-home" style="font-size:20px"></i>Home</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="browse_dataset.php"><i class="fa fa-list-alt" style="font-size:20px"></i>Browse Database</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="detailed_search.php"><i class="fa fa-search" style="font-size:20px"></i>Detailed Search</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="download_data.php"><i class="fa fa-download" style="font-size:20px"></i>Download Data</a>
		</li>

		<li class="nav-item">
			<a class="nav-link" href="https://sulab.uncc.edu/zhengchang-su-phd"><i class="fa fa-flask" style="font-size:20px"></i>Su Lab</a>
		</li>
		</ul>
  </nav>


  <div class="jumbotron bg-gray jumbotron-fluid">
    <div class="container">
      <h1 style="text-align: center">Welcome to PCRMs Database</h1>
      <h3>The PCRMs(Predicted cis-regulatory modules) holds de novo predicted CRMs.</h3>
    </div>
  </div>

  <div class='container'>
    <div class="row">
      <div class="col">
      <h4>Latest News</h4>  
          <ul class="timeline">
              <li>
                <a target="_blank" href="https://www.totoprayogo.com/#">Submit to CCI helper</a>
                <a href="#" class="float-right">22 June, 2020</a>
                <p>The web have submitted to CCI helper for checking</p>
              </li>
              <li>
                <a href="#">Bug fix</a>
                <a href="#" class="float-right">21 June, 2020</a>
                <p>Fix some null matched umotifs</p>
              </li>
              <li>
                <a href="#">First version release</a>
                <a href="#" class="float-right">20 June, 2020</a>
                <p>First version of DePCRMSv2 is finished</p>
              </li>
          </ul>      
      </div>

      <div class="col">
      <div id="demo" class="carousel slide" data-ride="carousel">    
        <!-- Indicators -->
        <ul class="carousel-indicators">
          <li data-target="#demo" data-slide-to="0" class="active"></li>
          <li data-target="#demo" data-slide-to="1"></li>
          <li data-target="#demo" data-slide-to="2"></li>
          <li data-target="#demo" data-slide-to="3"></li>
        </ul>
        
        <!-- The slideshow -->
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="/images/home.png" alt="Home" width="550" height="250">
          </div>
          <div class="carousel-item">
            <img src="/images/browse.png" alt="Browse" width="550" height="250">
          </div>
          <div class="carousel-item">
            <img src="/images/detail.png" alt="Detail" width="550" height="250">
          </div>

          <div class="carousel-item">
            <img src="/images/download.png" alt="Download" width="550" height="250">
          </div>
        </div>
        
        <!-- Left and right controls -->
        <a class="carousel-control-prev" href="#demo" data-slide="prev">
          <span class="carousel-control-prev-icon"></span>
        </a>
        <a class="carousel-control-next" href="#demo" data-slide="next">
          <span class="carousel-control-next-icon"></span>
        </a>
      </div>
      </div>    
    </div>  
  </div>

  <div class="wrapper flex-grow-1"></div>
	<footer class="page-footer font-small blue">
		<!-- Copyright -->
		<div class="footer-copyright text-center py-3">© Copyright 2020:
		<a href="https://sulab.uncc.edu/zhengchang-su-phd"> Sulab at UNC at Charoltte</a>
		</div>
		<!-- Copyright -->
	</footer>
</body>

</html> 

