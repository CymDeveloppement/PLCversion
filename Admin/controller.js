function addCustomer()
{
	error = 0;
	if ($('#customername').val()=='') {
		dispError('#nameCusError');
		error = 1;
	}


	if (error == 0) {
		$.post( "ajax.admin.php", { ADDCUSTOMER: $('#customername').val() })
		  .done(function( data ) {
		  	if (data != 'MKDIR') {
		  		$('#nameCusErrorAjaxContent').html(data);
		  		dispError('#nameCusErrorAjax');
		  	} else {
		  		dispValid('#nameCusValidAjax');
		  	}
		});
	}
}


function addFolder()
{
	error = 0;
	if ($('#foldername').val()=='') {
		dispError('#nameFolError');
		error = 1;
	}

	if ($('#selectCustomer').val()=='') {
		dispError('#selecFolError');
		error = 1;
	}




	if (error == 0) {
		$.post( "ajax.admin.php", { ADDFOLDER: $('#foldername').val(), CUSTOMER: $('#selectCustomer').val() })
		  .done(function( data ) {
		  	if (data != 'MKDIR') {
		  		$('#nameFolErrorAjaxContent').html(data);
		  		dispError('#nameFolErrorAjax');
		  	} else {
		  		dispValid('#nameFolValidAjax');
		  	}
		});
	}
}

function dispError(id)
{
	$(id).fadeIn('slow');
	setTimeout(function(){ $(id).fadeOut('slow'); }, 3000);
}

function dispValid(id)
{
	$(id).fadeIn('slow');
	setTimeout(function(){ $(id).fadeOut('slow'); }, 3000);
}

function listCustomer()
{
	$.post( "ajax.admin.php", { LISTCUSTOMER: 'selectCustomer' })
		  .done(function( data ) {
		  	$('#customerlist').html(data);
	});
	$.post( "ajax.admin.php", { LISTCUSTOMER: 'selectCustomerAdd' })
		  .done(function( data ) {
		  	$('#customerlistAdd').html(data);
	});
}

function refreshFolder()
{
	$.post( "ajax.admin.php", { LISTFOLDER: $('#selectCustomerAdd').val() })
		  .done(function( data ) {
		  	$('#folderlistAdd').html(data);
	});
}

function selectCustomer(name, id)
{
	$('#'+id).val(name);
	$('#'+id+'Disp').html(name);
	if (id == 'selectCustomerAdd') {refreshFolder();}
}

function selectFolder(name)
{
	$('#selectfolderAdd').val(name);
	$('#selectfolderAddDisp').html(name);
}

function selectElem(elem)
{
	$('#selectelemAdd').val(elem);
	$('#selectelemAddDisp').html(elem);
	getCurrentVersion($('#selectCustomerAdd').val(), $('#selectfolderAdd').val(), elem);
}

function getCurrentVersion(customer, name, elem)
{
	$.post( "ajax.admin.php", { CURRENT: name, CUSTOMERV: customer, ELEMENT: elem  })
		  .done(function( data ) {


		  	if(data != '')
		  	{
			  	$('#currentversion').html('Derniére version : '+data);
			  	currentversion = data.split('.');
			  	currentversion[3] = currentversion[2].charAt(currentversion[2].length - 1);
			  	currentversion[2] = currentversion[2].replace("B", "");
			  	currentversion[2] = currentversion[2].replace("A", "");
			  	currentversion[2] = (parseInt(currentversion[2],10)+1);
			  	initial = false;			  	
		  	} else {
		  		$('#currentversion').html('Version Initiale');
		  		var newData = '0.0.0A.NEW';
		  		currentversion = newData.split('.');
		  		currentversion[3] = currentversion[2].charAt(currentversion[2].length - 1);
			  	currentversion[2] = currentversion[2].replace("A", "");
			  	currentversion[2] = (parseInt(currentversion[2],10)+1);
			  	initial = true;
		  	}
		  	currentStateV = currentversion[3];
		  	if (currentversion[3] == 'A') {
			  	selectCorrect();
			  	setstateV('A');
			} else if (currentversion[3] == 'B') {
			  	selectMajor();
			  	setstateV('F');
			} else {
			  	selectMinor();
				setstateV('F');
			}
		  	
		  	$('#contentProgramm').fadeIn('slow');
	});
}

function selectCorrect(){
	
	$('#correctBtn').removeClass('btn-secondary');
	$('#majorBtn').removeClass('btn-primary');
	$('#minorBtn').removeClass('btn-primary');
	$('#minorBtn').addClass('btn-secondary');
	$('#majorBtn').addClass('btn-secondary');
	$('#correctBtn').addClass('btn-primary');
	setVersion(3);
}

function selectMinor(){
	$('#correctBtn').removeClass('btn-primary');
	$('#majorBtn').removeClass('btn-primary');
	$('#minorBtn').removeClass('btn-secondary');
	$('#minorBtn').addClass('btn-primary');
	$('#majorBtn').addClass('btn-secondary');
	$('#correctBtn').addClass('btn-secondary');
	setVersion(2);
}

function selectMajor(){
	$('#correctBtn').removeClass('btn-primary');
	$('#minorBtn').removeClass('btn-primary');
	$('#majorBtn').removeClass('btn-secondary');
	$('#majorBtn').addClass('btn-primary');
	$('#minorBtn').addClass('btn-secondary');
	$('#correctBtn').addClass('btn-secondary');
	setVersion(1);
}

function setstateV(state)
{
	currentStateV = state;
	if (state == "A") {
		
		$('#stateV').html('Alpha');
		if (currentversion[3] != 'A') {
			selectMajor();
		} else if(currentversion[3] == 'A') {
			selectCorrect();
		}
	}
	if (state == "B") {
		$('#stateV').html('Béta');
		selectMinor();
	}
	if (state == "F") {
		$('#stateV').html('Production');
		selectMinor();
	}
}

function setVersion(type)
{
	if (type == 1) {
		newV = (parseInt(currentversion[0], 10)+1);
		$('#V1').val(newV);
		$('#V2').val(0);
		$('#V3').val(0);
	}

	if (type == 2) {
		newV = (parseInt(currentversion[1], 10)+1);
		$('#V1').val(currentversion[0]);
		$('#V2').val(newV);
		$('#V3').val(0);
	}
	if (type == 3) {
		$('#V1').val(currentversion[0]);
		$('#V2').val(currentversion[1]);
		$('#V3').val(currentversion[2]);
	}
}

function dispDetails(file)
{
	$('#contentProgramm').fadeOut();
	$('#selectfolderdiv').fadeOut();


	
	var newfile = $('#selectfolderAdd').val()+'-V'+$('#V1').val()+'.'+$('#V2').val()+'.'+$('#V3').val()+currentStateV;
	$('#newfilename').html(newfile);

	if (!initial) {
		projectInfo = getinfo($('#selectCustomerAdd').val(), $('#selectfolderAdd').val(), $('#selectelemAdd').val());
	}


	$('#detailProgramm').fadeIn('slow');
}

function getinfo(customer, folder, element)
{
	$.post( "ajax.admin.php", { GETINFO: 1, FOLDER: folder, CUSTOMERV: customer, ELEMENT: element  })
		  .done(function( data ) {


		  });
}

function dispProgramm()
{
	$('#ticket').fadeOut('slow');
	$('#programm').fadeIn('slow');
}

function dispTicket()
{
	$('#ticket').fadeIn('slow');
	$('#programm').fadeOut('slow');
}

function dispAllVersion(UID)
{

	$('#modalListContent').html('');
	$.post( "ajax.admin.php", { GETALLVERSION: 1, UIDP: UID})
		  .done(function( data ) {
		  	$('#modalListContent').html(data);
		  	$('#modalListTitle').html('Toute les versions');
			$('#modalList').modal('show');

	});
}

function dispAllBug(UID)
{
	$('#modalListContent').html('');
	$.post( "ajax.admin.php", { GETBUGS: 1, UIDP: UID})
		  .done(function( data ) {
		  	$('#modalListContent').html(data);
		  	$('#modalListTitle').html('Bugs : ');
			$('#modalList').modal('show');

	});
	
}

function addbug(UID)
{
	if ($('#bugTextInput').val() == '') {
		$('#groupAddBug').addClass('has-danger');
	} else {
		var bugText = $('#bugTextInput').val();
		$.post( "ajax.admin.php", { ADDBUG: 1, UIDP: UID, BUG: bugText})
			  .done(function( data ) {
			  	$('#modalListContent').html(data);
			  	$('#groupAddBug').removeClass('has-danger');
			  	$('#groupAddBug').addClass('has-success');
			  	refreshList();
		});
	}
}

function saveVersion()
{
	var UID = $('#selectCustomerAdd').val() + "/" + $('#selectfolderAdd').val() + "/" + $('#selectelemAdd').val() + "/" + $('#newfilename').html();
	$.post( "ajax.admin.php", { SAVE: 1, INIT: initial, UIDV: UID, SOURCE: $('#currentFileName').html(), NEWNAME: $('#newfilename').html(), DESCRIPTION: $('#versiondesc').val()})
			  .done(function( data ) {
			  	$.post( "ajax.admin.php", { REFRESHPROGRAMMLIST: 1 })
			  		.done(function( data ) {
			  			$('#programmlistContent').html(data);
			  			$('#modalnewprogramm').modal('hide');
				});
	});

}

function refreshList()
{
	$.post( "ajax.admin.php", { REFRESHPROGRAMMLIST: 1 })
			  		.done(function( data ) {
			  			$('#programmlistContent').html(data);
	});
}

currentversion = [];
currentStateV = '';
initial = false;

$('.modal').on('hidden.bs.modal', function (e) {
 	$('#foldername').val('');
 	$('#customername').val('');
 	$('#contentProgramm').fadeOut();
 	$('#detailProgramm').fadeOut();
 	$('#selectfolderdiv').fadeIn();
 	$('#selectCustomerAddDisp').html('Choisissez un Client');
 	$('#selectfolderAddDisp').html('Choisissez un Dossier');
 	$('#selectelemAddDisp').html('Choisissez un Element');
 	$('#selectCustomerAdd').val('');
 	$('#selectfolderAdd').val('');
 	$('#selectelemAdd').val('');
 	$('#files').html('');
});

$('.modal').on('show.bs.modal', function (e) {
  listCustomer();
});

$(function () {
    'use strict';
    // Change this to the location of your server-side upload handler:
    var url = 'upload.php';
    $('#fileupload').fileupload({
        url: url,
        dataType: 'json',
        done: function (e, data) {
		console.log(data);
            $.each(data.result.files, function (index, file) {
            	//alert(file.name);
            	dispDetails(file.name);
            	$('#currentFileName').html(file.name);
                $('<p/>').text(file.name).appendTo('#files');
            });
        },
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .progress-bar').css(
                'width',
                progress + '%'
            );
        }
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');
});
