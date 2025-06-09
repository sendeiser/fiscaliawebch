/*(async() => {

  let url='phpserv/noticias.php';
 fetch(url).then(res => res.json()).then((out) =>{ 
out.forEach(function(elemento,indicece,array){
        console.log('ID: ', out[indicece].id);
        console.log('TITULO: ', out[indicece].titulo);
        console.log('NOTICIA: ', out[indicece].noticia);
        console.log('PATH: ', out[indicece].imagen);

})
}) 
.catch(err =>{throw err});

/*var datos = 'datos';
//var noticias = document.getElementById('noticias');

$.post('phpserv/noticias.php',{datos},(response)=>{
  alert(response);       
});
 
       /* noticias.innerHTML= `<div class="card mx-auto" style="width: 20rem;">
        <img src="${data}" class="card-img-top" alt="...">
        <div class="card-body">
        <h5 class="card-title fs-2">Card title</h5>
        <p class="card-text fs-3">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
        </div>
        </div>`


})()*/
function noti(i) {
  let url = './phpserv/noticias.php';
  fetch(url).then(res => res.json()).then((out) => {
      const almac = [];

      out.forEach(function (elemento, indice, array) {

        if (indice < i) {

          almac.push(`
     
     
     <div class="col-9 col-lg-4 col-md-7 col-sm-7 col-xl-4 p-3 rounded"> <div class="card">
     <img src="${out[indice].imagen}" class="thumb-post" style="width:100%; height:150px">
     <div class="card-body">
     <h5 class="card-title" style="font-size:20px">${out[indice].titulo}</h5>
     <p class="card-text" style="font-size:14px">${out[indice].noticia}.</p>
     </div>
     </div> </div>
     `)


          noticias.innerHTML = almac.join("").toString()
        }


      })
    })
    .catch(err => {
      throw err
    });
}

$(document).ready(function () {

  var id = 3;
  noti(id);
  $("#notibot").click(function () {
    noti(id + 3);
    id = id + 3;

  });


})

/*$.ajax({
     url:'phpserv/noticias.php',
     type:'POST',

     success: function(res){
      
     json= JSON.parse(res);

     
     console.log(json);
      
     } 
   });*/

/*    $(document).ready(function() {
envio='numero';
$.post('phpserv/noticias.php',{envio},(response)=>{
  const almac=[];
  
  

  for (let index = 1; index <= numero; index++) {

     var NRO=index;
     envio1='consulta';

    $.post('phpserv/noticias.php',{envio1,NRO},(response)=>{
      json= JSON.parse(response);

      almac.push(`<div class="card mx-auto" style="width: 20rem;">
      <img src="${json.imagen}" class="card-img-top" alt="...">
      <div class="card-body">
      <h5 class="card-title fs-2">${json.titulo}</h5>
      <p class="card-text fs-3">${json.noticia}.</p>
      </div>
      </div>`)
         
      noticias.innerHTML = almac.toString();
      console.log(json);

     })
   }
    
   
   
   
     })
      })*/


//response.forEach(item => console.log(item));


//})


//})