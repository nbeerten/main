import Alpine from 'alpinejs';

window.Alpine = Alpine

Alpine.start()

const url = 'https://nilsbeerten.goatcounter.com/counter/' + encodeURI(location.pathname) + '.json';
fetch( url )
    .then((response) => { return response.json() } )
    .then((json) => { 
        // document.querySelectorAll('#goatcounterstats').textContent = json.count;
        const elements = document.querySelectorAll('#goatcounterstats');
        elements.forEach( element => element.textContent = json.count );
    })
    .catch(() => { 
        const elements = document.querySelectorAll('#goatcounterstats');
        elements.forEach( element => element.textContent = '0' ); 
    });