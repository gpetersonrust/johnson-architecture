import "../scss/app.scss"; // Importing SCSS file

 function GP_JOHNSON_ARCHITECTS() {

let information = document.getElementById('information');
//  get the information box width
let information_box = information.offsetWidth - 65;
information.style.transform = `translateX(-${information_box}px)`;
setTimeout(() => {
   information.style.opacity  = 1;
}, 1000);

}
GP_JOHNSON_ARCHITECTS();