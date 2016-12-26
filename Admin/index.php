<?php



  ini_set('display_errors', true);
  ini_set('html_errors', false);
  ini_set('display_startup_errors',true);     
  ini_set('log_errors', false);
  ini_set('error_prepend_string','<span style="color: red;">');
  ini_set('error_append_string','<br /></span>');
  ini_set('ignore_repeated_errors', false);
require('func.admin.php');

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

    <title>PlCversion Administration 0.0.1 - Alpha</title>

    <!-- Bootstrap core CSS -->
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/jquery.fileupload.css">
    <link rel="stylesheet" href="../css/font-awesome/css/font-awesome.min.css">
    <!-- Custom styles for this template -->
    <link href="dashboard.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
  </head>

  <body>

    <nav class="navbar navbar-dark navbar-fixed-top bg-inverse">
      <button type="button" class="navbar-toggler hidden-sm-up" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar" aria-label="Toggle navigation"></button>
      <a class="navbar-brand" href="#">PLCversion</a>
      <div id="navbar">
        <nav class="nav navbar-nav float-xs-left">
          <a class="nav-item nav-link" href="#" onclick="dispProgramm();">Programme</a>
          <a class="nav-item nav-link" href="#" onclick="dispTicket();">Ticket</a>
          <a class="nav-item nav-link" href="#" onclick="dispUser();">Utilisateur</a>
        </nav>
        <form class="float-xs-right">
          <input type="text" class="form-control" placeholder="Search...">
        </form>
      </div>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
            <li><a href="#" data-toggle="modal" data-target="#modalnewfolder">Ajouter un dossier</a></li>
            <li><a href="#" data-toggle="modal" data-target="#modalnewcustomer">Ajouter un client</a></li>
            <li><a href="#" data-toggle="modal" data-target="#modalnewprogramm">Upload</a></li>
          </ul>
        </div>
        <div class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 main">
        <?php echo ini_get('upload_max_filesize'), ", " , ini_get('post_max_size'), ", ", ini_get('memory_limit'); ?>
          <div id="programm">
            <h2>Programmes</h2>
            <hr>
            <div id="programmlistContent">
            <?php
              dispProgrammList();
            ?>
            </div>
           
          </div>
          <div id="ticket">
            <h2>Ticket</h2>
            <a class="btn btn-default btn-sm" href="#"><i class="fa fa-cloud-download"></i></a>
          </div>

        </div>
      </div>
    </div>



    <!-- /.modal ajouter un client -->
    <div class="modal fade" id="modalnewcustomer">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title">Ajouter un Client</h4>
          </div>
          <div class="modal-body">
            <p>
              <div class="alert alert-danger" id="nameCusError" role="alert" style="display: none;">
                <strong>Ce nom n'est pas correcte!</strong>
              </div>
               <div class="alert alert-danger" id="nameCusErrorAjax" role="alert" style="display: none;">
                <strong>ERREUR!</strong><br>
                <small id="nameCusErrorAjaxContent"></small>
              </div>
              <div class="alert alert-success" id="nameCusValidAjax" role="alert" style="display: none;">
                <strong>Le client a été ajouté!</strong>
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">Nom du client</label>
                <input type="text" class="form-control" id="customername" aria-describedby="nameHelp" placeholder="...">
                <small id="nameHelp" class="form-text text-muted">Les espaces seront remplacé par des _.</small>
              </div>
            </p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
            <button type="button" class="btn btn-primary" onclick="addCustomer();">Enregistrer</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!-- /.modal ajouter un dossier -->
    <div class="modal fade" id="modalnewfolder">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title">Ajouter un Dossier</h4>
          </div>
          <div class="modal-body">
            <p>

              <div class="alert alert-danger" id="nameFolError" role="alert" style="display: none;">
                <strong>Ce nom n'est pas correcte!</strong>
              </div>
              <div class="alert alert-danger" id="selecFolError" role="alert" style="display: none;">
                <strong>Vous devez choisir un client!</strong>
              </div>
               <div class="alert alert-danger" id="nameFolErrorAjax" role="alert" style="display: none;">
                <strong>ERREUR!</strong><br>
                <small id="nameFolErrorAjaxContent"></small>
              </div>
              <div class="alert alert-success" id="nameFolValidAjax" role="alert" style="display: none;">
                <strong>Le dossier a été ajouté!</strong>
              </div>


              <input type="hidden" name="customerSelect" id="selectCustomer">
              <div class="btn-group">
                <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="selectCustomerDisp">
                  Choisissez un Client
                </button>
                <div class="dropdown-menu" id="customerlist">
                </div>
              </div>
              <br>
                <div class="form-group">
                  <label for="exampleInputEmail1">Nom du dossier</label>
                  <input type="text" class="form-control" id="foldername" aria-describedby="folderHelp" placeholder="...">
                  <small id="folderHelp" class="form-text text-muted">Les espaces seront remplacé par des _.</small>
                </div>
            </p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
            <button type="button" class="btn btn-primary" onclick="addFolder();">Enregistrer</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


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

   <?php include('addProgramm.php'); ?>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    
    <script src="../jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../jquery.min.js"><\/script>')</script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <script src="../js/vendor/jquery.ui.widget.js"></script>
    <script src="../js/jquery.iframe-transport.js"></script>
    <script src="../js/jquery.fileupload.js"></script>
    <script src="controller.js"></script>
  </body>
</html>
