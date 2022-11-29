import Alpine from 'alpinejs';

window.Alpine = Alpine

Alpine.start()

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
    document.head.appendChild(heroicons_styles)
}

const url = 'https://nilsbeerten.goatcounter.com/counter/' + encodeURI(location.pathname) + '.json';
fetch(url)
    .then((response) => { return response.json() })
    .then((json) => {
        // document.querySelectorAll('#goatcounterstats').textContent = json.count;
        const elements = document.querySelectorAll('#goatcounterstats');
        elements.forEach(element => element.textContent = json.count);
    })
    .catch(() => {
        const elements = document.querySelectorAll('#goatcounterstats');
        elements.forEach(element => element.textContent = '0');
    });