import Typed from 'typed.js'

addEventListener('load', () => {
    var mediaQuery = window.matchMedia("(prefers-reduced-motion: reduce)");
    if (!mediaQuery || mediaQuery.matches) {
        document.querySelector('#typewriter-text').textContent = "Nils";
    } else {
        var typing = new Typed("#typewriter-text", {
            strings: ["Nils.", "Nils.", "nbert.", "nbeerten."],
            typeSpeed: 100,
            backSpeed: 75,
            backDelay: 3000,
            loop: true,
        })
    }
});