"use strict";

import Alpine from 'alpinejs';

window.Alpine = Alpine

Alpine.start()

addEventListener('DOMContentLoaded', polyfill());
addEventListener('load', goatcounterstats());

async function goatcounterstats() {
    let url = 'https://nilsbeerten.goatcounter.com/counter/' + encodeURI(location.pathname) + '.json';

    fetch(url)
        .then((response) => { return response.json() })
        .then((json) => {
            const elements = document.querySelectorAll('#goatcounterstats');
            elements.forEach(element => element.textContent = json.count);
            return true;
        })
        .catch(() => {
            const elements = document.querySelectorAll('#goatcounterstats');
            elements.forEach(element => element.textContent = '0');
            return false;
        });
}

async function polyfill() {
    if (!CSS.supports('selector(:has(*))')) {
        document.querySelectorAll('tool-tip').forEach(tooltip =>
            tooltip.parentNode.classList.add('has_tool-tip'))

        let tooltip_styles = document.createElement('style')
        tooltip_styles.textContent = `
          .has_tool-tip {
            position: relative;
          }
          .has_tool-tip:is(:hover, :focus-visible, :active) > tool-tip {
            opacity: 1;
            transition-delay: 200ms;
          }
        `
        document.head.appendChild(tooltip_styles)

        document.querySelectorAll('.heroicons').forEach(tooltip =>
            tooltip.parentNode.classList.add('has_heroicons'))

        let heroicons_styles = document.createElement('style')
        heroicons_styles.textContent = `
          .has_heroicons {
            display: flex;
            flex-direction: row;
            gap: 0.5em;
          }
        `
        document.head.appendChild(heroicons_styles);
    }
}

/**
 * Function to change a number of CSS variables to accurate values. Used in the hero sections for nice scroll-linked animations
 * to change blur and opacity. The `setinterval` of `1000 / 60` is the calculation for the interval between frames for a 
 * framerate of 60fps (1000 milliseconds per second, 60 frames per second => 1000ms / 60fps = 1000 / 60 ≈ 16.67 )
 */
addEventListener("DOMContentLoaded", () => {
    if(matchMedia("(pointer: coarse)").matches || matchMedia("(prefers-reduced-motion: reduce)").matches) return;
    const root = document.documentElement;
    const body = document.body;
    addEventListener("scroll", () => {
        var positionFactor = (root.scrollTop||body.scrollTop) / ( (root.scrollHeight||body.scrollHeight) - root.clientHeight );

        root.style.setProperty('--scrollposition-y-px', (root.scrollTop||body.scrollTop) + "px");
        root.style.setProperty('--scrollposition-y-p', `calc(${positionFactor} * 100%)`);
        root.style.setProperty('--scrollposition-y', positionFactor.toFixed(4));
    });
});