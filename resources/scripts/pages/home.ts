import Typed from 'typed.js';

/**
 * Uses canvas.measureText to compute and return the width of the given text of given font in pixels.
 * 
 * @param text The text to be rendered.
 * @param {string} font The css font descriptor that text is to be rendered with (e.g. "14px verdana").
 * 
 * @see http://stackoverflow.com/questions/118241/calculate-text-width-with-javascript/21015393#21015393
 */
function getTextWidth(text: string, font: string) {
    // if given, use cached canvas for better performance
    // else, create new canvas
    var canvas: HTMLCanvasElement = canvas! || (canvas = document.createElement("canvas"));
    const context = canvas.getContext("2d");
    if(context == null) throw Error;
    context.font = font;
    const metrics = context.measureText(text);
    return metrics.width;
}

function startTypingAnimation() {
    const mediaQuery = window.matchMedia("(prefers-reduced-motion: reduce)");
    const textWidth = getTextWidth("Hai, I'm nbeerten. |", 'normal normal 800 semi-expanded min(4rem, 15vw)/1.5 "Hubot Sans"');
    const targetTextParent = document.querySelector("#typewriter-text")?.parentElement?.parentElement as HTMLElement;
        if(targetTextParent == null) return;
    targetTextParent.style.width = `${textWidth}px`;

    if (!mediaQuery || mediaQuery.matches) {
        return;
    } else {
        const typing: Typed = new Typed("#typewriter-text", {
            strings: ["Nils.", "Nils.", "nbert.", "nbeerten."],
            typeSpeed: 100,
            backSpeed: 75,
            backDelay: 3000,
            loop: true,
            autoInsertCss: false
        })
    }
}

addEventListener('load', () => startTypingAnimation());