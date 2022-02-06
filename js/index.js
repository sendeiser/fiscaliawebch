/*(async() => {

  let url='phpserv/noticias.php';
 fetch(url).then(res => res.json()).then((out) =>{ 
out.forEach(function(elemento,indice,array){
        console.log('ID: ', out[indice].id);
        console.log('TITULO: ', out[indice].titulo);
        console.log('NOTICIA: ', out[indice].noticia);
        console.log('PATH: ', out[indice].imagen);

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

$(document).ready(function() {

  
 let url='./phpserv/noticias.php';
const almac=[];
 fetch(url).then(res => res.json()).then((out) =>{ 

out.forEach(function(elemento,indice,array){

  almac.push(`<div class="card mx-auto" style="width: 20rem;">
  <img src="${out[indice].imagen}" class="card-img-top" alt="...">
  <div class="card-body">
  <h5 class="card-title fs-2">${out[indice].titulo}</h5>
  <p class="card-text fs-3">${out[indice].noticia}.</p>
  </div>
  </div>`)
     
  noticias.innerHTML = almac.toString();

  /*console.log('ID: ', out[indice].id);
        console.log('TITULO: ', out[indice].titulo);
        console.log('NOTICIA: ', out[indice].noticia);
        console.log('PATH: ', out[indice].imagen);*/
}) 
 })
.catch(err =>{throw err});



 } )

 /* $.ajax({
      url:'phpserv/noticias.php',
      type:'POST',

      success: function(res){
       
        var obj= JSON.parse(res);
    
        console.log(obj);
        obj.forEach(item => console.log(item));
       
      } 
    })*/


/*
$.post('phpserv/noticias.php',{datos},(response)=>{

    
    var obj= JSON.parse(response);
    
    console.log(obj);
   
   
    

  /* obj.forEach(function(noticia, index) {
        console.log(`${1} : ${noticia}`);
    });*/

    
  //response.forEach(item => console.log(item));
        
    /*
        noticias.innerHTML= `<div class="card mx-auto" style="width: 30rem;">
        <img src="${jsonarray.imagen}" class="card-img-top" alt="...">
        <div class="card-body">
        <h5 class="card-title fs-2">${jsonarray.titulo}</h5>
        <p class="card-text fs-3">${jsonarray.noticia}</p>
        </div>
        </div> `
      
    */    

//})


//})