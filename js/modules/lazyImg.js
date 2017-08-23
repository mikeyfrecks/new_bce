function lazyImg() {
   if(window.IntersectionObserver) {
      createIntersections();
   } else {

      document.querySelectorAll('img.lazy-img').forEach(function(e,i){
         swapSrc(e);
      });

   }

   function createIntersections() {
      let observer = new IntersectionObserver(onChange);

      function onChange(changes) {
       changes.forEach(change => {
         swapSrc(change.target);


        observer.unobserve(change.target);
      })
      }
      const imgs = [ ...document.querySelectorAll('img.lazy-img') ];
      imgs.forEach(img => observer.observe(img));
   }

   function swapSrc(i) {
      
      let parent = i.parentNode,
          full = document.createElement('img');
          full.style.visibility = 'hidden';
    
      function loadEvent() {
         full.removeEventListener('load',loadEvent);
         full.setAttribute('class',i.getAttribute('class'));
         full.classList.remove('preload-image');
         parent.removeChild(i);
         full.style.visibility = 'visible';
      }
      full.addEventListener('load',loadEvent);
      let  src = i.getAttribute('data-src'),
           srcset = i.getAttribute('data-srcset');
     full.setAttribute('srcset',srcset);
     full.setAttribute('src',src);  
     parent.appendChild(full);

   }

}
