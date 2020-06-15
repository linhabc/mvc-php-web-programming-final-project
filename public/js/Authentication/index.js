var x = document.getElementById('login');
var y = document.getElementById('register');
var z = document.getElementById('btn');

function register() {
  x.style.left = '-400px';
  y.style.left = '50px';
  z.style.left = '110px';
}

function login() {
  x.style.left = '50px';
  y.style.left = '450px';
  z.style.left = '0';
}

function showPass() {
  var x = document.getElementById('myPass');
  var y = document.getElementById('hide1');
  var z = document.getElementById('hide2');
  if (x.type === 'password') {
    x.type = 'text';
    y.style.display = 'block';
    z.style.display = 'none';
  } else {
    x.type = 'password';
    y.style.display = 'none';
    z.style.display = 'block';
  }
}

function showPass0() {
  var x = document.getElementById('myPass0');
  var y = document.getElementById('hide_1');
  var z = document.getElementById('hide_2');
  if (x.type === 'password') {
    x.type = 'text';
    y.style.display = 'block';
    z.style.display = 'none';
  } else {
    x.type = 'password';
    y.style.display = 'none';
    z.style.display = 'block';
  }
}

function coming() {
  alert('Coming soon...');
}