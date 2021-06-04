





function numberonly(e){		
	var unicode=e.charCode? e.charCode : e.keyCode
    if (unicode!=8){ 
        if (unicode<48||unicode>57)
            return false;
    }	  
}

function textonly(e){
	var unicode=e.charCode? e.charCode : e.keyCode
    if (unicode!=8){
        if (unicode<65 || (unicode>90&&unicode<97) || unicode>122)
            return false;
    }
}

$(document).ready(function() {

	$('#checkfname').hide();
	$('#checklname').hide();
	$('#checkage').hide();	
	$('#checkph'). hide();
	$('#checkstt'). hide();

	var fnamerr=true;	
	var lnamerr=true;	
	var agerr=true;	
	var phrr=true;	
	var sttrr=true;

	$('#firstname').keyup(function(){
		fcheck();
	});
	
	$('#lastname').keyup(function(){
		lcheck();
	});

	$('#age').keyup(function(){
		agecheck();
	});

	$('#ph').keyup(function(){
		phcheck();
	});

	$('#state').keyup(function(){
		sttcheck();
	});


	function fcheck(){		
		var x=$('#firstname').val();
		if(x.length == ''){
			$('#checkfname').show();
			$('#checkfname').html('*Please fill this field');
			$('#checkfname').focus();
			$('#checkfname').css("color","red");
			fnamerr=false;
			return false;
		}else{
			$('#checkfname').hide();					
		}
	}
	
	function lcheck(){		
		var x=$('#lastname').val();
		if(x.length == ''){
			$('#checklname').show();
			$('#checklname').html('*Please fill this field');
			$('#checklname').focus();
			$('#checklname').css("color","red");
			lnamerr=false;
			return false;
		}else{
			$('#checklname').hide();		
		}				
	}

	function agecheck(){

		var x=$('#age').val();
		if(x.length > 3 && x > 100 ){
			$('#checkage').show();
			$('#checkage').html('*Invalid');
			$('#checkage').focus();
			$('#checkage').css("color","red");
			agerr=false;				
			return false;
		}else{				
			$('#checkage').hide();				
		}

	}

	function phcheck(){
		var x=$('#ph').val();
		if(x.length > 10 || x.length<10){
			$('#checkph').show();
			$('#checkph').html('*Invalid');
			$('#checkph').focus();
			$('#checkph').css("color","red");
			phrr=false;
			return false;
		}else{
			$('#checkph').hide();			
		}

	}
	
	function sttcheck(){
		var x=$('#state').val();
		if(x.length==''){
			$('#checkstt').show();
			$('#checkstt').html('*Invalid');
			$('#checkstt').focus();
			$('#checkstt').css("color","red");
			sttrr=false;
			return false;
		}else{
			$('#checkstt').hide();			
		}

	}

	$('#butsave').on('click', function() {
        // alert("Data inserted!!");
		fnamerr=true;
		lnamerr=true;
		agerr=true;
		phrr=true;
		sttrr=true;

		fcheck();
		lcheck();
		agecheck();
		phcheck();
		sttcheck();

		if(fnamerr==true && lnamerr==true&& agerr==true && phrr==true && sttrr==true){			
			var hobbies=[];
			var f=0;
			$('.get_value').each(function(){
				if($(this).is(":checked")){
					hobbies.push($(this).val());
				}
			})
			if(hobbies.length==0)
				f=1;

			hobbies=hobbies.toString();	
			
			var firstname = $('#firstname').val();
			var lastname = $('#lastname').val();	
			var age = $('#age').val();
			var ph_no = $('#ph').val();	
			var state = $('#state').val();
			// var_dump(state);
			// alert(state);
			if(firstname!="" && lastname!="" && f==0 && age!="" && ph_no!="" && hobbies!="" && state!=""){
				$.ajax({
					url: "save.php",
					type: "POST",
					data: {
						first_name: firstname,
						last_name : lastname,
						hobbies : hobbies,
						age : age,
						state:state,
						ph_no : ph_no						
					},					
					success:function(data,status){												
						// var dataResult = JSON.parse(data);
						// alert(dataResult);
						alert('Submitted!!');						
						$("#butsave").removeAttr("disabled");
						$('#fupForm').find('input:text').val('');					
						fetchUser(); 
						function fetchUser(){
							var action = "Load";
							$.ajax({
								url : "action.php", 
								method:"POST",
								data:{action:action}, 
								success:function(data){
									$('#result').html(data);
								}
							});
						}					
					},
					err:function(error){
						alert(error);
					} 	
				});
			}else{
				alert('Please fill all the field !');
			}			
		}			
		else {
			alert("Invalid details");			
			return false;
		}
    });	
});