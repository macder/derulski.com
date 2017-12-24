import Header from '../patterns/_patterns/02-organisms/00-global/00-header/header';

const components = [{
  name: 'header',
  Component: Header,
}];

components.forEach((c) => {
  Array.from(document.querySelectorAll(`.c-${c.name}`)).forEach((el) => {
    const element = el;
    element.component = new c.Component(el);
  });
});
