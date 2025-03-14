<template>
  <div :class="{ 'container-fluid': true, footer: true, 'footer-sticky': sticky }">
    <div class="bottom-bar row">
      <div class="col-sm">
        <div class="flex">
          <ul class="no-list align-middle">
            <li class="logo">
              <img src="/img/logo-honda-white.svg" alt="Honda" />
            </li>
            <li class="logo">
              <a href="http://www.diesa.com.py" class="opacity" target="_blank">
                <img src="/img/logo-diesa.svg" alt="Diesa S.A." />
              </a>
            </li>
          </ul>
        </div>
      </div>
      <div class="col-sm">
        <div class="row">
          <div class="col">
            <div class="float-right social-networks">
              <a href="https://www.youtube.com/channel/UCVtTXtUa8kyD2Fl8Cmju2AA" class="opacity"  target="_blank">
                <img src="/img/social-networks/youtube.svg" alt="Honda Motos Paraguay" />
              </a>
              <a href="https://www.instagram.com/hondamotospy/" class="opacity"  target="_blank">
                <img src="/img/social-networks/instagram.svg" alt="Honda Motos Paraguay" />
              </a>
              <a href="https://www.facebook.com/pg/hondamotospy" class="opacity"  target="_blank">
                <img src="/img/social-networks/facebook.svg" alt="Honda Motos Paraguay" />
              </a>
            </div>
          </div>
        </div>
        <div class="row text-right">
          <div class="col">
            <a href="https://www.creadores.com.py" target="_blank">
              <img src="/img/creadores_logo_blanco.png" alt="Creadores S.A." />
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    sticky: {
      type: Boolean,
      default: true,
    },
  }
}
</script>
