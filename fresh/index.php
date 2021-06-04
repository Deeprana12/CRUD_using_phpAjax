<html>
 <head>
    <title>CRUD</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.0/jquery.min.js"></script>    
    <style>
    body{
        margin:0;
        padding:0;
        background-color:#ffffff;
    }
    .box{
        width:1500px;
        padding:8px;
        background-color:white;
        border:1px solid #ccc;
        border-radius:5px;
        margin-top:100px;
    }
    </style>
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
                    <input type="text" class="form-control" id="firstname"  onkeypress="return textonly(event)" placeholder="FirstName" name="firstname">
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
                    <label for="drop">Select your state:</label>
                    <select name="state" id="state">
                        <option value="">--Select--</option>
                        <option value="Gujarat">Gujarat</option>
                        <option value="Maharastra">Maharastra</option>
                        <option value="Rajasthan">Rajasthan</option>
                        <option value="Madhyapradesh">Madhyapradesh</option>
                    </select>
                    <h5 id="checkstt"></h5>
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
                <input type="hidden" name="customer_id" id="customer_id"/>                        

                <input type="button" name="save" id="butsave" class="btn btn-primary" value="Submit" >
                <input type="button" name="action" id="action" class="btn btn-primary" value="Update" >
            </form>
            <h1 style="text-align:center;">CRUD</h1>
            <br />           
            <br />
            <div id="result" class="table-responsive">
            </div>
        </div>
    

           
        
        <script src="script.js"></script>
    </body>
</html>

<script>  
    function fetchU(id){
        var id=id;        
        var action = "View";
        $.ajax({
            url : "action.php", 
            method:"POST",
            data:{id:id,action:action}, 
            success:function(data){
                $('#result').html(data);
            },
            error:function(){
                alert("l");
            }
        });
    }
    
$(document).ready(function(){
    
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
 
// $('#modal_button').click(function(){
//     $('#customerModal').modal('show'); 
//     $('#first_name').val(''); 
//     $('#last_name').val(''); 
//     $('#age').val('');
//     $('#ph_no').val('');
//     $('#hobbies').val('');
//     $('.modal-title').text("Create New Records"); 
//     $('#action').val('Create'); 
// });

 
$('#action').click(function(){
    var firstName = $('#firstname').val(); 
    var lastName = $('#lastname').val();
    var age=$('#age').val();
    var ph_no = $('#ph').val();
    var state = $('#state').val();
    var id = $('#customer_id').val();     
    var hobb=[];
		$('.get_value').each(function(){
			if($(this).is(":checked")){
				hobb.push($(this).val());
			}
		})
	var hobbies=hobb.toString();    
    var action = $('#action').val();              
        $.ajax({
            url : "action.php",    
            method:"POST", 
            data:{firstName:firstName,
                 lastName:lastName,hobbies:hobbies, age:age, ph_no:ph_no,
                 state:state,
                  id:id, action:action},
            success:function(data){           
                alert(data);                        
                fetchUser();    
            }
        });
});

 
$(document).on('click', '.update', function(){
    var id = $(this).attr("id"); 
    var action = "Select";
    $.ajax({
        url:"action.php",
        method:"POST",
        data:{id:id, action:action},
        dataType:"json",
        success:function(data){
            // $('#customerModal').modal('show');            
            $('.modal-title').text("Update Records");
            $('#action').val("Update");
            $('#customer_id').val(id);
            $('#firstname').val(data.first_name);
            $('#lastname').val(data.last_name);
            $('#age').val(data.age);
            $('#ph').val(data.ph_no);            
            $('#state').val(data.state);
            var temp = data.hobbies;
            // $temp2 = data.hobbies;.
            document.getElementById("h1").checked = false;                        
            document.getElementById("h2").checked = false;                    
            document.getElementById("h3").checked = false;
            document.getElementById("h4").checked = false;            
            var arr=temp.split(',');
            if(arr.includes('dancing')){
                document.getElementById("h1").checked = true;
            }
            if(arr.includes('gaming')){
                document.getElementById("h2").checked = true;
            }
            if(arr.includes('cp')){
                document.getElementById("h3").checked = true;
            }
            if(arr.includes('cycling')){
                document.getElementById("h4").checked = true;
            }                                            
            // $('#hobbies').val(data.hobbies);
        }
    });
 });
 

 $(document).on('click', '.view', function(){
    var id = $(this).attr("id"); 
    var action = "View1";
    $.ajax({
        url:"action.php",
        method:"POST",
        data:{id:id, action:action},
        // dataType:"json",
        success:function(data){            
            fetchU(id); 
            // alert(';ll');           
        },
        error:function(){
            alert('');
        }
    });
 });


 $(document).on('click', '.delete', function(){
    var id = $(this).attr("id"); 
    if(confirm("Are you sure you want to remove this data?")) 
    {
    var action = "Delete"; 
    $.ajax({
        url:"action.php",    
        method:"POST",     
        data:{id:id, action:action},
            success:function(data){
                fetchUser();    
                // alert(data);    
            }
        });
        }else{
            return false; //No action will perform
        }
    });
});
</script>