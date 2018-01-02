import Header from '../patterns/_patterns/02-organisms/00-global/00-header/header';
import InlineGallery from '../patterns/_patterns/01-molecules/media/inline-gallery/inline-gallery';

const components = [
  {
    name: 'header',
    Component: Header,
  },
  {
    name: 'inline-gallery',
    Component: InlineGallery,
  },
];

components.forEach((c) => {
  Array.from(document.querySelectorAll(`.c-${c.name}`)).forEach((el) => {
    const element = el;
    element.component = new c.Component(el);
  });
});
