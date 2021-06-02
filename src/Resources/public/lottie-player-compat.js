(function(){
    'use strict';

    const supported = window.customElements && document.body.attachShadow;
    if (!supported) {
        console.info('Your browser do not support CustomElements, please take another browser for better visual experience.')
        const elements = container.querySelectorAll('.ce_lottie_player .lottie-player-fallback img');
        elements.forEach(element => {
            element.removeAttribute('hidden');
        });
    }
})();