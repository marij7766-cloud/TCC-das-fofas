document.addEventListener('DOMContentLoaded', function() 
{

  const form = document.querySelector('form');
  const btnCadastrar = document.getElementById('btnCadastrar');
  const inputs = document.querySelectorAll('.form-control');

  //Verifica todos os campos estão preenchidos
  function checkAllFields() 
  {

    const allFilled = Array.from(inputs).every(input => input.value.trim().length > 0);
    
    if (allFilled) 
      {

      //Ativa o botão
      btnCadastrar.disabled = false;
      btnCadastrar.innerHTML = '<i class="fas fa-user-plus me-2"></i>Criar Conta';

    } 
    else 
    {

      // Desativa o botão
      btnCadastrar.disabled = true;
      btnCadastrar.innerHTML = '<i class="fas fa-exclamation-triangle me-2"></i>Preencha todos os campos';
    }
  }

  checkAllFields();

  //Formata o telefone automaticamente
  const telefone = document.querySelector('[name="telefone"]');

  telefone.addEventListener("input", function () 
  {

    let valor = telefone.value;

    //Remove caracteres que não são números
    valor = valor.replace(/\D/g, "");

    //Adiciona ()
    valor = valor.replace(/^(\d{2})(\d)/g, "($1) $2");

    //Adiciona -
    valor = valor.replace(/(\d{5})(\d)/, "$1-$2");

    telefone.value = valor;
  });

  //Verifica os campos enquanto digita
  inputs.forEach(input => 
    {

    input.addEventListener('input', checkAllFields);
    input.addEventListener('blur', checkAllFields);

    });

  form.addEventListener('submit', function(e) 
  {

    //Não deixa enviar se faltar campos
    if (btnCadastrar.disabled) 
      {
      e.preventDefault();
      return;
      }

    //Mostra carregamento
    btnCadastrar.disabled = true;
    btnCadastrar.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Criando...';
  });

});