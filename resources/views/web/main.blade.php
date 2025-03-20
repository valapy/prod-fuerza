<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
    @include('web/seo/head')
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="/img/favicon.png" type="image/png">

    <title>Honda Paraguay</title>
    <!-- Google Tag Manager -->
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-W4T7XSW');
    </script>
    <!-- End Google Tag Manager -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}?{{ hash_file('sha1', 'css/app.css') }}">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-W4T7XSW" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <div id="app" v-cloak>
        <div class="main-menu">
            <ul class="no-list">
                <li>
                    <router-link :to="{ name: 'home' }" class="logo">
                        <img src="/img/logo.png" alt="Honda" />
                    </router-link>
                </li>
                <li>
                    <router-link :to="{ name: 'branch_offices' }" class="opacity">
                        <img src="/img/menu-branch-offices.png" alt="Concesionarias" />
                        <div class="text">Concesionarias</div>
                    </router-link>
                </li>
                <li>
                    <router-link :to="{ name: 'products' }" class="opacity">
                        <img src="/img/menu-products.svg" alt="Modelos" />
                        <div class="text">Modelos</div>
                    </router-link>
                </li>
                <!--
        <li>
          <router-link :to="{ name: 'used-products' }" v-if="used_products.length > 0" class="opacity">
            <img src="/img/menu-products-used.svg" alt="Usados" />
            <div class="text">Usados</div>
          </router-link>
        </li>
        -->
                <li>
                    <router-link :to="{ name: 'service' }" class="opacity">
                        <img src="/img/menu-service.png" alt="Servicios & Repuestos" />
                        <div class="text">Servicios & Repuestos</div>
                    </router-link>
                </li>
                <li>
                    <a href="javascript:;" class="opacity" v-on:click="showOverlay('search')">
                        <img src="/img/menu-search.png" align="Buscar" />
                        <div class="text">Buscar</div>
                    </a>
                </li>
                <li>
                    <router-link :to="{ name: 'about_us' }" class="opacity">
                        <img src="/img/menu-about-us.png" alt="La empresa" />
                        <div class="text">La empresa</div>
                    </router-link>
                </li>
                <li>
                    <router-link :to="{ name: 'news' }" class="opacity">
                        <img src="/img/menu-news.png" alt="Noticias" />
                        <div class="text">Noticias</div>
                    </router-link>
                </li>
                <li>
                    <router-link :to="{ name: 'contact_us' }" class="opacity">
                        <img src="/img/menu-contact.svg" alt="Contactános" />
                        <div class="text">Contactános</div>
                    </router-link>
                </li>
            </ul>
        </div>

        <div class="main-menu-mobile">
            <div class="d-flex flex-row">
                <router-link :to="{ name: 'home' }" class="mr-auto" @click.native="hideMenu()">
                    <img src="/img/logo-honda-red.png" alt="Honda" height="60px" />
                </router-link>

                <a href="javascript:;" @click="isMainMenuVisible = !isMainMenuVisible" class="p-3">
                    <img src="/img/hamburger-menu.svg" alt="Menú" height="30px" v-if="!isMainMenuVisible" />
                    <img src="/img/hamburger-menu-close.svg" alt="Menú" height="30px" v-if="isMainMenuVisible" />
                </a>
            </div>
        </div>

        <div class="main-menu-mobile-list" v-if="isMainMenuVisible">
            <ul class="no-list">
                <li>
                    <router-link :to="{ name: 'branch_offices' }" class="opacity" @click.native="hideMenu()">
                        <img src="/img/menu-branch-offices.png" alt="Concesionarias" />
                        <div class="text">Concesionarias</div>
                    </router-link>
                </li>
                <li>
                    <router-link :to="{ name: 'products' }" class="opacity" @click.native="hideMenu()">
                        <img src="/img/menu-products.svg" alt="Modelos" />
                        <div class="text">Modelos</div>
                    </router-link>
                </li>
                <li>
                    <router-link :to="{ name: 'used-products' }" class="opacity" @click.native="hideMenu()">
                        <img src="/img/menu-products-used.svg" alt="Usados" />
                        <div class="text">Usados</div>
                    </router-link>
                </li>
                <li>
                    <router-link :to="{ name: 'service' }" class="opacity" @click.native="hideMenu()">
                        <img src="/img/menu-service.png" alt="Servicios & Repuestos" />
                        <div class="text">Servicios & Repuestos</div>
                    </router-link>
                </li>
                <li class="d-none">
                    <a href="javascript:;" class="opacity" v-on:click="showOverlay('search')">
                        <img src="/img/menu-search.png" align="Buscar" />
                        <div class="text">Buscar</div>
                    </a>
                </li>
                <li>
                    <router-link :to="{ name: 'about_us' }" class="opacity" @click.native="hideMenu()">
                        <img src="/img/menu-about-us.png" alt="La empresa" />
                        <div class="text">La empresa</div>
                    </router-link>
                </li>
                <li>
                    <router-link :to="{ name: 'news' }" class="opacity" @click.native="hideMenu()">
                        <img src="/img/menu-news.png" alt="Noticias" />
                        <div class="text">Noticias</div>
                    </router-link>
                </li>
                <li>
                    <router-link :to="{ name: 'contact_us' }" class="opacity" @click.native="hideMenu()">
                        <img src="/img/menu-contact.svg" alt="Contactános" />
                        <div class="text">Contactános</div>
                    </router-link>
                </li>
            </ul>
        </div>

        <transition name="fade-page">
            <router-view></router-view>
        </transition>

        <a href="javascript:;" class="btn-budget opacity" v-on:click="showOverlay('budget')">
            <img src="/img/btn-budget.svg" alt="Presupuesto" />
        </a>

        <v-back-to-top></v-back-to-top>

        <div class="clear"></div>

        {{-- @include('web/sections/overlay/search') --}}
        <budget-overlay v-if="overlay == 'budget'" @close="overlay = null"></budget-overlay>
        <search-overlay v-if="overlay == 'search'" @close="overlay = null"></search-overlay>
    </div>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-140834312-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'UA-140834312-1');
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBHK1kF4fVFPAhM_oc_Z4QroldC9hSk2Qs&libraries=places">
    </script>
    <script type="text/javascript" src="{{ asset('js/main.js') }}?{{ hash_file('sha1', 'js/main.js') }}"></script>
    @include('web/seo/data')
</body>

</html>
