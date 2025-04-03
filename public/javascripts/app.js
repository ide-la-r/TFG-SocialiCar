const btnCambiarTema = document.getElementById('change-theme');
const themeLink = document.getElementById('style-theme');
const navbar = document.getElementById('navbar');
const footer = document.getElementById('footer');

btnCambiarTema.addEventListener('click', () => {
    const body = document.body;
    
    if(body.classList.toggle("main")){
        themeLink.setAttribute("href", "../public/stylesheets/main-dark.css");

        navbar.classList.remove("bg-white");
        navbar.classList.remove("navbar-light");
        navbar.classList.add("bg-dark");
        navbar.classList.add("navbar-dark");

        footer.classList.remove("bg-white");
        footer.classList.remove("text-dark");
        footer.classList.add("bg-dark");
        footer.classList.add("text-light");

        btnCambiarTema.innerText = "☀️";
    } else {
        themeLink.setAttribute("href", "../public/stylesheets/main.css");

        navbar.classList.remove("bg-dark");
        navbar.classList.remove("navbar-dark");
        navbar.classList.add("bg-white");
        navbar.classList.add("navbar-light");

        footer.classList.remove("bg-dark");
        footer.classList.remove("text-white");
        footer.classList.add("bg-white");
        footer.classList.add("text-dark");

        btnCambiarTema.innerText = "🌙";
    }
});