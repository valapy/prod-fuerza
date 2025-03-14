// We load the apps if we find their selector
[
  'pricing',
  'specs',
].forEach(name => {
  const el = `#app-${name}`;
  if (!document.querySelector(el)) return;
  const build = require(`./${name}`).default;
  build(el);
});

const initializeDescriptionApps = () => {
  const apps = document.querySelectorAll('.description-app.uninitialized');
  apps.forEach(el => {
    el.classList.remove('uninitialized');
    const build = require(`./descriptions`).default;
    build(el);
  });
};

initializeDescriptionApps();

const descriptionForm = document.getElementById('description-root');
if (descriptionForm) {
  new MutationObserver(initializeDescriptionApps).observe(descriptionForm, {
    childList: true,
    subtree: true,
  });
}