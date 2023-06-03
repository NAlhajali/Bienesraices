document.addEventListener('DOMContentLoaded', function() {
    
    eventListeners();

    darkMode (); // creamos la funcon de modo oscuro
});
// la funcoon de darkmode se crea bajo las siguientes lineas de codigo
function darkMode() {

    const prefiereDarkMode = window.matchMedia('(prefers-color-scheme: dark)'); // aqui se empieza a crear el darkmodo automatico

    // console.log(prefiereDarkMode.matches);
    prefiereDarkMode.addEventListener('change', function(){
        if (prefiereDarkMode.matches) {
            document.body.classList.add('dark-mode');
        } else {
            document.body.classList.remove('dark-mode');
        }
    }); // asi se crea el darkmode automatico
    

    

    const botonDarkMode = document.querySelector('.dark-mode-boton');

    botonDarkMode.addEventListener('click', function () {
        document.body.classList.toggle('dark-mode');
    })
} // hasta aqui codigo de dark mode

function eventListeners() {
    const mobileMenu = document.querySelector('.mobile-menu');

    mobileMenu.addEventListener('click', navegacionResponsive);
}

function navegacionResponsive() {
    const navegacion = document.querySelector('.navegacion');

    navegacion.classList.toggle('mostrar'); /**esto y lo de abajo es lo mismo
    sirve para mostar lo que hay dentro de la hamburguesa 
    (menu) */

    // if(navegacion.classList.contains('mostrar')){
    //     navegacion.classList.remove('mostrar');
    // }else {
    //     navegacion.classList.add('mostrar');
    // }
} 