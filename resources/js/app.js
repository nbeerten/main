import Alpine from 'alpinejs'
 
window.Alpine = Alpine
 
Alpine.start()

// // General Purpose <details> element opener if URL hash matches ID of <details>
// function openDetails() {
//     const hash = location.hash.substring(1);
//     if (hash) {
//         const target = document.getElementById(hash);
//         if (target) {
//             const details = target.closest('details');
//             if (details)
//                 details.open = true;
//         }
//     }
// }
// window.addEventListener('hashchange', openDetails);
// window.addEventListener('DOMContentLoaded', openDetails);