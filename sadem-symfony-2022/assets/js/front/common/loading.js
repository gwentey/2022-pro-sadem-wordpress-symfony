
// on affiche le loading tant que la page n'est pas chargé : utilisation de VANILLA JS

let loader = document.querySelector('.loading');

document.addEventListener("DOMContentLoaded", function () {
    loader.style.display = 'none';

    let links = document.querySelectorAll('.js-link');
    links.forEach(link => link.addEventListener('click', linkClicked));
});


/* links.forEach(function (element) {
    element.addEventListener("onclick", linkClicked, false);
    console.log(element);
    return element;
}); */
function linkClicked(e) {
    loader.style.display = 'block';
}




/* function loadingView() {
    document.querySelector('.loading').style.display = 'block';
}
 */
/* function fadeOutEffect(el) {
    var fadeTarget = el;
     
      console.log(fadeTarget);

    var fadeEffect = setInterval(function () {
        if (!fadeTarget.style.opacity) {
            fadeTarget.style.opacity = 1;
        }
        if (fadeTarget.style.opacity > 0) {
            fadeTarget.style.opacity -= 0.1;
        } else {
            clearInterval(fadeEffect);
        }
    }, 200); 
} */