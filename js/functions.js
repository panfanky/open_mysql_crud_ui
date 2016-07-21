	function getresult(url, thistable, callback) {    
	$.ajax({
		url: url,
		type: "POST",
		data:  {name:$("#frmSearch"+thistable+" .name").val(),operatingontable:thistable},
		success: function(data){ $.when($("#dbcontainer").html(data)).then(function(){if(callback){ callback();}});
		}
	   });
	   
	}
	function gettable(url, thistable, callback) {    
	$.ajax({
		url: url,
		type: "POST",
		data:  {name:$("#frmSearch"+thistable+" .name").val(),operatingontable:thistable},
		success: function(data){ $.when($("#tablecalled"+thistable).html(data)).then(function(){if(callback){ callback();}});
		}
	   });
	   
	}
	function add() {
	var valid = validate();
	if(valid) {
		$.ajax({
			url: "scripts/add.php",
			type: "POST",
			data:  {name:$("#add-name").val(),code:$("#add-code").val(),category:$("#category").val(),price:$("#price").val(),stock_count:$("#stock_count").val()},
			success: function(data){ getresult("scripts/getresult.php",''); }
		   });
		}
	}
	function showEdit(editableObj,id,thistable) {
		if($('#tablecalled'+thistable+' .row-'+id).hasClass('beingedited'))
			$(editableObj).css("background","#FFF");
	} 
		
		function saveToDatabase(editableObj,column,id,thistable) {
			$(editableObj).css("background","#FFF url('img/loaderIcon.gif') no-repeat right");
			$.ajax({
				url: "scripts/saveedit.php?thistable="+thistable,
				type: "POST",
				data:'column='+column+'&editval='+$(editableObj).text().trim()+'&id='+id,
				success: function(data){
					$(editableObj).css("background","");
				}        
	   });
	}
	function allowEdit(id,thistable) {
		var value = $('#tablecalled'+thistable+' .row-'+id +' .editabletd').attr('contenteditable');
		if (value == 'false') {
			//close other rows
			$('#tablecalled'+thistable+' .editabletd').attr('contenteditable','false');
			$('#tablecalled'+thistable+' tr').removeClass('beingedited');
			//open my row
			$('#tablecalled'+thistable+' .row-'+id +' .editabletd').attr('contenteditable','true');
			$('#tablecalled'+thistable+' .row-'+id).addClass('beingedited');
		}
		else {
			$('#tablecalled'+thistable+' tr').removeClass('beingedited');
			$('#tablecalled'+thistable+' .row-'+id+' .editabletd').attr('contenteditable','false');
		}
		showEdit($('#tablecalled'+thistable+' .row-'+id + ' .editabletd:first'),id,thistable);
		$('#tablecalled'+thistable+' .row-'+id + ' .editabletd:first').focus();
	}
	
	/*not in use, using saveToDatabase instead
	function edit(id,thistable) {
	var valid = validate();
	if(valid) {
		$.ajax({
			url: "scripts/edit.php?id="+id+"&thistable="+thistable,
			type: "POST",
			data:  {name:$("#add-name").val(),code:$("#add-code").val(),category:$("#category").val(),price:$("#price").val(),stock_count:$("#stock_count").val()},
			success: function(data){ $(".row-"+id).html(data); }
		   });
		}
	}
	*/
	
	function del(id,thistable) {
	if(confirm("Really delete row (id:"+id+")?")){
	$.ajax({
		url: "scripts/delete.php?id="+id+"&thistable="+thistable,
		type: "POST",
		success: function(data){
		// original not-live
		//  $("#toy-"+id).html('');
		//live:
		getresult("scripts/getresult.php",thistable);
		}
	
	   });
	}
	}
	function add(thistable) {
	$.ajax({
		url: "scripts/add.php?thistable="+thistable,
		type: "POST",
		success: function(data){
		getresult("scripts/getresult.php", thistable, function(){allowEdit(data, thistable);});
		}
		
	
	   });
	}
	
	function searchfocus(thistable){
	$('#frmSearch' + thistable).focus();
	//focus end of string
	var tmpStr = $('#frmSearch' + thistable +' .name').val();
	$('#frmSearch' + thistable +' .name').val('');
	$('#frmSearch' + thistable +' .name').val(tmpStr);
	
	}
	//not in use
	// function validate() {
		// var valid = true;	
		// $(".demoInputBox").css('background-color','');
		// $(".info").html('');
		
		// if(!$("#add-name").val()) {
			// $("#name-info").html("(required)");
			// $("#add-name").css('background-color','#FFFFDF');
			// valid = false;
		// }
		// if(!$("#add-code").val()) {
			// $("#code-info").html("(required)");
			// $("#add-code").css('background-color','#FFFFDF');
			// valid = false;
		// }
		// if(!$("#category").val()) {
			// $("#category-info").html("(required)");
			// $("#category").css('background-color','#FFFFDF');
			// valid = false;
		// }
		// if(!$("#price").val()) {
			// $("#price-info").html("(required)");
			// $("#price").css('background-color','#FFFFDF');
			// valid = false;
		// }	
		// if(!$("#stock_count").val()) {
			// $("#stock_count-info").html("(required)");
			// $("#stock_count").css('background-color','#FFFFDF');
			// valid = false;
		// }	
		// return valid;
	// }