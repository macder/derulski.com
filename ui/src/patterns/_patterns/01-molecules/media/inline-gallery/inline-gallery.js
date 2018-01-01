import Swiper from 'swiper/dist/js/swiper.js';

export default class InlineGallery {

  /**
   *
   */
  constructor() {
    this.$j = jQuery;
    this.swiper = {};
    this.init();
    this.listen();
  }

  /**
   * Init all components when DOM ready
   *
   * @return {void}
   */
  init() {
    this.$j(document).ready( () => {
      this.initSwiper();
    });
  }

  /**
   * Init swiper
   *
   * @return {void}
   */
  initSwiper() {
    this.swiper = new Swiper ('.gallery-top', {
      speed: 1200,
      effect: 'flip',
    });
  }

  /**
   * Init event listeners
   *
   * @return {void}
   */
  listen() {
    this.thumbClick();
  }

  /**
   * Listen for a click on thumb
   * Transition to slide with same index
   *
   * @return {void}
   */
  thumbClick() {
    this.$j('.c-inline-gallery__nav-item').click( (e) => {
      this.swiper.slideTo(
        this.$j(e.currentTarget).data('index')
      );
    });
  }
}
