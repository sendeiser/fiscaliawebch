function actualizar(){location.reload(true);}

(async() => {

    const{value: password} = await Swal.fire({
        title: '<h1 style="color:#0de77ed0"><b>Contraseña de Acceso<b></h1>',
        input:'password',
        icon:'warning',
        html: '<p class="text-light">Para poder ingresar necesita ser un empleado de fiscalia y pedir su contraseña en la misma.</p>',
    inputPlaceholder: 'Ingrese la contraseña',
    iconColor:'#ffd000',
    padding: '10px',
    background:'#558776',
    allowOutsideClick: false,
    allowEnterkey:false,
    allowEscapekey:false,
    showCancelButton: true,
    reverseButtons: true,
    cancelButtonColor: '#1a35ac',
    cancelButtonText: 'Volver',
    confirmButtonText: 'Confirmar',
    confirmButtonColor: '#3eaa46', 
    inputAttributes: {
        maxLength:16,
        autocapitalize:'off',
        autocorrect:'off'
    }
       
    })

    if (password=='fiscaliach2021') {
        Swal.fire({
            iconColor:'#00EAD3',
            title:'<h1 class="border bg-primary" style="color:#0de77ed0;">Bienvenido</h1>',
            icon: 'success',
            background:'#A2DBFA',
            confirmButtonText: 'Aceptar',
    confirmButtonColor: '#0db4e7d0',
        html:'<p class="fw-bold text-dark border border-3 border-light">Ahora podra registrarse para poder gestionar el sistema de FiscaliaWeB</p>'
         })
        
        }
    else{
        Swal.fire({
            icon:'error',
            title:'ERROR',
            confirmButtonText:'OKEY!',
            
            allowOutsideClick: false,
    allowEnterkey:false,
    allowEscapekey:false,
            html:'<p>La contraseña ingresada es incorrecta!!</p><br><p style="color:red">Vuelva intentarlo</p>'
        })
        setInterval("actualizar()",1600);   
        
    }    
})()





