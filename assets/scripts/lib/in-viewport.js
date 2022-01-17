/**
 * Add "has-viewport-effect" indicator class to blocks before they are seen.
 * Add "is-in-viewport" indicator class to blocks when they are in viewport.
 */
const setInViewportIndicators = () => {

  // define matched elements
  const getMatchingElements = () => document.querySelectorAll([
    '.hero',
    '.blocks > *',
    '.inner-blocks > *',
    '.wp-block-acf-button > *',
    '.wp-block-columns > *',
    '.wp-block-column > *',
    '.wp-block-gallery li',
    '.js-teaser-container > *',
    '.js-site-footer',
    '.js-add-viewport-effect',
    '.js-add-children-viewport-effect > *'
  ]);

  // flag to limit unnecessary updates
  let viewportElementsNeedToBeChecked = false;

  // disable animations for bots
  var botPattern = "(googlebot\/|bot|Googlebot-Mobile|Googlebot-Image|Google favicon|Mediapartners-Google|bingbot|slurp|java|wget|curl|Commons-HttpClient|Python-urllib|libwww|httpunit|nutch|phpcrawl|msnbot|jyxobot|FAST-WebCrawler|FAST Enterprise Crawler|biglotron|teoma|convera|seekbot|gigablast|exabot|ngbot|ia_archiver|GingerCrawler|webmon |httrack|webcrawler|grub.org|UsineNouvelleCrawler|antibot|netresearchserver|speedy|fluffy|bibnum.bnf|findlink|msrbot|panscient|yacybot|AISearchBot|IOI|ips-agent|tagoobot|MJ12bot|dotbot|woriobot|yanga|buzzbot|mlbot|yandexbot|purebot|Linguee Bot|Voyager|CyberPatrol|voilabot|baiduspider|citeseerxbot|spbot|twengabot|postrank|turnitinbot|scribdbot|page2rss|sitebot|linkdex|Adidxbot|blekkobot|ezooms|dotbot|Mail.RU_Bot|discobot|heritrix|findthatfile|europarchive.org|NerdByNature.Bot|sistrix crawler|ahrefsbot|Aboundex|domaincrawler|wbsearchbot|summify|ccbot|edisterbot|seznambot|ec2linkfinder|gslfbot|aihitbot|intelium_bot|facebookexternalhit|yeti|RetrevoPageAnalyzer|lb-spider|sogou|lssbot|careerbot|wotbox|wocbot|ichiro|DuckDuckBot|lssrocketcrawler|drupact|webcompanycrawler|acoonbot|openindexspider|gnam gnam spider|web-archive-net.com.bot|backlinkcrawler|coccoc|integromedb|content crawler spider|toplistbot|seokicks-robot|it2media-domain-crawler|ip-web-crawler.com|siteexplorer.info|elisabot|proximic|changedetection|blexbot|arabot|WeSEE:Search|niki-bot|CrystalSemanticsBot|rogerbot|360Spider|psbot|InterfaxScanBot|Lipperhey SEO Service|CC Metadata Scaper|g00g1e.net|GrapeshotCrawler|urlappendbot|brainobot|fr-crawler|binlar|SimpleCrawler|Livelapbot|Twitterbot|cXensebot|smtbot|bnf.fr_bot|A6-Indexer|ADmantX|Facebot|Twitterbot|OrangeBot|memorybot|AdvBot|MegaIndex|SemanticScholarBot|ltx71|nerdybot|xovibot|BUbiNG|Qwantify|archive.org_bot|Applebot|TweetmemeBot|crawler4j|findxbot|SemrushBot|yoozBot|lipperhey|y!j-asr|Domain Re-Animator Bot|AddThis|semrush|Cookiebot)";
  var re = new RegExp(botPattern, 'i');
  if (re.test(navigator.userAgent)) {
    return;
  }

  // disable animations for user preference
  const mediaQuery = window.matchMedia("(prefers-reduced-motion: reduce)");
  if (!mediaQuery || mediaQuery.matches) {
    return;
  }

  // check if given element is visible or partly visible on screen
  const isBlockVisible = (block) => {

    // intersectionobserver should be used when IE11 can be dropped
    const bounding = block.getBoundingClientRect();
    if (bounding.top >= -block.offsetHeight && bounding.left >= -block.offsetWidth && bounding.right <= (window.innerWidth || document.documentElement.clientWidth) + block.offsetWidth && bounding.bottom <= (window.innerHeight || document.documentElement.clientHeight) + block.offsetHeight) {
      return true;
    }

    return false;

  };

  // add initial state for matched elements
  const blocks = getMatchingElements();
  for (let i = 0; i < blocks.length; i++) {
    if (!isBlockVisible(blocks[i])) {
      blocks[i].classList.add('has-viewport-effect');
    } else {
      blocks[i].classList.add('is-in-viewport');
    }
  }

  const updateViewportStatus = () => {

    /**
     * Get animatable elements
     *
     * Preformance could be optimized by saving element in variable but that would also
     * require a mutationobserver or some custom event to indiate when the list should
     * be updted in case of ajax elements.
     */
    const blocks = getMatchingElements();

    for (let i = 0; i < blocks.length; i++) {
      const block = blocks[i];
      if (isBlockVisible(block)) {
        block.classList.add('is-in-viewport');
      }
    }

  };

  // update: manually trigger update first time to avoid latency
  updateViewportStatus();

  // update: hacky just in case updates
  setTimeout(() => { viewportElementsNeedToBeChecked = true; }, 1000);
  setTimeout(() => { viewportElementsNeedToBeChecked = true; }, 2500);

  // updaet: after render is complete
  window.addEventListener('DOMContentLoaded', (event) => {
    viewportElementsNeedToBeChecked = true;
  });
  window.addEventListener('load', (event) => {
    viewportElementsNeedToBeChecked = true;
  });

  // update: after scroll
  window.addEventListener('scroll', (e) => {
    viewportElementsNeedToBeChecked = true;
  }, false);

  // update: after resize
  window.addEventListener('resize', (event) => {
    viewportElementsNeedToBeChecked = true;
  });

  // limit updates for performance and battery drain
  setInterval(() => {
    if (viewportElementsNeedToBeChecked) {
      updateViewportStatus();
      viewportElementsNeedToBeChecked = false;
    }
  }, 100);

};
setInViewportIndicators();
