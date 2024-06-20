<?php
// Include header file
include('include/header.php');

// Check if form is submitted
if (isset($_POST['submit'])) {
    // Check if terms are agreed
    if (isset($_POST['term'])) {
        // Validate name
        if (isset($_POST['name']) && !empty($_POST['name']) && preg_match('/^[A-Za-z\s]+$/', $_POST['name'])) {
            $name = $_POST['name'];
        } else {
            $nameError = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                          <strong>Only lower and upper case letters and spaces are allowed</strong>
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>';
        }

        // Validate gender
        if (isset($_POST['gender']) && !empty($_POST['gender'])) {
            $gender = $_POST['gender'];
        } else {
            $genderError = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                              <strong>Please select your gender</strong>
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>';
        }

        // Validate date of birth
        $day = $_POST['day'];
        $month = $_POST['month'];
        $year = $_POST['year'];
        if (empty($day) || empty($month) || empty($year)) {
            $dobError = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Please select complete date of birth</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>';
        } else {
            // You can further validate the date if required
            $dob = $year . '-' . $month . '-' . $day;
        }

        // Validate blood group
        if (isset($_POST['blood_group']) && !empty($_POST['blood_group'])) {
            $blood_group = $_POST['blood_group'];
        } else {
            $blood_groupError = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>Please select your blood group</strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>';
        }

        // Validate city
        if (isset($_POST['city']) && !empty($_POST['city']) && preg_match('/^[A-Za-z\s]+$/', $_POST['city'])) {
            $city = $_POST['city'];
        } else {
            $cityError = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Please enter a valid city name</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>';
        }

        // Validate email
        if (isset($_POST['email']) && !empty($_POST['email']) && preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $_POST['email'])) {
            $check_email = $_POST['email'];
            // Check if email already exists
            $sql = "SELECT email  FROM donor WHERE email = '$check_email'";
            $result = mysqli_query($connection, $sql);

            if (mysqli_num_rows($result) > 0) {
                $emailError = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>Email already exists</strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>';
            } else {
                $email = $_POST['email'];
            }
        } else {
            $emailError = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Please enter a valid email address</strong>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>';
        }

        // Validate contact number
        if (isset($_POST['contact_no']) && !empty($_POST['contact_no']) && preg_match('/^\d{11}$/', $_POST['contact_no'])) {
            $contact = $_POST['contact_no'];
        } else {
            $contactError = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Contact should consist of 10 numbers</strong>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>';
        }

        // Validate password
        if (isset($_POST['password']) && !empty($_POST['password']) && isset($_POST['c_password']) && !empty($_POST['c_password'])) {
            if (strlen($_POST['password']) >= 6) {
                if ($_POST['password'] == $_POST['c_password']) {
                    $password = $_POST['password'];
                    // Passwords match, continue
                } else {
                    $passwordError = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <strong>Passwords do not match</strong>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>';
                }
            } else {
                $passwordError = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>Password should be at least 6 characters long</strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>';
            }
        } else {
            $passwordError = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Please fill both Password and Confirm Password fields</strong>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>';
        }

		// INSERT DATA INTO DATAABASE 

		
if(isset($name) && isset($blood_group) && isset($gender) && isset($day) && isset($month) && isset($year) && isset($email) && isset($contact) && isset($city) && isset($password)) {
    // Assuming $connection is your MySQLi connection object
    if ($connection) {
        // Escape variables for security
        $name = mysqli_real_escape_string($connection, $name);
		$blood_group = mysqli_real_escape_string($connection, $blood_group);
        $gender = mysqli_real_escape_string($connection, $gender);
        $email = mysqli_real_escape_string($connection, $email);
        $city = mysqli_real_escape_string($connection, $city);
        $contact = mysqli_real_escape_string($connection, $contact);
        $password = mysqli_real_escape_string($connection, $password);

        // Concatenate the date fields to form the date of birth
        $DonorDOB = $year . "-" . $month . "-" . $day;
        $password = md5 ($password);
        // SQL query to insert data
        $sql = "INSERT INTO donor (name,blood_group, gender, email, city, contact_no, save_life_date, password) VALUES ('$name', '$blood_group','$gender', '$email', '$city', '$contact', '$DonorDOB', '$password')";

        // Execute the query
        if(mysqli_query($connection, $sql)){
        
            header("Location: signin.php");
        }else{
            // Error message if query execution fails
            $submitError = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Data not inserted, Try again: ' . mysqli_error($connection) . '</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>';
        }
    } else {
        // Error message if database connection fails
        $submitError = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Database connection failed.</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>';
    }
} else {
    // Error message if any required field is missing
    $submitError = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Please fill all required fields.</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>';
}

    }else {
        $termError = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Please agree with our terms and conditions</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
							</button>
							</div>';
								}
							  }
							

?>

<style>
	.size{
		min-height: 0px;
		padding: 60px 0 40px 0;
		
	}
	.form-container{
		background-color: white;
		border: .5px solid #eee;
		border-radius: 5px;
		padding: 20px 10px 20px 30px;
		-webkit-box-shadow: 0px 2px 5px -2px rgba(89,89,89,0.95);
-moz-box-shadow: 0px 2px 5px -2px rgba(89,89,89,0.95);
box-shadow: 0px 2px 5px -2px rgba(89,89,89,0.95);
	}
	.form-group{
		text-align: left;
	}
	h1{
		color: white;
	}
	h3{
		color: #e74c3c;
		text-align: center;
	}
	.red-bar{
		width: 25%;
	}
</style>
<div class="container-fluid red-background size">
	<div class="row">
		<div class="col-md-6 offset-md-3">
			<h1 class="text-center">Donate</h1>
			<hr class="white-bar">
		</div>
	</div>
</div>
<div class="container size">
	<div class="row">
		<div class="col-md-6 offset-md-3 form-container">
					<h3>SignUp</h3>
					

					<hr class="red-bar">
					<?php if(isset($termError)) echo $termError;
					if(isset($submitSuccess)) echo $submitSuccess;
					if(isset($submitError)) echo $submitError;
					?>
					
          <!-- Error Messages -->

				<form class="form-group" action="" method="post">
					<div class="form-group">
						<label for="fullname">Full Name</label>
						<input type="text" name="name" id="fullname" placeholder="Full Name" required pattern="[A-Za-z/\s]+" title="Only lower and upper case and space" class="form-control" value="<?php if(isset($name)) echo $name;?>">
							<?php if(isset($nameError)) echo $nameError;?>
					</div><!--full name-->
					<div class="form-group">
              <label for="name">Blood Group</label><br>
              <select class="form-control demo-default" id="blood_group" name="blood_group" required>
                <option value="">---Select Your Blood Group---</option>
                <?php if(isset($blood_group)) echo '<option selected="" value="'.$blood_group.'">'.$blood_group.'</option>'; ?>
                
                <option value="A+">A+</option>
                <option value="A-">A-</option>
                <option value="B+">B+</option>
                <option value="B-">B-</option>
                <option value="O+">O+</option>
                <option value="O-">O-</option>
                <option value="AB+">AB+</option>
                <option value="AB-">AB-</option>
              </select>
			  <?php if(isset($blood_groupError)) echo $blood_groupError;?>
            </div><!--End form-group-->

					<div class="form-group">
				              <label for="gender">Gender</label><br>
				              		Male<input type="radio" name="gender" id="gender" value="Male " style="margin-left:10px;">
				              		Female<input type="radio" name="gender" id="gender" value="Female" style="margin-left:10px;"<?php if (isset($gender)) { if($gender=="Female") echo "checked"; } ?> >
									  <?php if(isset($genderError)) echo $genderError;?>
						</div><!--gender-->
				    	
				    <div class="form-inline">
              <label for="name">Date of Birth</label><br>
              <select class="form-control demo-default" id="date" name="day" style="margin-bottom:10px;" required>
                <option value="">---Date---</option>
                <?php if(isset($month)) echo '<option selected="" value="'.$month.'">'.$month.'</option>'; ?>     
                <option value="01" >01</option><option value="02" >02</option><option value="03" >03</option><option value="04" >04</option><option value="05" >05</option><option value="06" >06</option><option value="07" >07</option> <option value="08" >08</option><option value="09" >09</option><option value="10" >10</option><option value="11" >11</option><option value="12" >12</option><option value="13" >13</option><option value="14" >14</option><option value="15" >15</option><option value="16" >16</option><option value="17" >17</option><option value="18" >18</option><option value="19" >19</option><option value="20" >20</option><option value="21" >21</option><option value="22" >22</option><option value="23" >23</option><option value="24" >24</option><option value="25" >25</option><option value="26" >26</option><option value="27" >27</option><option value="28" >28</option><option value="29" >29</option><option value="30" >30</option><option value="31" >31</option>
              </select>
              <select class="form-control demo-default" name="month" id="month" style="margin-bottom:10px;" required>
                <option value="">---Month---</option>
                <option value="01" >January</option><option value="02" >February</option><option value="03" >March</option><option value="04" >April</option><option value="05" >May</option><option value="06" >June</option><option value="07" >July</option><option value="08" >August</option><option value="09" >September</option><option value="10" >October</option><option value="11" >November</option><option value="12" >December</option>
              </select>
              <select class="form-control demo-default" id="year" name="year" style="margin-bottom:10px;" required>
                <option value="">---Year---</option>
                <?php if(isset($year)) echo '<option selected="" value="'.$year.'">'.$year.'</option>'; ?>     
                <option value="1957" >1957</option><option value="1958" >1958</option>
				<option value="1959" >1959</option><option value="1960" >1960</option>
				<option value="1961" >1961</option><option value="1962" >1962</option>
				<option value="1963" >1963</option><option value="1964" >1964</option>
				<option value="1965" >1965</option><option value="1966" >1966</option>
				<option value="1967" >1967</option><option value="1968" >1968</option>
				<option value="1969" >1969</option><option value="1970" >1970</option>
				<option value="1971" >1971</option><option value="1972" >1972</option>
				<option value="1973" >1973</option><option value="1974" >1974</option>
				<option value="1975" >1975</option><option value="1976" >1976</option>
				<option value="1977" >1977</option><option value="1978" >1978</option>
				<option value="1979" >1979</option><option value="1980" >1980</option>
				<option value="1981" >1981</option><option value="1982" >1982</option>
				<option value="1983" >1983</option><option value="1984" >1984</option>
				<option value="1985" >1985</option><option value="1986" >1986</option>
				<option value="1987" >1987</option><option value="1988" >1988</option>
				<option value="1989" >1989</option><option value="1990" >1990</option>
				<option value="1991" >1991</option><option value="1992" >1992</option>
				<option value="1993" >1993</option><option value="1994" >1994</option>
				<option value="1995" >1995</option><option value="1996" >1996</option>
				<option value="1997" >1997</option><option value="1998" >1998</option>
				<option value="1999" >1999</option><option value="2000" >2000</option>
				<option value="2001" >2001</option><option value="2002" >2002</option>
				<option value="2003" >2003</option><option value="2004" >2004</option>
				<option value="2005" >2005</option><option value="2006" >2006</option>
				
				

				
              </select>
            </div><!--End form-group-->
			<?php if(isset($dayError)) echo $dayError;?>
			<?php if(isset($monthError)) echo $monthError;?>
			<?php if(isset($yearError)) echo $yearError;?>
				    <div class="form-group">
						<label for="fullname">Email</label>
						<input type="text" name="email" id="email" placeholder="Email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" title="Please write correct email" class="form-control"value="<?php if(isset($email)) echo $email;?>">
					    <?php if(isset($emailError)) echo $emailError;?> 
					</div>
					
					<div class="form-group">
              <label for="contact_no">Contact No</label>
              <input type="text" name="contact_no" placeholder="12********" class="form-control" required pattern="^\d{11}$" title="11 numeric characters only" maxlength="11"value="<?php if(isset($contact)) echo $contact;?>">
              <?php if(isset($contactError)) echo $contactError;?>
			</div><!--End form-group-->
					<div class="form-group">
              <label for="city">City</label>
              <select name="city" id="city" class="form-control demo-default" required>
	<option value="">-- Select --</option><?php if(isset($city)) echo '<option selected="" value="'.$city.'">'.$city.'</option>'; ?> <optgroup title="Maharashtra" label="&raquo;Maharashtra"></optgroup>
<option value=" Amravati " > Amravati </option><option value="Aurangabad" >Aurangabad</option>
<option value=" Akkalkot " > Akkalkot </option><option value="Akola" > Akola</option>
<option value="Bhandara" > Bhandara </option><option value="Beed " > Beed</option>
<option value=" Buldhana" > Buldhana </option><option value="Chandrapur " > Chandrapur </option>
<option value="Dhule " > Dhule </option><option value=" Gadchiroli" > Gadchiroli </option>
<option value=" Gondia" > Gondia </option><option value="Hingoli " > Hingoli </option>
<option value="Jalgaon " > Jalgaon </option><option value="Jalna " > Jalna </option>
<option value=" Kolhapur" > Kolhapur </option><option value=" Latur" > Latur </option>
<option value="Mumbai " > Mumbai </option><option value=" Nagpur" > Nagpur </option>
<option value="Nanded " > Nanded </option><option value="Nashik " > Nashik </option>
<option value="Osmanabad " > Osmanabad </option><option value=" Parbhani" > Parbhani </option>
<option value="Pune " > Pune </option><option value=" Raigad" > Raigad </option>
<option value="Ratnagiri " > Ratnagiri </option><option value=" Sangali" > Sangali </option>
<option value="Satara " > Satara </option><option value="Sindhudurg " > Sindhudurg </option>
<option value=" Solapur" > Solapur </option><option value=" Thane" > Thane </option>
<option value=" Wardha" > Wardha </option><option value=" Washim" > Washim </option>
<option value=" Yavatmal" > Yavatmal </option><option value=" Yeola" > Yeola </option>
<optgroup title="Andhra Pradesh" label="&raquo;Andhra Pradesh"></optgroup>
<option value="Adoni" > Adoni </option><option value="Akkarampalle" > Akkarampalle </option>
<option value="Amalpuram" >Bagh</option><option value=" Amalpuram " >Bhimber</option>
<option value="Avilala" > Avilala </option><option value="Amadalavalasa" > Amadalavalasa </option>
<option value="Badvel" > Badvel </option><option value="Balaga" > Balaga </option>
<option value="Banaganapalle" > Banaganapalle </option><option value="Bobbili" > Bobbili </option>
<option value="Bowluvada" > Bowluvada </option><option value="Bapatla" > Bapatla </option>
<option value="Bandarulanka" > Bandarulanka </option><option value="Beemunipatnam" > Beemunipatnam </option>
<option value="Cherlopalle" > Cherlopalle </option><option value="Chidiga" > Chidiga </option>
<option value="Chirala" > Chirala </option><option value="Chittoor" > Chittoor </option>
<option value="Cumbum" > Cumbum </option><option value="Chodavaram" > Chodavaram </option>
<option value="Dharamvaram" > Dharamvaram </option><option value="Dhone" > Dhone </option>
<option value="Dommara Nandyala" > Dommara Nandyala </option><option value="Dowleswaram" > Dowleswaram </option>
<option value="Dwarakatirumala" > Dwarakatirumala </option><option value="Eluru" > Eluru </option>
<option value="Gooty" > Gooty </option><option value="Gopavaram" > Gopavaram </option>
<option value="Gudur" > Gudur </option><option value="Guntakal" > Guntakal </option>
<option value="Hindapur" > Hindapur </option><option value="Hiramandalam" > Hiramandalam </option>
<option value="Hukumpeta" > Hukumpeta </option><option value="Ichchapuram" > Ichchapuram </option>
<option value="Jaggaiahpet" > Jaggaiahpet </option><option value="Jarjapupeta" > Jarjapupeta </option>
<option value="Kadapa" > Kadapa </option><option value="Kadiri" > Kadiri </option>
<option value="Kanktabamsuguda" > Kanktabamsuguda </option><option value="Kothavalasa" > Kothavalasa </option>
<option value="L.A.Sagaram" > L.A.Sagaram </option><option value="Macherla" > Macherla </option>
<option value="Machilipatnam" > Machilipatnam </option><option value="Mamidalapadu" > Mamidalapadu </option>
<option value="Modameedipalle" > Modameedipalle </option><option value="Moragudi" > Moragudi </option>
<option value="Mulaguntapadu" > Mulaguntapadu </option><option value="Nadim Tiruvuru" > Nadim Tiruvuru </option>
<option value="Nagari" > Nagari </option><option value="Nagireddipalle" > Nagireddipalle </option>
<option value="Nakkapalle" > Nakkapalle </option><option value="Narasapur" > Narasapur </option>
<option value="Ongole" > Ongole </option><option value="Palacole" > Palacole </option>
<option value="Payakaraopeta" > Payakaraopeta </option><option value="Peddapuram" > Peddapuram </option>
<option value="Rajam" > Rajam </option><option value="Ramchandrapuram" > Ramchandrapuram </option>
<option value="Samalkot" > Samalkot </option><option value="Sulluru" > Sulluru </option>
<option value="Tadepalligudem" > Tadepalligudem </option><option value="Thummalamenta" > Thummalamenta </option>
<option value="Tirupati NMA" > Tirupati NMA </option><option value="Uravakonda" > Uravakonda </option>
<option value="Vaddeswaram" > Vaddeswaram </option><option value="Vetapalem" > Vetapalem </option>
<option value="Vizianagaram" > Vizianagaram </option><option value="Yelamanchilli" > Yelamanchilli </option>
<option value="Yenumalapalle" > Yenumalapalle </option><option value="Yerraguntla" > Yerraguntla </option>
</select>
	<?php if(isset($cityError)) echo $cityError;?>           
</div><!--city end-->
			
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" name="password" value="" placeholder="Password" class="form-control" required pattern=".{6,}">
			  <?php if(isset($passwordError)) echo $passwordError;?>
			</div><!--End form-group-->
            <div class="form-group">
              <label for="password">Confirm Password</label>
              <input type="password" name="c_password" value="" placeholder="Confirm Password" class="form-control" required pattern=".{6,}">
			  <?php if(isset($passwordError)) echo $passwordError;?>
			</div><!--End form-group-->
			
            <div class="form-inline">
              <input  type="checkbox" checked="" name="term" value="true" required style="margin-left:10px;">
              <span style="margin-left:10px;"><b>I am agree to donate my blood and show my Name, Contact Nos. and E-Mail in Blood donors List</b></span>
            </div><!--End form-group-->
			
					<div class="form-group">
						<button id="submit" name="submit" type="submit" class="btn btn-lg btn-danger center-aligned" style="margin-top: 20px;">SignUp</button>
					</div>
				</form>
		</div>
	</div>
</div>

<?php 
  //include footer file
  include ('include/footer.php');
?>