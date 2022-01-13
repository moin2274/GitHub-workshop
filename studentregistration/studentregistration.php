<?php
// Include config file
require_once "../config.php"; 

$fname = $lname = $moNumber = $email = $gender = $appId = $dob = $password = $conPassword = $branch = $rollNo = $fatherMoNo = $fatherOcc = $motherMoNo = $motherOcc = $bio = "";
$fnameErr = $lnameErr = $moNumberErr = $emailErr = $genderErr = $appIdErr = $passwordErr = $branchErr = $rollNoErr = $fatherMoNoErr = $fatherOcc = $motherMoNo = $motherOcc = "";

	if ($_SERVER["REQUEST_METHOD"] == "POST"){
		$flag = 0;
		$fname = $_POST["fname"];
		$lname = $_POST["lname"];
		$moNumber = $_POST["mo_number"];
		$email = $_POST["email"];
		$gender = $_POST["gender"];
        $dob = $_POST["dob"];
		$appId = $_POST["app_id"];
		$password = $_POST["password"];
		$conPassword = $_POST["con_password"];
		$branch = $_POST["branch"];
		$rollNo = $_POST["roll_no"];
		$fatherMoNo = $_POST["father_mo_no"];
		$fatherOcc = $_POST["father_occ"];
		$motherMoNo = $_POST["mother_mo_no"];
		$motherOcc = $_POST["mother_occ"];
		$bio = $_POST["bio"];
		
		// validations
		if (empty($fname)) {
				$fnameErr = "Name is required";
				$flag = 1; 
			  } else {
				$fname = test_input($fname);
				if (!preg_match("/^[a-zA-Z-' ]*$/",$fname)) {
				  $fnameErr = "Only letters and white space allowed";
				  $flag = 1;
				}
			  }
			  
		if (empty($lname)) {
				$lnameErr = "Surname is required";
				$flag = 1; 
			  } else {
				$lname = test_input($lname);
				if (!preg_match("/^[a-zA-Z-' ]*$/",$lname)) {
				  $lnameErr = "Only letters and white space allowed";
				  $flag = 1;
				}
			  }
			  
		if (empty($moNumber)) {
				$moNumberErr = "Mobile no. is required";
				$flag = 1; 
			  } else {
				$moNumber = test_input($moNumber);
				if ((!preg_match("/^[0-9]*$/",$moNumber)) || strlen($moNumber) != 10) {
				  $moNumberErr = "Enter valid mobile no.";
				  $flag = 1;
				}
			  }
		if (empty($email)) {
				$emailErr = "Email is required";
				$flag = 1;
			  } else {
				$email = test_input($email);
				// check if e-mail address is well-formed
				if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				  $emailErr = "Invalid email format";
				  $flag = 1;
				}
			  }
		if($gender == "select")
			  {
				  $genderErr = "Select a gender";
				  $flag = 1;
			  }
		if (empty($appId)) {
				$appIdErr = "UID is required";
				$flag = 1; 
			  }
		else {
			$sql = "SELECT app_id, l_name FROM regis_detail WHERE app_id = '$appId'";
			$result = $conn->query($sql);
			if($result->num_rows > 0)
			{
				$flag = 1;
				$appIdErr = "User already exists";
			}
		}
		if (empty($password)) {
				$passwordErr = "password is required";
				$flag = 1; 
			  }
		else{
			if($password !== $conPassword){
				$flag = 1;
				$passwordErr = "Password doesnot match";
			}
		}
		if (empty($branch)) {
				$branchErr = "Branch is required";
				$flag = 1; 
			  }		
		if (empty($rollNo)) {
				$rollNo = "Roll no. is required";
				$flag = 1; 
			  }
	    if (empty($fatherMoNo)) {
				$fatherMoNoErr = "Mobile no. is required";
				$flag = 1; 
			  } else {
				$fatherMoNo = test_input($fatherMoNo);
				if ((!preg_match("/^[0-9]*$/",$fatherMoNo)) || strlen($fatherMoNo) != 10) {
				  $fatherMoNoErr = "Enter valid mobile no.";
				  $flag = 1;
				}
			  }
		if($flag == 0){
			
			$sql = "INSERT INTO regis_detail VALUES ('$fname', '$lname', '$moNumber', '$email', '$gender', '$dob', '$appId', '$password', '$branch', '$rollNo', '$fatherMoNo', '$fatherOcc', '$motherMoNo', '$motherOcc', '$bio')";
			
			if(mysqli_query($conn, $sql)){				
		
						time_sleep_until(time()+2);
						function_alert("Account Created");
						header('Location: ../Studentlogin.html');
						
				} else{
					echo "ERROR: Hush! Sorry $sql. "
						. mysqli_error($conn);
				}
				mysqli_close($conn);
		}
		
	}
	
	function test_input($data) {
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}
	function function_alert($message) {
      
		// Display the alert box 
		echo "<script>alert('$message');</script>";
	}


 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Student Registration Form</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <div class="main">
        <div class="container">
            <div class="signup-content" style ="padding : 10px">
                <div class="signup-img"  style ="margin : auto 5px">
                    <img src="../studentlogin/images/loginpageimg.png" alt="registration img">
                </div>
                <div class="signup-form">
				<form  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                        <h2>student registration form</h2>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="fname">First name <span class="error">* <?php echo $fnameErr;?></span></label>
                                <input type="text" name="fname" id="fname" required/>
                            </div>
                            <div class="form-group">
                                <label for="lname">Last name <span class="error">* <?php echo $lnameErr;?></span></label>
                                <input type="text" name="lname" id="lname" required/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email">Email Id <span class="error">* <?php echo $emailErr;?></span></label>
                            <input type="text" name="email" id="email" required/>
                        </div>
                        <div class="form-radio">
                            <label for="gender" class="radio-label">Gender <span class="error">* <?php echo $genderErr;?></span></label>
                            <div class="form-radio-item">
                                <input type="radio" name="gender" value = "male" id="male" checked>
                                <label for="male">Male</label>
                                <span class="check"></span>
                            </div>
                            <div class="form-radio-item">
                                <input type="radio" name="gender" id="female" value = "male">
                                <label for="female">Female</label>
                                <span class="check"></span>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="mo_number">Mobile no. <span class="error">* <?php echo $moNumberErr;?></span></label>
                                <input type="text" name="mo_number" id="mo_number" required/>
                            </div>
                            <div class="form-group">
                                <label for="roll_no">Roll no. <span class="error">* <?php echo $rollNoErr;?></span></label>
                                <input type="text" name="roll_no" id="roll_no" required/>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="app_id">UID <span class="error">* <?php echo $appIdErr;?></span></label>
                                <input type="text" name="app_id" id="app_id">
                            </div>
                            <div class="form-group">
                                <label for="dob">Date of birth <span class="error">*</span></label>
                                <input type="text" name="dob" id="dob">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="password">Password <span class="error">* <?php echo $passwordErr;?></span></label>
                                <input type="password" name="password" id="password" required/>
                            </div>
                            <div class="form-group">
                                <label for="con_password">Confirm Password <span class="error">* </span></label>
                                <input type="password" name="con_password" id="con_password" required/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="branch">Branch <span class="error">* <?php echo $branchErr;?></span></label>
                            <div class="form-select">
                                <select name="branch" id="branch">
                                    <option value=""></option>
                                    <option value="computer">Computer Operator & Pragramming Assistant</option>
                                    <option value="desiger">Designer</option>
                                    <option value="marketing">Marketing</option>
                                </select>
                                <span class="select-icon"><i class="zmdi zmdi-chevron-down"></i></span>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="father_mo_no">Father's mobile number <span class="error">* <?php echo $fatherMoNoErr;?></span></label>
                                <input type="text" name="father_mo_no" id="father_mo_no" required/>
                            </div>
                            <div class="form-group">
                                <label for="father_occ">Father's occupation :</label>
                                <input type="test" name="father_occ" id="father_occ" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="mother_mo_no">Mother's mobile number :</label>
                                <input type="text" name="mother_mo_no" id="mother_mo_no" />
                            </div>
                            <div class="form-group">
                                <label for="mother_occ">Mother's occupation :</label>
                                <input type="text" name="mother_occ" id="mother_occ" />
                            </div>
                        </div>
						<div class="form-group">
							<label for="bio">bio :</label>
							<input type="text" name="bio" id="bio" />
						</div>
                        <div class="form-submit">
                            <input type="submit" value="Reset All" class="submit" name="reset" id="reset" />
                            <input type="submit" value="Register" class="submit" name="submit" id="submit" />
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
    <script src="js/main.js"></script>
</body>
</html>
 