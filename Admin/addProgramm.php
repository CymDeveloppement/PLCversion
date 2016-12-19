<?php

?>

 <!-- /.modal ajouter un dossier -->
    <div class="modal fade" id="modalnewprogramm">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title">Ajouter un Programme</h4>
          </div>
          <div class="modal-body">
            <p>
            	<div class="row" id="selectfolderdiv">
            		<div class="col-md-4">
            			<input type="hidden" name="customerSelectAdd" id="selectCustomerAdd" onchange="refreshFolder();">
		              	<div class="btn-group btn-block">
		                	<button type="button" class="btn btn-block btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="selectCustomerAddDisp">
		                  Choisissez un Client
		                	</button>
		                	<div class="dropdown-menu btn-block" id="customerlistAdd">
		                	</div>
		              	</div>
            		</div>
            		<div class="col-md-4">
            			<input type="hidden" name="folderSelectAdd" id="selectfolderAdd">
		              	<div class="btn-group btn-block">
		                	<button type="button" class="btn btn-block btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="selectfolderAddDisp">
		                  Choisissez un Dossier
		                	</button>
		                	<div class="dropdown-menu btn-block" id="folderlistAdd">
		                	</div>
		              	</div>
            		</div>
                    <div class="col-md-4">
                        <input type="hidden" name="elemSelectAdd" id="selectelemAdd">
                        <div class="btn-group btn-block">
                            <button type="button" class="btn btn-block btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="selectelemAddDisp">
                          Choisissez un Element
                            </button>
                            <div class="dropdown-menu btn-block" id="elemlistAdd">
                                <a class="dropdown-item" href="#" onclick="selectElem('PLC');">Automate</a>
                                <a class="dropdown-item" href="#" onclick="selectElem('HMI');">Afficheur</a>
                                <a class="dropdown-item" href="#" onclick="selectElem('DOCS');">Documents</a>
                            </div>
                        </div>
                    </div>
            	</div>


                <div id="contentProgramm">
                	<hr>
                	<h5 id="currentversion"></h5>
                	<div class="row">
                		<div class="col-md-4">
                			<button type="button" class="btn btn-block btn-secondary" id="majorBtn" onclick="selectMajor();">Version Majeur</button>
                		</div>
                		<div class="col-md-4">
                			<button type="button" class="btn btn-block btn-primary" id="minorBtn" onclick="selectMinor();">Version Mineur</button>
                		</div>
                		<div class="col-md-4">
                			<button type="button" class="btn btn-block btn-secondary" id="correctBtn" onclick="selectCorrect();">Correction</button>
                		</div>
                	</div>
                	<hr>
                	<div class="row">
                		<div class="col-md-2"></div>
                		<div class="col-md-8">
                			<div class="input-group">
    						  <span class="input-group-addon">Version : </span>
    						  <input type="text" id="V1" class="form-control input-version" aria-label="">
    						  <span class="input-group-addon">.</span>
    						  <input type="text" id="V2" class="form-control input-version" aria-label="">
    						  <span class="input-group-addon">.</span>
    						  <input type="text" id="V3" class="form-control input-version" aria-label="">
                              <div class="input-group-btn">
                                    <button type="button" class="btn btn-secondary" id="stateV"></button>
                                    <button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                      <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="#" onclick="setstateV('F');">Production</a>
                                    <a class="dropdown-item" href="#" onclick="setstateV('A');">Alpha</a>
                                    <a class="dropdown-item" href="#" onclick="setstateV('B');">Béta</a>
                                  </div>
                                </div>
    						</div>
                		</div>
                		<div class="col-md-2"></div>
                	</div>
                    <div class="row rowadd">
                    <div class="col-md-2">
                        
                    </div>
                        <div class="col-md-6">
                            <span class="btn btn-success fileinput-button">
                                <i class="glyphicon glyphicon-plus"></i>
                                <span>Selectioner le fichier...</span>
                                <!-- The file input field used as target for the file upload widget -->
                                <input id="fileupload" type="file" name="files[]" multiple>
                            </span>
                            <br>
                            <br>
                            <!-- The global progress bar -->
                            
                            <!-- The container for the uploaded files -->
                            <div id="files" class="files"></div>
                        </div>
                    </div>

                    <div class="row rowadd">
                        <div class="col-md-2"></div>
                        <div class="col-md-6">
                            <div id="progress" class="progress">
                                <div class="progress-bar progress-bar-success"></div>
                            </div>
                        </div>
                        <div class="col-md-2"></div>
                    </div>

                </div>
                <div id="detailProgramm">
                    <h1>Détails</h1>
                    <h3 id="newfilename"></h3>
                    <hr>
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div class="form-group row">
                              <label for="example-text-input" class="col-xs-2 col-form-label">Description :</label>
                              <div class="col-xs-10">
                                <input class="form-control" type="text" placeholder="Nouvelle fonctionnalité" value="" id="versiondesc">
                              </div>
                            </div>
                        </div>
                        <div class="col-md-1"></div>
                    </div>
                    <hr>
                    <div id="buglist">
                        <h3>Bug : </h3>
                    </div>
                </div>
            </p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
            <button type="button" class="btn btn-primary">Enregistrer</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->