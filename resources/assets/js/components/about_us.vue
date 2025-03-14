<template>
  <v-page>
    <div class="content-page">
      <div class="page-header">
        <h1>LA EMPRESA</h1>
      </div>

      <div class="container">
        <div class="row">
          <div class="col-12">
            <div v-html="content"></div>
            <h2>Otras marcas</h2>
            <ul class="brand-list">
              <li>
                <a href="http://www.volkswagen.com.py" rel="noopener" target="_blank">
                  <span class="helper"></span>
                  <img src="/img/logos/vw.png" alt="Volkswagen">
                </a>
              </li>
              <li>
                <a href="https://www.vwco.com.br" rel="noopener" target="_blank">
                  <span class="helper"></span>
                  <img src="/img/logos/man.png" alt="Man">
                </a>
              </li>
              <li>
                <a href="https://www.vwco.com.br" rel="noopener" target="_blank">
                  <span class="helper"></span>
                  <img src="/img/logos/vw-lkw.png" alt="Volkswagen">
                </a>
              </li>
              <li>
                <a href="http://www.audi.com.py" rel="noopener" target="_blank">
                  <span class="helper"></span>
                  <img src="/img/logos/audi.png" alt="Audi">
                </a>
              </li>
              <li>
                <a href="http://www.porsche.com.py" rel="noopener" target="_blank">
                  <span class="helper"></span>
                  <img src="/img/logos/porsche.png" alt="Porsche">
                </a>
              </li>
              <li>
                <a href="https://www.scania.com/br/pt/home.html" rel="noopener" target="_blank">
                  <span class="helper"></span>
                  <img src="/img/logos/scania.png" alt="Scania">
                </a>
              </li>
              <li>
                <span class="helper"></span>
                <img src="/img/logos/skoda.png" alt="Skoda">
              </li>
              <li>
                <a href="https://www.facebook.com/DiesaUsados/" rel="noopener" target="_blank">
                  <span class="helper"></span>
                  <img src="/img/logos/diesa.png" alt="Diesa usads">
                </a>
              </li>
              <li>
                <a href="https://www.facebook.com/hondaproductospy/" rel="noopener" target="_blank">
                  <span class="helper"></span>
                  <img src="/img/logos/honda.png" alt="Honda">
                </a>
              </li>
              <li>
                <a href="http://www.hertzparaguay.com" rel="noopener" target="_blank">
                  <span class="helper"></span>
                  <img src="/img/logos/hertz.png" alt="Hertz">
                </a>
              </li>
              <li>
                <span class="helper"></span>
                <img src="/img/logos/thrifty.png" alt="Thrifty">
              </li>
              <li>
                <a href="https://www.casece.com/latam/es-la" rel="noopener" target="_blank">
                  <span class="helper"></span>
                  <img src="/img/logos/case.png" alt="Case">
                </a>
              </li>
              <li>
                <a href="https://wayne.com/" rel="noopener" target="_blank">
                  <span class="helper"></span>
                  <img src="/img/logos/wayne.png" alt="Wayne">
                </a>
              </li>
              <li>
                <a href="https://www.facebook.com/fawparaguay/" rel="noopener" target="_blank">
                  <span class="helper"></span>
                  <img src="/img/logos/faw.png" alt="FAW">
                  </a>
              </li>
              <li>
                <a href="https://www.glory-global.com/es-es/" rel="noopener" target="_blank">
                  <span class="helper"></span>
                  <img src="/img/logos/glory.png" alt="Glory">
                </a>
              </li>
              <li>
                <a href="https://www.delarue.com/" rel="noopener" target="_blank">
                  <span class="helper"></span>
                  <img src="/img/logos/de-la-rue.png" alt="De la Rue">
                </a>
              </li>
              <li>
                <span class="helper"></span>
                <img src="/img/logos/acer.png" alt="Acer">
              </li>
              <li>
                <span class="helper"></span>
                <img src="/img/logos/avianca.png" alt="Avianca">
              </li>
              <li>
                <span class="helper"></span>
                <img src="/img/logos/mariner.png" alt="Mariner">
              </li>
              <li>
                <span class="helper"></span>
                <img src="/img/logos/clp.png" alt="CLP">
              </li>
              <li>
                <span class="helper"></span>
                <img src="/img/logos/seat.png" alt="Seat">
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </v-page>
</template>

<script>
export default {
  computed: {
    title() {
      return this.$parent.content['about-us'] ? this.$parent.content['about-us'].title : ''
    },
    content() {
      return this.$parent.content['about-us'] ? this.$parent.content['about-us'].content : ''
    },
  },
  components: {
    'v-page': require('./partials/page')
  }
}
</script>
