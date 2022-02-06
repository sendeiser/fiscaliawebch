$(document).ready(function() {
    var user_id, opcion;
        
 tablacomi= $('#tablacomi').DataTable({ 
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
                 text:'NUEVO',
                 className:'btn btn-danger fw-bold nuevo_comi',
                 },
                 {
                  //definimos estilos del boton de excel
                  extend: "excel",
                  text:'Exportar a Excel',
                  className:'btn btn-danger',
  
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
                      
                  },
                  {
                    html:`<i></i>`,
                    className:'btn btn-danger fas fa-sync reload_comi',
                   }]                
                },                       
            "bProcessing": true,
            "bDeferRender": true,	
            "bServerSide": true,                         
            "sAjaxSource": "serverside/serversideComisarias.php",	
            "columnDefs": [ {
                "targets": -1,        
                "defaultContent": "<div class='wrapper'><div class='btn-group'><button class='btn btn-info btn-sm btnEditar' data-bs-target='#editarcomi' data-bs-toggle='modal'><i class='fas fa-pen'></i></button><button class='btn btn-danger btn-sm btnBorrar' data-bs-target='#eliminarcomi' data-bs-toggle='modal' title='Eliminar'><i class='fas fa-minus'></i></button></div></div>"
            } ],	    
    })
     


var fila; //captura la fila, para editar o eliminar
//submit para el Alta y Actualización

//Editar        
$(document).on("click", ".btnEditar", function(){		        
    opcion = 6;//editar
    
    fila = $(this).closest("tr");	  
   	            
    idcomi = fila.find('td:eq(0)').text();
    nombrecomi = fila.find('td:eq(1)').text();
    nrocomi = fila.find('td:eq(2)').text();
    

    $("#idcomi").val(idcomi);
    $("#nombrecomi").val(nombrecomi);
    $("#nrocomi").val(nrocomi);
    	   
});

$(document).on("click", "#si-editarcomi", function(){
      
    idcomi =$('#idcomi').val();
    nombrecomi =$('#nombrecomi').val();
    telefono =$('#nrocomi').val();

    funcion='editar_comi';
    $.post('controlador/LaboratorioController.php',{idcomi,nombrecomi,telefono,funcion},(response)=>{
      tablacomi.ajax.reload(null, false);       
    })
    
  })

//Borrar
$(document).on("click", ".btnBorrar", function(){
            
    id_comi = tablacomi.row($(this).parents()).data();	
                    
    $("#comisaria_eliminar").html(id_comi[0]);
    $('#id_comisaria').val(id_comi[0]);
 });
     
 $(document).on("click", "#btn_borrarcomi", function(){

    fila = $(this);
    idcomi = $('#id_comisaria').val();
    funcion='eliminar_comi';
    $.post('controlador/LaboratorioController.php',{idcomi,funcion},(response)=>{
      console.log(response);
      tablacomi.row(fila.parents('tr')).remove().draw();
      //datatable.ajax.reload(null, false);       
    })
    
  })

  //boton de recarga de tabla
  $(document).on("click", ".reload_comi", function(){ 
    tablacomi.ajax.reload(null, false);
  });
 //Cargar nueva comisaria_eliminar
      $(document).on("click", ".nuevo_comi", function(){
      $('#nueva_comi').modal('show');
      });

      $(document).on("click", "#si_cominueva", function(){
      var nombre_comi= $('#nombrecominew').val();
      var nrocominew = $('#nrocominew').val();
      var idcominew = $('#idcominew').val();
      funcion='nueva_comi';
      $.post('controlador/LaboratorioController.php',{nombre_comi,nrocominew,idcominew,funcion},(response)=>{
        tablacomi.ajax.reload(null, false);
        
      })
      
      })




});    

