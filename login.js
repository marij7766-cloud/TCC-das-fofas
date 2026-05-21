// Espera todo o HTML carregar antes de executar o código
document.addEventListener('DOMContentLoaded', function() 
{

  
  const entrarBtn = document.getElementById('EntarBtn');
  const inputs = document.querySelectorAll('.form-control');
  
  // Função para verificar se todos os campos foram preenchidos
  function checkAllFields()
   {

    const allFilled = Array.from(inputs).every(input => input.value.trim().length > 0);
    
    if (allFilled) 
      {
      entrarBtn.disabled = false;

      // Altera o texto e o ícone do botão
      entrarBtn.innerHTML = '<i class="fas fa-check me-2"></i>Entrar';

      } 
    else
     {
      entrarBtn.disabled = true;
      entrarBtn.innerHTML = '<i class="fas fa-exclamation-triangle me-2"></i>Preencha todos os campos';
     }

    }

  checkAllFields();

  
  inputs.forEach(input =>
     {
    input.addEventListener('input', checkAllFields);
     });

});