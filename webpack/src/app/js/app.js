import "../scss/app.scss"; // Importing SCSS file

function GP_JOHNSON_ARCHITECTS() {
  let portfolios = [...home_images.home_images];
  // randomly select a portfolio
  let random_portfolio = portfolios[Math.floor(Math.random() * portfolios.length)];
 
 
  let slider_logo_url =random_portfolio.slider_logo;

  let logo = document.getElementById("logo").querySelector("img");
  slider_logo_url && logo.setAttribute("src", slider_logo_url);

  let background_img = document
    .getElementById("slider-background-image")
    .querySelector("img");

  background_img.setAttribute("src",random_portfolio.thumbnail);

  let headline = document.getElementById("headline");

  let headline_h1_a = headline.querySelector("h1 a");
  let span_a = document.querySelector("span a");
  headline_h1_a.href =random_portfolio.portfolio_link;
  span_a.href =random_portfolio.portfolio_link;
  headline_h1_a.innerHTML =random_portfolio.title;
  span_a.innerHTML =random_portfolio.subheadline;
}
GP_JOHNSON_ARCHITECTS();
