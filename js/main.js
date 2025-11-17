
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
      console.log(response.replace(/["']+/g, ''));
      switch (response.replace(/["']+/g, '')) {
        case 'conexion exitosa':
          setInterval(login(), 2500);
          // Verificar el rol del usuario para redirigir correctamente
          $.ajax({
            url: '/phpserv/get_user_role.php',
            method: 'GET',
            dataType: 'json',
            success: function(role) {
              console.log('Rol del usuario:', role);
              console.log('Tipo de dato:', typeof role);
              
              // Asegurar que la comparación funcione independientemente del formato
              var rolUsuario = typeof role === 'string' ? role : JSON.stringify(role);
              console.log('Rol antes de procesar:', rolUsuario);
              rolUsuario = rolUsuario.replace(/["']+/g, '');
              console.log('Rol procesado:', rolUsuario);
              console.log('¿Es igual a "administrador"?', rolUsuario.toLowerCase() === 'administrador');
              
              setTimeout(function () {
                // Comparar con 'administrador' en lugar de 'admin'
                if (rolUsuario.toLowerCase() === 'administrador') {
                  window.location.href = "auditoria.html";
                } else {
                  window.location.href = "gestorbeta.html";
                }
              }, 2500);
            },
            error: function(xhr, status, error) {
              console.error('Error al obtener el rol:', error);
              console.error('Estado de la solicitud:', status);
              console.error('Respuesta del servidor:', xhr.responseText);
              // Por defecto, redirigir a la página de usuario normal
              setTimeout(function () {
                window.location.href = "gestorbeta.html";
              }, 2500);
            }
          });
          break;
        case 'usuario_bloqueado':
          respuesta.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" style="display: none;"> <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></symbol></svg>
        <div class="alert alert-warning d-flex align-items-center col-8 alert-dismissible fade show justify-content-center"  role="alert">
          <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:"><use xlink:href="#exclamation-triangle-fill"/></svg>
          <div>
            Su cuenta ha sido bloqueada por múltiples intentos fallidos. Contacte al administrador.
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" aria-hidden="true"></button>
        </div>
        `
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

var btn_d = document.getElementById('btn-d');


if (btn_d) {

  btn_d.addEventListener('click', function (e) {

    var form_denu = document.getElementById('form-denu');
    var respuesta_d = document.getElementById('respuesta-d');
    var input_d = document.getElementById('input-d');
    e.preventDefault();

    var datos_denu = new FormData(form_denu);

    respuesta_d.innerHTML = '<div class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Cargando...</span></div></div>';
    fetch('/phpserv/estdenu.php', { method: 'POST', body: datos_denu })
      .then(function(res){ return res.json(); })
      .then(function(data){
        if (Array.isArray(data) && data.length > 0) {
          var html = '<div class="mb-3"><h3 class="text-center mb-4"><i class="fas fa-file-alt me-2"></i>Resultados de la Consulta</h3>';
          data.forEach(function(row){
            var closed = row.fechadesalida && String(row.fechadesalida).trim() !== '';
            var statusText = closed ? 'Finalizado' : 'En proceso';
            var statusClass = closed ? 'badge bg-success' : 'badge bg-warning';
            var expNum = row.numerodeexpediente || row.idexpediente;
            html += '<div class="border rounded p-3 mb-3">';
            html += '<div class="d-flex justify-content-between align-items-center mb-2">';
            html += '<h5 class="mb-0"><i class="fas fa-folder-open me-2"></i>Expediente N° ' + expNum + '</h5>';
            html += '<span class="' + statusClass + '">' + statusText + '</span>';
            html += '</div>';
            html += '<ul class="list-unstyled mb-0">';
            html += '<li><strong>DNI:</strong> ' + row.dnidenunciante + '</li>';
            html += '<li><strong>Fecha de entrada:</strong> ' + new Date(row.fechadeentrada).toLocaleDateString() + '</li>';
            if (closed) { html += '<li><strong>Fecha de salida:</strong> ' + new Date(row.fechadesalida).toLocaleDateString() + '</li>'; }
            if (row.causa) { html += '<li><strong>Causa:</strong> ' + row.causa + '</li>'; }
            if (row.denunciado) { html += '<li><strong>Denunciado:</strong> ' + row.denunciado + '</li>'; }
            html += '</ul>';
            html += '</div>';
          });
          html += '</div>';
          respuesta_d.innerHTML = html;
        } else if (typeof data === 'string' && data.replace(/["']+/g,'') === 'dninoexiste') {
          respuesta_d.innerHTML = '<div class="status-result text-center"><div class="alert alert-warning" role="alert"><i class="fas fa-exclamation-triangle fa-2x mb-3"></i><h4>No se encontraron resultados</h4><p class="mb-0">No se encontraron denuncias asociadas al DNI ingresado.</p></div></div>';
        } else {
          respuesta_d.innerHTML = '<div class="status-result text-center"><div class="alert alert-danger" role="alert"><i class="fas fa-exclamation-circle fa-2x mb-3"></i><h4>Error</h4><p class="mb-0">Ocurrió un error al consultar el estado de la denuncia.</p></div></div>';
        }
      })
      .catch(function(){
        respuesta_d.innerHTML = '<div class="status-result text-center"><div class="alert alert-danger" role="alert"><i class="fas fa-exclamation-circle fa-2x mb-3"></i><h4>Error</h4><p class="mb-0">Ocurrió un error al consultar el estado de la denuncia.</p></div></div>';
      });

  });

}

(function(){
  function injectLogoutStyles(){
    if (document.getElementById('logout-modal-styles')) return;
    var css = [
      ".swal2-popup.logout-modal{background:linear-gradient(135deg,var(--modal-bg1,#2b5876),var(--modal-bg2,#4e4376));color:var(--modal-text,#f1f5f9);border-radius:18px;box-shadow:0 12px 40px rgba(0,0,0,.35)}",
      ".logout-confirm{background:linear-gradient(135deg,#e53935,#c62828)!important;color:#fff!important;border:none!important;border-radius:12px;padding:.6rem 1.2rem;font-weight:600}",
      ".logout-confirm:hover{filter:brightness(1.05)}",
      ".logout-cancel{background:linear-gradient(135deg,var(--modal-cancel-bg1,#6c757d),var(--modal-cancel-bg2,#495057))!important;color:#fff!important;border:none!important;border-radius:12px;padding:.6rem 1.2rem;font-weight:600}",
      ".swal2-icon.logout-icon{border-color:var(--modal-icon-border,#ffd000)!important}"
    ].join("\n");
    var style = document.createElement('style');
    style.id = 'logout-modal-styles';
    style.textContent = css;
    document.head.appendChild(style);
  }
  function doLogout(){
    try{
      fetch('/phpserv/logout.php',{method:'POST'})
        .then(function(r){return r.json();})
        .then(function(){ if (window.redirectToLogin) { window.redirectToLogin(); } else { window.location.href='Login.html'; } })
        .catch(function(){ if (window.redirectToLogin) { window.redirectToLogin(); } else { window.location.href='Login.html'; } });
    }catch(e){
      if (window.redirectToLogin) { window.redirectToLogin(); } else { window.location.href='Login.html'; }
    }
  }
  function showLogout(){
    if (!window.Swal){ doLogout(); return; }
    injectLogoutStyles();
    Swal.fire({
      title:'Confirmar cierre de sesión',
      text:'¿Está seguro que desea cerrar su sesión?',
      icon:'warning',
      iconColor:'#ffd000',
      allowOutsideClick:false,
      allowEscapeKey:true,
      allowEnterKey:true,
      showCancelButton:true,
      reverseButtons:true,
      focusConfirm:true,
      confirmButtonText:'Aceptar',
      cancelButtonText:'Cancelar',
      customClass:{
        popup:'logout-modal',
        confirmButton:'logout-confirm',
        cancelButton:'logout-cancel',
        icon:'logout-icon'
      }
    }).then(function(res){
      if (res.isConfirmed){ doLogout(); }
    });
  }
  function attach(){
    var el = document.getElementById('btnLogout');
    if (!el) return;
    el.addEventListener('click', function(e){ e.preventDefault(); showLogout(); }, {passive:false});
    el.addEventListener('touchstart', function(e){ e.preventDefault(); showLogout(); }, {passive:false});
    el.setAttribute('role','button');
    el.setAttribute('tabindex','0');
    el.addEventListener('keydown', function(e){ if(e.key==='Enter'){ e.preventDefault(); showLogout(); }});
  }
  if (document.readyState==='loading'){
    document.addEventListener('DOMContentLoaded', attach);
  } else {
    attach();
  }
  window.LogoutDialog = { show: showLogout };
})();

/////////REGISTRO DE USUARIOS///////////////////
var btn_regist = document.getElementById('btn-reg');

if (btn_regist) {

  btn_regist.addEventListener('click', function (e) {
    e.preventDefault();
    var formreg = document.getElementById('form-reg');


    var data_reg = new FormData(formreg);
    btn_regist.disabled = true;
    var usuarioVal = (formreg.querySelector('input[name="usuario"]')||{}).value || '';
    var correoVal = (formreg.querySelector('input[name="correo"]')||{}).value || '';
    fetch('/phpserv/check_user_availability.php?usuario=' + encodeURIComponent(usuarioVal) + '&correo=' + encodeURIComponent(correoVal), { method:'GET' })
      .then(r => r.json())
      .then(av => {
        if (av && av.usernameAvailable === false) {
          Swal.fire({ title:'Usuario ya registrado', icon:'warning', text:'El nombre de usuario no está disponible.' });
          btn_regist.disabled = false; return Promise.reject('username duplicate');
        }
        if (av && av.emailAvailable === false) {
          Swal.fire({ title:'Correo ya registrado', icon:'warning', text:'El correo ya existe en el sistema.' });
          btn_regist.disabled = false; return Promise.reject('email duplicate');
        }
        return fetch('/phpserv/registrodb.php', { method:'POST', body: data_reg });
      })
      .then(res => {
        var status = res.status;
        return res.json().then(json => ({ status, json }));
      })
      .then(({ status, json }) => {
        if (status === 200 && json && json.status === 'success') {
          Swal.fire({
            title: 'Registro Exitoso',
            icon: 'success',
            timer: 2500,
            timerProgressBar: true,
            text: 'Redirigiendo al login...'
          });
          setTimeout(function(){ window.location.href = '/Login.html'; }, 2500);
        } else if (status === 409) {
          Swal.fire({
            title: 'Usuario ya registrado',
            icon: 'warning',
            text: 'El correo ya existe en el sistema.'
          });
          try {
            var pass1 = formreg.querySelector('input[name="contrasena"]');
            var pass2 = formreg.querySelector('input[name="contrasena_confirm"]');
            if (pass1) pass1.value = '';
            if (pass2) pass2.value = '';
          } catch(_){}
        } else if (status === 403) {
          Swal.fire({
            title: 'Clave de registro inválida',
            icon: 'error',
            text: (json && json.message) || 'Debe utilizar una contraseña generada por el administrador.'
          });
          try {
            var passField = formreg.querySelector('input[name="contrasena"]');
            if (passField) passField.focus();
          } catch(_){}
        } else {
          Swal.fire({
            title: 'Error',
            icon: 'error',
            text: (json && json.message) || 'No se pudo registrar el usuario.'
          });
        }
      })
      .catch(err => {
        console.error('Error en registro:', err);
        Swal.fire({ title:'Error', icon:'error', text:'Ocurrió un error al procesar el registro.' });
      })
      .finally(() => { btn_regist.disabled = false; });

  })

}


/////////REGISTRO DE EXPEDIENTES/////////////////

var btn_exp = document.getElementById('btn-exp');

if (btn_exp) {


  btn_exp.addEventListener('click', function (e) {
    e.preventDefault();
    var regexp = document.getElementById('regexp');

    var datos_exp = new FormData(regexp);


    fetch('/phpserv/gb_registrar_expediente.php', {
        method: 'POST',
        body: datos_exp,
        credentials: 'same-origin'
      })
      .then(function(res){ return res.json(); })
      .then(function(json){
        if (json && json.status === 'success') {
          var idexp = (json.data && json.data.idexpediente) ? json.data.idexpediente : '';
          Swal.fire({
            title: 'Registro Exitoso',
            icon: 'success',
            html: `<span class="text-success text-center">El Expediente fue registrado exitosamente.</span>${idexp?`<br><span class="text-center text-info">ID: ${idexp}</span>`:''}`,
            confirmButton: 'Aceptar'
          });
        } else {
          var msg = (json && json.message) ? json.message : 'No se pudo registrar el expediente.';
          Swal.fire({ title:'Error', icon:'error', text: msg });
        }
      })
      .catch(function(){ Swal.fire({ title:'Error', icon:'error', text:'No se pudo registrar el expediente.' }); })
  })

}

//Registro de Salida del Expediente

var btn_salida = document.getElementById('btn_salida');

if (btn_salida) {

  btn_salida.addEventListener('click', function (e) {
    e.preventDefault();

    var form_sali = document.getElementById('form-sali');

    var datos_sali = new FormData(form_sali);

    fetch('/phpserv/gb_registrar_salida.php', {
        method: 'POST',
        body: datos_sali,
        credentials: 'same-origin'
      })
      .then(function(res){ return res.json(); })
      .then(function(json){
        if (json && json.status === 'success') {
          var dniVal = datos_sali.get('dni1') || datos_sali.get('dni') || '';
          var fs = (json.data && json.data.fecha_salida) ? json.data.fecha_salida : '';
          Swal.fire({
            title: 'Registro Exitoso',
            icon: 'success',
            html: `<span class="text-success text-center">La fecha de salida para el DNI: <span class="text-center badge bg-dark text-light fs-5"> ${dniVal} </span> fue registrada exitosamente.</span>${fs?`<br><span class=\"text-center text-info\">Fecha: ${fs}</span>`:''}`,
            confirmButton: 'Aceptar'
          });
        } else {
          var msg = (json && json.message) ? json.message : 'No se pudo registrar la salida.';
          Swal.fire({ title:'ERROR', icon:'error', text: msg });
        }
      })
      .catch(function(){ Swal.fire({ title:'ERROR', icon:'error', text:'No se pudo registrar la salida.' }); })


  })
}

//Subida de Noticias

var btn_noti = document.getElementById('btn-noti');

if (btn_noti) {
  btn_noti.addEventListener('click', function (e) {

    e.preventDefault();

    titu = $('#inp-titu').val();
    texto = $('#inp-texto').val();
    
    const imgInput = document.getElementById("inp-img");
    let img = '';
    if (imgInput && imgInput.files && imgInput.files.length > 0) {
      img = imgInput.files[0].name;
    }

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

// Manual element functionality with proper null checks
// Only execute if the element exists in the current page

const ver_manual = document.getElementById('ver_manual');
if (ver_manual) {
  try {
    ver_manual.addEventListener('click', (e) => {
      e.preventDefault();
      window.location.href = "viewmanual.html";
    });
  } catch (err) {
    console.log('Error setting up ver_manual event listener:', err);
  }
}

const descargar_manual = document.getElementById('descargar_manual');
  if (descargar_manual) {
    try {
      descargar_manual.addEventListener('click', (e) => {
        e.preventDefault();
        window.location.href = "MANUAL DE USUARIO Y ADM DE S.A.G.D.F. 2022 0212.pdf"
      });
    } catch (err) {
      console.log('Error setting up descargar_manual event listener:', err);
    }
  }


const tomar_den = document.getElementById('tomar_den');
if (tomar_den) {
  try {
    tomar_den.addEventListener('click', (e) => {
      e.preventDefault();
      const doc = "https://docs.google.com/document/d/17piMDm0Ohw7PAWDyZgaRlpa4Uf97-Nuy/edit?usp=sharing&ouid=116680726476718182494&rtpof=true&sd=true";
      window.open(doc,"_blank");
    });
  } catch (err) {
    console.log('Error setting up tomar_den event listener:', err);
  }
}
//Reportes Graficos 

function crearCadenaLineal(json){
  var parsed = JSON.parse(json);
  var arr = [];
  for(var x in parsed){
    arr.push(parsed[x]);
  }
  return arr;
}

const btn_causas = document.getElementById('btn__causas');
if (btn_causas) {
  try {
    btn_causas.addEventListener('click', (e) => {
      e.preventDefault();
      var forma = document.getElementById('causas_form');
      if (!forma) return;
      var anioEl = document.getElementById('anio');
      var anio = anioEl ? parseInt(String(anioEl.value || '').trim(), 10) : NaN;
      if (!anio || anio < 1900 || anio > 2099) {
        if (window.Swal) {
          Swal.fire({ icon:'warning', title:'Validación', text:'Ingrese un año válido (1900–2099).' });
        } else {
          alert('Ingrese un año válido (1900–2099).');
        }
        return;
      }
      try {
        forma.action = '/phpserv/graficos.php';
        forma.method = 'POST';
        forma.target = '_self';
        forma.submit();
      } catch (err) {
        console.error('Error al enviar formulario de reporte:', err);
        if (window.Swal) {
          Swal.fire({ icon:'error', title:'Error', text:'No se pudo generar el reporte.' });
        } else {
          alert('No se pudo generar el reporte.');
        }
      }
    });
  } catch (err) {
    console.log('Error setting up btn_causas event listener:', err);
  }
}


