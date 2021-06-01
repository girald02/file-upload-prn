<!DOCTYPE html>
<html>
<body>
  <?php 
     // CONNECTION
     $servername = "localhost";
     $username = "root";
     $password = "";
     $dbname = "importsys_db";
     // Create connection
     $conn = new mysqli($servername, $username, $password, $dbname);
     // Check connection
     if ($conn->connect_error) {
       die("Connection failed: " . $conn->connect_error);
     }
  ?>

  <form action="" method="post" enctype="multipart/form-data">
      Select image to upload:
      <input type="file" name="fileToUpload" id="fileToUpload">
      <input type="submit" value="Upload Data" name="submit">
  </form>

  <?php

    // Inialize
    if (isset($_POST["submit"])) 
    {

     $chckSaved = false;
     $filtered_data = [];

     $target_dir = "contlist/";
     $target_file =  $target_dir . basename($_FILES["fileToUpload"]["name"]);
     $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
     $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

     $target_file = realpath($target_file);

     // var_dump($target_file);
 
     $csvFile = file($target_file);
     $data = [];
         foreach ($csvFile as $line) {
             $data[] = str_getcsv($line);
         }

         for ($i=5; $i < count($data) ; $i++) { 
             $filtered_data[] = (array_filter(explode(" ",$data[$i][0])));
         }

         for ($y=0; $y < count($filtered_data) ; $y++) { 
            
                 $data = array_values(($filtered_data[$y]));
                
                 $sql = "INSERT INTO module (data1, data2, data3, data4, data5, data6, data7, data8)
                 VALUES ('".$data[0]."',
                 '".$data[1]."',
                 '".$data[2]."',
                 '".$data[3]."',
                 '".$data[4]."',
                 '".$data[5]."',
                 '".$data[6]."',
                 '".$data[7]."'
                );";

                if ($conn->query($sql) === TRUE) {
                    $chckSaved = true;
                } else {
                    $chckSaved = false;
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
         }

        if ($chckSaved) {
            echo "Saved Successful!";
            $conn->close();

        }else{
            echo "Error.";
            $conn->close();
        }
    }

?>

</body>
</html>