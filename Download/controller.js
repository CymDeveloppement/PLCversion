function dispAllBug(UID)
{
	$('#modalListContent').html('');
	$.post( "ajax.download.php", { GETBUGS: 1, UIDP: UID})
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
		$.post( "ajax.download.php", { ADDBUG: 1, UIDP: UID, BUG: bugText})
			  .done(function( data ) {
			  	$('#modalListContent').html(data);
			  	$('#groupAddBug').removeClass('has-danger');
			  	$('#groupAddBug').addClass('has-success');
			  	//refreshList();
		});
	}
}

function dispchangelog(UID)
{
	$('#modalreadchangelog').html('');
	$.post( "ajax.download.php", { GETCHANGELOG: UID})
		  .done(function( data ) {
		  	$('#modalreadchangelog').html(data);
		  	//$('#modalListTitle').html('Bugs : ');
			$('#modalReadChangelog').modal('show');

	});
}