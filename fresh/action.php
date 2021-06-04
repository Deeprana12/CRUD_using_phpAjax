<?php
$username = 'root';
$password = '';
$connection = new PDO('mysql:host=localhost;dbname=task5', $username, $password);

if(isset($_POST["action"])){

      //For Load All Data
      if($_POST["action"] == "Load"){
          $statement = $connection->prepare("SELECT * FROM temp");
          $statement->execute();
          $result = $statement->fetchAll();
          $output = '';
          $output .= '
          <table class="table table-bordered">
            <tr>
            <th width="11.1%">First Name</th>
            <th width="11.1%">Last Name</th>
            <th width="11.1%">Hobbies</th>
            <th width="11.1%">Phone number</th>
            <th width="11.1%">Age</th>
            <th width="11.1%">State</th>
            <th width="11.1%">Update</th>
            <th width="11.1%">Delete</th>     
            <th width="11.1%">View</th>
            </tr>
          ';
          if($statement->rowCount() > 0){
              foreach($result as $row){
                $output .= '
                <tr>
                <td>'.$row["first_name"].'</td>
                <td>'.$row["last_name"].'</td>
                <td>'.$row["hobbies"].'</td>
                <td>'.$row["ph_no"].'</td>
                <td>'.$row["age"].'</td>
                <td>'.$row["state"].'</td>
                <td><button type="button" id="'.$row["id"].'" class="btn btn-warning btn-xs update">Update</button></td>
                <td><button type="button" id="'.$row["id"].'" class="btn btn-danger btn-xs delete">Delete</button></td>
                <td><button type="button" id="'.$row["id"].'" class="btn btn-primary btn-xs view">View</button></td>
                </tr>
                ';
              }
          }
          else{
            $output .= '
              <tr>
                <td>No data</td>
                <td>No data</td>
                <td>No data</td>
                <td>No data</td>
                <td>No data</td>
                <td>No data</td>
                <td>No data</td>
                <td>No data</td>
                <td>No data</td>
              </tr>
            ';
          }
          $output .= '</table>';
          echo $output;
      }

      // fetch only One
      if($_POST["action"] == "View") { 
            $statement = $connection->prepare(" SELECT * FROM temp where id=".$_POST["id"]." ");
            $statement->execute();
            $result = $statement->fetchAll();
            $output = '';
            $output .= '
            <table class="table table-bordered">
              <tr>
                <th width="11.1%">First Name</th>
                <th width="11.1%">Last Name</th>
                <th width="11.1%">Hobbies</th>
                <th width="11.1%">Phone number</th>
                <th width="11.1%">Age</th>
                <th width="11.1%">State</th>
                <th width="11.1%">Update</th>
                <th width="11.1%">Delete</th>     
                <th width="11.1%">View</th>
              </tr>
            ';
            if($statement->rowCount() > 0){
                foreach($result as $row){
                  $output .= '
                  <tr>
                  <td>'.$row["first_name"].'</td>
                  <td>'.$row["last_name"].'</td>
                  <td>'.$row["hobbies"].'</td>
                  <td>'.$row["ph_no"].'</td>
                  <td>'.$row["age"].'</td>
                  <td>'.$row["state"].'</td>
                  <td><button type="button" id="'.$row["id"].'" class="btn btn-warning btn-xs update">Update</button></td>
                  <td><button type="button" id="'.$row["id"].'" class="btn btn-danger btn-xs delete">Delete</button></td>
                  <td><button type="button" id="'.$row["id"].'" class="btn btn-danger btn-xs view">View</button></td>
                  </tr>
                  ';
              }
            }
            else{
              $output .= '
                <tr>
                <td align="center">Data not Found</td>
                </tr>
              ';
            }
            $output .= '</table>';
            echo $output;
      }

      //This Code is for fetch single customer data for display
      if($_POST["action"] == "Select"){
            //  alert("echo");
            $output = array();
            $statement = $connection->prepare(
                "SELECT * FROM temp 
                WHERE id = '".$_POST["id"]."' 
                LIMIT 1"
            );      
            $statement->execute();
            $result = $statement->fetchAll();
            foreach($result as $row){
                $output["first_name"] = $row["first_name"];
                $output["last_name"] = $row["last_name"];
                $output["hobbies"] = $row["hobbies"];
                $output["ph_no"] = $row["ph_no"];
                $output["age"] = $row["age"];
                $output["state"] = $row["state"];
            }
            echo json_encode($output);
      }

      // update the records
      if($_POST["action"] == "Update"){
          $statement = $connection->prepare("
            UPDATE temp SET first_name = :first_name,
            last_name = :last_name,
            hobbies=:hobbies,
            state=:state,
            age=:age,
            ph_no=:ph_no
            WHERE id = :id"
          );
            // var_dump($statement);
            $result = $statement->execute(
              array(          
                ':first_name' => $_POST["firstName"],
                ':last_name' => $_POST["lastName"],                    
                ':hobbies' => $_POST["hobbies"],
                ':ph_no' => $_POST["ph_no"],  
                ':age' => $_POST["age"],
                ':state' => $_POST["state"],
                ':id' => $_POST["id"]
              )
            );
            echo json_encode($result);
      }

      // for delete
      if($_POST["action"] == "Delete"){
          $statement = $connection->prepare(
            "DELETE FROM temp WHERE id = :id"
          );
          $result = $statement->execute(
            array(':id' => $_POST["id"])
          );        
      }

      // View perticular data
      if($_POST["action"] == "View1"){
        // var_dump($_POST["id"]);
        $statement = $connection->prepare(
            "SELECT * FROM temp 
            WHERE id = :id" 
        );    
        $result = $statement->execute(
          array(':id' => $_POST["id"])
        );
      }

}
?>