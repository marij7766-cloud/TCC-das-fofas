// Inicializa os ícones da biblioteca Lucide
lucide.createIcons();

// Seleciona todos os links que começam com "#"
document.querySelectorAll('a[href^="#"]').forEach(anchor => 
{

  // Adiciona evento de clique em cada link
  anchor.addEventListener('click', function (e) 
  {

    // Impede o comportamento padrão do link
    e.preventDefault();

    // Faz a rolagem suave até a seção correspondente
    document.querySelector(this.getAttribute('href')).scrollIntoView(
      {
      behavior: 'smooth'
      });
  });
});


// Cria um observador para detectar elementos visíveis na tela
const observer = new IntersectionObserver((entries) =>
   {

  // Percorre todos os elementos observados
  entries.forEach(entry => 
    {

    // Verifica se o elemento apareceu na tela
    if (entry.isIntersecting)
      {

      // Inicia a animação do elemento
      entry.target.style.animationPlayState = 'running';
      }
    });
   });

// Seleciona todos os elementos com animação fade-in
document.querySelectorAll('.animate-fade-in').forEach(el =>
   {

      // Deixa a animação pausada inicialmente
      el.style.animationPlayState = 'paused';

      // Faz o observer monitorar o elemento
      observer.observe(el);
   });
