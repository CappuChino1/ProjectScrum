
<?php
    session_start();
    include('server.php'); 

?>

<head><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" 
rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
 crossorigin="anonymous">
 <title>InFridge - Login</title>


</head>

<body>
<?php include('errors.php'); ?>
            <?php if (isset($_SESSION['error'])) : ?>
            <div class="error">
                <label class="" style="margin-left: 28%; margin-top: 7px; font-weight: bold; font-size : 23px">
                    <?php 
                        echo $_SESSION['error'];
                        unset($_SESSION['error']);
						header("Refresh:1; url=login.php"); 
                    ?>
                </label>
            </div>
        <?php endif ?>	
<div class="container-fluid border-3 h-75" >


	

<!-- New Login -->
<div class="container h-100 w-75" id="container">
	<!-- ส่วน register ขวามือ -->
	<div class="form-container sign-up-container">
	     <form action="register_db.php" method="post">        
		<div  class="  h-75 mt-5 ">
			<h1 class="mb-3" style="color: #253E5E;">สร้างบัญชี</h1>
			
			<span style="color: #253E5E;">หรือใช้อีเมลล์ของท่านในการลงทะเบียน</span>
			<div class="my-4 container-fluid">
			<input required class="mt-2 w-75 rounded-pill" type="text" name = "username" placeholder="Name" />
			
			<input required class="mt-3 w-75 rounded-pill" type="password" name = "password_1" placeholder="Password" />
			</div>
			<div class="mt-4">
			<button type="submit" name="reg_user">Sign Up</button>
			</div>
		</div>
		</form>
	</div>
	<!------------------->
<!-- ส่วน Login ซ้ายมือ -->
	<div class="form-container sign-in-container  ">
	<form action="login_db.php" method="post">


            <div  class="  h-100 mt-5">
            <img src="img/infridgelog.png"  class="mb-3" style="width: 300px;">
			<h1 class="mb-3" style="color: #253E5E;">ลงชื่อเข้าใช้</h1>
		
			<span style="color: #253E5E;">หรือเข้าใช้บัญชีของท่าน</span>
			<div class="my-4 container-fluid">
			<input required class=" rounded-pill" type="text" name = "username"  placeholder="Username">
			<input required class=" rounded-pill" type="password" name = "password"  placeholder="Password">
			</div>
			
			<div class="mt-4">
			<button type ="submit" name = "login_user" >
					<span class="button__text">Log In</span>
				
				</button>		
		</div>
		
				</div>
		</form>
	</div>
     <!------------------->
	<!-- ส่วนข้อความ Overlay ที่สับเปลี่ยน -->
	<div class="overlay-container">
		<div class="overlay">
			<div class="overlay-panel overlay-left">
				<h1>Welcome Back!</h1>
				<p>เพื่อที่จะเข้าใช้งาน InFridge โปรดล็อกอินด้วยข้อมูลของท่าน</p>
				<span class="mb-2">กดปุ่มข้างล่างนี้หลังจากสร้างบัญชีสำเร็จ</span>
				<button class="ghost mt-4" id="signIn">Sign In</button>
			</div>
			<div class="overlay-panel overlay-right">
				<h1>สวัสดี, ยินดีต้อนรับ!</h1>
				<p>ก่อนจะเข้าใช้งาน InFridge ต้องลงทะเบียนก่อน</p>
				<span class="mb-2">กดปุ่มข้างล่างนี้</span>
				<button class="ghost mt-4" id="signUp">Sign Up</button>
			</div>
		</div>
	</div>
	<!------------------->
</div>
<!-- New Login -->

<!-- JS ใช้สลับหน้า-->
<script>
const signUpButton = document.getElementById('signUp');
const signInButton = document.getElementById('signIn');
const container = document.getElementById('container');

signUpButton.addEventListener('click', () => {
	container.classList.add("right-panel-active");
});

signInButton.addEventListener('click', () => {
	container.classList.remove("right-panel-active");
});
</script>
<!-------style details for decoration---------->
</div>
</body>


<style>
    @import url('https://fonts.googleapis.com/css?family=Raleway:400,700');

* {
	box-sizing: border-box;
	margin: 0;
	padding: 0;	
	font-family: Raleway, sans-serif;
}


@import url('https://fonts.googleapis.com/css?family=Montserrat:400,800');

* {
	box-sizing: border-box;
}

body {
	background: linear-gradient(to top,#Add8e6,#4682b4,#00386B) ;
	display: flex;
	justify-content: center;
	align-items: center;
	flex-direction: column;
	font-family: 'Montserrat', sans-serif;
	height: 100vh;
	margin: -20px 0 50px;
}

h1 {
	font-weight: bold;
	margin: 0;
}

h2 {
	text-align: center;
}

p {
	font-size: 14px;
	font-weight: 100;
	line-height: 20px;
	letter-spacing: 0.5px;
	margin: 20px 0 30px;
}

span {
	font-size: 12px;
}

a {
	color: #333;
	font-size: 14px;
	text-decoration: none;
	margin: 15px 0;
}

button {
	border-radius: 20px;
	border: 1px solid #FF4B2B;
	background-color: #FF4B2B;
	color: #FFFFFF;
	font-size: 12px;
	font-weight: bold;
	padding: 12px 45px;
	letter-spacing: 1px;
	text-transform: uppercase;
	transition: transform 80ms ease-in;
}

button:active {
	transform: scale(0.95);
}

button:focus {
	outline: none;
}

button.ghost {
	background-color: transparent;
	border-color: #FFFFFF;
}

form {
	background-color: #FFFFFF;
	display: flex;
	align-items: center;
	justify-content: center;
	flex-direction: column;
	padding: 0 50px;
	height: 100%;
	text-align: center;
}

input {
	background-color: #eee;
	border: none;
	padding: 12px 15px;
	margin: 8px 0;
	width: 100%;
}

.container {
	background-color: #fff;
	border-radius: 10px;
  	box-shadow: 0 14px 28px rgba(0,0,0,0.25), 
			0 10px 10px rgba(0,0,0,0.22);
	position: relative;
	overflow: hidden;
	width: 768px;
	max-width: 100%;
	min-height: 480px;
}

.form-container {
	position: absolute;
	top: 0;
	height: 100%;
	transition: all 0.6s ease-in-out;
}

.sign-in-container {
	left: 0;
	width: 50%;
	z-index: 2;
}

.container.right-panel-active .sign-in-container {
	transform: translateX(100%);
}

.sign-up-container {
	left: 0;
	width: 50%;
	opacity: 0;
	z-index: 1;
}

.container.right-panel-active .sign-up-container {
	transform: translateX(100%);
	opacity: 1;
	z-index: 5;
	animation: show 0.6s;
}

@keyframes show {
	0%, 49.99% {
		opacity: 0;
		z-index: 1;
	}
	
	50%, 100% {
		opacity: 1;
		z-index: 5;
	}
}

.overlay-container {
	position: absolute;
	top: 0;
	left: 50%;
	width: 50%;
	height: 100%;
	overflow: hidden;
	transition: transform 0.6s ease-in-out;
	z-index: 100;
}

.container.right-panel-active .overlay-container{
	transform: translateX(-100%);
}

.overlay {
	background: #25639B;
	background: -webkit-linear-gradient(to right, #FFC700 50%, #25639B 50%);
	background: linear-gradient(to right, #FFC700 50%, #25639B 50%);
	background-repeat: no-repeat;
	background-size: cover;
	background-position: 0 0;
	color: #FFFFFF;
	position: relative;
	left: -100%;
	height: 100%;
	width: 200%;
  	transform: translateX(0);
	transition: transform 0.6s ease-in-out;
}

.container.right-panel-active .overlay {
  	transform: translateX(50%);
}

.overlay-panel {
	position: absolute;
	display: flex;
	align-items: center;
	justify-content: center;
	flex-direction: column;
	padding: 0 40px;
	text-align: center;
	top: 0;
	height: 100%;
	width: 50%;
	transform: translateX(0);
	transition: transform 0.6s ease-in-out;
}

.overlay-left {
	transform: translateX(-20%);
}

.container.right-panel-active .overlay-left {
	transform: translateX(0);
}

.overlay-right {
	right: 0;
	transform: translateX(0);
}

.container.right-panel-active .overlay-right {
	transform: translateX(20%);
}

.social-container {
	margin: 20px 0;
}

.social-container a {
	border: 1px solid #DDDDDD;
	border-radius: 50%;
	display: inline-flex;
	justify-content: center;
	align-items: center;
	margin: 0 5px;
	height: 40px;
	width: 40px;
}

footer {
    background-color: #222;
    color: #fff;
    font-size: 14px;
    bottom: 0;
    position: fixed;
    left: 0;
    right: 0;
    text-align: center;
    z-index: 999;
}

footer p {
    margin: 10px 0;
}

footer i {
    color: red;
}

footer a {
    color: #3c97bf;
    text-decoration: none;
}
.error{
	color: #253E5E;
	padding: 1px;
	background-color: #FAF9F6;
    width: 700px;
	height: 50px;
	border-radius: 10px;
	outline-style: solid;
	outline-color: #FFC700;
	margin-bottom: 40px;
	vertical-align: baseline;
	text-decoration: none;
	box-shadow: 0px 0px 15px lightblue;

}

</style>