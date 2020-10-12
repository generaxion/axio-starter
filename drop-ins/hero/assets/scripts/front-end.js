/**
 * Hero front-end scripts
 */

/**
 * Add body class .has-no-hero-background
 */
const bodyHeroBackgroundIndicator = () => {

  if (document.querySelector('.hero--no-background')) {
    document.body.classList.add('has-no-hero-background');
  }

};
bodyHeroBackgroundIndicator();
