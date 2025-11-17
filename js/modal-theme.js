(function(){
  function setVars(vars){
    const root = document.documentElement;
    Object.entries(vars).forEach(([k,v])=>root.style.setProperty(k,v));
  }
  function byPage(){
    const page = document.body.getAttribute('data-page') || (location.pathname.split('/').pop() || '').toLowerCase();
    switch(true){
      case /registro\.html$/.test(page) || page==='registro':
        setVars({
          '--modal-bg1':'#4c9e88',
          '--modal-bg2':'#3b7f6f',
          '--modal-text':'#eaf7f3',
          '--modal-confirm-bg1':'#3cb371',
          '--modal-confirm-bg2':'#2e8b57',
          '--modal-cancel-bg1':'#2645b8',
          '--modal-cancel-bg2':'#1a35ac',
          '--modal-icon-border':'#ffd000'
        });
        break;
      case /login\.html$/.test(page) || page==='login':
        setVars({
          '--modal-bg1':'#1e3a8a',
          '--modal-bg2':'#2563eb',
          '--modal-text':'#eaf2ff',
          '--modal-confirm-bg1':'#3498db',
          '--modal-confirm-bg2':'#2176bd',
          '--modal-cancel-bg1':'#6c757d',
          '--modal-cancel-bg2':'#495057',
          '--modal-icon-border':'#ffd000'
        });
        break;
      case /contacto\.html$/.test(page) || page==='contacto':
        setVars({
          '--modal-bg1':'#1976d2',
          '--modal-bg2':'#2196f3',
          '--modal-text':'#eaf7ff',
          '--modal-confirm-bg1':'#2ecc71',
          '--modal-confirm-bg2':'#27ae60',
          '--modal-cancel-bg1':'#6c757d',
          '--modal-cancel-bg2':'#495057',
          '--modal-icon-border':'#ffd000'
        });
        break;
      default:
        setVars({
          '--modal-bg1':'#2b5876',
          '--modal-bg2':'#4e4376',
          '--modal-text':'#f1f5f9',
          '--modal-confirm-bg1':'#28a745',
          '--modal-confirm-bg2':'#218838',
          '--modal-cancel-bg1':'#6c757d',
          '--modal-cancel-bg2':'#495057',
          '--modal-icon-border':'#ffd000'
        });
    }
  }
  if(document.readyState==='loading'){
    document.addEventListener('DOMContentLoaded', byPage);
  }else{
    byPage();
  }
})();