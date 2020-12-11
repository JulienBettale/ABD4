<?php
    session_start();

    /*include('bd/connectionDB.php');*/

    if (!isset($_SESSION['id'])){
        header('Location: index.php');
        exit;
    }

    $connect = mysqli_connect("localhost", "bettal_j", "91022", "medisafe");
    
    if(isset($_POST["submit"])){
        if($_FILES['file']['name']){
            $filename = explode(".", $_FILES['file']['name']);
        
            if($filename[1] == 'csv'){
                $handle = fopen($_FILES['file']['tmp_name'], "r");

                fgetcsv($handle, 10000, ";");

                while(($data = fgetcsv($handle, 10000, ";")) !== FALSE){
                    $employeeNumber = mysqli_real_escape_string($connect, $data[0]);
                    $surname = mysqli_real_escape_string($connect, $data[1]);
                    $givenName = mysqli_real_escape_string($connect, $data[2]);
                    $gender = mysqli_real_escape_string($connect, $data[3]);
                    $city = mysqli_real_escape_string($connect, $data[4]);
                    $jobTitle = mysqli_real_escape_string($connect, $data[5]);
                    $departmentName = mysqli_real_escape_string($connect, $data[6]);
                    $storeLocation = mysqli_real_escape_string($connect, $data[7]);
                    $division = mysqli_real_escape_string($connect, $data[8]);
                    $age = mysqli_real_escape_string($connect, $data[9]);
                    $lengthService = mysqli_real_escape_string($connect, $data[10]);
                    $absentHours = mysqli_real_escape_string($connect, $data[11]);
                    $businessUnit = mysqli_real_escape_string($connect, $data[12]);

                    $query = "INSERT INTO employees(EmployeeNumber, Surname, GivenName, Gender, City, JobTitle, DepartmentName, StoreLocation, Division, Age, LengthService, AbsentHours, BusinessUnit)
                    VALUES('$employeeNumber','$surname','$givenName','$gender','$city','$jobTitle','$departmentName','$storeLocation','$division','$age','$lengthService','$absentHours','$businessUnit')";
                            
                    mysqli_query($connect, $query);

                    header('Location: index.php');
                    
                }
                fclose($handle);
                exit;
            }
        }
    }

?>

<!DOCTYPE html>  
<html>  
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
        <link rel="stylesheet" href="./styles/style.css">
        <title>Medisafe - Import</title>
    </head>  
    <body>
        <?php
            require_once('navbar.php');
        ?>
        <h3>Importer</h3>
        <form method="post" enctype="multipart/form-data">
            <div>  
                <label>Sélectionner un fichier CSV :</label>
                <input type="file" name="file" />
                <br>
                <input type="submit" name="submit" value="Import" class="btn btn-info" />
            </div>
        </form>
    </body>  
</html>