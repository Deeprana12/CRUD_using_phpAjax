<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.0/jquery.min.js"></script>
    <title>Document</title>
</head>
<body>

<div class="container">
        <h1>Form</h1>
        <div class="alert alert-success alert-dismissible" id="success" style="display:none;">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
        </div>
        <form id="fupForm" name="fupForm" method="POST">
            <div class="form-group">
                <label for="email">Firstname:</label>
                <input type="text" class="form-control" id="firstname" onkeypress="return textonly(event)" placeholder="FirstName" name="firstname">
				<h5 id="checkfname"></h5>
            </div>
            <div class="form-group">
                <label for="lastname">Lastname:</label>
                <input type="text" class="form-control" id="lastname" onkeypress="return textonly(event)" placeholder="LastName" name="lastname">
				<h5 id="checklname"></h5>
            </div>	
			<div class="form-group">
                <label for="age">Age:</label>
                <input type="text" class="form-control" id="age" onkeypress="return numberonly(event)" placeholder="Age" name="age">
				<h5 id="checkage"></h5><h5 id="nan"></h5>
            </div>
			<div class="form-group">
                <label for="phnumber">Phone number:</label>
                <input type="text" class="form-control" id="ph" onkeypress="return numberonly(event)" placeholder="Phone Number" name="ph">
				<h5 id="checkph"></h5>
            </div>
			<div class="form-group">
                <label for="pwd">Hobbies:</label><br>
                <input type="checkbox" id="h1" name="h1" class="get_value" value="dancing">
				<label for="h1"> Dancing</label>
				<input type="checkbox" id="h2" name="h2" class="get_value" value="gaming">
				<label for="h2"> Gaming</label>
				<input type="checkbox" id="h3" name="h3" class="get_value" value="cp">
				<label for="h3"> Competitive Programming</label>
				<input type="checkbox" id="h4" name="h4" class="get_value" value="cycling">
				<label for="h4"> Cycling</label>
            </div>
            <input type="button" name="save" class="btn btn-primary" value="Submit" id="butsave">
        </form>
</div>
 

<script type="text/javascript">

function numberonly(e){		
	var unicode=e.charCode? e.charCode : e.keyCode
    if (unicode!=8){ //if the key isn't the backspace key (which we should allow)
        if (unicode<48||unicode>57) //if not a number
            return false //disable key press
    }	  
}

function textonly(e){
	var unicode=e.charCode? e.charCode : e.keyCode
    if (unicode!=8){ //if the key isn't the backspace key (which we should allow)
        if (unicode<65 || (unicode>90&&unicode<97) || unicode>122) //if not a number
            return false //disable key press
    }
}

$(document).ready(function() {
	
	$('#checkfname').hide();
	$('#checklname').hide();
	$('#checkage').hide();	
	$('#checkph'). hide();
 
	var fnamerr=true;	
	var lnamerr=true;	
	var agerr=true;	
	var phrr=true;	
	
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

	$('#butsave').on('click', function() {
		fnamerr=true;
		lnamerr=true;
		agerr=true;
		phrr=true;

		fcheck();
		lcheck();
		agecheck();
		phcheck();

		if(fnamerr==true && lnamerr==true&& agerr==true && phrr==true){
			
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
			if(firstname!="" && lastname!="" && f==0 && age!="" && ph_no!="" && hobbies!=""){
				$.ajax({
					url: "save.php",
					type: "POST",
					data: {
						first_name: firstname,
						last_name : lastname,
						hobbies : hobbies,
						age : age,
						ph_no : ph_no
					},					
					success:function(data,status){
						var dataResult = JSON.parse(data);
						alert(data);
						alert('Succssfully');
						if(dataResult.statusCode==200){
							// $("#butsave").removeAttr("disabled");
							$('#fupForm').find('input:text').val('');
							$("#success").show();
							$('#success').html('Data added successfully !'); 						
						}
						else if(dataResult.statusCode==201){
							alert("Error occured !");
						}					
					}
				});
			}else{
				alert('Please fill all the field !');
			}			
		}			
		else {
			alert("Invalid details");
			$("#butsave").attr("disabled", "disabled");
			return false;
		}
    });	
});

</script>

</body>
</html>
