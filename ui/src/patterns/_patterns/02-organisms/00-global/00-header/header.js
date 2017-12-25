export default class Header {

  /**
   * Set properties and init event listener.
   */
  constructor() {
    this.$j = jQuery;
    this.$el = {}
    this.setElements();
    this.listen();
  }

  /**
   * Set DOM targets into $el property
   *
   * @return {void}
   */
  setElements() {
    this.$el = {
      hamburger: this.$j('.hamburger'),
      header: this.$j('.c-header'),
    }
  }

  /**
   * Init all header event listeners
   *
   * @return {void}
   */
  listen() {
    this.listenBurgerClick();
  }

  /**
   * Toggles menu classes - css takes over transitions, etc
   *
   * @param {JQuery} el - The triggered jQuery element.
   *
   * @return {void}
   */
  toggleBurger(el) {
    el.toggleClass('is-active');
    this.$el.header.toggleClass('c-header--active');
  }

  /**
   * Listen for a click on burger button
   *
   * @return {void}
   */
  listenBurgerClick() {
    this.$el.hamburger.click( (e) => {
      const $el = this.$j(e.currentTarget);
      this.toggleBurger($el);
    });
  }
}
