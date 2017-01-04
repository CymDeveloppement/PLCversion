<?php
require('func.inc/func.php');


?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>PlCversion 0.0.1 - Alpha</title>

    <!-- Bootstrap core CSS -->
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/font-awesome/css/font-awesome.min.css">
    <!-- Custom styles for this template -->
    <link href="dashboard.css" rel="stylesheet">
  </head>

  <body>




    <nav class="navbar navbar-dark bg-primary navbar-fixed-top">
      <button class="navbar-toggler hidden-lg-up" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"></button>
      <a class="navbar-brand" href="#">PLCversion / <?php echo $user['customer']; ?></a>
      <div class="collapse navbar-toggleable-md" id="navbarResponsive">
        
        <ul class="nav navbar-nav">
          <li class="nav-item active">
            <a class="nav-link" href="#">Programmes</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Tickets</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Ajouter des documents</a>
          </li>
        </ul>
        <form class="form-inline float-lg-right">
          <input class="form-control" type="text" placeholder="Rechercher">
          <i class="fa fa-user-circle fa-lg"></i> <?php echo $user['ID']; ?>
        </form>

      </div>
    </nav>

    <div class="container-fluid" style="margin-top: 30px;">
      <div class="row">
        <div class="col-md-2">

        </div>
        <div class="col-md-8">
          <h1>Liste des programmes</h1>

          <div id="programmList">
          <?php dispProgrammBadge(); ?>
            





        </div>
      </div>
    </div>


    <div class="modal fade" id="modalList">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title" id="modalListTitle"></h4>
          </div>
          <div class="modal-body">
            <p id="modalListContent"></p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


    <!-- Modal -->
    <div class="modal fade" id="modalReadChangelog" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title" id="modalchangelogtitle">Modal title</h4>
          </div>
          <div class="modal-body">
            <p id="modalreadchangelog"></p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="../jquery.min.js"></script>
    
    <script>window.jQuery || document.write('<script src="../jquery.min.js"><\/script>')</script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <script src="controller.js"></script>
  </body>
</html>
