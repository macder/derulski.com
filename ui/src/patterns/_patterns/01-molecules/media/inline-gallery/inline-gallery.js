import $ from 'jquery';
import 'slick-carousel';

export default class InlineGallery {

  /**
   * Temporary image slider code
   * Will be replaced soon
   */
  constructor() {

    // TEMP
    $('.slider-for').slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      arrows: false,
      fade: true,
      asNavFor: '.slider-nav'
    });
    $('.slider-nav').slick({
      slidesToShow: 3,
      slidesToScroll: 1,
      asNavFor: '.slider-for',
      arrows: false,
      // dots: true,
      // centerMode: true,
      focusOnSelect: true
    });
  }
}
