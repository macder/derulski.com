import Header from '../patterns/_patterns/02-organisms/00-global/00-header/header';
import InlineGallery from '../patterns/_patterns/01-molecules/media/inline-gallery/inline-gallery';
import SocialShare from '../patterns/_patterns/01-molecules/controls/social-share/social-share';

const components = [
  {
    name: 'header',
    Component: Header,
  },
  {
    name: 'inline-gallery',
    Component: InlineGallery,
  },
  {
    name: 'social-share',
    Component: SocialShare,
  },
];

components.forEach((c) => {
  Array.from(document.querySelectorAll(`.c-${c.name}`)).forEach((el) => {
    const element = el;
    element.component = new c.Component(el);
  });
});
