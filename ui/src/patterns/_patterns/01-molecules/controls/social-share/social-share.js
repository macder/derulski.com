export default class SocialShare {

  /**
   * Opens share url in a popup
   */
  constructor(el) {
    this.onClick();
  }

  onClick() {
    $('.js-social-share').on('click', (e) => {
      e.preventDefault();
      this.windowPopup($(e.currentTarget).attr('href'), 500, 300);
    });
  }

  windowPopup(url, width, height) {
    // Calculate the position of the popup so
    // it’s centered on the screen.
    const left = (screen.width / 2) - (width / 2),
    top = (screen.height / 2) - (height / 2);

    window.open(
      url,
      "",
      "menubar=no,toolbar=no,resizable=yes,scrollbars=yes,width=" + width + ",height=" + height + ",top=" + top + ",left=" + left
    );
  }
}
