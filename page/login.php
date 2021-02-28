<!DOCTYPE html>
<html>
<head>
	<title>OkyDoky</title>
	<meta charset="UTF-8">
	<meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0' >
	<link rel="stylesheet" type="text/css" href="<?= Routes::url_for('/styles/style.css')?>">
</head>
<body>

	<a href="." class="top-left-name-absolute">OkyDoky</a>
	<div class="form-structor">
		<form class="signup" action="<?= Routes::url_for('/signup') ?>" method="POST">
			<h2 class="form-title" id="signup"><span>or</span>Sign up</h2>
			<div class="form-holder">
				<input type="text" name="nickname" class="input" placeholder="Nickname" />
				<input type="email" name="email" class="input" placeholder="Email" />
				<input type="password" name="password" class="input" placeholder="Password" />
			</div>
			<input type="submit" value="Sign up" class="submit-btn"></input>
		</form>
		<form class="login slide-up" action="<?= Routes::url_for('/signin') ?>" method="POST">
			<div class="center">
				<h2 class="form-title" id="login"><span>or</span>Login</h2>
				<div class="form-holder">
					<input type="email" name="login" class="input" placeholder="Email" />
					<input type="password" name="password" class="input" placeholder="Password" />
				</div>
				<input type="submit" value="Login"class="submit-btn"></input>
			</div>
		</form>
	</div>


</body>
<script type='text/javascript'>

/*potentielement à améliorer */
const loginBtn = document.getElementById('login');
const signupBtn = document.getElementById('signup');

loginBtn.addEventListener('click', (e) => {
	let parent = e.target.parentNode.parentNode;
	Array.from(e.target.parentNode.parentNode.classList).find((element) => {
		if(element !== "slide-up") {
			parent.classList.add('slide-up')
		}else{
			signupBtn.parentNode.classList.add('slide-up')
			parent.classList.remove('slide-up')
		}
	});
});

signupBtn.addEventListener('click', (e) => {
	let parent = e.target.parentNode;
	Array.from(e.target.parentNode.classList).find((element) => {
		if(element !== "slide-up") {
			parent.classList.add('slide-up')
		}else{
			loginBtn.parentNode.parentNode.classList.add('slide-up')
			parent.classList.remove('slide-up')
		}
	});
});
</script>
</html>	
