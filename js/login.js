
const loginBtn = document.getElementById('login');
const signupBtn = document.getElementById('signup');

loginBtn.addEventListener('click', (e) => {
	let formSignup = document.getElementById("signupForm");
	let formLogin = document.getElementById("loginForm");
	if (!formSignup.classList.contains("slide-up")){
		
		formSignup.classList.toggle("slide-up");
		formLogin.classList.toggle("slide-up");
	}
});

signupBtn.addEventListener('click', (e) => {
	let formSignup = document.getElementById("signupForm");
	let formLogin = document.getElementById("loginForm");
	if (!formLogin.classList.contains("slide-up")){
		
		formSignup.classList.toggle("slide-up");
		formLogin.classList.toggle("slide-up");
	}
});