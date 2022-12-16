import Typed from 'typed.js'

/**
 * Uses canvas.measureText to compute and return the width of the given text of given font in pixels.
 * 
 * @param text The text to be rendered.
 * @param {String} font The css font descriptor that text is to be rendered with (e.g. "14px verdana").
 * 
 * @see http://stackoverflow.com/questions/118241/calculate-text-width-with-javascript/21015393#21015393
 */
function getTextWidth(text, font) {
    // if given, use cached canvas for better performance
    // else, create new canvas
    var canvas = getTextWidth.canvas || (getTextWidth.canvas = document.createElement("canvas"));
    var context = canvas.getContext("2d");
    context.font = font;
    var metrics = context.measureText(text);
    return metrics.width;
}

addEventListener('load', () => {
    const mediaQuery = window.matchMedia("(prefers-reduced-motion: reduce)");
    const textWidth = getTextWidth("Hai, I'm nbeerten. |", 'normal normal 800 semi-expanded min(4rem, 15vw)/1.5 "Hubot Sans"');
    const targetTextParent = document.querySelector("#typewriter-text").parentNode.parentNode;
    targetTextParent.style.width = `${textWidth}px`;

    if (!mediaQuery || mediaQuery.matches) {
        return;
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