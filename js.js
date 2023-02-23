
var a = document.querySelectorAll('.topic h4');
var form = document.querySelectorAll('.form-post');

for (let i = 0; i < a.length; i++) {
    a[i].addEventListener('click', (e) => {
      e.preventDefault();
      form[i].classList.toggle('display-none');
    });
  }