/////////////////Logueo/Login//////////////////////
function login(){
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
var btn_login = document.getElementById('btn-L');

if(btn_login){

  btn_login.addEventListener('click',function(e){ 
  
    e.preventDefault();
    var formsesion = document.getElementById('sesion');
    var respuesta = document.getElementById('respuesta');
    
    var datos = new FormData(formsesion);
   

    fetch('/phpserv/logueodb.php',{
    method:'POST',
    body: datos

      }).then(res => res.json())
      .then(data => {
        switch (data) {
          case 'conexion exitosa':
            setInterval(login(),2500);
            setTimeout(function(){window.location.href="gestor.php?seguridad=1";},2500);
            
            break
          case 'contraseña incorrecta':
          respuesta.innerHTML=`<svg xmlns="http://www.w3.org/2000/svg" style="display: none;"> <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></symbol></svg>
          <div class="alert alert-danger d-flex align-items-center col-8 alert-dismissible fade show"  role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
            <div>
              La contraseña es incorrecta! Por favor verifique y vuelva a escribirla.
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" aria-hidden="true"></button>
          </div>
          `      
            break
        
          case 'usuario incorrecto':
            respuesta.innerHTML=`<svg xmlns="http://www.w3.org/2000/svg" style="display: none;"> <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></symbol></svg>
          <div class="alert alert-danger d-flex align-items-center col-8 alert-dismissible fade show"  role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
            <div>
              El usuario es incorrecto! Por favor verifique y vuelva a escribirlo.
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" aria-hidden="true"></button>
          </div>
          `  
            break
          default:
            respuesta.innerHTML=`<svg xmlns="http://www.w3.org/2000/svg" style="display: none;"> <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></symbol></svg>
            <div class="alert alert-danger d-flex align-items-center col-8 alert-dismissible fade show"  role="alert">
              <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
              <div>
                El usuario y la contraseña son incorrectos! Por favor verifique y vuelva a escribirlos.
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


if(btn_d){

 btn_d.addEventListener('click',function(e){

  var form_denu= document.getElementById('form-denu');
  var respuesta_d = document.getElementById('respuesta-d');
  var input_d = document.getElementById('input-d');
  e.preventDefault();
  
  var datos_denu = new FormData(form_denu);


  fetch('/phpserv/estdenu.php',{ 
    method: 'POST',
    body: datos_denu
    
  })
 
  
  .then(res => res.json())
    .then(data => {
     if(data==='noprocesada'){
     respuesta_d.innerHTML=`
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
     else{
         respuesta_d.innerHTML=`
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

if(btn_regist){

  btn_regist.addEventListener('click',function(e){
      e.preventDefault();
      var formreg= document.getElementById('form-reg');
      var resp_reg = document.getElementById('resp-reg');

    var data_reg = new FormData(formreg);
  
    fetch('/phpserv/registrodb.php',{
      method: 'POST',
      body: data_reg
    }).then(res => res.json())
    .then(data => {
      if (data === 'exitoso'){

        
        Swal.fire({
        title:'Registro Exitoso!',
        icon: 'success',
        html:`<p><strong>Logueese con su usuario y contraseña para gestionar el sistema</strong></p>`
         })

       
        
      }
      else{
        Swal.fire({
          title:'Error!',
          icon: 'warning',
          html: `Info: ${data}`
           })  
      }
    })
  
  })

}


/////////REGISTRO DE EXPEDIENTES/////////////////

var btn_exp = document.getElementById('btn-exp');

if(btn_exp){


    btn_exp.addEventListener('click',function(e){  
          e.preventDefault();
          var regexp= document.getElementById('regexp');
          
          var datos_exp = new FormData(regexp);

  
          fetch('/phpserv/regexp.php',{
            method: 'POST',
            body: datos_exp
                        }).then(res => res.json())
                          .then(data => {
                              if(data==='personanueva'){
                                Swal.fire({
                                  title: 'Registro Exitoso',
                                  icon: 'success',
                                  html:`<span class="text-success text-center">El Expediente fue registrado exitosamente a la base de datos</span><br><span class="text-center text-info">${data}</span>`,
                                  confirmButton: 'Aceptar'
                                })
                              }
                              else{
                                Swal.fire({
                                  title: 'Registro Exitoso',
                                  icon: 'success',
                                  html:`<span class="text-success text-center">El Expediente fue registrado exitosamente a la base de datos</span><br><span class="text-center text-info">${data}</span>`,
                                  confirmButton: 'Aceptar'
                                        }) 

                                }
                           })
        })

}

//Registro de Salida del Expediente

var btn_salida= document.getElementById('btn_salida');

if(btn_salida){ 

  btn_salida.addEventListener('click',function(e){
  e.preventDefault();

        var form_sali= document.getElementById('form-sali');

          var datos_sali= new FormData(form_sali);

          fetch('/phpserv/regexp.php',{
            method: 'POST',
            body: datos_sali
                        }).then(res => res.json())
                          .then(data => { 
                            if(data==='exitoso'){
                              Swal.fire({
                                title: 'Registro Exitoso',
                                icon: 'success',
                                html:`<span class="text-success text-center">La Fecha del Expediente para el DNI: <span class="text-center badge bg-dark text-light fs-5"> ${datos_sali.get('dni1')} </span> fue registrado exitosamente a la base de datos</span>`,
                                confirmButton: 'Aceptar'
                              })
                            }
                            else{
                              Swal.fire({
                                title: 'ERROR',
                                icon: 'warning',
                                html:`<span class="text-success text-center">Hubo erro inesperado al cargar los datos.</span><br><span class="text-center text-info">${data}</span>`,
                                confirmButton: 'Aceptar'
                                      }) 

                                }

                          })


        })
}



