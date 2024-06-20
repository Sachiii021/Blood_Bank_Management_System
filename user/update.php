<?php 
include 'include/header.php';

if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
    include 'include/sidebar.php';
    
if (isset($_POST['submit'])) {
    // Validate and sanitize inputs
    if (isset($_POST['name']) && !empty($_POST['name']) && preg_match('/^[A-Za-z\s]+$/', $_POST['name'])) {
        $name = $_POST['name'];
    } else {
        $nameError = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                          <strong>Only letters and spaces are allowed</strong>
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                      </div>';
    }

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

    $day = $_POST['day'];
    $month = $_POST['month'];
    $year = $_POST['year'];
    if (empty($day) || empty($month) || empty($year)) {
        $dobError = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Please select a complete date of birth</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
    } else {
        $dob = $year . '-' . $month . '-' . $day;
    }

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

    if (isset($_POST['email']) && !empty($_POST['email']) && preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $_POST['email'])) {
        $check_email = $_POST['email'];
        $sql = "SELECT email FROM donor WHERE email = '$check_email' AND ID != " . $_SESSION['user_id'];
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

    if (isset($_POST['contact_no']) && !empty($_POST['contact_no']) && preg_match('/^\d{11}$/', $_POST['contact_no'])) {
        $contact = $_POST['contact_no'];
    } else {
        $contactError = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Contact number should consist of 11 digits</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                         </div>';
    }

    if (isset($name) && isset($blood_group) && isset($gender) && isset($dob) && isset($email) && isset($contact) && isset($city)) {
        if ($connection) {
            $name = mysqli_real_escape_string($connection, $name);
            $blood_group = mysqli_real_escape_string($connection, $blood_group);
            $gender = mysqli_real_escape_string($connection, $gender);
            $email = mysqli_real_escape_string($connection, $email);
            $city = mysqli_real_escape_string($connection, $city);
            $contact = mysqli_real_escape_string($connection, $contact);
            
            $sql = "UPDATE donor SET name='$name', blood_group='$blood_group', gender='$gender', email='$email', city='$city', contact_no='$contact', dob='$dob' WHERE ID=" . $_SESSION['user_id'];
            
            if (mysqli_query($connection, $sql)) {
                
				$updateSuccess = '
					<div class="alert alert-success alert-dismissible fade show" role="alert">
						<strong>Data Updated</strong>
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>';
				?>


				<script>
					function myFunction(){
						location.reload();
					}
				</script>
					
					<?php

            } else {
                $updateError = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                  <strong>Data update failed: ' . mysqli_error($connection) . '</strong>
                                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>';
            }
        }
		$sql = "SELECT * FROM DONOR WHERE ID = " . $_SESSION['user_id'];
		$result = mysqli_query($connection, $sql);
		
		while ($row = mysqli_fetch_assoc($result)) {
			$userID = $row['id'];
			$name = $row['name'];
			$blood_group = $row['blood_group'];
			$gender = $row['gender'];
			$email = $row['email'];
			$contact = $row['contact_no'];
			$city = $row['city'];
			$dob = $row['dob'];
			// Split the date into day, month, and year
			$date = explode("-", $dob);
			$dbPassword = $row['password'];
		}
	}
		if(isset($_POST['update_pass'])){
			 // Validate password
			 if (isset($_POST['old_password']) && !empty($_POST['old_password']) && 
			 isset($_POST['c_password']) && !empty($_POST['c_password'])
			 && isset($_POST['new_password']) && !empty($_POST['new_password'])) {
             
			  $old_password =	md5($_POST['old_password']);

			  if($old_password == $dbPassword){
                  
				if (strlen($_POST['new_password']) >= 6) {
					if ($_POST['new_password'] == $_POST['c_password']) {
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

			  }else{
				$passwordError = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
											<strong>Please enter valid password</strong>
											<button type="button" class="close" data-dismiss="alert" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
										</div>';
			  }
			  }

				
			} else {
				$passwordError = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
									<strong>Please fill Password field</strong>
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>';
			}
			if(isset($password)){
				$sql = "UPDATE donor SET password ='$password' WHERE id='$userID'";
				if (mysqli_query($connection, $sql))  {
					
					$updatePasswordSuccess = '
					<div class="alert alert-success alert-dismissible fade show" role="alert">
						<strong>Updated Password</strong>
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>';
					?>
					<script>
						function myFunction(){
							location.reload();
						}
					</script>
					<?php
					exit;
					 } else {
					$passwordError = '
					<div class="alert alert-danger alert-dismissible fade show" role="alert">
						<strong>Error updating record. Please try again later.</strong>
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>';
				}
			}
	
		}
   
include 'include/sidebar.php';

				}else{
					// Error message if query execution fails
					$updateError = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
						<strong>Data  updated ' . mysqli_error($connection) . '</strong>
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>';
				}
			
	
		
			
				if (isset($_POST['delete_account'])) {
					if (isset($_POST['account_password']) && !empty($_POST['account_password'])) {
						$account_password = md5($_POST['account_password']);
						if ($account_password == $dbPassword) {
							$showForm = '
							<div class="alert ggalert-success alert-dismissible fade show" role="alert">
								<strong>Are you sure you want to delete your account?</strong>
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
								<form method="post">
									<br>
									<input type="hidden" name="userID" value="' . htmlspecialchars($_SESSION['user_id']) . '">
									<button name="updateSave" type="submit" class="btn btn-danger">Yes</button>
									<button type="button" class="btn btn-info" data-dismiss="alert"><span aria-hidden="true">Oops! No</span></button>
								</form>
							</div>';
						} else {
							$deleteAccountError = '
							<div class="alert alert-danger alert-dismissible fade show" role="alert">
								<strong>Please enter a valid password.</strong>
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>';
						}
					}
				}
				
		 if (isset($_POST['userID'])) {
			
			}

		
include 'include/sidebar.php';
?>

<style>
	.form-group{
		text-align: left;
	}
	.form-container{

		padding: 20px 10px 20px 30px;

	}
</style>
			<div class="container" style="padding: 60px 0;">
			<div class="row">

				
				
				<div class="card col-md-6 offset-md-3">
					<div class="panel panel-default" style="padding: 20px;">
					<!------ Error message ------>
					<?php 
						if(isset($showForm)) echo $showForm;
						if(isset($deletesubmitError)) echo $deletesubmitError;
					      if(isset($updateError)) echo $updateError; 
						 if(isset($updateSuccess)) echo $updateSuccess; 
						 ?>
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
                <option value="O-">O+</option>
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
                <?php if(isset($date['2'])) echo '<option selected="" value="'.$date['2'].'">'.$date['2'].'</option>'; ?>     
                <option value="01" >01</option><option value="02" >02</option><option value="03" >03</option><option value="04" >04</option><option value="05" >05</option><option value="06" >06</option><option value="07" >07</option> <option value="08" >08</option><option value="09" >09</option><option value="10" >10</option><option value="11" >11</option><option value="12" >12</option><option value="13" >13</option><option value="14" >14</option><option value="15" >15</option><option value="16" >16</option><option value="17" >17</option><option value="18" >18</option><option value="19" >19</option><option value="20" >20</option><option value="21" >21</option><option value="22" >22</option><option value="23" >23</option><option value="24" >24</option><option value="25" >25</option><option value="26" >26</option><option value="27" >27</option><option value="28" >28</option><option value="29" >29</option><option value="30" >30</option><option value="31" >31</option>
              </select>
              <select class="form-control demo-default" name="month" id="month" style="margin-bottom:10px;" required>
                <option value="">---Month---</option>
				<?php if(isset($date['1'])) echo '<option selected="" value="'.$date['1'].'">'.$date['1'].'</option>'; ?>     
                <option value="01" >January</option><option value="02" >February</option>
				<option value="03" >March</option><option value="04" >April</option>
				<option value="05" >May</option><option value="06" >June</option>
				<option value="07" >July</option><option value="08" >August</option>
				<option value="09" >September</option><option value="10" >October</option>
				<option value="11" >November</option><option value="12" >December</option>
              </select>
              <select class="form-control demo-default" id="year" name="year" style="margin-bottom:10px;" required>
                <option value="">---Year---</option>
				<?php if(isset($date['0'])) echo '<option selected="" value="'.$date['0'].'">'.$date['0'].'</option>'; ?>     
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
	<option value="">-- Select --</option><?php if(isset($city)) echo '<option selected="" value="'.$city.'">'.$city.'</option>'; ?>  <optgroup title="Azad Jammu and Kashmir " label="&raquo; Azad Jammu and Kashmir (Azad Kashmir)">

	</optgroup>	<optgroup title="Maharashtra" label="&raquo;Maharashtra"></optgroup>
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
						<button id="submit" name="submit" type="submit" class="btn btn-lg btn-danger center-aligned" style="margin-top: 20px;">Update</button>
					</div>
				</form>
					

					<!-- Messages -->	
					
						<form action="" method="post" class="form-group form-container" >
						

							<div class="form-group">
							
								<label for="oldpassword">Current Password</label>
								<input type="password" required name="old_password" placeholder="Current Password" class="form-control">
						        <?php if(isset($passwordError)) echo $passwordError;
								if(isset($updatePasswordSuccess)) echo $updatePasswordSuccess;
								?>
							</div>
							<div class="form-group">
								<label for="newpassword">New Password</label>
								<input type="password" required name="new_password" placeholder="New Password" class="form-control">
								<?php if(isset($passwordError)) echo $passwordError; ?>
							</div>
							<div class="form-group">
								<label for="c_password">Confirm Password</label>
								<input type="password" required name="c_password" placeholder="Confirm Password" class="form-control">
								<?php if(isset($passwordError)) echo $passwordError; ?>
							</div>
							<div class="form-group">
								<button class="btn btn-lg btn-danger center-aligned" type="submit" name="update_pass">Update Password</button>
							</div>
						</form>
					</div>
				</div>


				<div class="card col-md-6 offset-md-3">
					
					<!-- Display Message -->
					<?php if(isset($deleteAccountError)) echo $deleteAccountError;
					 ?>
					<div class="panel panel-default" style="padding: 20px;">
						<form action="" method="post" class="form-group form-container" >
							
							<div class="form-group">
								<label for="oldpassword">Password</label>
								<input type="password" required name="account_password" placeholder="Current Password" class="form-control">
							</div>

							<div class="form-group">
								<button class="btn btn-lg btn-danger center-aligned" type="submit" name="delete_account">Delete Account</button>
							</div>

						</form>
					</div>
				</div>

			</div>
		</div>
	
<?php include 'include/footer.php'; ?>  