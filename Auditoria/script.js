// Función para cargar las noticias
function cargarNoticias() {
    fetch('noticias.php')
      .then(response => response.json())
      .then(data => {
        const noticiasContainer = document.getElementById('noticias-container');
        data.forEach(noticia => {
          const noticiaElement = document.createElement('div');
          noticiaElement.classList.add('card', 'mb-3');
          noticiaElement.innerHTML = `
            <img src="../${noticia.imagen}" class="card-img-top" alt="${noticia.titulo}">
            <div class="card-body">
              <h5 class="card-title">${noticia.titulo}</h5>
              <p class="card-text">${noticia.noticia}</p>
            </div>
          `;
          noticiasContainer.appendChild(noticiaElement);
        });
      })
      .catch(error => console.error('Error al cargar las noticias:', error));
  }
  
  // Función para cargar los expedientes
  function cargarExpedientes() {
    fetch('expedientes.php')
      .then(response => response.json())
      .then(data => {
        const expedientesContainer = document.getElementById('expedientes-container');
        data.forEach(expediente => {
          const expedienteElement = document.createElement('tr');
          expedienteElement.innerHTML = `
            <td>${expediente.idexpediente}</td>
            <td>${expediente.dnidenunciante}</td>
            <td>${expediente.denunciado}</td>
            <td>${expediente.causa}</td>
            <td>${expediente.medida}</td>
            <td>${expediente.fojas}</td>
            <td>${expediente.librodeactas}</td>
            <td>${expediente.codigocomisaria}</td>
            <td>${expediente.numerodeexpediente}</td>
            <td>${expediente.numexpinstru}</td>
            <td>${expediente.fechadeentrada}</td>
          `;
          expedientesContainer.appendChild(expedienteElement);
        });
      })
      .catch(error => console.error('Error al cargar los expedientes:', error));
  }
  
  // Cargar las noticias y los expedientes al cargar la página
  window.onload = function() {
    cargarNoticias();
    cargarExpedientes();
  };