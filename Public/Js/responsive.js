/**
 * Script para tornar elementos responsivos em dispositivos móveis
 * Adiciona a classe 'dropend' à div com classe 'btn-group' em dispositivos móveis
 */
document.addEventListener('DOMContentLoaded', function() {
    // Função para verificar o tamanho da tela e adicionar/remover a classes
    function checkScreenSize() {
        const btnGroup = document.getElementById('userDropdownGroup');
        if (btnGroup) {
            // Verifica se a largura da tela é menor que 768px (dispositivo móvel)
            if (window.innerWidth < 768) {
                btnGroup.classList.add('dropdown-menu-end dropdown-menu-lg-start');
            } else {
                btnGroup.classList.remove('dropdown-menu-end dropdown-menu-lg-start');
            }
        }
    }

    // Executa a função quando a página carrega
    checkScreenSize();

    // Adiciona um listener para quando a janela for redimensionada
    window.addEventListener('resize', checkScreenSize);
});