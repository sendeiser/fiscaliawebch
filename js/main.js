
/////////////////Logueo/Login//////////////////////
function login() {
  const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 2500,
    timerProgressBar: true,
    didOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
  })

  Toast.fire({
    icon: 'success',
    title: 'Signed in successfully'
  })

}
let btn_login = document.getElementById('btn-L');

if (btn_login) {

  btn_login.addEventListener('click', function (e) {

    e.preventDefault();

    usuario = $('#input_name').val();
    contrasena = $('#input_contra').val();
   

    var respuesta = document.getElementById('respuesta');
    
    $.post('/phpserv/logueodb.php', {
      usuario,
      contrasena
    }, (response) => {
      console.log(response.replace(/['"]+/g, ''));
      switch (response.replace(/['"]+/g, '')) {
        case 'conexion exitosa':
          setInterval(login(), 2500);
          setTimeout(function () {
            window.location.href = "gestorbeta.html";
          }, 2500);

          break
        case 'contrasena incorrecta':
          respuesta.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" style="display: none;"> <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></symbol></svg>
        <div class="alert alert-danger d-flex align-items-center col-8 alert-dismissible fade show justify-content-center"  role="alert">
          <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
          <div>
            La contraseña es incorrecta! Por favor verifique y vuelva a escribirla.
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" aria-hidden="true"></button>
        </div>
        `
          break

        case 'usuario incorrecto':
          respuesta.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" style="display: none;"> <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></symbol></svg>
        <div class="alert alert-danger d-flex align-items-center col-8 alert-dismissible fade show justify-content-center"  role="alert">
          <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
          <div>
            El usuario es incorrecto! Por favor verifique y vuelva a escribirlo.
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" aria-hidden="true"></button>
        </div>
        `
          break
        default:
          respuesta.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" style="display: none;"> <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></symbol></svg>
          <div class="alert alert-danger d-flex align-items-center col-8 alert-dismissible fade show justify-content-center"  role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
            <div>
              El usuario o la contraseña son incorrectos!  Por favor verifique y vuelva a escribirlos.
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" aria-hidden="true"></button>
          </div>
          `
          break
      }
    })




  });

}

/////////////////Estado de Denuncia///////////////////
var btn_d = document.getElementById('btn-d');


if (btn_d) {

  btn_d.addEventListener('click', function (e) {

    var form_denu = document.getElementById('form-denu');
    var respuesta_d = document.getElementById('respuesta-d');
    var input_d = document.getElementById('input-d');
    e.preventDefault();

    var datos_denu = new FormData(form_denu);


    fetch('/phpserv/estdenu.php', {
        method: 'POST',
        body: datos_denu

      })
      .then(res => res.json())
      .then(data => {
        if (data === 'noprocesada') {
          respuesta_d.innerHTML = `
     <br>
                     <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                      <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                      </symbol>
                    </svg>
                    <div class="alert alert-primary d-flex align-items-center" role="alert">
                      <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#info-fill"/></svg>
                      <div>
                        Su denuncia esta proxima a ser procesada a la autoridad correspondiente
                      </div>
                    </div>
     `
        } 
        else if (data==='dninoexiste')
        {
              alert('El DNI  que ingreso no existe por favor ingrese un DNI ya cargado previamente.')
        }

        else {
          respuesta_d.innerHTML = `
         <br>
                         <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                          <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                          </symbol>
                        </svg>
                        <div class="alert alert-success d-flex align-items-center" role="alert">
                          <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
                          <div>
                          Su denuncia ya se proceso en Fiscalia y paso al Juzgado el dia: ${data} 
                          </div>
                        </div>
         
         `
        }

      })

  });

}

/////////REGISTRO DE USUARIOS///////////////////
var btn_regist = document.getElementById('btn-reg');

if (btn_regist) {

  btn_regist.addEventListener('click', function (e) {
    e.preventDefault();
    var formreg = document.getElementById('form-reg');


    var data_reg = new FormData(formreg);

    fetch('/phpserv/registrodb.php', {
        method: 'POST',
        body: data_reg
      }).then(res => res.json())
      .then(data => {
        if (data === 'exitoso') {


          Swal.fire({
            title: 'Registro Exitoso!',
            icon: 'success',
            html: `<p><strong>Logueese con su usuario y contraseña para gestionar el sistema</strong></p>`
          })



        } else {
          Swal.fire({
            title: 'Error!',
            icon: 'warning',
            html: `Info: ${data}`
          })
        }
      })

  })

}


/////////REGISTRO DE EXPEDIENTES/////////////////

var btn_exp = document.getElementById('btn-exp');

if (btn_exp) {


  btn_exp.addEventListener('click', function (e) {
    e.preventDefault();
    var regexp = document.getElementById('regexp');

    var datos_exp = new FormData(regexp);


    fetch('/phpserv/regexp.php', {
        method: 'POST',
        body: datos_exp
      }).then(res => console.log(res.json()))
      .then(data => {
        if (data === 'personanueva') {
          Swal.fire({
            title: 'Registro Exitoso',
            icon: 'success',
            html: `<span class="text-success text-center">El Expediente fue registrado exitosamente a la base de datos</span><br><span class="text-center text-info">${data}</span>`,
            confirmButton: 'Aceptar'
          })
        } else {
          Swal.fire({
            title: 'Registro Exitoso',
            icon: 'success',
            html: `<span class="text-success text-center">El Expediente fue registrado exitosamente a la base de datos</span><br><span class="text-center text-info">${data}</span>`,
            confirmButton: 'Aceptar'
          })

        }
      })
  })

}

//Registro de Salida del Expediente

var btn_salida = document.getElementById('btn_salida');

if (btn_salida) {

  btn_salida.addEventListener('click', function (e) {
    e.preventDefault();

    var form_sali = document.getElementById('form-sali');

    var datos_sali = new FormData(form_sali);

    fetch('/phpserv/regexp.php', {
        method: 'POST',
        body: datos_sali
      }).then(res => res.json())
      .then(data => {
        console.log(data);

        if (data === 'exitoso') {
          Swal.fire({
            title: 'Registro Exitoso',
            icon: 'success',
            html: `<span class="text-success text-center">La Fecha del Expediente para el DNI: <span class="text-center badge bg-dark text-light fs-5"> ${datos_sali.get('dni1')} </span> fue registrado exitosamente a la base de datos</span>`,
            confirmButton: 'Aceptar'
          })
        }
        else if(data === 'dninoexiste')
        {
          Swal.fire({
            title: 'ERROR',
            icon: 'error',
            html: `<span class="text-danger text-center">El DNI igresado no existe en la base de datos, por favor verifique.</span><br><span class="text-center text-info text-uppercase">${data}</span>`,
            confirmButton: 'Aceptar'
          })
        } 
        else {
          Swal.fire({
            title: 'ERROR',
            icon: 'error',
            html: `<span class="text-danger text-center">Hubo erro inesperado al cargar los datos.</span><br><span class="text-center text-info">${data}</span>`,
            confirmButton: 'Aceptar'
          })

        }

      })


  })
}

//Subida de Noticias

var btn_noti = document.getElementById('btn-noti');

if (btn_noti) {
  btn_noti.addEventListener('click', function (e) {

    e.preventDefault();

    titu = $('#inp-titu').val();
    texto = $('#inp-texto').val();
    img = document.getElementById("inp-img").files[0].name;

    $.post('phpserv/carganoti.php', {
      titu,
      texto,
      img
    }, (response) => {


      var form_data = new FormData($('#form_img')[0]);

      $.ajax({
        data: form_data,
        url: "phpserv/carganoti.php",
        type: "POST",
        cahe: false,
        contentType: false,
        processData: false,
        beforeSend: function () {

          let timerInterval
          Swal.fire({
            title: 'Subiendo la Noticia',
            html: 'Progreso de la carga <b></b> en milisegundos.',
            timer: 3000,
            timerProgressBar: true,
            allowOutsideClick: false,
            allowEnterkey: false,
            allowEscapekey: false,
            didOpen: () => {
              Swal.showLoading()
              timerInterval = setInterval(() => {
                const content = Swal.getHtmlContainer()
                if (content) {
                  const b = content.querySelector('b')
                  if (b) {
                    b.textContent = Swal.getTimerLeft()
                  }
                }
              }, 100)
            },
            willClose: () => {
              clearInterval(timerInterval)
            }
          }).then((result) => {
            /* Read more about handling dismissals below */
            if (result.dismiss === Swal.DismissReason.timer) {
              console.log('I was closed by the timer')
            }
          })

        },
        success: function (r) {
          data = JSON.parse(r);
          if (data === 'exito') {
            Swal.fire({
              title: '¡Todo Okey!',
              icon: 'success',
              html: `<span class="text-success text-center">La noticia se ha subido exitosamente.</span>`,
              confirmButton: 'Aceptar'
            })

          }
        }
      });



    })


  })

}

//Reportes Graficos 

/* function crearCadenaLineal(json){
  var parsed = JSON.parse(json);
  var arr = [];
  for(var x in parsed){
    arr.push(parsed[x]);
  }
  return arr;
}
var btn_causas = document.getElementById('btn__causas');
if(btn_causas){
  btn_causas.addEventListener('click', (e) => {
    e.preventDefault();
    causa_form = document.getElementById('causas_form')
    var causa_type = new FormData(causa_form);
    fetch('/phpserv/graficos.php', {
      method: 'POST',
      body: causa_type
    }).then(res => res.json())
    .then(data => {
      console.log(data)
    })
  })
} */
