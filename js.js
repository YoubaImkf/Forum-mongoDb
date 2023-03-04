
var a = document.querySelectorAll('#add-resp');
var form = document.querySelectorAll('.form-post');

for (let i = 0; i < a.length; i++) {
    a[i].addEventListener('click', (e) => {
      e.preventDefault();
      form[i].classList.toggle('display-none');
    });
  }



  var toResp = document.querySelectorAll('#add-resp-to-resp');
  var formToResp = document.querySelectorAll('.form-post-to-resp');
  
  for (let i = 0; i < toResp.length; i++) {
      toResp[i].addEventListener('click', (e) => {
        e.preventDefault();
        formToResp[i].classList.toggle('display-none');
      });
    }


 