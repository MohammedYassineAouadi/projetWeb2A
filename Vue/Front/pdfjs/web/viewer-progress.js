/**
 * viewer-progress.js
 *
 * Écoute les scrolls dans le conteneur PDF.js et envoie
 * la progression au parent via postMessage.
 */
(function() {
    'use strict';
  
    /**
     * Handler du scroll : calcule le pourcentage et postMessage au parent.
     */
    function handleScroll() {
      const container = document.getElementById('viewerContainer');
      if (!container) return;
  
      const scrollTop = container.scrollTop;
      const maxScroll = container.scrollHeight - container.clientHeight;
      let pct = 0;
      if (maxScroll > 0) {
        pct = Math.round((scrollTop / maxScroll) * 100);
      }
  
      window.parent.postMessage({ type: 'pdf-progress', progress: pct }, '*');
    }
  
    /**
     * Dès qu'une page est rendue, on (re)branche le listener de scroll
     * pour s'assurer de capter le conteneur correct.
     */
    document.addEventListener('pagerendered', () => {
      const container = document.getElementById('viewerContainer');
      if (!container) {
        console.warn('viewer-progress.js : #viewerContainer non trouvé');
        return;
      }
  
      // On enlève d'abord tout listener existant pour éviter les doublons
      container.removeEventListener('scroll', handleScroll);
      container.addEventListener('scroll', handleScroll);
    });
  })();
  