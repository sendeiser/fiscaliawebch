$(document).ready(function() {
    var user_id, opcion;
        
 tablapersonas= $('#tablaper').DataTable({ 
            "language": {
            "url":"http://cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
                    },
          responsive: true,
          dom: 'Bfrtilp',
          buttons:{
              dom: {
                  button: {
                      className: 'btn'
                  }
              },
              buttons: [
               {
                  //definimos estilos del boton de excel
                  extend: "excel",
                  text:'Exportar a Excel',
                  className:'btn btn-warning',
  
                  // 1 - ejemplo básico - uso de templates pre-definidos
                  //definimos los parametros al exportar a excel
                  
                  excelStyles: {                
                      //template: "header_blue",  // Apply the 'header_blue' template part (white font on a blue background in the header/footer)
                      //template:"green_medium" 
                      
                      "template": [
                          "blue_medium",
                          "header_green",
                          "title_medium"
                      ] }
                      
                  }, {
                    //definimos estilos del boton de excel
                    html:`<i></i>`,
                    className:'btn btn-warning fas fa-sync reload_per',
                   }]   
                },
                                    
            "bProcessing": true,
            "bDeferRender": true,	
            "bServerSide": true,                         
            "sAjaxSource": "serverside/serversidePersonas.php",	
            "columnDefs": [ {
                "targets": -1,        
                "defaultContent": "<div class='wrapper'><div class='btn-group'><button class='btn btn-info btn-sm btnEditar' data-bs-target='#editarper' data-bs-toggle='modal'><i class='fas fa-pen'></i></button><button class='btn btn-danger btn-sm btnBorrar' data-bs-target='#eliminarper' data-bs-toggle='modal' title='Eliminar'><i class='fas fa-user-minus'></i></button></div></div>"
            } ],	    
    })
    
     


var fila; //captura la fila, para editar o eliminar
//submit para el Alta y Actualización

//Editar        
$(document).on("click", ".btnEditar", function(){		        
    opcion = 6;//editar
    
    fila = $(this).closest("tr");	  
   	            
    dniper = fila.find('td:eq(0)').text();
    nombreper = fila.find('td:eq(1)').text();
    apellidoper = fila.find('td:eq(2)').text();
    

    $("#dniper").val(dniper);
    $("#nombreper").val(nombreper);
    $("#apellidoper").val(apellidoper);
    	   
});
$(document).on("click", "#si-editarper", function(){
      
    dni =$('#dniper').val();
    nombre =$('#nombreper').val();
    apellido =$('#apellidoper').val();

    funcion='editar_per';
    $.post('controlador/LaboratorioController.php',{dni,nombre,apellido,funcion},(response)=>{
      tablapersonas.ajax.reload(null, false);       
    })
    
  })

  $(document).on("click", ".reload_per", function(){ 
    tablapersonas.ajax.reload(null, false);
  });


//Borrar
$(document).on("click", ".btnBorrar", function(){
            
    fila = $(this);  
               
    dni_per = tablapersonas.row($(this).parents()).data();	
                    
    $("#persona_eliminar").html(dni_per[0]);
    $('#dni_persona').val(dni_per[0]);
 });
     
 $(document).on("click", "#btn_borrarper", function(){
      
    idper =$('#dni_persona').val();
    funcion='eliminar_per';
    $.post('controlador/LaboratorioController.php',{idper,funcion},(response)=>{
      tablapersonas.row(fila.parents('tr')).remove().draw();
      //datatable.ajax.reload(null, false);       
    })
    
  })


});    

