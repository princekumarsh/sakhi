<!doctype html>
<html class="no-js" lang="en" dir="ltr">

<head>
  <script>
    let storeShopifyDomain = "jisora-india.myshopify.com";
          window.Shopify = {
          ...window.Shopify,
          shop: storeShopifyDomain,
        };
      window.onload = () => {
        let shopifyObjectDomain = window?.Shopify?.shop;
        if (!window.Shopify.shop || !Shopify.shop.includes("myshopify.com")) {
          window.Shopify = {
            ...window.Shopify,
            shop: shopifyObjectDomain,
          };
        }
      };
      window.triggerSentry = (message) => {
      try {
        message = `[theme-script] :: ${message} :: ${window.location.href}`;
        fetch(`${window.zecpeHostName}/api/utils/sentry`, {
          method: "POST",
          body: JSON.stringify({ message, type: "error", sentry: true }),
          headers: {
            "Content-Type": "application/json",
          },
        });
      } catch (err) {
        console.error(`Zecpe sentry error :: ${err?.message}`);
      }
    };
    window.zecpeCheckFunctionAndCall = function (func, ...args) {
      try {
        let button = args[0];
        // * Checking if button is a valid HTML element
        if (button instanceof HTMLElement) {
          if (button && button.children) {
            if (Array.from(button.children).length === 2) {
              Array.from(button.children)[0].style.display = "grid";
              Array.from(button.children)[1].style.display = "none";
            }
            button.disabled = true;
            button.style.cursor = "not-allowed";
            // * Re-enabling button after 6 seconds
            setTimeout(() => {
              if (Array.from(button.children).length === 2) {
                Array.from(button.children)[0].style.display = "none";
                Array.from(button.children)[1].style.display = "flex";
              }
              button.removeAttribute("disabled");
              button.style.cursor = "pointer";
            }, 6000);
          }
        }
        let giftCardCheckBox = document.getElementById("zecpe-gift-card");
        if(giftCardCheckBox?.checked){
          window.location.href = "/cart/checkout";
          return;
        }
        let outSideIndiaCheckbox = document.getElementById("zecpe-outside-india");
        if(outSideIndiaCheckbox?.checked){
          window.location.href = "/cart/checkout";
          return;
        }
        if (typeof window[func] === "function") {
          window[func](...args);
        } else {
          let isZecpeThemeScriptLoaded = false;
          let script = document.createElement("script");
          script.type = "text/javascript";
          script.src = "https://cdn.zecpe.com/payModal/themeScript.js";
          script.id = "zecpe-theme-script";
          document.getElementsByTagName("head")[0].appendChild(script);
          // * Wait for 2 seconds, if script is not loaded redirect to /cart/checkout
          setTimeout(() => {
            if (!isZecpeThemeScriptLoaded) {
              window.location.href = "/cart/checkout";
            }
          }, 2000);
          script.onload = function () {
            isZecpeThemeScriptLoaded = true;
            // * Triggering the custom code handler to overrwite the default code        
            window.zecpeCustomCode(); 
            window[func](...args);
          };
        }
      } catch (err) {
        window.triggerSentry(`zecpeCheckFunctionAndCall :: ${err?.message}`);
      }
    };

  </script>

  <script async type="text/javascript">
    let themeScriptLoaded = false;
      // * Define a function to load the script with retries
    function loadScriptWithRetries(url, retries) {
      // * Checking if script is already loaded or retries are over
      if(retries <=0 || themeScriptLoaded) return;
      // * Creating a new script element
      let script = document.createElement('script');
      script.type = 'text/javascript';
      script.src = url;
      script.id = "zecpe-theme-script";
      script.async = true;
      script.onload = function() {
        // * Script loaded successfully
        themeScriptLoaded = true;
          // * Triggering the custom code handler to overrwite the default code
        window.zecpeCustomCode();
      };

      // * Append the script to the document head
      document.head.appendChild(script);

      // * Retrying after 2 seconds
      setTimeout(function() {
        loadScriptWithRetries(url, retries - 1);
      }, 2000);
    }
    // * Call the loadScriptWithRetries function with the script URL and retries count
    loadScriptWithRetries('https://cdn.zecpe.com/payModal/themeScript.js', 3);

  </script>

  <script async type="text/javascript">
    // * Theme file for custom changes
      try {
        // * Listening for the event "zecpeThemeScriptLoaded" on the document and executing the code
        window.zecpeCustomCode = function (){
          // * Custom code goes here
        }
    } catch (err) {
        console.log(err)
    }
  </script>


  <style>
    #occ-payment-loader {
      width: 40px;
      height: 40px;
      margin: auto !important;
      color: #7d0101 !important;
      background: linear-gradient(currentColor 0 0), linear-gradient(currentColor 0 0), linear-gradient(currentColor 0 0), linear-gradient(currentColor 0 0);
      background-size: 21px 21px;
      background-repeat: no-repeat;
      animation: sh5 1.5s infinite cubic-bezier(0.3, 1, 0, 1);
    }

    @keyframes sh5 {
      0% {
        background-position: 0 0, 100% 0, 100% 100%, 0 100%;
      }

      33% {
        background-position: 0 0, 100% 0, 100% 100%, 0 100%;
        width: 60px;
        height: 60px;
      }

      66% {
        background-position: 100% 0, 100% 100%, 0 100%, 0 0;
        width: 60px;
        height: 60px;
      }

      100% {
        background-position: 100% 0, 100% 100%, 0 100%, 0 0;
      }
    }

    #occ-payment-loader-container {
      min-height: 60px;
      height: 60px;
      display: grid;
      place-items: center;
    }

    #zecpe-overlay {
      display: grid;
      position: fixed;
      top: 0;
      place-items: center;
      left: 0;
      z-index: 99999999999999;
      justify-content: center;
      align-items: center;
      width: 100vw;
      height: 100vh;
      background: #fff;
    }

    #zecpe-btn-text {
      line-height: 18px;
      text-align: left;
    }

    #zecpe-btn-header {
      font-weight: 600;
    }

    #zecpe-btn-desc {
      font-weight: 600;
      font-size: 11px;
    }

    #zecpe-arrow-icon {
      display: inline
    }

    .zecpe-buy-now {
      background: #000;
      width: 100%;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.3em;
      font-size: 13px;
      font-family: Montserrat, sans-serif;
      color: #fff;
      height: 46px;
      max-height: 46px;
      position: relative;
    }

    .lds-ring {
      display: none;
      position: relative;
      width: 100%;
      height: 30px;
      place-items: center;
      text-align: center;
      max-height: 100%;
    }

    .lds-ring div {
      box-sizing: border-box;
      display: block;
      width: 24px;
      position: absolute;
      height: 24px;
      margin: 3px;
      border: 3px solid #fff;
      border-radius: 50%;
      animation: lds-ring 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
      border-color: #fff transparent transparent transparent;
    }

    .lds-ring div:nth-child(1) {
      animation-delay: -0.45s;
    }

    .lds-ring div:nth-child(2) {
      animation-delay: -0.3s;
    }

    .lds-ring div:nth-child(3) {
      animation-delay: -0.15s;
    }

    @keyframes lds-ring {
      0% {
        transform: rotate(0deg);
      }

      100% {
        transform: rotate(360deg);
      }
    }

    @media only screen and (max-width: 768px) {
      .zecpe-buy-now {
        font-size: 11px;
      }

      #zecpe-btn-header {
        font-size: 14px
      }

      #zecpe-arrow-icon {
        display: none
      }

      #zecpe-btn-text {
        font-size: 14px;
      }

      #zecpe-btn-desc {
        font-size: 7px;
      }
    }
  </style>
  <script>
    let zecpeEvents = ["checkout_initiated_zecpe"];
    zecpeEvents.forEach((eventName) => {
        window.addEventListener(eventName, (e) => {
            let closeBtns = document.querySelectorAll(".drawer__close-button");
            for (let btn of closeBtns)
                btn.click();
        })
    })
  </script>
  <script>
    let count = 0;
    function wigzoEventListener(e) {
      try {
        if (e.type === 'address_added_zecpe') {
          let identifyData = {
            phone: `${e.detail.mobileNumber}`,
            email: e.detail.email,
          };
          window.wigzo('identify', identifyData);
          console.log('Identify event sent to wigzo');

          let checkoutStartedData = {
            cart_token: e.detail.cartDetails.token,
            buyer_accepts_marketing: e.detail.cartDetails.marketingConsent || true,
            phone: `${e.detail.mobileNumber}`,
            line_items: e.detail.cartDetails.items,
            billing_address: {
              first_name: e.detail.firstName,
              last_name: e.detail.lastName,
              phone: `+91${e.detail.mobileNumber}`,
              city: e.detail.city,
              zip: e.detail.pincode,
              province: e.detail.state,
              country: 'IN',
            },
            shipping_address: {
              first_name: e.detail.firstName,
              last_name: e.detail.lastName,
              phone: `+91${e.detail.mobileNumber}`,
              city: e.detail.city,
              zip: e.detail.pincode,
              province: e.detail.state,
              country: 'IN',
            },
            customer: {
              accepts_marketing: e.detail.cartDetails.marketingConsent,
              first_name: e.detail.cartDetails.firstName,
              last_name: e.detail.cartDetails.lastName,
              state: e.detail.state,
              phone: `+91${e.detail.mobileNumber}`,
              default_address: {
                first_name: e.detail.firstName,
                last_name: e.detail.lastName,
                phone: `+91${e.detail.mobileNumber}`,
                city: e.detail.city,
                zip: e.detail.pincode,
                province: e.detail.state,
                country: 'IN',
              },
            },
          };
          window.wigzo('track', 'checkoutstarted', checkoutStartedData);
          console.log('checkoutstarted event sent to wigzo');
        }
      } catch (error) {
        console.log(error);
      }
    }

    function addWigzoEventListeners() {
      try {
        let zecpeEvents = ['user_verified_zecpe', 'address_added_zecpe'];
        if (typeof window.wigzo === 'function') {
          zecpeEvents.forEach((event) => {
            window.addEventListener(event, wigzoEventListener);
          });
        } else {
          if (count++ < 7) {
            console.log('Zecpe :: Wigzo not initialized checking againg');
            setTimeout(addWigzoEventListeners, 2000);
          } else {
            console.log('Zepce :: Wigzo is not initialized on this store.');
          }
        }
      } catch (error) {
        console.log(error);
        if (window?.triggerSentry && typeof window?.triggerSentry === 'function') {
          window.triggerSentry(`[zecpe-wigzo] error while firing wigzo event :: ${JSON.stringify(error)}`);
        }
      }
    }
    setTimeout(addWigzoEventListeners, 2000);
  </script>






  <script src="https://cdn.beae.com/vendors/js-v2/jquery.min.js" crossorigin="anonymous" referrerpolicy="no-referrer">
  </script>

  <script src="https://cdn.ecomposer.app/vendors/js/jquery.min.js" crossorigin="anonymous" referrerpolicy="no-referrer">
  </script>
  <meta name="facebook-domain-verification" content="4vkzi7rxmd3wy3jkmwulv32u2prlfw" />

  <!-- Added by AVADA SEO Suite -->



  <!-- /Added by AVADA SEO Suite -->
  <script>
    window.KiwiSizing = window.KiwiSizing === undefined ? {} : window.KiwiSizing;
    KiwiSizing.shop = "jisora-india.myshopify.com";


  </script>


  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="theme-color" content="#750902">
  <link rel="canonical" href="https://jisora.com/">
  <link rel="preconnect" href="https://cdn.shopify.com">
  <link rel="preconnect" href="https://fonts.shopifycdn.com">
  <link rel="dns-prefetch" href="https://productreviews.shopifycdn.com">
  <link rel="dns-prefetch" href="https://ajax.googleapis.com">
  <link rel="dns-prefetch" href="https://maps.googleapis.com">
  <link rel="dns-prefetch" href="https://maps.gstatic.com">
  <link rel="shortcut icon"
    href="//jisora.com/cdn/shop/files/jisora-logo_32x32_5c13bc54-2d3d-4bd0-870d-d4b7dd3ca847_32x32.webp?v=1648472682"
    type="image/png" />
  <title>Buy cotton dresses online for women in India.
    &ndash; JISORA
  </title>
  <meta name="description"
    content="Buy cotton dresses online for women in India. Jisora is a women&#39;s cotton dress clothing store that offers modern &amp; casual 100% cotton dresses for women and girls.">
  <meta property="og:site_name" content="JISORA">
  <meta property="og:url" content="https://jisora.com/">
  <meta property="og:title" content="Buy cotton dresses online for women in India.">
  <meta property="og:type" content="website">
  <meta property="og:description"
    content="Buy cotton dresses online for women in India. Jisora is a women&#39;s cotton dress clothing store that offers modern &amp; casual 100% cotton dresses for women and girls.">
  <meta name="twitter:site" content="@">
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="Buy cotton dresses online for women in India.">
  <meta name="twitter:description"
    content="Buy cotton dresses online for women in India. Jisora is a women&#39;s cotton dress clothing store that offers modern &amp; casual 100% cotton dresses for women and girls.">

  <style data-shopify>
    @font-face {
      font-family: "Avenir Next";
      font-weight: 400;
      font-style: normal;
      font-display: swap;
      src: url("//jisora.com/cdn/fonts/avenir_next/avenirnext_n4.7fd0287595be20cd5a683102bf49d073b6abf144.woff2?h1=amlzb3JhLmNvbQ&h2=amlzb3JhLmlu&h3=amlzb3JhZ2xvYmFsLmNvbQ&h4=amlzb3JhLWluZGlhLmFjY291bnQubXlzaG9waWZ5LmNvbQ&h5=amlzb3JhLm5ldA&h6=amlzb3JhLmNvLmlu&h7=amlzb3JhLm9yZw&h8=amlzb3JhamFpcHVyLmlu&h9=amlzb3JhamFpcHVyLmNvbQ&hmac=e21d093732075835a1cf68e7c36f5a299c9eca653361d806593feb2a13442307") format("woff2"),
        url("//jisora.com/cdn/fonts/avenir_next/avenirnext_n4.a26a334a0852627a5f36b195112385b0cd700077.woff?h1=amlzb3JhLmNvbQ&h2=amlzb3JhLmlu&h3=amlzb3JhZ2xvYmFsLmNvbQ&h4=amlzb3JhLWluZGlhLmFjY291bnQubXlzaG9waWZ5LmNvbQ&h5=amlzb3JhLm5ldA&h6=amlzb3JhLmNvLmlu&h7=amlzb3JhLm9yZw&h8=amlzb3JhamFpcHVyLmlu&h9=amlzb3JhamFpcHVyLmNvbQ&hmac=d6e56143d9459a0e2a2a96f84b58865e2e725f3994d0445139f7f91661b689d3") format("woff");
    }

    @font-face {
      font-family: "Avenir Next";
      font-weight: 400;
      font-style: normal;
      font-display: swap;
      src: url("//jisora.com/cdn/fonts/avenir_next/avenirnext_n4.7fd0287595be20cd5a683102bf49d073b6abf144.woff2?h1=amlzb3JhLmNvbQ&h2=amlzb3JhLmlu&h3=amlzb3JhZ2xvYmFsLmNvbQ&h4=amlzb3JhLWluZGlhLmFjY291bnQubXlzaG9waWZ5LmNvbQ&h5=amlzb3JhLm5ldA&h6=amlzb3JhLmNvLmlu&h7=amlzb3JhLm9yZw&h8=amlzb3JhamFpcHVyLmlu&h9=amlzb3JhamFpcHVyLmNvbQ&hmac=e21d093732075835a1cf68e7c36f5a299c9eca653361d806593feb2a13442307") format("woff2"),
        url("//jisora.com/cdn/fonts/avenir_next/avenirnext_n4.a26a334a0852627a5f36b195112385b0cd700077.woff?h1=amlzb3JhLmNvbQ&h2=amlzb3JhLmlu&h3=amlzb3JhZ2xvYmFsLmNvbQ&h4=amlzb3JhLWluZGlhLmFjY291bnQubXlzaG9waWZ5LmNvbQ&h5=amlzb3JhLm5ldA&h6=amlzb3JhLmNvLmlu&h7=amlzb3JhLm9yZw&h8=amlzb3JhamFpcHVyLmlu&h9=amlzb3JhamFpcHVyLmNvbQ&hmac=d6e56143d9459a0e2a2a96f84b58865e2e725f3994d0445139f7f91661b689d3") format("woff");
    }


    @font-face {
      font-family: "Avenir Next";
      font-weight: 600;
      font-style: normal;
      font-display: swap;
      src: url("//jisora.com/cdn/fonts/avenir_next/avenirnext_n6.08f6a09127d450aa39c74986de08fd8fa84e6a11.woff2?h1=amlzb3JhLmNvbQ&h2=amlzb3JhLmlu&h3=amlzb3JhZ2xvYmFsLmNvbQ&h4=amlzb3JhLWluZGlhLmFjY291bnQubXlzaG9waWZ5LmNvbQ&h5=amlzb3JhLm5ldA&h6=amlzb3JhLmNvLmlu&h7=amlzb3JhLm9yZw&h8=amlzb3JhamFpcHVyLmlu&h9=amlzb3JhamFpcHVyLmNvbQ&hmac=f940c8c84d090ab8090f1c41619d385e96253c1c33e402e4aac4ec97c6621301") format("woff2"),
        url("//jisora.com/cdn/fonts/avenir_next/avenirnext_n6.bd2f76897d6f40c767db7c40226916ec7b6ffc65.woff?h1=amlzb3JhLmNvbQ&h2=amlzb3JhLmlu&h3=amlzb3JhZ2xvYmFsLmNvbQ&h4=amlzb3JhLWluZGlhLmFjY291bnQubXlzaG9waWZ5LmNvbQ&h5=amlzb3JhLm5ldA&h6=amlzb3JhLmNvLmlu&h7=amlzb3JhLm9yZw&h8=amlzb3JhamFpcHVyLmlu&h9=amlzb3JhamFpcHVyLmNvbQ&hmac=0476a700bfe822959b07f398df20e8137507c713851a610af5b42f0ff700223f") format("woff");
    }

    @font-face {
      font-family: "Avenir Next";
      font-weight: 400;
      font-style: italic;
      font-display: swap;
      src: url("//jisora.com/cdn/fonts/avenir_next/avenirnext_i4.f1583d9f457b68e44fbda187a48b4096d547d7f4.woff2?h1=amlzb3JhLmNvbQ&h2=amlzb3JhLmlu&h3=amlzb3JhZ2xvYmFsLmNvbQ&h4=amlzb3JhLWluZGlhLmFjY291bnQubXlzaG9waWZ5LmNvbQ&h5=amlzb3JhLm5ldA&h6=amlzb3JhLmNvLmlu&h7=amlzb3JhLm9yZw&h8=amlzb3JhamFpcHVyLmlu&h9=amlzb3JhamFpcHVyLmNvbQ&hmac=e4567c4a382bf61c99f1366c06eaad9dbae69c11bbd5bfd0535abd24041203d8") format("woff2"),
        url("//jisora.com/cdn/fonts/avenir_next/avenirnext_i4.67fb53a3e0351125941146246183577ae8d8bf23.woff?h1=amlzb3JhLmNvbQ&h2=amlzb3JhLmlu&h3=amlzb3JhZ2xvYmFsLmNvbQ&h4=amlzb3JhLWluZGlhLmFjY291bnQubXlzaG9waWZ5LmNvbQ&h5=amlzb3JhLm5ldA&h6=amlzb3JhLmNvLmlu&h7=amlzb3JhLm9yZw&h8=amlzb3JhamFpcHVyLmlu&h9=amlzb3JhamFpcHVyLmNvbQ&hmac=f4ad7246bfdf83a05c87b7abb992037d102641ebfe4e47ccd29198a7b9542cd2") format("woff");
    }

    @font-face {
      font-family: "Avenir Next";
      font-weight: 600;
      font-style: italic;
      font-display: swap;
      src: url("//jisora.com/cdn/fonts/avenir_next/avenirnext_i6.449b8593f8987f1402fdf6d634f972f810c90c5c.woff2?h1=amlzb3JhLmNvbQ&h2=amlzb3JhLmlu&h3=amlzb3JhZ2xvYmFsLmNvbQ&h4=amlzb3JhLWluZGlhLmFjY291bnQubXlzaG9waWZ5LmNvbQ&h5=amlzb3JhLm5ldA&h6=amlzb3JhLmNvLmlu&h7=amlzb3JhLm9yZw&h8=amlzb3JhamFpcHVyLmlu&h9=amlzb3JhamFpcHVyLmNvbQ&hmac=7c2a44d560d3a604e4c7dbe0258933669a0a4ae88c4925987ddd51fdd0297ee0") format("woff2"),
        url("//jisora.com/cdn/fonts/avenir_next/avenirnext_i6.9c697a2eda486add54c668d1ec4ac662c8402e7c.woff?h1=amlzb3JhLmNvbQ&h2=amlzb3JhLmlu&h3=amlzb3JhZ2xvYmFsLmNvbQ&h4=amlzb3JhLWluZGlhLmFjY291bnQubXlzaG9waWZ5LmNvbQ&h5=amlzb3JhLm5ldA&h6=amlzb3JhLmNvLmlu&h7=amlzb3JhLm9yZw&h8=amlzb3JhamFpcHVyLmlu&h9=amlzb3JhamFpcHVyLmNvbQ&hmac=fd8f450edd99441288e00e01e0a69dc7b866d246563f9b9cd0bf12198781b2b9") format("woff");
    }
  </style>

  <link href="//jisora.com/cdn/shop/t/29/assets/theme.css?v=45122268607735783641679976358" rel="stylesheet"
    type="text/css" media="all" />
  <style data-shopify>
    :root {
      --typeHeaderPrimary: "Avenir Next";
      --typeHeaderFallback: sans-serif;
      --typeHeaderSize: 36px;
      --typeHeaderWeight: 400;
      --typeHeaderLineHeight: 1;
      --typeHeaderSpacing: 0.0em;

      --typeBasePrimary: "Avenir Next";
      --typeBaseFallback: sans-serif;
      --typeBaseSize: 18px;
      --typeBaseWeight: 400;
      --typeBaseSpacing: 0.025em;
      --typeBaseLineHeight: 1.4;

      --typeCollectionTitle: 20px;

      --iconWeight: 2px;
      --iconLinecaps: miter;


      --buttonRadius: 0px;


      --colorGridOverlayOpacity: 0.1;
    }

    .placeholder-content {
      background-image: linear-gradient(100deg, #ffffff 40%, #f7f7f7 63%, #ffffff 79%);
    }
  </style>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@500;600;700&display=swap" rel="stylesheet">
  <script>
    document.documentElement.className = document.documentElement.className.replace('no-js', 'js');

      window.theme = window.theme || {};
      theme.routes = {
        home: "/",
        cart: "/cart.js",
        cartPage: "/cart",
        cartAdd: "/cart/add.js",
        cartChange: "/cart/change.js",
        search: "/search"
      };
      theme.strings = {
        soldOut: "Sold Out",
        unavailable: "Unavailable",
        inStockLabel: "In stock, ready to ship",
        stockLabel: "Low stock - [count] items left",
        willNotShipUntil: "Ready to ship [date]",
        willBeInStockAfter: "Back in stock [date]",
        waitingForStock: "Inventory on the way",
        savePrice: "Save [saved_amount]",
        cartEmpty: "Your cart is currently empty.",
        cartTermsConfirmation: "You must agree with the terms and conditions of sales to check out",
        searchCollections: "Collections:",
        searchPages: "Pages:",
        searchArticles: "Articles:"
      };
      theme.settings = {
        dynamicVariantsEnable: true,
        cartType: "drawer",
        isCustomerTemplate: false,
      
        saveType: "dollar",
        productImageSize: "natural",
        productImageCover: false,
        predictiveSearch: true,
        predictiveSearchType: "product,article,page,collection",
        quickView: true,
        themeName: 'Impulse',
        themeVersion: "5.5.0"
      };
  </script>

  <script>
    window.performance && window.performance.mark && window.performance.mark('shopify.content_for_header.start');
  </script>
  <meta name="google-site-verification" content="9lv5hlWXCHUa4Q2jZ4xiry7kd3WguvMa_2hkdGO-8x8">

  <meta name="facebook-domain-verification" content="knxteuct9pabnw13m9brd9itwey6c7">
  <meta name="google-site-verification" content="XOv7JCPoi141qVPtmm7XJ3cofxzagP7Kl9kS-ioC7uY">
  <meta id="shopify-digital-wallet" name="shopify-digital-wallet" content="/52435222686/digital_wallets/dialog">
  <link rel="alternate" hreflang="x-default" href="https://jisora.com/">
  <link rel="alternate" hreflang="en-IN" href="https://jisora.com/">
  <link rel="alternate" hreflang="en-AC" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-AD" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-AF" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-AG" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-AI" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-AL" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-AM" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-AO" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-AR" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-AT" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-AU" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-AW" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-AX" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-AZ" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-BA" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-BB" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-BD" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-BE" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-BF" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-BG" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-BH" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-BI" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-BJ" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-BL" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-BM" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-BN" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-BO" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-BQ" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-BR" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-BS" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-BT" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-BW" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-BY" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-BZ" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-CA" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-CC" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-CD" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-CF" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-CG" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-CH" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-CI" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-CK" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-CL" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-CM" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-CN" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-CO" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-CR" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-CV" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-CW" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-CX" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-CY" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-CZ" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-DE" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-DJ" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-DK" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-DM" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-DO" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-DZ" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-EC" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-EE" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-EG" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-EH" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-ER" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-ES" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-ET" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-FI" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-FJ" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-FK" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-FO" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-FR" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-GA" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-GB" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-GD" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-GE" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-GF" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-GG" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-GH" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-GI" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-GL" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-GM" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-GN" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-GP" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-GQ" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-GR" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-GS" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-GT" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-GW" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-GY" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-HK" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-HN" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-HR" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-HT" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-HU" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-ID" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-IE" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-IL" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-IM" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-IO" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-IQ" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-IS" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-IT" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-JE" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-JM" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-JO" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-JP" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-KE" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-KG" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-KH" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-KI" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-KM" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-KN" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-KR" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-KW" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-KY" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-KZ" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-LA" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-LB" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-LC" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-LI" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-LK" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-LR" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-LS" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-LT" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-LU" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-LV" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-LY" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-MA" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-MC" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-MD" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-ME" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-MF" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-MG" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-MK" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-ML" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-MM" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-MN" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-MO" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-MQ" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-MR" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-MS" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-MT" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-MU" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-MV" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-MW" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-MX" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-MY" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-MZ" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-NA" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-NC" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-NE" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-NF" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-NG" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-NI" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-NL" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-NO" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-NP" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-NR" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-NU" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-NZ" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-OM" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-PA" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-PE" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-PF" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-PG" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-PH" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-PK" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-PL" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-PM" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-PN" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-PS" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-PT" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-PY" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-QA" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-RE" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-RO" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-RS" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-RU" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-RW" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-SA" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-SB" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-SC" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-SD" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-SE" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-SG" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-SH" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-SI" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-SJ" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-SK" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-SL" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-SM" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-SN" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-SO" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-SR" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-SS" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-ST" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-SV" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-SX" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-SZ" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-TA" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-TC" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-TD" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-TF" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-TG" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-TH" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-TJ" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-TK" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-TL" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-TM" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-TN" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-TO" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-TR" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-TT" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-TV" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-TW" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-TZ" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-UA" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-UG" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-UM" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-UY" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-UZ" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-VA" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-VC" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-VE" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-VG" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-VN" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-VU" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-WF" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-WS" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-XK" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-YE" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-YT" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-ZA" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-ZM" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-ZW" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-AE" href="https://jisoraglobal.com/">
  <link rel="alternate" hreflang="en-US" href="https://jisoraglobal.com/">
  <script async="async" src="/checkouts/internal/preloads.js?locale=en-IN"></script>
  <script id="shopify-features" type="application/json">
    {"accessToken":"eb2593c7ceb54a8a758b01334c292035","betas":["rich-media-storefront-analytics"],"domain":"jisora.com","predictiveSearch":true,"shopId":52435222686,"smart_payment_buttons_url":"https:\/\/jisora.com\/cdn\/shopifycloud\/payment-sheet\/assets\/latest\/spb.en.js","dynamic_checkout_cart_url":"https:\/\/jisora.com\/cdn\/shopifycloud\/payment-sheet\/assets\/latest\/dynamic-checkout-cart.en.js","locale":"en","optimusEnabled":true,"optimusHidden":false,"betterDynamicCheckoutRecommendationVariant":"control","shopPromisePDPV3Enabled":false}
  </script>
  <script>
    var Shopify = Shopify || {};
    Shopify.shop = "jisora-india.myshopify.com";
    Shopify.locale = "en";
    Shopify.currency = {"active":"INR","rate":"1.0"};
    Shopify.country = "IN";
    Shopify.theme = {"name":"Zecpe [27 March]","id":136894873825,"theme_store_id":null,"role":"main"};
    Shopify.theme.handle = "null";
    Shopify.theme.style = {"id":null,"handle":null};
    Shopify.cdnHost = "jisora.com/cdn";
    Shopify.routes = Shopify.routes || {};
    Shopify.routes.root = "/";
  </script>
  <script type="module">
    !function(o){(o.Shopify=o.Shopify||{}).modules=!0}(window);
  </script>
  <script>
    !function(o){function n(){var o=[];function n(){o.push(Array.prototype.slice.apply(arguments))}return n.q=o,n}var t=o.Shopify=o.Shopify||{};t.loadFeatures=n(),t.autoloadFeatures=n()}(window);
  </script>
  <script>
    (function() {
      function asyncLoad() {
        var urls = ["https:\/\/www.risingsigma.com\/zippy-v2\/assets\/js\/createScript.js?shop=jisora-india.myshopify.com","https:\/\/restock-master.hulkapps.com\/assets\/mha-rn-popup.js?shop=jisora-india.myshopify.com","https:\/\/cloudsearch-1f874.kxcdn.com\/shopify.js?srp=\/a\/search\u0026shop=jisora-india.myshopify.com","https:\/\/shop.miniorange.com\/mo_icons.js?shop=jisora-india.myshopify.com","https:\/\/intg.snapchat.com\/shopify\/shopify-scevent-init.js?id=ba34b297-9ff9-457b-a466-1c10e853640a\u0026shop=jisora-india.myshopify.com","https:\/\/app.kiwisizing.com\/web\/js\/dist\/kiwiSizing\/plugin\/SizingPlugin.prod.js?v=308\u0026shop=jisora-india.myshopify.com","https:\/\/geolocation-recommendations.shopifyapps.com\/locale_bar\/script.js?shop=jisora-india.myshopify.com","https:\/\/d3g420rgevyqxw.cloudfront.net\/cffOrderifyLoader_min.js?shop=jisora-india.myshopify.com","https:\/\/tracker.wigzopush.com\/shopify.js?orgtoken=atz7cZgBQR23bIVgLuAorg\u0026shop=jisora-india.myshopify.com","https:\/\/cdn.nfcube.com\/instafeed-a42f4b5f4d2290b7a6b31c46343fdb15.js?shop=jisora-india.myshopify.com","\/\/cdn.shopify.com\/proxy\/35b5083f0636f1893032afe07103e148d1d57c3e34d2c16f59950f3109c52808\/app.1clickpopup.com\/widget.js?shop=jisora-india.myshopify.com\u0026sp-cache-control=cHVibGljLCBtYXgtYWdlPTkwMA","https:\/\/cdn.zecpe.com\/payModal\/events-embed.js?shop=jisora-india.myshopify.com","https:\/\/cdn.shopify.com\/s\/files\/1\/0449\/2568\/1820\/t\/4\/assets\/booster_currency.js?v=1624978055\u0026shop=jisora-india.myshopify.com","https:\/\/logisy.s3.amazonaws.com\/logisy-theme.js?shop=jisora-india.myshopify.com","https:\/\/cdn.zecpe.com\/payModal\/checkout.js?shop=jisora-india.myshopify.com","https:\/\/cdn.shopify.com\/shopifycloud\/privacy-banner\/storefront-banner.js?shop=jisora-india.myshopify.com"];
        for (var i = 0; i < urls.length; i++) {
          var s = document.createElement('script');
          s.type = 'text/javascript';
          s.async = true;
          s.src = urls[i];
          var x = document.getElementsByTagName('script')[0];
          x.parentNode.insertBefore(s, x);
        }
      };
      if(window.attachEvent) {
        window.attachEvent('onload', asyncLoad);
      } else {
        window.addEventListener('load', asyncLoad, false);
      }
    })();
  </script>
  <script id="__st">
    var __st={"a":52435222686,"offset":19800,"reqid":"f2ade96f-4f01-457b-829d-9e87150ad427","pageurl":"jisora.com\/","u":"7db48ef4f56c","p":"home"};
  </script>
  <script>
    window.ShopifyPaypalV4VisibilityTracking = true;
  </script>
  <script>
    !function(o){o.addEventListener("DOMContentLoaded",function(){window.Shopify=window.Shopify||{},window.Shopify.recaptchaV3=window.Shopify.recaptchaV3||{siteKey:"6LcCR2cUAAAAANS1Gpq_mDIJ2pQuJphsSQaUEuc9"};var t=['form[action*="/contact"] input[name="form_type"][value="contact"]','form[action*="/comments"] input[name="form_type"][value="new_comment"]','form[action*="/account"] input[name="form_type"][value="customer_login"]','form[action*="/account"] input[name="form_type"][value="recover_customer_password"]','form[action*="/account"] input[name="form_type"][value="create_customer"]','form[action*="/contact"] input[name="form_type"][value="customer"]'].join(",");function n(e){e=e.target;null==e||null!=(e=function e(t,n){if(null==t.parentElement)return null;if("FORM"!=t.parentElement.tagName)return e(t.parentElement,n);for(var o=t.parentElement.action,r=0;r<n.length;r++)if(-1!==o.indexOf(n[r]))return t.parentElement;return null}(e,["/contact","/comments","/account"]))&&null!=e.querySelector(t)&&((e=o.createElement("script")).setAttribute("src","https://cdn.shopify.com/shopifycloud/storefront-recaptcha-v3/v0.6/index.js"),o.body.appendChild(e),o.removeEventListener("focus",n,!0),o.removeEventListener("change",n,!0),o.removeEventListener("click",n,!0))}o.addEventListener("click",n,!0),o.addEventListener("change",n,!0),o.addEventListener("focus",n,!0)})}(document);
  </script>
  <script integrity="sha256-h4dvokWvGcvRSqiG7VnGqoonxF0k3NeoHPLSMjUGIz4=" data-source-attribution="shopify.loadfeatures"
    defer="defer"
    src="//jisora.com/cdn/shopifycloud/shopify/assets/storefront/load_feature-87876fa245af19cbd14aa886ed59c6aa8a27c45d24dcd7a81cf2d2323506233e.js"
    crossorigin="anonymous"></script>
  <script data-source-attribution="shopify.dynamic_checkout.dynamic.init">
    var Shopify=Shopify||{};Shopify.PaymentButton=Shopify.PaymentButton||{isStorefrontPortableWallets:!0,init:function t(){window.Shopify.PaymentButton.init=function(){},[["https://jisora.com/cdn/shopifycloud/portable-wallets/latest/portable-wallets.en.iife.js",null,""],["https://jisora.com/cdn/shopifycloud/portable-wallets/latest/portable-wallets.en.js","module",null],].forEach(function(t){var e=document.createElement("script");e.src=t[0],e.type=t[1],e.setAttribute("nomodule",t[2]),document.head.appendChild(e)})}};
  </script>
  <script integrity="sha256-HAs5a9TQVLlKuuHrahvWuke+s1UlxXohfHeoYv8G2D8="
    data-source-attribution="shopify.dynamic-checkout" defer="defer"
    src="//jisora.com/cdn/shopifycloud/shopify/assets/storefront/features-1c0b396bd4d054b94abae1eb6a1bd6ba47beb35525c57a217c77a862ff06d83f.js"
    crossorigin="anonymous"></script>


  <script>
    window.performance && window.performance.mark && window.performance.mark('shopify.content_for_header.end');
  </script>

  <script src="//jisora.com/cdn/shop/t/29/assets/vendor-scripts-v11.js" defer="defer"></script>
  <script src="//jisora.com/cdn/shop/t/29/assets/theme.js?v=19629914627915677641679922258" defer="defer"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://unpkg.com/flickity@2/dist/flickity.min.css">

  <script src="https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js"></script>
  <style type='text/css'>
      .baCountry {
        width: 30px;
        height: 20px;
        display: inline-block;
        vertical-align: middle;
        margin-right: 6px;
        background-size: 30px !important;
        border-radius: 4px;
        background-repeat: no-repeat
      }

      .baCountry-traditional .baCountry {
        background-image: url(https://cdn.shopify.com/s/files/1/0194/1736/6592/t/1/assets/ba-flags.png?=14261939516959647149);
        height: 19px !important
      }

      .baCountry-modern .baCountry {
        background-image: url(https://cdn.shopify.com/s/files/1/0194/1736/6592/t/1/assets/ba-flags.png?=14261939516959647149)
      }

      .baCountry-NO-FLAG {
        background-position: 0 0
      }

      .baCountry-AD {
        background-position: 0 -20px
      }

      .baCountry-AED {
        background-position: 0 -40px
      }

      .baCountry-AFN {
        background-position: 0 -60px
      }

      .baCountry-AG {
        background-position: 0 -80px
      }

      .baCountry-AI {
        background-position: 0 -100px
      }

      .baCountry-ALL {
        background-position: 0 -120px
      }

      .baCountry-AMD {
        background-position: 0 -140px
      }

      .baCountry-AOA {
        background-position: 0 -160px
      }

      .baCountry-ARS {
        background-position: 0 -180px
      }

      .baCountry-AS {
        background-position: 0 -200px
      }

      .baCountry-AT {
        background-position: 0 -220px
      }

      .baCountry-AUD {
        background-position: 0 -240px
      }

      .baCountry-AWG {
        background-position: 0 -260px
      }

      .baCountry-AZN {
        background-position: 0 -280px
      }

      .baCountry-BAM {
        background-position: 0 -300px
      }

      .baCountry-BBD {
        background-position: 0 -320px
      }

      .baCountry-BDT {
        background-position: 0 -340px
      }

      .baCountry-BE {
        background-position: 0 -360px
      }

      .baCountry-BF {
        background-position: 0 -380px
      }

      .baCountry-BGN {
        background-position: 0 -400px
      }

      .baCountry-BHD {
        background-position: 0 -420px
      }

      .baCountry-BIF {
        background-position: 0 -440px
      }

      .baCountry-BJ {
        background-position: 0 -460px
      }

      .baCountry-BMD {
        background-position: 0 -480px
      }

      .baCountry-BND {
        background-position: 0 -500px
      }

      .baCountry-BOB {
        background-position: 0 -520px
      }

      .baCountry-BRL {
        background-position: 0 -540px
      }

      .baCountry-BSD {
        background-position: 0 -560px
      }

      .baCountry-BTN {
        background-position: 0 -580px
      }

      .baCountry-BWP {
        background-position: 0 -600px
      }

      .baCountry-BYN {
        background-position: 0 -620px
      }

      .baCountry-BZD {
        background-position: 0 -640px
      }

      .baCountry-CAD {
        background-position: 0 -660px
      }

      .baCountry-CC {
        background-position: 0 -680px
      }

      .baCountry-CDF {
        background-position: 0 -700px
      }

      .baCountry-CG {
        background-position: 0 -720px
      }

      .baCountry-CHF {
        background-position: 0 -740px
      }

      .baCountry-CI {
        background-position: 0 -760px
      }

      .baCountry-CK {
        background-position: 0 -780px
      }

      .baCountry-CLP {
        background-position: 0 -800px
      }

      .baCountry-CM {
        background-position: 0 -820px
      }

      .baCountry-CNY {
        background-position: 0 -840px
      }

      .baCountry-COP {
        background-position: 0 -860px
      }

      .baCountry-CRC {
        background-position: 0 -880px
      }

      .baCountry-CU {
        background-position: 0 -900px
      }

      .baCountry-CX {
        background-position: 0 -920px
      }

      .baCountry-CY {
        background-position: 0 -940px
      }

      .baCountry-CZK {
        background-position: 0 -960px
      }

      .baCountry-DE {
        background-position: 0 -980px
      }

      .baCountry-DJF {
        background-position: 0 -1000px
      }

      .baCountry-DKK {
        background-position: 0 -1020px
      }

      .baCountry-DM {
        background-position: 0 -1040px
      }

      .baCountry-DOP {
        background-position: 0 -1060px
      }

      .baCountry-DZD {
        background-position: 0 -1080px
      }

      .baCountry-EC {
        background-position: 0 -1100px
      }

      .baCountry-EE {
        background-position: 0 -1120px
      }

      .baCountry-EGP {
        background-position: 0 -1140px
      }

      .baCountry-ER {
        background-position: 0 -1160px
      }

      .baCountry-ES {
        background-position: 0 -1180px
      }

      .baCountry-ETB {
        background-position: 0 -1200px
      }

      .baCountry-EUR {
        background-position: 0 -1220px
      }

      .baCountry-FI {
        background-position: 0 -1240px
      }

      .baCountry-FJD {
        background-position: 0 -1260px
      }

      .baCountry-FKP {
        background-position: 0 -1280px
      }

      .baCountry-FO {
        background-position: 0 -1300px
      }

      .baCountry-FR {
        background-position: 0 -1320px
      }

      .baCountry-GA {
        background-position: 0 -1340px
      }

      .baCountry-GBP {
        background-position: 0 -1360px
      }

      .baCountry-GD {
        background-position: 0 -1380px
      }

      .baCountry-GEL {
        background-position: 0 -1400px
      }

      .baCountry-GHS {
        background-position: 0 -1420px
      }

      .baCountry-GIP {
        background-position: 0 -1440px
      }

      .baCountry-GL {
        background-position: 0 -1460px
      }

      .baCountry-GMD {
        background-position: 0 -1480px
      }

      .baCountry-GNF {
        background-position: 0 -1500px
      }

      .baCountry-GQ {
        background-position: 0 -1520px
      }

      .baCountry-GR {
        background-position: 0 -1540px
      }

      .baCountry-GTQ {
        background-position: 0 -1560px
      }

      .baCountry-GU {
        background-position: 0 -1580px
      }

      .baCountry-GW {
        background-position: 0 -1600px
      }

      .baCountry-HKD {
        background-position: 0 -1620px
      }

      .baCountry-HNL {
        background-position: 0 -1640px
      }

      .baCountry-HRK {
        background-position: 0 -1660px
      }

      .baCountry-HTG {
        background-position: 0 -1680px
      }

      .baCountry-HUF {
        background-position: 0 -1700px
      }

      .baCountry-IDR {
        background-position: 0 -1720px
      }

      .baCountry-IE {
        background-position: 0 -1740px
      }

      .baCountry-ILS {
        background-position: 0 -1760px
      }

      .baCountry-INR {
        background-position: 0 -1780px
      }

      .baCountry-IO {
        background-position: 0 -1800px
      }

      .baCountry-IQD {
        background-position: 0 -1820px
      }

      .baCountry-IRR {
        background-position: 0 -1840px
      }

      .baCountry-ISK {
        background-position: 0 -1860px
      }

      .baCountry-IT {
        background-position: 0 -1880px
      }

      .baCountry-JMD {
        background-position: 0 -1900px
      }

      .baCountry-JOD {
        background-position: 0 -1920px
      }

      .baCountry-JPY {
        background-position: 0 -1940px
      }

      .baCountry-KES {
        background-position: 0 -1960px
      }

      .baCountry-KGS {
        background-position: 0 -1980px
      }

      .baCountry-KHR {
        background-position: 0 -2000px
      }

      .baCountry-KI {
        background-position: 0 -2020px
      }

      .baCountry-KMF {
        background-position: 0 -2040px
      }

      .baCountry-KN {
        background-position: 0 -2060px
      }

      .baCountry-KP {
        background-position: 0 -2080px
      }

      .baCountry-KRW {
        background-position: 0 -2100px
      }

      .baCountry-KWD {
        background-position: 0 -2120px
      }

      .baCountry-KYD {
        background-position: 0 -2140px
      }

      .baCountry-KZT {
        background-position: 0 -2160px
      }

      .baCountry-LBP {
        background-position: 0 -2180px
      }

      .baCountry-LI {
        background-position: 0 -2200px
      }

      .baCountry-LKR {
        background-position: 0 -2220px
      }

      .baCountry-LRD {
        background-position: 0 -2240px
      }

      .baCountry-LSL {
        background-position: 0 -2260px
      }

      .baCountry-LT {
        background-position: 0 -2280px
      }

      .baCountry-LU {
        background-position: 0 -2300px
      }

      .baCountry-LV {
        background-position: 0 -2320px
      }

      .baCountry-LYD {
        background-position: 0 -2340px
      }

      .baCountry-MAD {
        background-position: 0 -2360px
      }

      .baCountry-MC {
        background-position: 0 -2380px
      }

      .baCountry-MDL {
        background-position: 0 -2400px
      }

      .baCountry-ME {
        background-position: 0 -2420px
      }

      .baCountry-MGA {
        background-position: 0 -2440px
      }

      .baCountry-MKD {
        background-position: 0 -2460px
      }

      .baCountry-ML {
        background-position: 0 -2480px
      }

      .baCountry-MMK {
        background-position: 0 -2500px
      }

      .baCountry-MN {
        background-position: 0 -2520px
      }

      .baCountry-MOP {
        background-position: 0 -2540px
      }

      .baCountry-MQ {
        background-position: 0 -2560px
      }

      .baCountry-MR {
        background-position: 0 -2580px
      }

      .baCountry-MS {
        background-position: 0 -2600px
      }

      .baCountry-MT {
        background-position: 0 -2620px
      }

      .baCountry-MUR {
        background-position: 0 -2640px
      }

      .baCountry-MVR {
        background-position: 0 -2660px
      }

      .baCountry-MWK {
        background-position: 0 -2680px
      }

      .baCountry-MXN {
        background-position: 0 -2700px
      }

      .baCountry-MYR {
        background-position: 0 -2720px
      }

      .baCountry-MZN {
        background-position: 0 -2740px
      }

      .baCountry-NAD {
        background-position: 0 -2760px
      }

      .baCountry-NE {
        background-position: 0 -2780px
      }

      .baCountry-NF {
        background-position: 0 -2800px
      }

      .baCountry-NG {
        background-position: 0 -2820px
      }

      .baCountry-NIO {
        background-position: 0 -2840px
      }

      .baCountry-NL {
        background-position: 0 -2860px
      }

      .baCountry-NOK {
        background-position: 0 -2880px
      }

      .baCountry-NPR {
        background-position: 0 -2900px
      }

      .baCountry-NR {
        background-position: 0 -2920px
      }

      .baCountry-NU {
        background-position: 0 -2940px
      }

      .baCountry-NZD {
        background-position: 0 -2960px
      }

      .baCountry-OMR {
        background-position: 0 -2980px
      }

      .baCountry-PAB {
        background-position: 0 -3000px
      }

      .baCountry-PEN {
        background-position: 0 -3020px
      }

      .baCountry-PGK {
        background-position: 0 -3040px
      }

      .baCountry-PHP {
        background-position: 0 -3060px
      }

      .baCountry-PKR {
        background-position: 0 -3080px
      }

      .baCountry-PLN {
        background-position: 0 -3100px
      }

      .baCountry-PR {
        background-position: 0 -3120px
      }

      .baCountry-PS {
        background-position: 0 -3140px
      }

      .baCountry-PT {
        background-position: 0 -3160px
      }

      .baCountry-PW {
        background-position: 0 -3180px
      }

      .baCountry-QAR {
        background-position: 0 -3200px
      }

      .baCountry-RON {
        background-position: 0 -3220px
      }

      .baCountry-RSD {
        background-position: 0 -3240px
      }

      .baCountry-RUB {
        background-position: 0 -3260px
      }

      .baCountry-RWF {
        background-position: 0 -3280px
      }

      .baCountry-SAR {
        background-position: 0 -3300px
      }

      .baCountry-SBD {
        background-position: 0 -3320px
      }

      .baCountry-SCR {
        background-position: 0 -3340px
      }

      .baCountry-SDG {
        background-position: 0 -3360px
      }

      .baCountry-SEK {
        background-position: 0 -3380px
      }

      .baCountry-SGD {
        background-position: 0 -3400px
      }

      .baCountry-SI {
        background-position: 0 -3420px
      }

      .baCountry-SK {
        background-position: 0 -3440px
      }

      .baCountry-SLL {
        background-position: 0 -3460px
      }

      .baCountry-SM {
        background-position: 0 -3480px
      }

      .baCountry-SN {
        background-position: 0 -3500px
      }

      .baCountry-SO {
        background-position: 0 -3520px
      }

      .baCountry-SRD {
        background-position: 0 -3540px
      }

      .baCountry-SSP {
        background-position: 0 -3560px
      }

      .baCountry-STD {
        background-position: 0 -3580px
      }

      .baCountry-SV {
        background-position: 0 -3600px
      }

      .baCountry-SYP {
        background-position: 0 -3620px
      }

      .baCountry-SZL {
        background-position: 0 -3640px
      }

      .baCountry-TC {
        background-position: 0 -3660px
      }

      .baCountry-TD {
        background-position: 0 -3680px
      }

      .baCountry-TG {
        background-position: 0 -3700px
      }

      .baCountry-THB {
        background-position: 0 -3720px
      }

      .baCountry-TJS {
        background-position: 0 -3740px
      }

      .baCountry-TK {
        background-position: 0 -3760px
      }

      .baCountry-TMT {
        background-position: 0 -3780px
      }

      .baCountry-TND {
        background-position: 0 -3800px
      }

      .baCountry-TOP {
        background-position: 0 -3820px
      }

      .baCountry-TRY {
        background-position: 0 -3840px
      }

      .baCountry-TTD {
        background-position: 0 -3860px
      }

      .baCountry-TWD {
        background-position: 0 -3880px
      }

      .baCountry-TZS {
        background-position: 0 -3900px
      }

      .baCountry-UAH {
        background-position: 0 -3920px
      }

      .baCountry-UGX {
        background-position: 0 -3940px
      }

      .baCountry-USD {
        background-position: 0 -3960px
      }

      .baCountry-UYU {
        background-position: 0 -3980px
      }

      .baCountry-UZS {
        background-position: 0 -4000px
      }

      .baCountry-VEF {
        background-position: 0 -4020px
      }

      .baCountry-VG {
        background-position: 0 -4040px
      }

      .baCountry-VI {
        background-position: 0 -4060px
      }

      .baCountry-VND {
        background-position: 0 -4080px
      }

      .baCountry-VUV {
        background-position: 0 -4100px
      }

      .baCountry-WST {
        background-position: 0 -4120px
      }

      .baCountry-XAF {
        background-position: 0 -4140px
      }

      .baCountry-XPF {
        background-position: 0 -4160px
      }

      .baCountry-YER {
        background-position: 0 -4180px
      }

      .baCountry-ZAR {
        background-position: 0 -4200px
      }

      .baCountry-ZM {
        background-position: 0 -4220px
      }

      .baCountry-ZW {
        background-position: 0 -4240px
      }

      .bacurr-checkoutNotice {
        margin: 3px 10px 0 10px;
        left: 0;
        right: 0;
        text-align: center;
      }

      @media (min-width:750px) {
        .bacurr-checkoutNotice {
          position: absolute;
        }
      }
  </style>

  <script>
    window.baCurr = window.baCurr || {};
      window.baCurr.config = {}; window.baCurr.rePeat = function () {};
      Object.assign(window.baCurr.config, {
        "enabled":true,
        "manual_placement":"",
        "night_time":false,
        "round_by_default":true,
        "display_position":"bottom_right",
        "display_position_type":"floating",
        "custom_code":{"css":""},
        "flag_type":"showCurrencyOnly",
        "flag_design":"modern",
        "round_style":"removeDecimal",
        "round_dec":"1",
        "chosen_cur":[{"INR":"Indian Rupee (INR)"},{"USD":"US Dollar (USD)"},{"AED":"United Arab Emirates Dirham (AED)"},{"SGD":"Singapore Dollar (SGD)"},{"EUR":"Euro (EUR)"},{"CAD":"Canadian Dollar (CAD)"},{"AUD":"Australian Dollar (AUD)"},{"IDR":"Indonesian Rupiah (IDR)"},{"JPY":"Japanese Yen (JPY)"},{"KRW":"South Korean Won (KRW)"},{"LKR":"Sri Lankan Rupee (LKR)"},{"MXN":"Mexican Peso (MXN)"},{"NPR":"Nepalese Rupee (NPR)"},{"QAR":"Qatari Rial (QAR)"},{"PKR":"Pakistani Rupee (PKR)"}],
        "desktop_visible":false,
        "mob_visible":false,
        "money_mouse_show":false,
        "textColor":"#1e1e1e",
        "flag_theme":"default",
        "selector_hover_hex":"#7d0101",
        "lightning":true,
        "mob_manual_placement":"",
        "mob_placement":"bottom_right",
        "mob_placement_type":"floating",
        "moneyWithCurrencyFormat":false,
        "ui_style":"default",
        "user_curr":"",
        "auto_loc":true,
        "auto_pref":false,
        "selector_bg_hex":"#ffffff",
        "selector_border_type":"noBorder",
        "cart_alert_bg_hex":"#fbf5f5",
        "cart_alert_note":"All orders are processed in [checkout_currency], using the latest exchange rates.",
        "cart_alert_state":true,
        "cart_alert_font_hex":"#1e1e1e"
      },{

      });
      window.baCurr.config.multi_curr = [];
      
      window.baCurr.config.final_currency = "INR" || '';
      window.baCurr.config.multi_curr = "INR".split(',') || '';

      (function(window, document) {"use strict";
        function onload(){
          function insertPopupMessageJs(){
            var head = document.getElementsByTagName('head')[0];
            var script = document.createElement('script');
            script.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'currency.boosterapps.com/preview_curr.js';
            script.type = 'text/javascript';
            head.appendChild(script);
          }

          if(document.location.search.indexOf("preview_cur=1") > -1){
            setTimeout(function(){
              window.currency_preview_result = document.getElementById("baCurrSelector").length > 0 ? 'success' : 'error';
              insertPopupMessageJs();
            }, 1000);
          }
        }

        var head = document.getElementsByTagName('head')[0];
        var script = document.createElement('script');
        script.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + "";
        script.type = 'text/javascript';
        script.onload = script.onreadystatechange = function() {
        if (script.readyState) {
          if (script.readyState === 'complete' || script.readyState === 'loaded') {
            script.onreadystatechange = null;
              onload();
            }
          }
          else {
            onload();
          }
        };
        head.appendChild(script);

      }(window, document));
  </script>


  <!-- Era of Ecom Engine Hook start -->
  <link rel="dns-prefetch" href="//winads.eraofecom.org">





  <!-- Era of Ecom Engine Hook end -->




  <script>
    (() => {const installerKey = 'docapp-free-gift-auto-install'; const urlParams = new URLSearchParams(window.location.search); if (urlParams.get(installerKey)) {window.sessionStorage.setItem(installerKey, JSON.stringify({integrationId: urlParams.get('docapp-integration-id'), divClass: urlParams.get('docapp-install-class'), check: urlParams.get('docapp-check')}));}})();
  </script>

  <script>
    (() => {const previewKey = 'docapp-free-gift-test'; const urlParams = new URLSearchParams(window.location.search); if (urlParams.get(previewKey)) {window.sessionStorage.setItem(previewKey, JSON.stringify({active: true, integrationId: urlParams.get('docapp-free-gift-inst-test')}));}})();
  </script>
  
  <link href="//jisora.com/cdn/shop/t/29/assets/smk-sections.css?v=147244019065819453361679922258" rel="stylesheet"
    type="text/css" media="all" />

  <script src="//jisora.com/cdn/shop/t/29/assets/bss-file-configdata.js?v=19453381437224918031679922258"
    type="text/javascript"></script>
  <script>
    if (typeof BSS_PL == 'undefined') {
                  var BSS_PL = {};
              }
              
              var bssPlApiServer = "https://product-labels-pro.bsscommerce.com";
              BSS_PL.customerTags = 'null';
              BSS_PL.configData = configDatas;
              BSS_PL.storeId = 27777;
              BSS_PL.currentPlan = "false";
              BSS_PL.storeIdCustomOld = "10678";
              BSS_PL.storeIdOldWIthPriority = "12200";
              BSS_PL.apiServerProduction = "https://product-labels-pro.bsscommerce.com";
              
  </script>
  <style>
    .homepage-slideshow .slick-slide .bss_pl_img {
      visibility: hidden !important;
    }
  </style>
  <script>
    function fixBugForStores($, BSS_PL, parent, page, htmlLabel) { return false;}
  </script>



  <!-- BEGIN app block: shopify://apps/back-in-stock-restock-alerts/blocks/app-embed/8b875ab4-abf0-4c7c-b35c-43d33469852d -->
  <!-- BEGIN app snippet: hulkapps-restock-theme-ext -->
  <script type="text/javascript">
    if (typeof window.restockext_config != "object") {
        window.restockext_config = {}
      }
      
      
      window.restockext = {
        shop_slug: "jisora-india",
        store_id: "jisora-india.myshopify.com",
        
        customer: null,
        cart: null,
      }

      

      

      
        
      

      
        window.restockext.cart = {"note":null,"attributes":{},"original_total_price":0,"total_price":0,"total_discount":0,"total_weight":0.0,"item_count":0,"items":[],"requires_shipping":false,"currency":"INR","items_subtotal_price":0,"cart_level_discount_applications":[]}
        delete window.restockext.cart.note
        window.restockext.cart_collections = {}
        
      if (typeof window.restockext.cart.items == "object") {
          for (var i=0; i<window.restockext.cart.items.length; i++) {
              ["sku", "grams", "vendor", "url", "image", "handle", "requires_shipping", "product_type", "product_description"].map(function(a) {
                  delete window.restockext.cart.items[i][a]
              })
          }
        }
      
      window.restockext.page_type = ""
      window.restockext.partner_url = "https://restock-master.hulkapps.com";
  </script>
  <!-- END app snippet -->
  <!-- END app app block -->
  <!-- BEGIN app block: shopify://apps/whatmore-live/blocks/app-embed/20db8a72-315a-4364-8885-64219ee48303 -->

  <div class="whatmore-base">
    <div id="whatmoreShopId" data="52435222686"> </div>
    <div id="whatmoreProductId" data=""> </div>
    <div id="whatmoreExtensionType" data="index"> </div>
    <div class="whatmore-template-type" data="template-embed"> </div>
    <div id="whatmoreVariantId" data=""> </div>
    <div id="whatmoreSecondaryColor" data="#750902"> </div>
    <div id="whatmoreEmbedAppPositionPortrait" data="right"> </div>
    <div id="whatmoreEmbedAppHorizontalPaddingPortrait" data="15"> </div>
    <div id="whatmoreEmbedAppVerticalPaddingPortrait" data="170"> </div>
    <div id="whatmoreEmbedAppVideoPlayerSizePortrait" data="45"> </div>
    <div id="whatmoreEmbedAppPositionLandscape" data="right"> </div>
    <div id="whatmoreEmbedAppHorizontalPaddingLandscape" data="15"> </div>
    <div id="whatmoreEmbedAppVerticalPaddingLandscape" data="148"> </div>
    <div id="whatmoreEmbedAppVideoPlayerSizeLandscape" data="50"> </div>
    <div id="whatmoreEmbedAppUseVariant" data="false"> </div>

    <style data-shopify>
      @font-face {
        font-family: whatmorePrimaryFontFamily;
        font-weight: 400;
        font-style: normal;
        src: url("//jisora.com/cdn/fonts/avenir_next/avenirnext_n4.7fd0287595be20cd5a683102bf49d073b6abf144.woff2?h1=amlzb3JhLmNvbQ&h2=amlzb3JhLmlu&h3=amlzb3JhZ2xvYmFsLmNvbQ&h4=amlzb3JhLWluZGlhLmFjY291bnQubXlzaG9waWZ5LmNvbQ&h5=amlzb3JhLm5ldA&h6=amlzb3JhLmNvLmlu&h7=amlzb3JhLm9yZw&h8=amlzb3JhamFpcHVyLmlu&h9=amlzb3JhamFpcHVyLmNvbQ&hmac=e21d093732075835a1cf68e7c36f5a299c9eca653361d806593feb2a13442307") format("woff2"),
          url("//jisora.com/cdn/fonts/avenir_next/avenirnext_n4.a26a334a0852627a5f36b195112385b0cd700077.woff?h1=amlzb3JhLmNvbQ&h2=amlzb3JhLmlu&h3=amlzb3JhZ2xvYmFsLmNvbQ&h4=amlzb3JhLWluZGlhLmFjY291bnQubXlzaG9waWZ5LmNvbQ&h5=amlzb3JhLm5ldA&h6=amlzb3JhLmNvLmlu&h7=amlzb3JhLm9yZw&h8=amlzb3JhamFpcHVyLmlu&h9=amlzb3JhamFpcHVyLmNvbQ&hmac=d6e56143d9459a0e2a2a96f84b58865e2e725f3994d0445139f7f91661b689d3") format("woff");
      }
    </style>

    <div id="whatmorePrimaryFont" data="whatmorePrimaryFontFamily"> </div>
    <div id="whatmoreEmbedAppVideoTitle" data=""> </div>
    <div id="whatmoreIsInDesignMode" data='false'> </div>

    <div id="whatmoreUITheme" data="round"> </div>
    <div class="whatmore-render-root"> </div>

  </div>
  <!-- END app app block -->
  <!-- BEGIN app block: shopify://apps/frequently-bought-together/blocks/app-embed-block/b1a8cbea-c844-4842-9529-7c62dbab1b1f -->
  <script src="//cdn.codeblackbelt.com/scripts/frequently-bought-together/bootstrap.min.js?version=2023111315+0530"
    async></script>
  <!-- END app app block -->
  <script
    src="https://cdn.shopify.com/extensions/4f59b47e-41a6-49f7-9d13-bc1cef45d13d/2.9.0/assets/mha-rn-popup-theme-ext.js"
    type="text/javascript" defer="defer"></script>
  <link
    href="https://cdn.shopify.com/extensions/4f59b47e-41a6-49f7-9d13-bc1cef45d13d/2.9.0/assets/restock-master-theme-ext.css"
    rel="stylesheet" type="text/css" media="all">
  <script
    src="https://cdn.shopify.com/extensions/d0ecccad-7c62-4655-900f-ef8af7a544b5/whatmore-shoppable-videos-62/assets/whatmore.js"
    type="text/javascript" defer="defer"></script>
  <link
    href="https://cdn.shopify.com/extensions/d0ecccad-7c62-4655-900f-ef8af7a544b5/whatmore-shoppable-videos-62/assets/whatmore.css"
    rel="stylesheet" type="text/css" media="all">
  <script
    src="https://cdn.shopify.com/extensions/3203dc9d-c13e-4e24-b56d-389ff954922a/pify-form-builder-contact-form-15/assets/popup.js"
    type="text/javascript" defer="defer"></script>
  <script
    src="https://cdn.shopify.com/extensions/297ea48f-d444-4177-8225-5789f2d55fb4/attrac-2/assets/attrac-embed-bars.js"
    type="text/javascript" defer="defer"></script>
  <link href="https://monorail-edge.shopifysvc.com" rel="dns-prefetch">
  <script>
    (function(){if ("sendBeacon" in navigator && "performance" in window) {var session_token = document.cookie.match(/_shopify_s=([^;]*)/);function handle_abandonment_event(e) {var entries = performance.getEntries().filter(function(entry) {return /monorail-edge.shopifysvc.com/.test(entry.name);});if (!window.abandonment_tracked && entries.length === 0) {window.abandonment_tracked = true;var currentMs = Date.now();var navigation_start = performance.timing.navigationStart;var payload = {shop_id: 52435222686,url: window.location.href,navigation_start,duration: currentMs - navigation_start,session_token: session_token && session_token.length === 2 ? session_token[1] : "",page_type: "index"};window.navigator.sendBeacon("https://monorail-edge.shopifysvc.com/v1/produce", JSON.stringify({schema_id: "online_store_buyer_site_abandonment/1.1",payload: payload,metadata: {event_created_at_ms: currentMs,event_sent_at_ms: currentMs}}));}}window.addEventListener('pagehide', handle_abandonment_event);}}());
  </script>
  <script id="web-pixels-manager-setup">
    (function e(e,n,a,t,o,r,i){var s=null!==e,l=("function"==typeof BigInt&&BigInt.toString().indexOf("[native code]")?"modern":"legacy").substring(0,1),c=t.substring(0,1);if(s){window.Shopify=window.Shopify||{};var d=window.Shopify;d.analytics=d.analytics||{};var u=d.analytics;u.replayQueue=[],u.publish=function(e,n,a){u.replayQueue.push([e,n,a])};try{self.performance.mark("wpm:start")}catch(e){}}var p,f,y,h,v,m,w,g,b,_=[a,"/wpm","/",c,r,l,".js"].join("");f=(p={src:_,async:!0,onload:function(){if(e){var a=window.webPixelsManager.init(e);null==n||n(a);var t=window.Shopify.analytics;t.replayQueue.forEach((function(e){var n=e[0],t=e[1],o=e[2];a.publishCustomEvent(n,t,o)})),t.replayQueue=[],t.publish=a.publishCustomEvent,t.visitor=a.visitor}},onerror:function(){var n=(null==e?void 0:e.storefrontBaseUrl)?e.storefrontBaseUrl.replace(/\/$/,""):self.location.origin,a="".concat(n,"/.well-known/shopify/monorail/unstable/produce_batch"),t=JSON.stringify({metadata:{event_sent_at_ms:(new Date).getTime()},events:[{schema_id:"web_pixels_manager_load/2.0",payload:{version:o||"latest",page_url:self.location.href,status:"failed",error_msg:"".concat(_," has failed to load")},metadata:{event_created_at_ms:(new Date).getTime()}}]});try{if(self.navigator.sendBeacon.bind(self.navigator)(a,t))return!0}catch(e){}var r=new XMLHttpRequest;try{return r.open("POST",a,!0),r.setRequestHeader("Content-Type","text/plain"),r.send(t),!0}catch(e){console&&console.warn&&console.warn("[Web Pixels Manager] Got an unhandled error while logging a load error.")}return!1}}).src,y=p.async,h=void 0===y||y,v=p.onload,m=p.onerror,w=document.createElement("script"),g=document.head,b=document.body,w.async=h,w.src=f,v&&w.addEventListener("load",v),m&&w.addEventListener("error",m),g?g.appendChild(w):b?b.appendChild(w):console.error("Did not find a head or body element to append the script")})({shopId: 52435222686,storefrontBaseUrl: "https://jisora.com",cdnBaseUrl: "https://jisora.com/cdn",surface: "storefront-renderer",enabledBetaFlags: ["web_pixels_async_pixel_refactor","web_pixels_visitor_api","web_pixels_manager_performance_improvement"],webPixelsConfigList: [{"id":"7766241","configuration":"{\"pixelId\":\"ba34b297-9ff9-457b-a466-1c10e853640a\"}","eventPayloadVersion":"v1","runtimeContext":"STRICT","scriptVersion":"bb41bf091d86ec09beb5141ead6fafc0","type":"APP","apiClientId":2556259},{"id":"shopify-app-pixel","configuration":"{}","eventPayloadVersion":"v1","runtimeContext":"STRICT","scriptVersion":"0570","apiClientId":"shopify-pixel","type":"APP"},{"id":"shopify-custom-pixel","eventPayloadVersion":"v1","runtimeContext":"LAX","scriptVersion":"0570","apiClientId":"shopify-pixel","type":"CUSTOM"}],initData: {"cart":null,"checkout":null,"customer":null,"productVariants":[]},},function pageEvents(webPixelsManagerAPI) {webPixelsManagerAPI.publish("page_viewed");},"https://jisora.com/cdn","browser","0.0.403","aa73dfb0w354a5a7epc16508fdma002f749",["web_pixels_async_pixel_refactor","web_pixels_visitor_api","web_pixels_manager_performance_improvement"]);
  </script>
  <script>
    window.ShopifyAnalytics = window.ShopifyAnalytics || {};
    window.ShopifyAnalytics.meta = window.ShopifyAnalytics.meta || {};
    window.ShopifyAnalytics.meta.currency = 'INR';
    var meta = {"page":{"pageType":"home"}};
    for (var attr in meta) {
      window.ShopifyAnalytics.meta[attr] = meta[attr];
    }
  </script>
  <script>
    window.ShopifyAnalytics.merchantGoogleAnalytics = function() {
      
    };
  </script>
  <script class="analytics">
        (window.gaDevIds=window.gaDevIds||[]).push('BwiEti');


    (function () {
        var customDocumentWrite = function(content) {
          var jquery = null;

          if (window.jQuery) {
            jquery = window.jQuery;
          } else if (window.Checkout && window.Checkout.$) {
            jquery = window.Checkout.$;
          }

          if (jquery) {
            jquery('body').append(content);
          }
        };

        var hasLoggedConversion = function(token) {
          if (token) {
            return document.cookie.indexOf('loggedConversion=' + token) !== -1;
          }
          return false;
        }

        var setCookieIfConversion = function(token) {
          if (token) {
            var twoMonthsFromNow = new Date(Date.now());
            twoMonthsFromNow.setMonth(twoMonthsFromNow.getMonth() + 2);

            document.cookie = 'loggedConversion=' + token + '; expires=' + twoMonthsFromNow;
          }
        }

        var trekkie = window.ShopifyAnalytics.lib = window.trekkie = window.trekkie || [];
        if (trekkie.integrations) {
          return;
        }
        trekkie.methods = [
          'identify',
          'page',
          'ready',
          'track',
          'trackForm',
          'trackLink'
        ];
        trekkie.factory = function(method) {
          return function() {
            var args = Array.prototype.slice.call(arguments);
            args.unshift(method);
            trekkie.push(args);
            return trekkie;
          };
        };
        for (var i = 0; i < trekkie.methods.length; i++) {
          var key = trekkie.methods[i];
          trekkie[key] = trekkie.factory(key);
        }
        trekkie.load = function(config) {
          trekkie.config = config || {};
          trekkie.config.initialDocumentCookie = document.cookie;
          var first = document.getElementsByTagName('script')[0];
          var script = document.createElement('script');
          script.type = 'text/javascript';
          script.onerror = function(e) {
            var scriptFallback = document.createElement('script');
            scriptFallback.type = 'text/javascript';
            scriptFallback.onerror = function(error) {
                    var Monorail = {
          produce: function produce(monorailDomain, schemaId, payload) {
            var currentMs = new Date().getTime();
            var event = {
              schema_id: schemaId,
              payload: payload,
              metadata: {
                event_created_at_ms: currentMs,
                event_sent_at_ms: currentMs
              }
            };
            return Monorail.sendRequest("https://" + monorailDomain + "/v1/produce", JSON.stringify(event));
          },
          sendRequest: function sendRequest(endpointUrl, payload) {
            // Try the sendBeacon API
            if (window && window.navigator && typeof window.navigator.sendBeacon === 'function' && typeof window.Blob === 'function' && !Monorail.isIos12()) {
              var blobData = new window.Blob([payload], {
                type: 'text/plain'
              });

              if (window.navigator.sendBeacon(endpointUrl, blobData)) {
                return true;
              } // sendBeacon was not successful

            } // XHR beacon

            var xhr = new XMLHttpRequest();

            try {
              xhr.open('POST', endpointUrl);
              xhr.setRequestHeader('Content-Type', 'text/plain');
              xhr.send(payload);
            } catch (e) {
              console.log(e);
            }

            return false;
          },
          isIos12: function isIos12() {
            return window.navigator.userAgent.lastIndexOf('iPhone; CPU iPhone OS 12_') !== -1 || window.navigator.userAgent.lastIndexOf('iPad; CPU OS 12_') !== -1;
          }
        };
        Monorail.produce('monorail-edge.shopifysvc.com',
          'trekkie_storefront_load_errors/1.1',
          {shop_id: 52435222686,
          theme_id: 136894873825,
          app_name: "storefront",
          context_url: window.location.href,
          source_url: "//jisora.com/cdn/s/trekkie.storefront.f33399a7b9d8c1007209860fbdd63bb24633ae9f.min.js"});

            };
            scriptFallback.async = true;
            scriptFallback.src = '//jisora.com/cdn/s/trekkie.storefront.f33399a7b9d8c1007209860fbdd63bb24633ae9f.min.js';
            first.parentNode.insertBefore(scriptFallback, first);
          };
          script.async = true;
          script.src = '//jisora.com/cdn/s/trekkie.storefront.f33399a7b9d8c1007209860fbdd63bb24633ae9f.min.js';
          first.parentNode.insertBefore(script, first);
        };
        trekkie.load(
          {"Trekkie":{"appName":"storefront","development":false,"defaultAttributes":{"shopId":52435222686,"isMerchantRequest":null,"themeId":136894873825,"themeCityHash":"9946520566861944121","contentLanguage":"en","currency":"INR"},"isServerSideCookieWritingEnabled":true,"monorailRegion":"shop_domain"},"Google Analytics":{"trackingId":"UA-201300722-1","domain":"auto","siteSpeedSampleRate":"10","enhancedEcommerce":true,"doubleClick":true,"includeSearch":true},"Facebook Pixel":{"pixelIds":["776372463251070"],"agent":"plshopify1.2"},"Google Gtag Pixel":{"conversionId":"AW-340852420","eventLabels":[{"type":"search","action_label":"AW-340852420\/9zNGCJqJxM8CEMT9w6IB"},{"type":"begin_checkout","action_label":"AW-340852420\/3SZtCJeJxM8CEMT9w6IB"},{"type":"view_item","action_label":["AW-340852420\/jV8UCJGJxM8CEMT9w6IB","MC-S10PW681BK"]},{"type":"purchase","action_label":["AW-340852420\/JpxzCI6JxM8CEMT9w6IB","MC-S10PW681BK"]},{"type":"page_view","action_label":["AW-340852420\/Z7BlCIuJxM8CEMT9w6IB","MC-S10PW681BK"]},{"type":"add_payment_info","action_label":"AW-340852420\/dmLbCJ2JxM8CEMT9w6IB"},{"type":"add_to_cart","action_label":"AW-340852420\/NwHqCInvvI8YEMT9w6IB"}],"targetCountry":"IN"},"Session Attribution":{},"S2S":{"facebookCapiEnabled":true,"facebookAppPixelId":"776372463251070","source":"trekkie-storefront-renderer"}}
        );

        var loaded = false;
        trekkie.ready(function() {
          if (loaded) return;
          loaded = true;

          window.ShopifyAnalytics.lib = window.trekkie;

            ga('require', 'linker');
          function addListener(element, type, callback) {
            if (element.addEventListener) {
              element.addEventListener(type, callback);
            }
            else if (element.attachEvent) {
              element.attachEvent('on' + type, callback);
            }
          }
          function decorate(event) {
            event = event || window.event;
            var target = event.target || event.srcElement;
            if (target && (target.getAttribute('action') || target.getAttribute('href'))) {
              ga(function (tracker) {
                var linkerParam = tracker.get('linkerParam');
                document.cookie = '_shopify_ga=' + linkerParam + '; ' + 'path=/';
              });
            }
          }
          addListener(window, 'load', function(){
            for (var i=0; i < document.forms.length; i++) {
              var action = document.forms[i].getAttribute('action');
              if(action && action.indexOf('/cart') >= 0) {
                addListener(document.forms[i], 'submit', decorate);
              }
            }
            for (var i=0; i < document.links.length; i++) {
              var href = document.links[i].getAttribute('href');
              if(href && href.indexOf('/checkout') >= 0) {
                addListener(document.links[i], 'click', decorate);
              }
            }
          });
        

          var originalDocumentWrite = document.write;
          document.write = customDocumentWrite;
          try { window.ShopifyAnalytics.merchantGoogleAnalytics.call(this); } catch(error) {};
          document.write = originalDocumentWrite;

          window.ShopifyAnalytics.lib.page(null,{"pageType":"home"});

          var match = window.location.pathname.match(/checkouts\/(.+)\/(thank_you|post_purchase)/)
          var token = match? match[1]: undefined;
          if (!hasLoggedConversion(token)) {
            setCookieIfConversion(token);
            
          }
        });


            var eventsListenerScript = document.createElement('script');
            eventsListenerScript.async = true;
            eventsListenerScript.src = "//jisora.com/cdn/shopifycloud/shopify/assets/shop_events_listener-a7c63dba65ccddc484f77541dc8ca437e60e1e9e297fe1c3faebf6523a0ede9b.js";
            document.getElementsByTagName('head')[0].appendChild(eventsListenerScript);

    })();
  </script>
  <script class="boomerang">
        (function () {
      if (window.BOOMR && (window.BOOMR.version || window.BOOMR.snippetExecuted)) {
        return;
      }
      window.BOOMR = window.BOOMR || {};
      window.BOOMR.snippetStart = new Date().getTime();
      window.BOOMR.snippetExecuted = true;
      window.BOOMR.snippetVersion = 12;
      window.BOOMR.application = "storefront-renderer";
      window.BOOMR.themeName = "Impulse";
      window.BOOMR.themeVersion = "5.5.0";
      window.BOOMR.shopId = 52435222686;
      window.BOOMR.themeId = 136894873825;
      window.BOOMR.renderRegion = "gcp-europe-west1";
      window.BOOMR.url =
        "https://jisora.com/cdn/shopifycloud/boomerang/shopify-boomerang-1.0.0.min.js";
      var where = document.currentScript || document.getElementsByTagName("script")[0];
      var parentNode = where.parentNode;
      var promoted = false;
      var LOADER_TIMEOUT = 3000;
      function promote() {
        if (promoted) {
          return;
        }
        var script = document.createElement("script");
        script.id = "boomr-scr-as";
        script.src = window.BOOMR.url;
        script.async = true;
        parentNode.appendChild(script);
        promoted = true;
      }
      function iframeLoader(wasFallback) {
        promoted = true;
        var dom, bootstrap, iframe, iframeStyle;
        var doc = document;
        var win = window;
        window.BOOMR.snippetMethod = wasFallback ? "if" : "i";
        bootstrap = function(parent, scriptId) {
          var script = doc.createElement("script");
          script.id = scriptId || "boomr-if-as";
          script.src = window.BOOMR.url;
          BOOMR_lstart = new Date().getTime();
          parent = parent || doc.body;
          parent.appendChild(script);
        };
        if (!window.addEventListener && window.attachEvent && navigator.userAgent.match(/MSIE [67]./)) {
          window.BOOMR.snippetMethod = "s";
          bootstrap(parentNode, "boomr-async");
          return;
        }
        iframe = document.createElement("IFRAME");
        iframe.src = "about:blank";
        iframe.title = "";
        iframe.role = "presentation";
        iframe.loading = "eager";
        iframeStyle = (iframe.frameElement || iframe).style;
        iframeStyle.width = 0;
        iframeStyle.height = 0;
        iframeStyle.border = 0;
        iframeStyle.display = "none";
        parentNode.appendChild(iframe);
        try {
          win = iframe.contentWindow;
          doc = win.document.open();
        } catch (e) {
          dom = document.domain;
          iframe.src = "javascript:var d=document.open();d.domain='" + dom + "';void(0);";
          win = iframe.contentWindow;
          doc = win.document.open();
        }
        if (dom) {
          doc._boomrl = function() {
            this.domain = dom;
            bootstrap();
          };
          doc.write("<body onload='document._boomrl();'>");
        } else {
          win._boomrl = function() {
            bootstrap();
          };
          if (win.addEventListener) {
            win.addEventListener("load", win._boomrl, false);
          } else if (win.attachEvent) {
            win.attachEvent("onload", win._boomrl);
          }
        }
        doc.close();
      }
      var link = document.createElement("link");
      if (link.relList &&
        typeof link.relList.supports === "function" &&
        link.relList.supports("preload") &&
        ("as" in link)) {
        window.BOOMR.snippetMethod = "p";
        link.href = window.BOOMR.url;
        link.rel = "preload";
        link.as = "script";
        link.addEventListener("load", promote);
        link.addEventListener("error", function() {
          iframeLoader(true);
        });
        setTimeout(function() {
          if (!promoted) {
            iframeLoader(true);
          }
        }, LOADER_TIMEOUT);
        BOOMR_lstart = new Date().getTime();
        parentNode.appendChild(link);
      } else {
        iframeLoader(false);
      }
      function boomerangSaveLoadTime(e) {
        window.BOOMR_onload = (e && e.timeStamp) || new Date().getTime();
      }
      if (window.addEventListener) {
        window.addEventListener("load", boomerangSaveLoadTime, false);
      } else if (window.attachEvent) {
        window.attachEvent("onload", boomerangSaveLoadTime);
      }
      if (document.addEventListener) {
        document.addEventListener("onBoomerangLoaded", function(e) {
          e.detail.BOOMR.init({
            ResourceTiming: {
              enabled: true,
              trackedResourceTypes: ["script", "img", "css"]
            },
          });
          e.detail.BOOMR.t_end = new Date().getTime();
        });
      } else if (document.attachEvent) {
        document.attachEvent("onpropertychange", function(e) {
          if (!e) e=event;
          if (e.propertyName === "onBoomerangLoaded") {
            e.detail.BOOMR.init({
              ResourceTiming: {
                enabled: true,
                trackedResourceTypes: ["script", "img", "css"]
              },
            });
            e.detail.BOOMR.t_end = new Date().getTime();
          }
        });
      }
    })();
  </script>
</head>



<body class="template-index" data-center-text="true" data-button_style="square" data-type_header_capitalize="true"
  data-type_headers_align_text="true" data-type_product_capitalize="true" data-swatch_style="round"
  data-disable-animations="true">

  <a class="in-page-link visually-hidden skip-link" href="#MainContent">Skip to content</a>
  
  
  @include('layouts.front-end.partials._header')


  <div id="PageContainer" class="page-container">
    <div class="transition-body">



        @yield('content')



        @include('layouts.front-end.partials._footer')

    </div>
  </div>
  <div id="shopify-section-newsletter-popup" class="shopify-section index-section--hidden">
  </div>
  <div id="VideoModal" class="modal modal--solid">
    <div class="modal__inner">
      <div class="modal__centered page-width text-center">
        <div class="modal__centered-content">
          <div class="video-wrapper video-wrapper--modal">
            <div id="VideoHolder"></div>
          </div>
        </div>
      </div>
    </div>

    <button type="button" class="modal__close js-modal-close text-link">
      <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-close" viewBox="0 0 64 64">
        <path d="M19 17.61l27.12 27.13m0-27.12L19 44.74" />
      </svg>
      <span class="icon__fallback-text">"Close (esc)"</span>
    </button>
  </div>
  <div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="pswp__bg"></div>
    <div class="pswp__scroll-wrap">
      <div class="pswp__container">
        <div class="pswp__item"></div>
        <div class="pswp__item"></div>
        <div class="pswp__item"></div>
      </div>

      <div class="pswp__ui pswp__ui--hidden">
        <button class="btn btn--body btn--circle pswp__button pswp__button--arrow--left" title="Previous">
          <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-chevron-left"
            viewBox="0 0 284.49 498.98">
            <path
              d="M249.49 0a35 35 0 0 1 24.75 59.75L84.49 249.49l189.75 189.74a35.002 35.002 0 1 1-49.5 49.5L10.25 274.24a35 35 0 0 1 0-49.5L224.74 10.25A34.89 34.89 0 0 1 249.49 0z" />
          </svg>
        </button>

        <button class="btn btn--body btn--circle btn--large pswp__button pswp__button--close" title="Close (esc)">
          <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-close" viewBox="0 0 64 64">
            <path d="M19 17.61l27.12 27.13m0-27.12L19 44.74" />
          </svg>
        </button>

        <button class="btn btn--body btn--circle pswp__button pswp__button--arrow--right" title="Next">
          <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-chevron-right"
            viewBox="0 0 284.49 498.98">
            <path
              d="M35 498.98a35 35 0 0 1-24.75-59.75l189.74-189.74L10.25 59.75a35.002 35.002 0 0 1 49.5-49.5l214.49 214.49a35 35 0 0 1 0 49.5L59.75 488.73A34.89 34.89 0 0 1 35 498.98z" />
          </svg>
        </button>
      </div>
    </div>
  </div>
  <tool-tip data-tool-tip="">
    <div class="tool-tip__inner" data-tool-tip-inner>
      <button class="tool-tip__close" data-tool-tip-close=""><svg aria-hidden="true" focusable="false"
          role="presentation" class="icon icon-close" viewBox="0 0 64 64">
          <path d="M19 17.61l27.12 27.13m0-27.12L19 44.74" />
        </svg></button>
      <div class="tool-tip__content" data-tool-tip-content>
      </div>
    </div>
  </tool-tip>
  <!-- Avada Size Chart Script -->

  <script src="//jisora.com/cdn/shop/t/29/assets/size-chart-data.js?v=78150491546977935781679922258" defer='defer'>
  </script>









  <script>
      const AVADA_SC = {};
    AVADA_SC.product = null;
    AVADA_SC.template = "index";
    AVADA_SC.collections = [];
    AVADA_SC.collectionsName = [];
    
    AVADA_SC.branding = false
  </script>

  <!-- /Avada Size Chart Script -->

  <script type="text/javascript">
          if (typeof window.restock_config != "object") {
              window.restock_config = {}
            }
            
            
            window.restock = {
              shop_slug: "jisora-india",
              store_id: "jisora-india.myshopify.com",
            
              customer: null,
              cart: null,
            }

            

            

            
              
            

            
              window.restock.cart = {"note":null,"attributes":{},"original_total_price":0,"total_price":0,"total_discount":0,"total_weight":0.0,"item_count":0,"items":[],"requires_shipping":false,"currency":"INR","items_subtotal_price":0,"cart_level_discount_applications":[]}
              delete window.restock.cart.note
              window.restock.cart_collections = {}
              
            if (typeof window.restock.cart.items == "object") {
                for (var i=0; i<window.restock.cart.items.length; i++) {
                    ["sku", "grams", "vendor", "url", "image", "handle", "requires_shipping", "product_type", "product_description"].map(function(a) {
                        delete window.restock.cart.items[i][a]
                    })
                }
              }
            
            window.restock.page_type = ""
            window.restock.partner_url = "https://restock-master.hulkapps.com";
        </script>
        <link rel="stylesheet" type="text/css" href="https://restock-master.hulkapps.com/assets/restock-master.css">

        <script type="text/javascript">
          if(true === true){
          loaderMode = 1;
      loadMoreBtnText = 'Load More';


      oncegoI = false;
      specialTheme = 0;

      cleverLastUrl = '';

      XMLHttpRequest.prototype.cleverOpen = XMLHttpRequest.prototype.open;
      XMLHttpRequest.prototype.cleverSend = XMLHttpRequest.prototype.send;

      !function(e,t){"use strict";"object"==typeof module&&"object"==typeof module.exports?module.exports=e.document?t(e,!0):function(e){if(!e.document)throw new Error("jQuery requires a window with a document");return t(e)}:t(e)}("undefined"!=typeof window?window:this,function(C,e){"use strict";var t=[],r=Object.getPrototypeOf,s=t.slice,g=t.flat?function(e){return t.flat.call(e)}:function(e){return t.concat.apply([],e)},u=t.push,i=t.indexOf,n={},o=n.toString,v=n.hasOwnProperty,a=v.toString,l=a.call(Object),y={},m=function(e){return"function"==typeof e&&"number"!=typeof e.nodeType&&"function"!=typeof e.item},x=function(e){return null!=e&&e===e.window},E=C.document,c={type:!0,src:!0,nonce:!0,noModule:!0};function b(e,t,n){var r,i,o=(n=n||E).createElement("script");if(o.text=e,t)for(r in c)(i=t[r]||t.getAttribute&&t.getAttribute(r))&&o.setAttribute(r,i);n.head.appendChild(o).parentNode.removeChild(o)}function w(e){return null==e?e+"":"object"==typeof e||"function"==typeof e?n[o.call(e)]||"object":typeof e}var f="3.6.0",S=function(e,t){return new S.fn.init(e,t)};function p(e){var t=!!e&&"length"in e&&e.length,n=w(e);return!m(e)&&!x(e)&&("array"===n||0===t||"number"==typeof t&&0<t&&t-1 in e)}S.fn=S.prototype={jquery:f,constructor:S,length:0,toArray:function(){return s.call(this)},get:function(e){return null==e?s.call(this):e<0?this[e+this.length]:this[e]},pushStack:function(e){var t=S.merge(this.constructor(),e);return t.prevObject=this,t},each:function(e){return S.each(this,e)},map:function(n){return this.pushStack(S.map(this,function(e,t){return n.call(e,t,e)}))},slice:function(){return this.pushStack(s.apply(this,arguments))},first:function(){return this.eq(0)},last:function(){return this.eq(-1)},even:function(){return this.pushStack(S.grep(this,function(e,t){return(t+1)%2}))},odd:function(){return this.pushStack(S.grep(this,function(e,t){return t%2}))},eq:function(e){var t=this.length,n=+e+(e<0?t:0);return this.pushStack(0<=n&&n<t?[this[n]]:[])},end:function(){return this.prevObject||this.constructor()},push:u,sort:t.sort,splice:t.splice},S.extend=S.fn.extend=function(){var e,t,n,r,i,o,a=arguments[0]||{},s=1,u=arguments.length,l=!1;for("boolean"==typeof a&&(l=a,a=arguments[s]||{},s++),"object"==typeof a||m(a)||(a={}),s===u&&(a=this,s--);s<u;s++)if(null!=(e=arguments[s]))for(t in e)r=e[t],"__proto__"!==t&&a!==r&&(l&&r&&(S.isPlainObject(r)||(i=Array.isArray(r)))?(n=a[t],o=i&&!Array.isArray(n)?[]:i||S.isPlainObject(n)?n:{},i=!1,a[t]=S.extend(l,o,r)):void 0!==r&&(a[t]=r));return a},S.extend({expando:"jQuery"+(f+Math.random()).replace(/\D/g,""),isReady:!0,error:function(e){throw new Error(e)},noop:function(){},isPlainObject:function(e){var t,n;return!(!e||"[object Object]"!==o.call(e))&&(!(t=r(e))||"function"==typeof(n=v.call(t,"constructor")&&t.constructor)&&a.call(n)===l)},isEmptyObject:function(e){var t;for(t in e)return!1;return!0},globalEval:function(e,t,n){b(e,{nonce:t&&t.nonce},n)},each:function(e,t){var n,r=0;if(p(e)){for(n=e.length;r<n;r++)if(!1===t.call(e[r],r,e[r]))break}else for(r in e)if(!1===t.call(e[r],r,e[r]))break;return e},makeArray:function(e,t){var n=t||[];return null!=e&&(p(Object(e))?S.merge(n,"string"==typeof e?[e]:e):u.call(n,e)),n},inArray:function(e,t,n){return null==t?-1:i.call(t,e,n)},merge:function(e,t){for(var n=+t.length,r=0,i=e.length;r<n;r++)e[i++]=t[r];return e.length=i,e},grep:function(e,t,n){for(var r=[],i=0,o=e.length,a=!n;i<o;i++)!t(e[i],i)!==a&&r.push(e[i]);return r},map:function(e,t,n){var r,i,o=0,a=[];if(p(e))for(r=e.length;o<r;o++)null!=(i=t(e[o],o,n))&&a.push(i);else for(o in e)null!=(i=t(e[o],o,n))&&a.push(i);return g(a)},guid:1,support:y}),"function"==typeof Symbol&&(S.fn[Symbol.iterator]=t[Symbol.iterator]),S.each("Boolean Number String Function Array Date RegExp Object Error Symbol".split(" "),function(e,t){n["[object "+t+"]"]=t.toLowerCase()});var d=function(n){var e,d,b,o,i,h,f,g,w,u,l,T,C,a,E,v,s,c,y,S="sizzle"+1*new Date,p=n.document,k=0,r=0,m=ue(),x=ue(),A=ue(),N=ue(),j=function(e,t){return e===t&&(l=!0),0},D={}.hasOwnProperty,t=[],q=t.pop,L=t.push,H=t.push,O=t.slice,P=function(e,t){for(var n=0,r=e.length;n<r;n++)if(e[n]===t)return n;return-1},R="checked|selected|async|autofocus|autoplay|controls|defer|disabled|hidden|ismap|loop|multiple|open|readonly|required|scoped",M="[\ \\t\\r\\n\\f]",I="(?:\\\\[\\da-fA-F]{1,6}"+M+"?|\\\\[^\\r\\n\\f]|[\\w-]|[^\0-\])+",W="\\["+M+"*("+I+")(?:"+M+"*([*^$|!~]?=)"+M+"*(?:'((?:\\\\.|[^\\\\'])*)'|\"((?:\\\\.|[^\\\\\"])*)\"|("+I+"))|)"+M+"*\\]",F=":("+I+")(?:\\((('((?:\\\\.|[^\\\\'])*)'|\"((?:\\\\.|[^\\\\\"])*)\")|((?:\\\\.|[^\\\\()[\\]]|"+W+")*)|.*)\\)|)",B=new RegExp(M+"+","g"),$=new RegExp("^"+M+"+|((?:^|[^\\\\])(?:\\\\.)*)"+M+"+$","g"),_=new RegExp("^"+M+"*,"+M+"*"),z=new RegExp("^"+M+"*([>+~]|"+M+")"+M+"*"),U=new RegExp(M+"|>"),X=new RegExp(F),V=new RegExp("^"+I+"$"),G={ID:new RegExp("^#("+I+")"),CLASS:new RegExp("^\\.("+I+")"),TAG:new RegExp("^("+I+"|[*])"),ATTR:new RegExp("^"+W),PSEUDO:new RegExp("^"+F),CHILD:new RegExp("^:(only|first|last|nth|nth-last)-(child|of-type)(?:\\("+M+"*(even|odd|(([+-]|)(\\d*)n|)"+M+"*(?:([+-]|)"+M+"*(\\d+)|))"+M+"*\\)|)","i"),bool:new RegExp("^(?:"+R+")$","i"),needsContext:new RegExp("^"+M+"*[>+~]|:(even|odd|eq|gt|lt|nth|first|last)(?:\\("+M+"*((?:-\\d)?\\d*)"+M+"*\\)|)(?=[^-]|$)","i")},Y=/HTML$/i,Q=/^(?:input|select|textarea|button)$/i,J=/^h\d$/i,K=/^[^{]+\{\s*\[native \w/,Z=/^(?:#([\w-]+)|(\w+)|\.([\w-]+))$/,ee=/[+~]/,te=new RegExp("\\\\[\\da-fA-F]{1,6}"+M+"?|\\\\([^\\r\\n\\f])","g"),ne=function(e,t){var n="0x"+e.slice(1)-65536;return t||(n<0?String.fromCharCode(n+65536):String.fromCharCode(n>>10|55296,1023&n|56320))},re=/([\0-]|^-?\d)|^-$|[^\0--￿\w-]/g,ie=function(e,t){return t?"\0"===e?"�":e.slice(0,-1)+"\\"+e.charCodeAt(e.length-1).toString(16)+" ":"\\"+e},oe=function(){T()},ae=be(function(e){return!0===e.disabled&&"fieldset"===e.nodeName.toLowerCase()},{dir:"parentNode",next:"legend"});try{H.apply(t=O.call(p.childNodes),p.childNodes),t[p.childNodes.length].nodeType}catch(e){H={apply:t.length?function(e,t){L.apply(e,O.call(t))}:function(e,t){var n=e.length,r=0;while(e[n++]=t[r++]);e.length=n-1}}}function se(t,e,n,r){var i,o,a,s,u,l,c,f=e&&e.ownerDocument,p=e?e.nodeType:9;if(n=n||[],"string"!=typeof t||!t||1!==p&&9!==p&&11!==p)return n;if(!r&&(T(e),e=e||C,E)){if(11!==p&&(u=Z.exec(t)))if(i=u[1]){if(9===p){if(!(a=e.getElementById(i)))return n;if(a.id===i)return n.push(a),n}else if(f&&(a=f.getElementById(i))&&y(e,a)&&a.id===i)return n.push(a),n}else{if(u[2])return H.apply(n,e.getElementsByTagName(t)),n;if((i=u[3])&&d.getElementsByClassName&&e.getElementsByClassName)return H.apply(n,e.getElementsByClassName(i)),n}if(d.qsa&&!N[t+" "]&&(!v||!v.test(t))&&(1!==p||"object"!==e.nodeName.toLowerCase())){if(c=t,f=e,1===p&&(U.test(t)||z.test(t))){(f=ee.test(t)&&ye(e.parentNode)||e)===e&&d.scope||((s=e.getAttribute("id"))?s=s.replace(re,ie):e.setAttribute("id",s=S)),o=(l=h(t)).length;while(o--)l[o]=(s?"#"+s:":scope")+" "+xe(l[o]);c=l.join(",")}try{return H.apply(n,f.querySelectorAll(c)),n}catch(e){N(t,!0)}finally{s===S&&e.removeAttribute("id")}}}return g(t.replace($,"$1"),e,n,r)}function ue(){var r=[];return function e(t,n){return r.push(t+" ")>b.cacheLength&&delete e[r.shift()],e[t+" "]=n}}function le(e){return e[S]=!0,e}function ce(e){var t=C.createElement("fieldset");try{return!!e(t)}catch(e){return!1}finally{t.parentNode&&t.parentNode.removeChild(t),t=null}}function fe(e,t){var n=e.split("|"),r=n.length;while(r--)b.attrHandle[n[r]]=t}function pe(e,t){var n=t&&e,r=n&&1===e.nodeType&&1===t.nodeType&&e.sourceIndex-t.sourceIndex;if(r)return r;if(n)while(n=n.nextSibling)if(n===t)return-1;return e?1:-1}function de(t){return function(e){return"input"===e.nodeName.toLowerCase()&&e.type===t}}function he(n){return function(e){var t=e.nodeName.toLowerCase();return("input"===t||"button"===t)&&e.type===n}}function ge(t){return function(e){return"form"in e?e.parentNode&&!1===e.disabled?"label"in e?"label"in e.parentNode?e.parentNode.disabled===t:e.disabled===t:e.isDisabled===t||e.isDisabled!==!t&&ae(e)===t:e.disabled===t:"label"in e&&e.disabled===t}}function ve(a){return le(function(o){return o=+o,le(function(e,t){var n,r=a([],e.length,o),i=r.length;while(i--)e[n=r[i]]&&(e[n]=!(t[n]=e[n]))})})}function ye(e){return e&&"undefined"!=typeof e.getElementsByTagName&&e}for(e in d=se.support={},i=se.isXML=function(e){var t=e&&e.namespaceURI,n=e&&(e.ownerDocument||e).documentElement;return!Y.test(t||n&&n.nodeName||"HTML")},T=se.setDocument=function(e){var t,n,r=e?e.ownerDocument||e:p;return r!=C&&9===r.nodeType&&r.documentElement&&(a=(C=r).documentElement,E=!i(C),p!=C&&(n=C.defaultView)&&n.top!==n&&(n.addEventListener?n.addEventListener("unload",oe,!1):n.attachEvent&&n.attachEvent("onunload",oe)),d.scope=ce(function(e){return a.appendChild(e).appendChild(C.createElement("div")),"undefined"!=typeof e.querySelectorAll&&!e.querySelectorAll(":scope fieldset div").length}),d.attributes=ce(function(e){return e.className="i",!e.getAttribute("className")}),d.getElementsByTagName=ce(function(e){return e.appendChild(C.createComment("")),!e.getElementsByTagName("*").length}),d.getElementsByClassName=K.test(C.getElementsByClassName),d.getById=ce(function(e){return a.appendChild(e).id=S,!C.getElementsByName||!C.getElementsByName(S).length}),d.getById?(b.filter.ID=function(e){var t=e.replace(te,ne);return function(e){return e.getAttribute("id")===t}},b.find.ID=function(e,t){if("undefined"!=typeof t.getElementById&&E){var n=t.getElementById(e);return n?[n]:[]}}):(b.filter.ID=function(e){var n=e.replace(te,ne);return function(e){var t="undefined"!=typeof e.getAttributeNode&&e.getAttributeNode("id");return t&&t.value===n}},b.find.ID=function(e,t){if("undefined"!=typeof t.getElementById&&E){var n,r,i,o=t.getElementById(e);if(o){if((n=o.getAttributeNode("id"))&&n.value===e)return[o];i=t.getElementsByName(e),r=0;while(o=i[r++])if((n=o.getAttributeNode("id"))&&n.value===e)return[o]}return[]}}),b.find.TAG=d.getElementsByTagName?function(e,t){return"undefined"!=typeof t.getElementsByTagName?t.getElementsByTagName(e):d.qsa?t.querySelectorAll(e):void 0}:function(e,t){var n,r=[],i=0,o=t.getElementsByTagName(e);if("*"===e){while(n=o[i++])1===n.nodeType&&r.push(n);return r}return o},b.find.CLASS=d.getElementsByClassName&&function(e,t){if("undefined"!=typeof t.getElementsByClassName&&E)return t.getElementsByClassName(e)},s=[],v=[],(d.qsa=K.test(C.querySelectorAll))&&(ce(function(e){var t;a.appendChild(e).innerHTML="<a id='"+S+"'></a><select id='"+S+"-\r\\' msallowcapture=''><option selected=''></option></select>",e.querySelectorAll("[msallowcapture^='']").length&&v.push("[*^$]="+M+"*(?:''|\"\")"),e.querySelectorAll("[selected]").length||v.push("\\["+M+"*(?:value|"+R+")"),e.querySelectorAll("[id~="+S+"-]").length||v.push("~="),(t=C.createElement("input")).setAttribute("name",""),e.appendChild(t),e.querySelectorAll("[name='']").length||v.push("\\["+M+"*name"+M+"*="+M+"*(?:''|\"\")"),e.querySelectorAll(":checked").length||v.push(":checked"),e.querySelectorAll("a#"+S+"+*").length||v.push(".#.+[+~]"),e.querySelectorAll("\\\f"),v.push("[\\r\\n\\f]")}),ce(function(e){e.innerHTML="<a href='' disabled='disabled'></a><select disabled='disabled'><option/></select>";var t=C.createElement("input");t.setAttribute("type","hidden"),e.appendChild(t).setAttribute("name","D"),e.querySelectorAll("[name=d]").length&&v.push("name"+M+"*[*^$|!~]?="),2!==e.querySelectorAll(":enabled").length&&v.push(":enabled",":disabled"),a.appendChild(e).disabled=!0,2!==e.querySelectorAll(":disabled").length&&v.push(":enabled",":disabled"),e.querySelectorAll("*,:x"),v.push(",.*:")})),(d.matchesSelector=K.test(c=a.matches||a.webkitMatchesSelector||a.mozMatchesSelector||a.oMatchesSelector||a.msMatchesSelector))&&ce(function(e){d.disconnectedMatch=c.call(e,"*"),c.call(e,"[s!='']:x"),s.push("!=",F)}),v=v.length&&new RegExp(v.join("|")),s=s.length&&new RegExp(s.join("|")),t=K.test(a.compareDocumentPosition),y=t||K.test(a.contains)?function(e,t){var n=9===e.nodeType?e.documentElement:e,r=t&&t.parentNode;return e===r||!(!r||1!==r.nodeType||!(n.contains?n.contains(r):e.compareDocumentPosition&&16&e.compareDocumentPosition(r)))}:function(e,t){if(t)while(t=t.parentNode)if(t===e)return!0;return!1},j=t?function(e,t){if(e===t)return l=!0,0;var n=!e.compareDocumentPosition-!t.compareDocumentPosition;return n||(1&(n=(e.ownerDocument||e)==(t.ownerDocument||t)?e.compareDocumentPosition(t):1)||!d.sortDetached&&t.compareDocumentPosition(e)===n?e==C||e.ownerDocument==p&&y(p,e)?-1:t==C||t.ownerDocument==p&&y(p,t)?1:u?P(u,e)-P(u,t):0:4&n?-1:1)}:function(e,t){if(e===t)return l=!0,0;var n,r=0,i=e.parentNode,o=t.parentNode,a=[e],s=[t];if(!i||!o)return e==C?-1:t==C?1:i?-1:o?1:u?P(u,e)-P(u,t):0;if(i===o)return pe(e,t);n=e;while(n=n.parentNode)a.unshift(n);n=t;while(n=n.parentNode)s.unshift(n);while(a[r]===s[r])r++;return r?pe(a[r],s[r]):a[r]==p?-1:s[r]==p?1:0}),C},se.matches=function(e,t){return se(e,null,null,t)},se.matchesSelector=function(e,t){if(T(e),d.matchesSelector&&E&&!N[t+" "]&&(!s||!s.test(t))&&(!v||!v.test(t)))try{var n=c.call(e,t);if(n||d.disconnectedMatch||e.document&&11!==e.document.nodeType)return n}catch(e){N(t,!0)}return 0<se(t,C,null,[e]).length},se.contains=function(e,t){return(e.ownerDocument||e)!=C&&T(e),y(e,t)},se.attr=function(e,t){(e.ownerDocument||e)!=C&&T(e);var n=b.attrHandle[t.toLowerCase()],r=n&&D.call(b.attrHandle,t.toLowerCase())?n(e,t,!E):void 0;return void 0!==r?r:d.attributes||!E?e.getAttribute(t):(r=e.getAttributeNode(t))&&r.specified?r.value:null},se.escape=function(e){return(e+"").replace(re,ie)},se.error=function(e){throw new Error("Syntax error, unrecognized expression: "+e)},se.uniqueSort=function(e){var t,n=[],r=0,i=0;if(l=!d.detectDuplicates,u=!d.sortStable&&e.slice(0),e.sort(j),l){while(t=e[i++])t===e[i]&&(r=n.push(i));while(r--)e.splice(n[r],1)}return u=null,e},o=se.getText=function(e){var t,n="",r=0,i=e.nodeType;if(i){if(1===i||9===i||11===i){if("string"==typeof e.textContent)return e.textContent;for(e=e.firstChild;e;e=e.nextSibling)n+=o(e)}else if(3===i||4===i)return e.nodeValue}else while(t=e[r++])n+=o(t);return n},(b=se.selectors={cacheLength:50,createPseudo:le,match:G,attrHandle:{},find:{},relative:{">":{dir:"parentNode",first:!0}," ":{dir:"parentNode"},"+":{dir:"previousSibling",first:!0},"~":{dir:"previousSibling"}},preFilter:{ATTR:function(e){return e[1]=e[1].replace(te,ne),e[3]=(e[3]||e[4]||e[5]||"").replace(te,ne),"~="===e[2]&&(e[3]=" "+e[3]+" "),e.slice(0,4)},CHILD:function(e){return e[1]=e[1].toLowerCase(),"nth"===e[1].slice(0,3)?(e[3]||se.error(e[0]),e[4]=+(e[4]?e[5]+(e[6]||1):2*("even"===e[3]||"odd"===e[3])),e[5]=+(e[7]+e[8]||"odd"===e[3])):e[3]&&se.error(e[0]),e},PSEUDO:function(e){var t,n=!e[6]&&e[2];return G.CHILD.test(e[0])?null:(e[3]?e[2]=e[4]||e[5]||"":n&&X.test(n)&&(t=h(n,!0))&&(t=n.indexOf(")",n.length-t)-n.length)&&(e[0]=e[0].slice(0,t),e[2]=n.slice(0,t)),e.slice(0,3))}},filter:{TAG:function(e){var t=e.replace(te,ne).toLowerCase();return"*"===e?function(){return!0}:function(e){return e.nodeName&&e.nodeName.toLowerCase()===t}},CLASS:function(e){var t=m[e+" "];return t||(t=new RegExp("(^|"+M+")"+e+"("+M+"|$)"))&&m(e,function(e){return t.test("string"==typeof e.className&&e.className||"undefined"!=typeof e.getAttribute&&e.getAttribute("class")||"")})},ATTR:function(n,r,i){return function(e){var t=se.attr(e,n);return null==t?"!="===r:!r||(t+="","="===r?t===i:"!="===r?t!==i:"^="===r?i&&0===t.indexOf(i):"*="===r?i&&-1<t.indexOf(i):"$="===r?i&&t.slice(-i.length)===i:"~="===r?-1<(" "+t.replace(B," ")+" ").indexOf(i):"|="===r&&(t===i||t.slice(0,i.length+1)===i+"-"))}},CHILD:function(h,e,t,g,v){var y="nth"!==h.slice(0,3),m="last"!==h.slice(-4),x="of-type"===e;return 1===g&&0===v?function(e){return!!e.parentNode}:function(e,t,n){var r,i,o,a,s,u,l=y!==m?"nextSibling":"previousSibling",c=e.parentNode,f=x&&e.nodeName.toLowerCase(),p=!n&&!x,d=!1;if(c){if(y){while(l){a=e;while(a=a[l])if(x?a.nodeName.toLowerCase()===f:1===a.nodeType)return!1;u=l="only"===h&&!u&&"nextSibling"}return!0}if(u=[m?c.firstChild:c.lastChild],m&&p){d=(s=(r=(i=(o=(a=c)[S]||(a[S]={}))[a.uniqueID]||(o[a.uniqueID]={}))[h]||[])[0]===k&&r[1])&&r[2],a=s&&c.childNodes[s];while(a=++s&&a&&a[l]||(d=s=0)||u.pop())if(1===a.nodeType&&++d&&a===e){i[h]=[k,s,d];break}}else if(p&&(d=s=(r=(i=(o=(a=e)[S]||(a[S]={}))[a.uniqueID]||(o[a.uniqueID]={}))[h]||[])[0]===k&&r[1]),!1===d)while(a=++s&&a&&a[l]||(d=s=0)||u.pop())if((x?a.nodeName.toLowerCase()===f:1===a.nodeType)&&++d&&(p&&((i=(o=a[S]||(a[S]={}))[a.uniqueID]||(o[a.uniqueID]={}))[h]=[k,d]),a===e))break;return(d-=v)===g||d%g==0&&0<=d/g}}},PSEUDO:function(e,o){var t,a=b.pseudos[e]||b.setFilters[e.toLowerCase()]||se.error("unsupported pseudo: "+e);return a[S]?a(o):1<a.length?(t=[e,e,"",o],b.setFilters.hasOwnProperty(e.toLowerCase())?le(function(e,t){var n,r=a(e,o),i=r.length;while(i--)e[n=P(e,r[i])]=!(t[n]=r[i])}):function(e){return a(e,0,t)}):a}},pseudos:{not:le(function(e){var r=[],i=[],s=f(e.replace($,"$1"));return s[S]?le(function(e,t,n,r){var i,o=s(e,null,r,[]),a=e.length;while(a--)(i=o[a])&&(e[a]=!(t[a]=i))}):function(e,t,n){return r[0]=e,s(r,null,n,i),r[0]=null,!i.pop()}}),has:le(function(t){return function(e){return 0<se(t,e).length}}),contains:le(function(t){return t=t.replace(te,ne),function(e){return-1<(e.textContent||o(e)).indexOf(t)}}),lang:le(function(n){return V.test(n||"")||se.error("unsupported lang: "+n),n=n.replace(te,ne).toLowerCase(),function(e){var t;do{if(t=E?e.lang:e.getAttribute("xml:lang")||e.getAttribute("lang"))return(t=t.toLowerCase())===n||0===t.indexOf(n+"-")}while((e=e.parentNode)&&1===e.nodeType);return!1}}),target:function(e){var t=n.location&&n.location.hash;return t&&t.slice(1)===e.id},root:function(e){return e===a},focus:function(e){return e===C.activeElement&&(!C.hasFocus||C.hasFocus())&&!!(e.type||e.href||~e.tabIndex)},enabled:ge(!1),disabled:ge(!0),checked:function(e){var t=e.nodeName.toLowerCase();return"input"===t&&!!e.checked||"option"===t&&!!e.selected},selected:function(e){return e.parentNode&&e.parentNode.selectedIndex,!0===e.selected},empty:function(e){for(e=e.firstChild;e;e=e.nextSibling)if(e.nodeType<6)return!1;return!0},parent:function(e){return!b.pseudos.empty(e)},header:function(e){return J.test(e.nodeName)},input:function(e){return Q.test(e.nodeName)},button:function(e){var t=e.nodeName.toLowerCase();return"input"===t&&"button"===e.type||"button"===t},text:function(e){var t;return"input"===e.nodeName.toLowerCase()&&"text"===e.type&&(null==(t=e.getAttribute("type"))||"text"===t.toLowerCase())},first:ve(function(){return[0]}),last:ve(function(e,t){return[t-1]}),eq:ve(function(e,t,n){return[n<0?n+t:n]}),even:ve(function(e,t){for(var n=0;n<t;n+=2)e.push(n);return e}),odd:ve(function(e,t){for(var n=1;n<t;n+=2)e.push(n);return e}),lt:ve(function(e,t,n){for(var r=n<0?n+t:t<n?t:n;0<=--r;)e.push(r);return e}),gt:ve(function(e,t,n){for(var r=n<0?n+t:n;++r<t;)e.push(r);return e})}}).pseudos.nth=b.pseudos.eq,{radio:!0,checkbox:!0,file:!0,password:!0,image:!0})b.pseudos[e]=de(e);for(e in{submit:!0,reset:!0})b.pseudos[e]=he(e);function me(){}function xe(e){for(var t=0,n=e.length,r="";t<n;t++)r+=e[t].value;return r}function be(s,e,t){var u=e.dir,l=e.next,c=l||u,f=t&&"parentNode"===c,p=r++;return e.first?function(e,t,n){while(e=e[u])if(1===e.nodeType||f)return s(e,t,n);return!1}:function(e,t,n){var r,i,o,a=[k,p];if(n){while(e=e[u])if((1===e.nodeType||f)&&s(e,t,n))return!0}else while(e=e[u])if(1===e.nodeType||f)if(i=(o=e[S]||(e[S]={}))[e.uniqueID]||(o[e.uniqueID]={}),l&&l===e.nodeName.toLowerCase())e=e[u]||e;else{if((r=i[c])&&r[0]===k&&r[1]===p)return a[2]=r[2];if((i[c]=a)[2]=s(e,t,n))return!0}return!1}}function we(i){return 1<i.length?function(e,t,n){var r=i.length;while(r--)if(!i[r](e,t,n))return!1;return!0}:i[0]}function Te(e,t,n,r,i){for(var o,a=[],s=0,u=e.length,l=null!=t;s<u;s++)(o=e[s])&&(n&&!n(o,r,i)||(a.push(o),l&&t.push(s)));return a}function Ce(d,h,g,v,y,e){return v&&!v[S]&&(v=Ce(v)),y&&!y[S]&&(y=Ce(y,e)),le(function(e,t,n,r){var i,o,a,s=[],u=[],l=t.length,c=e||function(e,t,n){for(var r=0,i=t.length;r<i;r++)se(e,t[r],n);return n}(h||"*",n.nodeType?[n]:n,[]),f=!d||!e&&h?c:Te(c,s,d,n,r),p=g?y||(e?d:l||v)?[]:t:f;if(g&&g(f,p,n,r),v){i=Te(p,u),v(i,[],n,r),o=i.length;while(o--)(a=i[o])&&(p[u[o]]=!(f[u[o]]=a))}if(e){if(y||d){if(y){i=[],o=p.length;while(o--)(a=p[o])&&i.push(f[o]=a);y(null,p=[],i,r)}o=p.length;while(o--)(a=p[o])&&-1<(i=y?P(e,a):s[o])&&(e[i]=!(t[i]=a))}}else p=Te(p===t?p.splice(l,p.length):p),y?y(null,t,p,r):H.apply(t,p)})}function Ee(e){for(var i,t,n,r=e.length,o=b.relative[e[0].type],a=o||b.relative[" "],s=o?1:0,u=be(function(e){return e===i},a,!0),l=be(function(e){return-1<P(i,e)},a,!0),c=[function(e,t,n){var r=!o&&(n||t!==w)||((i=t).nodeType?u(e,t,n):l(e,t,n));return i=null,r}];s<r;s++)if(t=b.relative[e[s].type])c=[be(we(c),t)];else{if((t=b.filter[e[s].type].apply(null,e[s].matches))[S]){for(n=++s;n<r;n++)if(b.relative[e[n].type])break;return Ce(1<s&&we(c),1<s&&xe(e.slice(0,s-1).concat({value:" "===e[s-2].type?"*":""})).replace($,"$1"),t,s<n&&Ee(e.slice(s,n)),n<r&&Ee(e=e.slice(n)),n<r&&xe(e))}c.push(t)}return we(c)}return me.prototype=b.filters=b.pseudos,b.setFilters=new me,h=se.tokenize=function(e,t){var n,r,i,o,a,s,u,l=x[e+" "];if(l)return t?0:l.slice(0);a=e,s=[],u=b.preFilter;while(a){for(o in n&&!(r=_.exec(a))||(r&&(a=a.slice(r[0].length)||a),s.push(i=[])),n=!1,(r=z.exec(a))&&(n=r.shift(),i.push({value:n,type:r[0].replace($," ")}),a=a.slice(n.length)),b.filter)!(r=G[o].exec(a))||u[o]&&!(r=u[o](r))||(n=r.shift(),i.push({value:n,type:o,matches:r}),a=a.slice(n.length));if(!n)break}return t?a.length:a?se.error(e):x(e,s).slice(0)},f=se.compile=function(e,t){var n,v,y,m,x,r,i=[],o=[],a=A[e+" "];if(!a){t||(t=h(e)),n=t.length;while(n--)(a=Ee(t[n]))[S]?i.push(a):o.push(a);(a=A(e,(v=o,m=0<(y=i).length,x=0<v.length,r=function(e,t,n,r,i){var o,a,s,u=0,l="0",c=e&&[],f=[],p=w,d=e||x&&b.find.TAG("*",i),h=k+=null==p?1:Math.random()||.1,g=d.length;for(i&&(w=t==C||t||i);l!==g&&null!=(o=d[l]);l++){if(x&&o){a=0,t||o.ownerDocument==C||(T(o),n=!E);while(s=v[a++])if(s(o,t||C,n)){r.push(o);break}i&&(k=h)}m&&((o=!s&&o)&&u--,e&&c.push(o))}if(u+=l,m&&l!==u){a=0;while(s=y[a++])s(c,f,t,n);if(e){if(0<u)while(l--)c[l]||f[l]||(f[l]=q.call(r));f=Te(f)}H.apply(r,f),i&&!e&&0<f.length&&1<u+y.length&&se.uniqueSort(r)}return i&&(k=h,w=p),c},m?le(r):r))).selector=e}return a},g=se.select=function(e,t,n,r){var i,o,a,s,u,l="function"==typeof e&&e,c=!r&&h(e=l.selector||e);if(n=n||[],1===c.length){if(2<(o=c[0]=c[0].slice(0)).length&&"ID"===(a=o[0]).type&&9===t.nodeType&&E&&b.relative[o[1].type]){if(!(t=(b.find.ID(a.matches[0].replace(te,ne),t)||[])[0]))return n;l&&(t=t.parentNode),e=e.slice(o.shift().value.length)}i=G.needsContext.test(e)?0:o.length;while(i--){if(a=o[i],b.relative[s=a.type])break;if((u=b.find[s])&&(r=u(a.matches[0].replace(te,ne),ee.test(o[0].type)&&ye(t.parentNode)||t))){if(o.splice(i,1),!(e=r.length&&xe(o)))return H.apply(n,r),n;break}}}return(l||f(e,c))(r,t,!E,n,!t||ee.test(e)&&ye(t.parentNode)||t),n},d.sortStable=S.split("").sort(j).join("")===S,d.detectDuplicates=!!l,T(),d.sortDetached=ce(function(e){return 1&e.compareDocumentPosition(C.createElement("fieldset"))}),ce(function(e){return e.innerHTML="<a href='#'></a>","#"===e.firstChild.getAttribute("href")})||fe("type|href|height|width",function(e,t,n){if(!n)return e.getAttribute(t,"type"===t.toLowerCase()?1:2)}),d.attributes&&ce(function(e){return e.innerHTML="<input/>",e.firstChild.setAttribute("value",""),""===e.firstChild.getAttribute("value")})||fe("value",function(e,t,n){if(!n&&"input"===e.nodeName.toLowerCase())return e.defaultValue}),ce(function(e){return null==e.getAttribute("disabled")})||fe(R,function(e,t,n){var r;if(!n)return!0===e[t]?t.toLowerCase():(r=e.getAttributeNode(t))&&r.specified?r.value:null}),se}(C);S.find=d,S.expr=d.selectors,S.expr[":"]=S.expr.pseudos,S.uniqueSort=S.unique=d.uniqueSort,S.text=d.getText,S.isXMLDoc=d.isXML,S.contains=d.contains,S.escapeSelector=d.escape;var h=function(e,t,n){var r=[],i=void 0!==n;while((e=e[t])&&9!==e.nodeType)if(1===e.nodeType){if(i&&S(e).is(n))break;r.push(e)}return r},T=function(e,t){for(var n=[];e;e=e.nextSibling)1===e.nodeType&&e!==t&&n.push(e);return n},k=S.expr.match.needsContext;function A(e,t){return e.nodeName&&e.nodeName.toLowerCase()===t.toLowerCase()}var N=/^<([a-z][^\/\0>: \t\r\n\f]*)[ \t\r\n\f]*\/?>(?:<\/\1>|)$/i;function j(e,n,r){return m(n)?S.grep(e,function(e,t){return!!n.call(e,t,e)!==r}):n.nodeType?S.grep(e,function(e){return e===n!==r}):"string"!=typeof n?S.grep(e,function(e){return-1<i.call(n,e)!==r}):S.filter(n,e,r)}S.filter=function(e,t,n){var r=t[0];return n&&(e=":not("+e+")"),1===t.length&&1===r.nodeType?S.find.matchesSelector(r,e)?[r]:[]:S.find.matches(e,S.grep(t,function(e){return 1===e.nodeType}))},S.fn.extend({find:function(e){var t,n,r=this.length,i=this;if("string"!=typeof e)return this.pushStack(S(e).filter(function(){for(t=0;t<r;t++)if(S.contains(i[t],this))return!0}));for(n=this.pushStack([]),t=0;t<r;t++)S.find(e,i[t],n);return 1<r?S.uniqueSort(n):n},filter:function(e){return this.pushStack(j(this,e||[],!1))},not:function(e){return this.pushStack(j(this,e||[],!0))},is:function(e){return!!j(this,"string"==typeof e&&k.test(e)?S(e):e||[],!1).length}});var D,q=/^(?:\s*(<[\w\W]+>)[^>]*|#([\w-]+))$/;(S.fn.init=function(e,t,n){var r,i;if(!e)return this;if(n=n||D,"string"==typeof e){if(!(r="<"===e[0]&&">"===e[e.length-1]&&3<=e.length?[null,e,null]:q.exec(e))||!r[1]&&t)return!t||t.jquery?(t||n).find(e):this.constructor(t).find(e);if(r[1]){if(t=t instanceof S?t[0]:t,S.merge(this,S.parseHTML(r[1],t&&t.nodeType?t.ownerDocument||t:E,!0)),N.test(r[1])&&S.isPlainObject(t))for(r in t)m(this[r])?this[r](t[r]):this.attr(r,t[r]);return this}return(i=E.getElementById(r[2]))&&(this[0]=i,this.length=1),this}return e.nodeType?(this[0]=e,this.length=1,this):m(e)?void 0!==n.ready?n.ready(e):e(S):S.makeArray(e,this)}).prototype=S.fn,D=S(E);var L=/^(?:parents|prev(?:Until|All))/,H={children:!0,contents:!0,next:!0,prev:!0};function O(e,t){while((e=e[t])&&1!==e.nodeType);return e}S.fn.extend({has:function(e){var t=S(e,this),n=t.length;return this.filter(function(){for(var e=0;e<n;e++)if(S.contains(this,t[e]))return!0})},closest:function(e,t){var n,r=0,i=this.length,o=[],a="string"!=typeof e&&S(e);if(!k.test(e))for(;r<i;r++)for(n=this[r];n&&n!==t;n=n.parentNode)if(n.nodeType<11&&(a?-1<a.index(n):1===n.nodeType&&S.find.matchesSelector(n,e))){o.push(n);break}return this.pushStack(1<o.length?S.uniqueSort(o):o)},index:function(e){return e?"string"==typeof e?i.call(S(e),this[0]):i.call(this,e.jquery?e[0]:e):this[0]&&this[0].parentNode?this.first().prevAll().length:-1},add:function(e,t){return this.pushStack(S.uniqueSort(S.merge(this.get(),S(e,t))))},addBack:function(e){return this.add(null==e?this.prevObject:this.prevObject.filter(e))}}),S.each({parent:function(e){var t=e.parentNode;return t&&11!==t.nodeType?t:null},parents:function(e){return h(e,"parentNode")},parentsUntil:function(e,t,n){return h(e,"parentNode",n)},next:function(e){return O(e,"nextSibling")},prev:function(e){return O(e,"previousSibling")},nextAll:function(e){return h(e,"nextSibling")},prevAll:function(e){return h(e,"previousSibling")},nextUntil:function(e,t,n){return h(e,"nextSibling",n)},prevUntil:function(e,t,n){return h(e,"previousSibling",n)},siblings:function(e){return T((e.parentNode||{}).firstChild,e)},children:function(e){return T(e.firstChild)},contents:function(e){return null!=e.contentDocument&&r(e.contentDocument)?e.contentDocument:(A(e,"template")&&(e=e.content||e),S.merge([],e.childNodes))}},function(r,i){S.fn[r]=function(e,t){var n=S.map(this,i,e);return"Until"!==r.slice(-5)&&(t=e),t&&"string"==typeof t&&(n=S.filter(t,n)),1<this.length&&(H[r]||S.uniqueSort(n),L.test(r)&&n.reverse()),this.pushStack(n)}});var P=/[^ \t\r\n\f]+/g;function R(e){return e}function M(e){throw e}function I(e,t,n,r){var i;try{e&&m(i=e.promise)?i.call(e).done(t).fail(n):e&&m(i=e.then)?i.call(e,t,n):t.apply(void 0,[e].slice(r))}catch(e){n.apply(void 0,[e])}}S.Callbacks=function(r){var e,n;r="string"==typeof r?(e=r,n={},S.each(e.match(P)||[],function(e,t){n[t]=!0}),n):S.extend({},r);var i,t,o,a,s=[],u=[],l=-1,c=function(){for(a=a||r.once,o=i=!0;u.length;l=-1){t=u.shift();while(++l<s.length)!1===s[l].apply(t[0],t[1])&&r.stopOnFalse&&(l=s.length,t=!1)}r.memory||(t=!1),i=!1,a&&(s=t?[]:"")},f={add:function(){return s&&(t&&!i&&(l=s.length-1,u.push(t)),function n(e){S.each(e,function(e,t){m(t)?r.unique&&f.has(t)||s.push(t):t&&t.length&&"string"!==w(t)&&n(t)})}(arguments),t&&!i&&c()),this},remove:function(){return S.each(arguments,function(e,t){var n;while(-1<(n=S.inArray(t,s,n)))s.splice(n,1),n<=l&&l--}),this},has:function(e){return e?-1<S.inArray(e,s):0<s.length},empty:function(){return s&&(s=[]),this},disable:function(){return a=u=[],s=t="",this},disabled:function(){return!s},lock:function(){return a=u=[],t||i||(s=t=""),this},locked:function(){return!!a},fireWith:function(e,t){return a||(t=[e,(t=t||[]).slice?t.slice():t],u.push(t),i||c()),this},fire:function(){return f.fireWith(this,arguments),this},fired:function(){return!!o}};return f},S.extend({Deferred:function(e){var o=[["notify","progress",S.Callbacks("memory"),S.Callbacks("memory"),2],["resolve","done",S.Callbacks("once memory"),S.Callbacks("once memory"),0,"resolved"],["reject","fail",S.Callbacks("once memory"),S.Callbacks("once memory"),1,"rejected"]],i="pending",a={state:function(){return i},always:function(){return s.done(arguments).fail(arguments),this},"catch":function(e){return a.then(null,e)},pipe:function(){var i=arguments;return S.Deferred(function(r){S.each(o,function(e,t){var n=m(i[t[4]])&&i[t[4]];s[t[1]](function(){var e=n&&n.apply(this,arguments);e&&m(e.promise)?e.promise().progress(r.notify).done(r.resolve).fail(r.reject):r[t[0]+"With"](this,n?[e]:arguments)})}),i=null}).promise()},then:function(t,n,r){var u=0;function l(i,o,a,s){return function(){var n=this,r=arguments,e=function(){var e,t;if(!(i<u)){if((e=a.apply(n,r))===o.promise())throw new TypeError("Thenable self-resolution");t=e&&("object"==typeof e||"function"==typeof e)&&e.then,m(t)?s?t.call(e,l(u,o,R,s),l(u,o,M,s)):(u++,t.call(e,l(u,o,R,s),l(u,o,M,s),l(u,o,R,o.notifyWith))):(a!==R&&(n=void 0,r=[e]),(s||o.resolveWith)(n,r))}},t=s?e:function(){try{e()}catch(e){S.Deferred.exceptionHook&&S.Deferred.exceptionHook(e,t.stackTrace),u<=i+1&&(a!==M&&(n=void 0,r=[e]),o.rejectWith(n,r))}};i?t():(S.Deferred.getStackHook&&(t.stackTrace=S.Deferred.getStackHook()),C.setTimeout(t))}}return S.Deferred(function(e){o[0][3].add(l(0,e,m(r)?r:R,e.notifyWith)),o[1][3].add(l(0,e,m(t)?t:R)),o[2][3].add(l(0,e,m(n)?n:M))}).promise()},promise:function(e){return null!=e?S.extend(e,a):a}},s={};return S.each(o,function(e,t){var n=t[2],r=t[5];a[t[1]]=n.add,r&&n.add(function(){i=r},o[3-e][2].disable,o[3-e][3].disable,o[0][2].lock,o[0][3].lock),n.add(t[3].fire),s[t[0]]=function(){return s[t[0]+"With"](this===s?void 0:this,arguments),this},s[t[0]+"With"]=n.fireWith}),a.promise(s),e&&e.call(s,s),s},when:function(e){var n=arguments.length,t=n,r=Array(t),i=s.call(arguments),o=S.Deferred(),a=function(t){return function(e){r[t]=this,i[t]=1<arguments.length?s.call(arguments):e,--n||o.resolveWith(r,i)}};if(n<=1&&(I(e,o.done(a(t)).resolve,o.reject,!n),"pending"===o.state()||m(i[t]&&i[t].then)))return o.then();while(t--)I(i[t],a(t),o.reject);return o.promise()}});var W=/^(Eval|Internal|Range|Reference|Syntax|Type|URI)Error$/;S.Deferred.exceptionHook=function(e,t){C.console&&C.console.warn&&e&&W.test(e.name)&&C.console.warn("jQuery.Deferred exception: "+e.message,e.stack,t)},S.readyException=function(e){C.setTimeout(function(){throw e})};var F=S.Deferred();function B(){E.removeEventListener("DOMContentLoaded",B),C.removeEventListener("load",B),S.ready()}S.fn.ready=function(e){return F.then(e)["catch"](function(e){S.readyException(e)}),this},S.extend({isReady:!1,readyWait:1,ready:function(e){(!0===e?--S.readyWait:S.isReady)||(S.isReady=!0)!==e&&0<--S.readyWait||F.resolveWith(E,[S])}}),S.ready.then=F.then,"complete"===E.readyState||"loading"!==E.readyState&&!E.documentElement.doScroll?C.setTimeout(S.ready):(E.addEventListener("DOMContentLoaded",B),C.addEventListener("load",B));var $=function(e,t,n,r,i,o,a){var s=0,u=e.length,l=null==n;if("object"===w(n))for(s in i=!0,n)$(e,t,s,n[s],!0,o,a);else if(void 0!==r&&(i=!0,m(r)||(a=!0),l&&(a?(t.call(e,r),t=null):(l=t,t=function(e,t,n){return l.call(S(e),n)})),t))for(;s<u;s++)t(e[s],n,a?r:r.call(e[s],s,t(e[s],n)));return i?e:l?t.call(e):u?t(e[0],n):o},_=/^-ms-/,z=/-([a-z])/g;function U(e,t){return t.toUpperCase()}function X(e){return e.replace(_,"ms-").replace(z,U)}var V=function(e){return 1===e.nodeType||9===e.nodeType||!+e.nodeType};function G(){this.expando=S.expando+G.uid++}G.uid=1,G.prototype={cache:function(e){var t=e[this.expando];return t||(t={},V(e)&&(e.nodeType?e[this.expando]=t:Object.defineProperty(e,this.expando,{value:t,configurable:!0}))),t},set:function(e,t,n){var r,i=this.cache(e);if("string"==typeof t)i[X(t)]=n;else for(r in t)i[X(r)]=t[r];return i},get:function(e,t){return void 0===t?this.cache(e):e[this.expando]&&e[this.expando][X(t)]},access:function(e,t,n){return void 0===t||t&&"string"==typeof t&&void 0===n?this.get(e,t):(this.set(e,t,n),void 0!==n?n:t)},remove:function(e,t){var n,r=e[this.expando];if(void 0!==r){if(void 0!==t){n=(t=Array.isArray(t)?t.map(X):(t=X(t))in r?[t]:t.match(P)||[]).length;while(n--)delete r[t[n]]}(void 0===t||S.isEmptyObject(r))&&(e.nodeType?e[this.expando]=void 0:delete e[this.expando])}},hasData:function(e){var t=e[this.expando];return void 0!==t&&!S.isEmptyObject(t)}};var Y=new G,Q=new G,J=/^(?:\{[\w\W]*\}|\[[\w\W]*\])$/,K=/[A-Z]/g;function Z(e,t,n){var r,i;if(void 0===n&&1===e.nodeType)if(r="data-"+t.replace(K,"-$&").toLowerCase(),"string"==typeof(n=e.getAttribute(r))){try{n="true"===(i=n)||"false"!==i&&("null"===i?null:i===+i+""?+i:J.test(i)?JSON.parse(i):i)}catch(e){}Q.set(e,t,n)}else n=void 0;return n}S.extend({hasData:function(e){return Q.hasData(e)||Y.hasData(e)},data:function(e,t,n){return Q.access(e,t,n)},removeData:function(e,t){Q.remove(e,t)},_data:function(e,t,n){return Y.access(e,t,n)},_removeData:function(e,t){Y.remove(e,t)}}),S.fn.extend({data:function(n,e){var t,r,i,o=this[0],a=o&&o.attributes;if(void 0===n){if(this.length&&(i=Q.get(o),1===o.nodeType&&!Y.get(o,"hasDataAttrs"))){t=a.length;while(t--)a[t]&&0===(r=a[t].name).indexOf("data-")&&(r=X(r.slice(5)),Z(o,r,i[r]));Y.set(o,"hasDataAttrs",!0)}return i}return"object"==typeof n?this.each(function(){Q.set(this,n)}):$(this,function(e){var t;if(o&&void 0===e)return void 0!==(t=Q.get(o,n))?t:void 0!==(t=Z(o,n))?t:void 0;this.each(function(){Q.set(this,n,e)})},null,e,1<arguments.length,null,!0)},removeData:function(e){return this.each(function(){Q.remove(this,e)})}}),S.extend({queue:function(e,t,n){var r;if(e)return t=(t||"fx")+"queue",r=Y.get(e,t),n&&(!r||Array.isArray(n)?r=Y.access(e,t,S.makeArray(n)):r.push(n)),r||[]},dequeue:function(e,t){t=t||"fx";var n=S.queue(e,t),r=n.length,i=n.shift(),o=S._queueHooks(e,t);"inprogress"===i&&(i=n.shift(),r--),i&&("fx"===t&&n.unshift("inprogress"),delete o.stop,i.call(e,function(){S.dequeue(e,t)},o)),!r&&o&&o.empty.fire()},_queueHooks:function(e,t){var n=t+"queueHooks";return Y.get(e,n)||Y.access(e,n,{empty:S.Callbacks("once memory").add(function(){Y.remove(e,[t+"queue",n])})})}}),S.fn.extend({queue:function(t,n){var e=2;return"string"!=typeof t&&(n=t,t="fx",e--),arguments.length<e?S.queue(this[0],t):void 0===n?this:this.each(function(){var e=S.queue(this,t,n);S._queueHooks(this,t),"fx"===t&&"inprogress"!==e[0]&&S.dequeue(this,t)})},dequeue:function(e){return this.each(function(){S.dequeue(this,e)})},clearQueue:function(e){return this.queue(e||"fx",[])},promise:function(e,t){var n,r=1,i=S.Deferred(),o=this,a=this.length,s=function(){--r||i.resolveWith(o,[o])};"string"!=typeof e&&(t=e,e=void 0),e=e||"fx";while(a--)(n=Y.get(o[a],e+"queueHooks"))&&n.empty&&(r++,n.empty.add(s));return s(),i.promise(t)}});var ee=/[+-]?(?:\d*\.|)\d+(?:[eE][+-]?\d+|)/.source,te=new RegExp("^(?:([+-])=|)("+ee+")([a-z%]*)$","i"),ne=["Top","Right","Bottom","Left"],re=E.documentElement,ie=function(e){return S.contains(e.ownerDocument,e)},oe={composed:!0};re.getRootNode&&(ie=function(e){return S.contains(e.ownerDocument,e)||e.getRootNode(oe)===e.ownerDocument});var ae=function(e,t){return"none"===(e=t||e).style.display||""===e.style.display&&ie(e)&&"none"===S.css(e,"display")};function se(e,t,n,r){var i,o,a=20,s=r?function(){return r.cur()}:function(){return S.css(e,t,"")},u=s(),l=n&&n[3]||(S.cssNumber[t]?"":"px"),c=e.nodeType&&(S.cssNumber[t]||"px"!==l&&+u)&&te.exec(S.css(e,t));if(c&&c[3]!==l){u/=2,l=l||c[3],c=+u||1;while(a--)S.style(e,t,c+l),(1-o)*(1-(o=s()/u||.5))<=0&&(a=0),c/=o;c*=2,S.style(e,t,c+l),n=n||[]}return n&&(c=+c||+u||0,i=n[1]?c+(n[1]+1)*n[2]:+n[2],r&&(r.unit=l,r.start=c,r.end=i)),i}var ue={};function le(e,t){for(var n,r,i,o,a,s,u,l=[],c=0,f=e.length;c<f;c++)(r=e[c]).style&&(n=r.style.display,t?("none"===n&&(l[c]=Y.get(r,"display")||null,l[c]||(r.style.display="")),""===r.style.display&&ae(r)&&(l[c]=(u=a=o=void 0,a=(i=r).ownerDocument,s=i.nodeName,(u=ue[s])||(o=a.body.appendChild(a.createElement(s)),u=S.css(o,"display"),o.parentNode.removeChild(o),"none"===u&&(u="block"),ue[s]=u)))):"none"!==n&&(l[c]="none",Y.set(r,"display",n)));for(c=0;c<f;c++)null!=l[c]&&(e[c].style.display=l[c]);return e}S.fn.extend({show:function(){return le(this,!0)},hide:function(){return le(this)},toggle:function(e){return"boolean"==typeof e?e?this.show():this.hide():this.each(function(){ae(this)?S(this).show():S(this).hide()})}});var ce,fe,pe=/^(?:checkbox|radio)$/i,de=/<([a-z][^\/\0> \t\r\n\f]*)/i,he=/^$|^module$|\/(?:java|ecma)script/i;ce=E.createDocumentFragment().appendChild(E.createElement("div")),(fe=E.createElement("input")).setAttribute("type","radio"),fe.setAttribute("checked","checked"),fe.setAttribute("name","t"),ce.appendChild(fe),y.checkClone=ce.cloneNode(!0).cloneNode(!0).lastChild.checked,ce.innerHTML="<textarea>x</textarea>",y.noCloneChecked=!!ce.cloneNode(!0).lastChild.defaultValue,ce.innerHTML="<option></option>",y.option=!!ce.lastChild;var ge={thead:[1,"<table>","</table>"],col:[2,"<table><colgroup>","</colgroup></table>"],tr:[2,"<table><tbody>","</tbody></table>"],td:[3,"<table><tbody><tr>","</tr></tbody></table>"],_default:[0,"",""]};function ve(e,t){var n;return n="undefined"!=typeof e.getElementsByTagName?e.getElementsByTagName(t||"*"):"undefined"!=typeof e.querySelectorAll?e.querySelectorAll(t||"*"):[],void 0===t||t&&A(e,t)?S.merge([e],n):n}function ye(e,t){for(var n=0,r=e.length;n<r;n++)Y.set(e[n],"globalEval",!t||Y.get(t[n],"globalEval"))}ge.tbody=ge.tfoot=ge.colgroup=ge.caption=ge.thead,ge.th=ge.td,y.option||(ge.optgroup=ge.option=[1,"<select multiple='multiple'>","</select>"]);var me=/<|&#?\w+;/;function xe(e,t,n,r,i){for(var o,a,s,u,l,c,f=t.createDocumentFragment(),p=[],d=0,h=e.length;d<h;d++)if((o=e[d])||0===o)if("object"===w(o))S.merge(p,o.nodeType?[o]:o);else if(me.test(o)){a=a||f.appendChild(t.createElement("div")),s=(de.exec(o)||["",""])[1].toLowerCase(),u=ge[s]||ge._default,a.innerHTML=u[1]+S.htmlPrefilter(o)+u[2],c=u[0];while(c--)a=a.lastChild;S.merge(p,a.childNodes),(a=f.firstChild).textContent=""}else p.push(t.createTextNode(o));f.textContent="",d=0;while(o=p[d++])if(r&&-1<S.inArray(o,r))i&&i.push(o);else if(l=ie(o),a=ve(f.appendChild(o),"script"),l&&ye(a),n){c=0;while(o=a[c++])he.test(o.type||"")&&n.push(o)}return f}var be=/^([^.]*)(?:\.(.+)|)/;function we(){return!0}function Te(){return!1}function Ce(e,t){return e===function(){try{return E.activeElement}catch(e){}}()==("focus"===t)}function Ee(e,t,n,r,i,o){var a,s;if("object"==typeof t){for(s in"string"!=typeof n&&(r=r||n,n=void 0),t)Ee(e,s,n,r,t[s],o);return e}if(null==r&&null==i?(i=n,r=n=void 0):null==i&&("string"==typeof n?(i=r,r=void 0):(i=r,r=n,n=void 0)),!1===i)i=Te;else if(!i)return e;return 1===o&&(a=i,(i=function(e){return S().off(e),a.apply(this,arguments)}).guid=a.guid||(a.guid=S.guid++)),e.each(function(){S.event.add(this,t,i,r,n)})}function Se(e,i,o){o?(Y.set(e,i,!1),S.event.add(e,i,{namespace:!1,handler:function(e){var t,n,r=Y.get(this,i);if(1&e.isTrigger&&this[i]){if(r.length)(S.event.special[i]||{}).delegateType&&e.stopPropagation();else if(r=s.call(arguments),Y.set(this,i,r),t=o(this,i),this[i](),r!==(n=Y.get(this,i))||t?Y.set(this,i,!1):n={},r!==n)return e.stopImmediatePropagation(),e.preventDefault(),n&&n.value}else r.length&&(Y.set(this,i,{value:S.event.trigger(S.extend(r[0],S.Event.prototype),r.slice(1),this)}),e.stopImmediatePropagation())}})):void 0===Y.get(e,i)&&S.event.add(e,i,we)}S.event={global:{},add:function(t,e,n,r,i){var o,a,s,u,l,c,f,p,d,h,g,v=Y.get(t);if(V(t)){n.handler&&(n=(o=n).handler,i=o.selector),i&&S.find.matchesSelector(re,i),n.guid||(n.guid=S.guid++),(u=v.events)||(u=v.events=Object.create(null)),(a=v.handle)||(a=v.handle=function(e){return"undefined"!=typeof S&&S.event.triggered!==e.type?S.event.dispatch.apply(t,arguments):void 0}),l=(e=(e||"").match(P)||[""]).length;while(l--)d=g=(s=be.exec(e[l])||[])[1],h=(s[2]||"").split(".").sort(),d&&(f=S.event.special[d]||{},d=(i?f.delegateType:f.bindType)||d,f=S.event.special[d]||{},c=S.extend({type:d,origType:g,data:r,handler:n,guid:n.guid,selector:i,needsContext:i&&S.expr.match.needsContext.test(i),namespace:h.join(".")},o),(p=u[d])||((p=u[d]=[]).delegateCount=0,f.setup&&!1!==f.setup.call(t,r,h,a)||t.addEventListener&&t.addEventListener(d,a)),f.add&&(f.add.call(t,c),c.handler.guid||(c.handler.guid=n.guid)),i?p.splice(p.delegateCount++,0,c):p.push(c),S.event.global[d]=!0)}},remove:function(e,t,n,r,i){var o,a,s,u,l,c,f,p,d,h,g,v=Y.hasData(e)&&Y.get(e);if(v&&(u=v.events)){l=(t=(t||"").match(P)||[""]).length;while(l--)if(d=g=(s=be.exec(t[l])||[])[1],h=(s[2]||"").split(".").sort(),d){f=S.event.special[d]||{},p=u[d=(r?f.delegateType:f.bindType)||d]||[],s=s[2]&&new RegExp("(^|\\.)"+h.join("\\.(?:.*\\.|)")+"(\\.|$)"),a=o=p.length;while(o--)c=p[o],!i&&g!==c.origType||n&&n.guid!==c.guid||s&&!s.test(c.namespace)||r&&r!==c.selector&&("**"!==r||!c.selector)||(p.splice(o,1),c.selector&&p.delegateCount--,f.remove&&f.remove.call(e,c));a&&!p.length&&(f.teardown&&!1!==f.teardown.call(e,h,v.handle)||S.removeEvent(e,d,v.handle),delete u[d])}else for(d in u)S.event.remove(e,d+t[l],n,r,!0);S.isEmptyObject(u)&&Y.remove(e,"handle events")}},dispatch:function(e){var t,n,r,i,o,a,s=new Array(arguments.length),u=S.event.fix(e),l=(Y.get(this,"events")||Object.create(null))[u.type]||[],c=S.event.special[u.type]||{};for(s[0]=u,t=1;t<arguments.length;t++)s[t]=arguments[t];if(u.delegateTarget=this,!c.preDispatch||!1!==c.preDispatch.call(this,u)){a=S.event.handlers.call(this,u,l),t=0;while((i=a[t++])&&!u.isPropagationStopped()){u.currentTarget=i.elem,n=0;while((o=i.handlers[n++])&&!u.isImmediatePropagationStopped())u.rnamespace&&!1!==o.namespace&&!u.rnamespace.test(o.namespace)||(u.handleObj=o,u.data=o.data,void 0!==(r=((S.event.special[o.origType]||{}).handle||o.handler).apply(i.elem,s))&&!1===(u.result=r)&&(u.preventDefault(),u.stopPropagation()))}return c.postDispatch&&c.postDispatch.call(this,u),u.result}},handlers:function(e,t){var n,r,i,o,a,s=[],u=t.delegateCount,l=e.target;if(u&&l.nodeType&&!("click"===e.type&&1<=e.button))for(;l!==this;l=l.parentNode||this)if(1===l.nodeType&&("click"!==e.type||!0!==l.disabled)){for(o=[],a={},n=0;n<u;n++)void 0===a[i=(r=t[n]).selector+" "]&&(a[i]=r.needsContext?-1<S(i,this).index(l):S.find(i,this,null,[l]).length),a[i]&&o.push(r);o.length&&s.push({elem:l,handlers:o})}return l=this,u<t.length&&s.push({elem:l,handlers:t.slice(u)}),s},addProp:function(t,e){Object.defineProperty(S.Event.prototype,t,{enumerable:!0,configurable:!0,get:m(e)?function(){if(this.originalEvent)return e(this.originalEvent)}:function(){if(this.originalEvent)return this.originalEvent[t]},set:function(e){Object.defineProperty(this,t,{enumerable:!0,configurable:!0,writable:!0,value:e})}})},fix:function(e){return e[S.expando]?e:new S.Event(e)},special:{load:{noBubble:!0},click:{setup:function(e){var t=this||e;return pe.test(t.type)&&t.click&&A(t,"input")&&Se(t,"click",we),!1},trigger:function(e){var t=this||e;return pe.test(t.type)&&t.click&&A(t,"input")&&Se(t,"click"),!0},_default:function(e){var t=e.target;return pe.test(t.type)&&t.click&&A(t,"input")&&Y.get(t,"click")||A(t,"a")}},beforeunload:{postDispatch:function(e){void 0!==e.result&&e.originalEvent&&(e.originalEvent.returnValue=e.result)}}}},S.removeEvent=function(e,t,n){e.removeEventListener&&e.removeEventListener(t,n)},S.Event=function(e,t){if(!(this instanceof S.Event))return new S.Event(e,t);e&&e.type?(this.originalEvent=e,this.type=e.type,this.isDefaultPrevented=e.defaultPrevented||void 0===e.defaultPrevented&&!1===e.returnValue?we:Te,this.target=e.target&&3===e.target.nodeType?e.target.parentNode:e.target,this.currentTarget=e.currentTarget,this.relatedTarget=e.relatedTarget):this.type=e,t&&S.extend(this,t),this.timeStamp=e&&e.timeStamp||Date.now(),this[S.expando]=!0},S.Event.prototype={constructor:S.Event,isDefaultPrevented:Te,isPropagationStopped:Te,isImmediatePropagationStopped:Te,isSimulated:!1,preventDefault:function(){var e=this.originalEvent;this.isDefaultPrevented=we,e&&!this.isSimulated&&e.preventDefault()},stopPropagation:function(){var e=this.originalEvent;this.isPropagationStopped=we,e&&!this.isSimulated&&e.stopPropagation()},stopImmediatePropagation:function(){var e=this.originalEvent;this.isImmediatePropagationStopped=we,e&&!this.isSimulated&&e.stopImmediatePropagation(),this.stopPropagation()}},S.each({altKey:!0,bubbles:!0,cancelable:!0,changedTouches:!0,ctrlKey:!0,detail:!0,eventPhase:!0,metaKey:!0,pageX:!0,pageY:!0,shiftKey:!0,view:!0,"char":!0,code:!0,charCode:!0,key:!0,keyCode:!0,button:!0,buttons:!0,clientX:!0,clientY:!0,offsetX:!0,offsetY:!0,pointerId:!0,pointerType:!0,screenX:!0,screenY:!0,targetTouches:!0,toElement:!0,touches:!0,which:!0},S.event.addProp),S.each({focus:"focusin",blur:"focusout"},function(e,t){S.event.special[e]={setup:function(){return Se(this,e,Ce),!1},trigger:function(){return Se(this,e),!0},_default:function(){return!0},delegateType:t}}),S.each({mouseenter:"mouseover",mouseleave:"mouseout",pointerenter:"pointerover",pointerleave:"pointerout"},function(e,i){S.event.special[e]={delegateType:i,bindType:i,handle:function(e){var t,n=e.relatedTarget,r=e.handleObj;return n&&(n===this||S.contains(this,n))||(e.type=r.origType,t=r.handler.apply(this,arguments),e.type=i),t}}}),S.fn.extend({on:function(e,t,n,r){return Ee(this,e,t,n,r)},one:function(e,t,n,r){return Ee(this,e,t,n,r,1)},off:function(e,t,n){var r,i;if(e&&e.preventDefault&&e.handleObj)return r=e.handleObj,S(e.delegateTarget).off(r.namespace?r.origType+"."+r.namespace:r.origType,r.selector,r.handler),this;if("object"==typeof e){for(i in e)this.off(i,t,e[i]);return this}return!1!==t&&"function"!=typeof t||(n=t,t=void 0),!1===n&&(n=Te),this.each(function(){S.event.remove(this,e,n,t)})}});var ke=/<script|<style|<link/i,Ae=/checked\s*(?:[^=]|=\s*.checked.)/i,Ne=/^\s*<!(?:\[CDATA\[|--)|(?:\]\]|--)>\s*$/g;function je(e,t){return A(e,"table")&&A(11!==t.nodeType?t:t.firstChild,"tr")&&S(e).children("tbody")[0]||e}function De(e){return e.type=(null!==e.getAttribute("type"))+"/"+e.type,e}function qe(e){return"true/"===(e.type||"").slice(0,5)?e.type=e.type.slice(5):e.removeAttribute("type"),e}function Le(e,t){var n,r,i,o,a,s;if(1===t.nodeType){if(Y.hasData(e)&&(s=Y.get(e).events))for(i in Y.remove(t,"handle events"),s)for(n=0,r=s[i].length;n<r;n++)S.event.add(t,i,s[i][n]);Q.hasData(e)&&(o=Q.access(e),a=S.extend({},o),Q.set(t,a))}}function He(n,r,i,o){r=g(r);var e,t,a,s,u,l,c=0,f=n.length,p=f-1,d=r[0],h=m(d);if(h||1<f&&"string"==typeof d&&!y.checkClone&&Ae.test(d))return n.each(function(e){var t=n.eq(e);h&&(r[0]=d.call(this,e,t.html())),He(t,r,i,o)});if(f&&(t=(e=xe(r,n[0].ownerDocument,!1,n,o)).firstChild,1===e.childNodes.length&&(e=t),t||o)){for(s=(a=S.map(ve(e,"script"),De)).length;c<f;c++)u=e,c!==p&&(u=S.clone(u,!0,!0),s&&S.merge(a,ve(u,"script"))),i.call(n[c],u,c);if(s)for(l=a[a.length-1].ownerDocument,S.map(a,qe),c=0;c<s;c++)u=a[c],he.test(u.type||"")&&!Y.access(u,"globalEval")&&S.contains(l,u)&&(u.src&&"module"!==(u.type||"").toLowerCase()?S._evalUrl&&!u.noModule&&S._evalUrl(u.src,{nonce:u.nonce||u.getAttribute("nonce")},l):b(u.textContent.replace(Ne,""),u,l))}return n}function Oe(e,t,n){for(var r,i=t?S.filter(t,e):e,o=0;null!=(r=i[o]);o++)n||1!==r.nodeType||S.cleanData(ve(r)),r.parentNode&&(n&&ie(r)&&ye(ve(r,"script")),r.parentNode.removeChild(r));return e}S.extend({htmlPrefilter:function(e){return e},clone:function(e,t,n){var r,i,o,a,s,u,l,c=e.cloneNode(!0),f=ie(e);if(!(y.noCloneChecked||1!==e.nodeType&&11!==e.nodeType||S.isXMLDoc(e)))for(a=ve(c),r=0,i=(o=ve(e)).length;r<i;r++)s=o[r],u=a[r],void 0,"input"===(l=u.nodeName.toLowerCase())&&pe.test(s.type)?u.checked=s.checked:"input"!==l&&"textarea"!==l||(u.defaultValue=s.defaultValue);if(t)if(n)for(o=o||ve(e),a=a||ve(c),r=0,i=o.length;r<i;r++)Le(o[r],a[r]);else Le(e,c);return 0<(a=ve(c,"script")).length&&ye(a,!f&&ve(e,"script")),c},cleanData:function(e){for(var t,n,r,i=S.event.special,o=0;void 0!==(n=e[o]);o++)if(V(n)){if(t=n[Y.expando]){if(t.events)for(r in t.events)i[r]?S.event.remove(n,r):S.removeEvent(n,r,t.handle);n[Y.expando]=void 0}n[Q.expando]&&(n[Q.expando]=void 0)}}}),S.fn.extend({detach:function(e){return Oe(this,e,!0)},remove:function(e){return Oe(this,e)},text:function(e){return $(this,function(e){return void 0===e?S.text(this):this.empty().each(function(){1!==this.nodeType&&11!==this.nodeType&&9!==this.nodeType||(this.textContent=e)})},null,e,arguments.length)},append:function(){return He(this,arguments,function(e){1!==this.nodeType&&11!==this.nodeType&&9!==this.nodeType||je(this,e).appendChild(e)})},prepend:function(){return He(this,arguments,function(e){if(1===this.nodeType||11===this.nodeType||9===this.nodeType){var t=je(this,e);t.insertBefore(e,t.firstChild)}})},before:function(){return He(this,arguments,function(e){this.parentNode&&this.parentNode.insertBefore(e,this)})},after:function(){return He(this,arguments,function(e){this.parentNode&&this.parentNode.insertBefore(e,this.nextSibling)})},empty:function(){for(var e,t=0;null!=(e=this[t]);t++)1===e.nodeType&&(S.cleanData(ve(e,!1)),e.textContent="");return this},clone:function(e,t){return e=null!=e&&e,t=null==t?e:t,this.map(function(){return S.clone(this,e,t)})},html:function(e){return $(this,function(e){var t=this[0]||{},n=0,r=this.length;if(void 0===e&&1===t.nodeType)return t.innerHTML;if("string"==typeof e&&!ke.test(e)&&!ge[(de.exec(e)||["",""])[1].toLowerCase()]){e=S.htmlPrefilter(e);try{for(;n<r;n++)1===(t=this[n]||{}).nodeType&&(S.cleanData(ve(t,!1)),t.innerHTML=e);t=0}catch(e){}}t&&this.empty().append(e)},null,e,arguments.length)},replaceWith:function(){var n=[];return He(this,arguments,function(e){var t=this.parentNode;S.inArray(this,n)<0&&(S.cleanData(ve(this)),t&&t.replaceChild(e,this))},n)}}),S.each({appendTo:"append",prependTo:"prepend",insertBefore:"before",insertAfter:"after",replaceAll:"replaceWith"},function(e,a){S.fn[e]=function(e){for(var t,n=[],r=S(e),i=r.length-1,o=0;o<=i;o++)t=o===i?this:this.clone(!0),S(r[o])[a](t),u.apply(n,t.get());return this.pushStack(n)}});var Pe=new RegExp("^("+ee+")(?!px)[a-z%]+$","i"),Re=function(e){var t=e.ownerDocument.defaultView;return t&&t.opener||(t=C),t.getComputedStyle(e)},Me=function(e,t,n){var r,i,o={};for(i in t)o[i]=e.style[i],e.style[i]=t[i];for(i in r=n.call(e),t)e.style[i]=o[i];return r},Ie=new RegExp(ne.join("|"),"i");function We(e,t,n){var r,i,o,a,s=e.style;return(n=n||Re(e))&&(""!==(a=n.getPropertyValue(t)||n[t])||ie(e)||(a=S.style(e,t)),!y.pixelBoxStyles()&&Pe.test(a)&&Ie.test(t)&&(r=s.width,i=s.minWidth,o=s.maxWidth,s.minWidth=s.maxWidth=s.width=a,a=n.width,s.width=r,s.minWidth=i,s.maxWidth=o)),void 0!==a?a+"":a}function Fe(e,t){return{get:function(){if(!e())return(this.get=t).apply(this,arguments);delete this.get}}}!function(){function e(){if(l){u.style.cssText="position:absolute;left:-11111px;width:60px;margin-top:1px;padding:0;border:0",l.style.cssText="position:relative;display:block;box-sizing:border-box;overflow:scroll;margin:auto;border:1px;padding:1px;width:60%;top:1%",re.appendChild(u).appendChild(l);var e=C.getComputedStyle(l);n="1%"!==e.top,s=12===t(e.marginLeft),l.style.right="60%",o=36===t(e.right),r=36===t(e.width),l.style.position="absolute",i=12===t(l.offsetWidth/3),re.removeChild(u),l=null}}function t(e){return Math.round(parseFloat(e))}var n,r,i,o,a,s,u=E.createElement("div"),l=E.createElement("div");l.style&&(l.style.backgroundClip="content-box",l.cloneNode(!0).style.backgroundClip="",y.clearCloneStyle="content-box"===l.style.backgroundClip,S.extend(y,{boxSizingReliable:function(){return e(),r},pixelBoxStyles:function(){return e(),o},pixelPosition:function(){return e(),n},reliableMarginLeft:function(){return e(),s},scrollboxSize:function(){return e(),i},reliableTrDimensions:function(){var e,t,n,r;return null==a&&(e=E.createElement("table"),t=E.createElement("tr"),n=E.createElement("div"),e.style.cssText="position:absolute;left:-11111px;border-collapse:separate",t.style.cssText="border:1px solid",t.style.height="1px",n.style.height="9px",n.style.display="block",re.appendChild(e).appendChild(t).appendChild(n),r=C.getComputedStyle(t),a=parseInt(r.height,10)+parseInt(r.borderTopWidth,10)+parseInt(r.borderBottomWidth,10)===t.offsetHeight,re.removeChild(e)),a}}))}();var Be=["Webkit","Moz","ms"],$e=E.createElement("div").style,_e={};function ze(e){var t=S.cssProps[e]||_e[e];return t||(e in $e?e:_e[e]=function(e){var t=e[0].toUpperCase()+e.slice(1),n=Be.length;while(n--)if((e=Be[n]+t)in $e)return e}(e)||e)}var Ue=/^(none|table(?!-c[ea]).+)/,Xe=/^--/,Ve={position:"absolute",visibility:"hidden",display:"block"},Ge={letterSpacing:"0",fontWeight:"400"};function Ye(e,t,n){var r=te.exec(t);return r?Math.max(0,r[2]-(n||0))+(r[3]||"px"):t}function Qe(e,t,n,r,i,o){var a="width"===t?1:0,s=0,u=0;if(n===(r?"border":"content"))return 0;for(;a<4;a+=2)"margin"===n&&(u+=S.css(e,n+ne[a],!0,i)),r?("content"===n&&(u-=S.css(e,"padding"+ne[a],!0,i)),"margin"!==n&&(u-=S.css(e,"border"+ne[a]+"Width",!0,i))):(u+=S.css(e,"padding"+ne[a],!0,i),"padding"!==n?u+=S.css(e,"border"+ne[a]+"Width",!0,i):s+=S.css(e,"border"+ne[a]+"Width",!0,i));return!r&&0<=o&&(u+=Math.max(0,Math.ceil(e["offset"+t[0].toUpperCase()+t.slice(1)]-o-u-s-.5))||0),u}function Je(e,t,n){var r=Re(e),i=(!y.boxSizingReliable()||n)&&"border-box"===S.css(e,"boxSizing",!1,r),o=i,a=We(e,t,r),s="offset"+t[0].toUpperCase()+t.slice(1);if(Pe.test(a)){if(!n)return a;a="auto"}return(!y.boxSizingReliable()&&i||!y.reliableTrDimensions()&&A(e,"tr")||"auto"===a||!parseFloat(a)&&"inline"===S.css(e,"display",!1,r))&&e.getClientRects().length&&(i="border-box"===S.css(e,"boxSizing",!1,r),(o=s in e)&&(a=e[s])),(a=parseFloat(a)||0)+Qe(e,t,n||(i?"border":"content"),o,r,a)+"px"}function Ke(e,t,n,r,i){return new Ke.prototype.init(e,t,n,r,i)}S.extend({cssHooks:{opacity:{get:function(e,t){if(t){var n=We(e,"opacity");return""===n?"1":n}}}},cssNumber:{animationIterationCount:!0,columnCount:!0,fillOpacity:!0,flexGrow:!0,flexShrink:!0,fontWeight:!0,gridArea:!0,gridColumn:!0,gridColumnEnd:!0,gridColumnStart:!0,gridRow:!0,gridRowEnd:!0,gridRowStart:!0,lineHeight:!0,opacity:!0,order:!0,orphans:!0,widows:!0,zIndex:!0,zoom:!0},cssProps:{},style:function(e,t,n,r){if(e&&3!==e.nodeType&&8!==e.nodeType&&e.style){var i,o,a,s=X(t),u=Xe.test(t),l=e.style;if(u||(t=ze(s)),a=S.cssHooks[t]||S.cssHooks[s],void 0===n)return a&&"get"in a&&void 0!==(i=a.get(e,!1,r))?i:l[t];"string"===(o=typeof n)&&(i=te.exec(n))&&i[1]&&(n=se(e,t,i),o="number"),null!=n&&n==n&&("number"!==o||u||(n+=i&&i[3]||(S.cssNumber[s]?"":"px")),y.clearCloneStyle||""!==n||0!==t.indexOf("background")||(l[t]="inherit"),a&&"set"in a&&void 0===(n=a.set(e,n,r))||(u?l.setProperty(t,n):l[t]=n))}},css:function(e,t,n,r){var i,o,a,s=X(t);return Xe.test(t)||(t=ze(s)),(a=S.cssHooks[t]||S.cssHooks[s])&&"get"in a&&(i=a.get(e,!0,n)),void 0===i&&(i=We(e,t,r)),"normal"===i&&t in Ge&&(i=Ge[t]),""===n||n?(o=parseFloat(i),!0===n||isFinite(o)?o||0:i):i}}),S.each(["height","width"],function(e,u){S.cssHooks[u]={get:function(e,t,n){if(t)return!Ue.test(S.css(e,"display"))||e.getClientRects().length&&e.getBoundingClientRect().width?Je(e,u,n):Me(e,Ve,function(){return Je(e,u,n)})},set:function(e,t,n){var r,i=Re(e),o=!y.scrollboxSize()&&"absolute"===i.position,a=(o||n)&&"border-box"===S.css(e,"boxSizing",!1,i),s=n?Qe(e,u,n,a,i):0;return a&&o&&(s-=Math.ceil(e["offset"+u[0].toUpperCase()+u.slice(1)]-parseFloat(i[u])-Qe(e,u,"border",!1,i)-.5)),s&&(r=te.exec(t))&&"px"!==(r[3]||"px")&&(e.style[u]=t,t=S.css(e,u)),Ye(0,t,s)}}}),S.cssHooks.marginLeft=Fe(y.reliableMarginLeft,function(e,t){if(t)return(parseFloat(We(e,"marginLeft"))||e.getBoundingClientRect().left-Me(e,{marginLeft:0},function(){return e.getBoundingClientRect().left}))+"px"}),S.each({margin:"",padding:"",border:"Width"},function(i,o){S.cssHooks[i+o]={expand:function(e){for(var t=0,n={},r="string"==typeof e?e.split(" "):[e];t<4;t++)n[i+ne[t]+o]=r[t]||r[t-2]||r[0];return n}},"margin"!==i&&(S.cssHooks[i+o].set=Ye)}),S.fn.extend({css:function(e,t){return $(this,function(e,t,n){var r,i,o={},a=0;if(Array.isArray(t)){for(r=Re(e),i=t.length;a<i;a++)o[t[a]]=S.css(e,t[a],!1,r);return o}return void 0!==n?S.style(e,t,n):S.css(e,t)},e,t,1<arguments.length)}}),((S.Tween=Ke).prototype={constructor:Ke,init:function(e,t,n,r,i,o){this.elem=e,this.prop=n,this.easing=i||S.easing._default,this.options=t,this.start=this.now=this.cur(),this.end=r,this.unit=o||(S.cssNumber[n]?"":"px")},cur:function(){var e=Ke.propHooks[this.prop];return e&&e.get?e.get(this):Ke.propHooks._default.get(this)},run:function(e){var t,n=Ke.propHooks[this.prop];return this.options.duration?this.pos=t=S.easing[this.easing](e,this.options.duration*e,0,1,this.options.duration):this.pos=t=e,this.now=(this.end-this.start)*t+this.start,this.options.step&&this.options.step.call(this.elem,this.now,this),n&&n.set?n.set(this):Ke.propHooks._default.set(this),this}}).init.prototype=Ke.prototype,(Ke.propHooks={_default:{get:function(e){var t;return 1!==e.elem.nodeType||null!=e.elem[e.prop]&&null==e.elem.style[e.prop]?e.elem[e.prop]:(t=S.css(e.elem,e.prop,""))&&"auto"!==t?t:0},set:function(e){S.fx.step[e.prop]?S.fx.step[e.prop](e):1!==e.elem.nodeType||!S.cssHooks[e.prop]&&null==e.elem.style[ze(e.prop)]?e.elem[e.prop]=e.now:S.style(e.elem,e.prop,e.now+e.unit)}}}).scrollTop=Ke.propHooks.scrollLeft={set:function(e){e.elem.nodeType&&e.elem.parentNode&&(e.elem[e.prop]=e.now)}},S.easing={linear:function(e){return e},swing:function(e){return.5-Math.cos(e*Math.PI)/2},_default:"swing"},S.fx=Ke.prototype.init,S.fx.step={};var Ze,et,tt,nt,rt=/^(?:toggle|show|hide)$/,it=/queueHooks$/;function ot(){et&&(!1===E.hidden&&C.requestAnimationFrame?C.requestAnimationFrame(ot):C.setTimeout(ot,S.fx.interval),S.fx.tick())}function at(){return C.setTimeout(function(){Ze=void 0}),Ze=Date.now()}function st(e,t){var n,r=0,i={height:e};for(t=t?1:0;r<4;r+=2-t)i["margin"+(n=ne[r])]=i["padding"+n]=e;return t&&(i.opacity=i.width=e),i}function ut(e,t,n){for(var r,i=(lt.tweeners[t]||[]).concat(lt.tweeners["*"]),o=0,a=i.length;o<a;o++)if(r=i[o].call(n,t,e))return r}function lt(o,e,t){var n,a,r=0,i=lt.prefilters.length,s=S.Deferred().always(function(){delete u.elem}),u=function(){if(a)return!1;for(var e=Ze||at(),t=Math.max(0,l.startTime+l.duration-e),n=1-(t/l.duration||0),r=0,i=l.tweens.length;r<i;r++)l.tweens[r].run(n);return s.notifyWith(o,[l,n,t]),n<1&&i?t:(i||s.notifyWith(o,[l,1,0]),s.resolveWith(o,[l]),!1)},l=s.promise({elem:o,props:S.extend({},e),opts:S.extend(!0,{specialEasing:{},easing:S.easing._default},t),originalProperties:e,originalOptions:t,startTime:Ze||at(),duration:t.duration,tweens:[],createTween:function(e,t){var n=S.Tween(o,l.opts,e,t,l.opts.specialEasing[e]||l.opts.easing);return l.tweens.push(n),n},stop:function(e){var t=0,n=e?l.tweens.length:0;if(a)return this;for(a=!0;t<n;t++)l.tweens[t].run(1);return e?(s.notifyWith(o,[l,1,0]),s.resolveWith(o,[l,e])):s.rejectWith(o,[l,e]),this}}),c=l.props;for(!function(e,t){var n,r,i,o,a;for(n in e)if(i=t[r=X(n)],o=e[n],Array.isArray(o)&&(i=o[1],o=e[n]=o[0]),n!==r&&(e[r]=o,delete e[n]),(a=S.cssHooks[r])&&"expand"in a)for(n in o=a.expand(o),delete e[r],o)n in e||(e[n]=o[n],t[n]=i);else t[r]=i}(c,l.opts.specialEasing);r<i;r++)if(n=lt.prefilters[r].call(l,o,c,l.opts))return m(n.stop)&&(S._queueHooks(l.elem,l.opts.queue).stop=n.stop.bind(n)),n;return S.map(c,ut,l),m(l.opts.start)&&l.opts.start.call(o,l),l.progress(l.opts.progress).done(l.opts.done,l.opts.complete).fail(l.opts.fail).always(l.opts.always),S.fx.timer(S.extend(u,{elem:o,anim:l,queue:l.opts.queue})),l}S.Animation=S.extend(lt,{tweeners:{"*":[function(e,t){var n=this.createTween(e,t);return se(n.elem,e,te.exec(t),n),n}]},tweener:function(e,t){m(e)?(t=e,e=["*"]):e=e.match(P);for(var n,r=0,i=e.length;r<i;r++)n=e[r],lt.tweeners[n]=lt.tweeners[n]||[],lt.tweeners[n].unshift(t)},prefilters:[function(e,t,n){var r,i,o,a,s,u,l,c,f="width"in t||"height"in t,p=this,d={},h=e.style,g=e.nodeType&&ae(e),v=Y.get(e,"fxshow");for(r in n.queue||(null==(a=S._queueHooks(e,"fx")).unqueued&&(a.unqueued=0,s=a.empty.fire,a.empty.fire=function(){a.unqueued||s()}),a.unqueued++,p.always(function(){p.always(function(){a.unqueued--,S.queue(e,"fx").length||a.empty.fire()})})),t)if(i=t[r],rt.test(i)){if(delete t[r],o=o||"toggle"===i,i===(g?"hide":"show")){if("show"!==i||!v||void 0===v[r])continue;g=!0}d[r]=v&&v[r]||S.style(e,r)}if((u=!S.isEmptyObject(t))||!S.isEmptyObject(d))for(r in f&&1===e.nodeType&&(n.overflow=[h.overflow,h.overflowX,h.overflowY],null==(l=v&&v.display)&&(l=Y.get(e,"display")),"none"===(c=S.css(e,"display"))&&(l?c=l:(le([e],!0),l=e.style.display||l,c=S.css(e,"display"),le([e]))),("inline"===c||"inline-block"===c&&null!=l)&&"none"===S.css(e,"float")&&(u||(p.done(function(){h.display=l}),null==l&&(c=h.display,l="none"===c?"":c)),h.display="inline-block")),n.overflow&&(h.overflow="hidden",p.always(function(){h.overflow=n.overflow[0],h.overflowX=n.overflow[1],h.overflowY=n.overflow[2]})),u=!1,d)u||(v?"hidden"in v&&(g=v.hidden):v=Y.access(e,"fxshow",{display:l}),o&&(v.hidden=!g),g&&le([e],!0),p.done(function(){for(r in g||le([e]),Y.remove(e,"fxshow"),d)S.style(e,r,d[r])})),u=ut(g?v[r]:0,r,p),r in v||(v[r]=u.start,g&&(u.end=u.start,u.start=0))}],prefilter:function(e,t){t?lt.prefilters.unshift(e):lt.prefilters.push(e)}}),S.speed=function(e,t,n){var r=e&&"object"==typeof e?S.extend({},e):{complete:n||!n&&t||m(e)&&e,duration:e,easing:n&&t||t&&!m(t)&&t};return S.fx.off?r.duration=0:"number"!=typeof r.duration&&(r.duration in S.fx.speeds?r.duration=S.fx.speeds[r.duration]:r.duration=S.fx.speeds._default),null!=r.queue&&!0!==r.queue||(r.queue="fx"),r.old=r.complete,r.complete=function(){m(r.old)&&r.old.call(this),r.queue&&S.dequeue(this,r.queue)},r},S.fn.extend({fadeTo:function(e,t,n,r){return this.filter(ae).css("opacity",0).show().end().animate({opacity:t},e,n,r)},animate:function(t,e,n,r){var i=S.isEmptyObject(t),o=S.speed(e,n,r),a=function(){var e=lt(this,S.extend({},t),o);(i||Y.get(this,"finish"))&&e.stop(!0)};return a.finish=a,i||!1===o.queue?this.each(a):this.queue(o.queue,a)},stop:function(i,e,o){var a=function(e){var t=e.stop;delete e.stop,t(o)};return"string"!=typeof i&&(o=e,e=i,i=void 0),e&&this.queue(i||"fx",[]),this.each(function(){var e=!0,t=null!=i&&i+"queueHooks",n=S.timers,r=Y.get(this);if(t)r[t]&&r[t].stop&&a(r[t]);else for(t in r)r[t]&&r[t].stop&&it.test(t)&&a(r[t]);for(t=n.length;t--;)n[t].elem!==this||null!=i&&n[t].queue!==i||(n[t].anim.stop(o),e=!1,n.splice(t,1));!e&&o||S.dequeue(this,i)})},finish:function(a){return!1!==a&&(a=a||"fx"),this.each(function(){var e,t=Y.get(this),n=t[a+"queue"],r=t[a+"queueHooks"],i=S.timers,o=n?n.length:0;for(t.finish=!0,S.queue(this,a,[]),r&&r.stop&&r.stop.call(this,!0),e=i.length;e--;)i[e].elem===this&&i[e].queue===a&&(i[e].anim.stop(!0),i.splice(e,1));for(e=0;e<o;e++)n[e]&&n[e].finish&&n[e].finish.call(this);delete t.finish})}}),S.each(["toggle","show","hide"],function(e,r){var i=S.fn[r];S.fn[r]=function(e,t,n){return null==e||"boolean"==typeof e?i.apply(this,arguments):this.animate(st(r,!0),e,t,n)}}),S.each({slideDown:st("show"),slideUp:st("hide"),slideToggle:st("toggle"),fadeIn:{opacity:"show"},fadeOut:{opacity:"hide"},fadeToggle:{opacity:"toggle"}},function(e,r){S.fn[e]=function(e,t,n){return this.animate(r,e,t,n)}}),S.timers=[],S.fx.tick=function(){var e,t=0,n=S.timers;for(Ze=Date.now();t<n.length;t++)(e=n[t])()||n[t]!==e||n.splice(t--,1);n.length||S.fx.stop(),Ze=void 0},S.fx.timer=function(e){S.timers.push(e),S.fx.start()},S.fx.interval=13,S.fx.start=function(){et||(et=!0,ot())},S.fx.stop=function(){et=null},S.fx.speeds={slow:600,fast:200,_default:400},S.fn.delay=function(r,e){return r=S.fx&&S.fx.speeds[r]||r,e=e||"fx",this.queue(e,function(e,t){var n=C.setTimeout(e,r);t.stop=function(){C.clearTimeout(n)}})},tt=E.createElement("input"),nt=E.createElement("select").appendChild(E.createElement("option")),tt.type="checkbox",y.checkOn=""!==tt.value,y.optSelected=nt.selected,(tt=E.createElement("input")).value="t",tt.type="radio",y.radioValue="t"===tt.value;var ct,ft=S.expr.attrHandle;S.fn.extend({attr:function(e,t){return $(this,S.attr,e,t,1<arguments.length)},removeAttr:function(e){return this.each(function(){S.removeAttr(this,e)})}}),S.extend({attr:function(e,t,n){var r,i,o=e.nodeType;if(3!==o&&8!==o&&2!==o)return"undefined"==typeof e.getAttribute?S.prop(e,t,n):(1===o&&S.isXMLDoc(e)||(i=S.attrHooks[t.toLowerCase()]||(S.expr.match.bool.test(t)?ct:void 0)),void 0!==n?null===n?void S.removeAttr(e,t):i&&"set"in i&&void 0!==(r=i.set(e,n,t))?r:(e.setAttribute(t,n+""),n):i&&"get"in i&&null!==(r=i.get(e,t))?r:null==(r=S.find.attr(e,t))?void 0:r)},attrHooks:{type:{set:function(e,t){if(!y.radioValue&&"radio"===t&&A(e,"input")){var n=e.value;return e.setAttribute("type",t),n&&(e.value=n),t}}}},removeAttr:function(e,t){var n,r=0,i=t&&t.match(P);if(i&&1===e.nodeType)while(n=i[r++])e.removeAttribute(n)}}),ct={set:function(e,t,n){return!1===t?S.removeAttr(e,n):e.setAttribute(n,n),n}},S.each(S.expr.match.bool.source.match(/\w+/g),function(e,t){var a=ft[t]||S.find.attr;ft[t]=function(e,t,n){var r,i,o=t.toLowerCase();return n||(i=ft[o],ft[o]=r,r=null!=a(e,t,n)?o:null,ft[o]=i),r}});var pt=/^(?:input|select|textarea|button)$/i,dt=/^(?:a|area)$/i;function ht(e){return(e.match(P)||[]).join(" ")}function gt(e){return e.getAttribute&&e.getAttribute("class")||""}function vt(e){return Array.isArray(e)?e:"string"==typeof e&&e.match(P)||[]}S.fn.extend({prop:function(e,t){return $(this,S.prop,e,t,1<arguments.length)},removeProp:function(e){return this.each(function(){delete this[S.propFix[e]||e]})}}),S.extend({prop:function(e,t,n){var r,i,o=e.nodeType;if(3!==o&&8!==o&&2!==o)return 1===o&&S.isXMLDoc(e)||(t=S.propFix[t]||t,i=S.propHooks[t]),void 0!==n?i&&"set"in i&&void 0!==(r=i.set(e,n,t))?r:e[t]=n:i&&"get"in i&&null!==(r=i.get(e,t))?r:e[t]},propHooks:{tabIndex:{get:function(e){var t=S.find.attr(e,"tabindex");return t?parseInt(t,10):pt.test(e.nodeName)||dt.test(e.nodeName)&&e.href?0:-1}}},propFix:{"for":"htmlFor","class":"className"}}),y.optSelected||(S.propHooks.selected={get:function(e){var t=e.parentNode;return t&&t.parentNode&&t.parentNode.selectedIndex,null},set:function(e){var t=e.parentNode;t&&(t.selectedIndex,t.parentNode&&t.parentNode.selectedIndex)}}),S.each(["tabIndex","readOnly","maxLength","cellSpacing","cellPadding","rowSpan","colSpan","useMap","frameBorder","contentEditable"],function(){S.propFix[this.toLowerCase()]=this}),S.fn.extend({addClass:function(t){var e,n,r,i,o,a,s,u=0;if(m(t))return this.each(function(e){S(this).addClass(t.call(this,e,gt(this)))});if((e=vt(t)).length)while(n=this[u++])if(i=gt(n),r=1===n.nodeType&&" "+ht(i)+" "){a=0;while(o=e[a++])r.indexOf(" "+o+" ")<0&&(r+=o+" ");i!==(s=ht(r))&&n.setAttribute("class",s)}return this},removeClass:function(t){var e,n,r,i,o,a,s,u=0;if(m(t))return this.each(function(e){S(this).removeClass(t.call(this,e,gt(this)))});if(!arguments.length)return this.attr("class","");if((e=vt(t)).length)while(n=this[u++])if(i=gt(n),r=1===n.nodeType&&" "+ht(i)+" "){a=0;while(o=e[a++])while(-1<r.indexOf(" "+o+" "))r=r.replace(" "+o+" "," ");i!==(s=ht(r))&&n.setAttribute("class",s)}return this},toggleClass:function(i,t){var o=typeof i,a="string"===o||Array.isArray(i);return"boolean"==typeof t&&a?t?this.addClass(i):this.removeClass(i):m(i)?this.each(function(e){S(this).toggleClass(i.call(this,e,gt(this),t),t)}):this.each(function(){var e,t,n,r;if(a){t=0,n=S(this),r=vt(i);while(e=r[t++])n.hasClass(e)?n.removeClass(e):n.addClass(e)}else void 0!==i&&"boolean"!==o||((e=gt(this))&&Y.set(this,"__className__",e),this.setAttribute&&this.setAttribute("class",e||!1===i?"":Y.get(this,"__className__")||""))})},hasClass:function(e){var t,n,r=0;t=" "+e+" ";while(n=this[r++])if(1===n.nodeType&&-1<(" "+ht(gt(n))+" ").indexOf(t))return!0;return!1}});var yt=/\r/g;S.fn.extend({val:function(n){var r,e,i,t=this[0];return arguments.length?(i=m(n),this.each(function(e){var t;1===this.nodeType&&(null==(t=i?n.call(this,e,S(this).val()):n)?t="":"number"==typeof t?t+="":Array.isArray(t)&&(t=S.map(t,function(e){return null==e?"":e+""})),(r=S.valHooks[this.type]||S.valHooks[this.nodeName.toLowerCase()])&&"set"in r&&void 0!==r.set(this,t,"value")||(this.value=t))})):t?(r=S.valHooks[t.type]||S.valHooks[t.nodeName.toLowerCase()])&&"get"in r&&void 0!==(e=r.get(t,"value"))?e:"string"==typeof(e=t.value)?e.replace(yt,""):null==e?"":e:void 0}}),S.extend({valHooks:{option:{get:function(e){var t=S.find.attr(e,"value");return null!=t?t:ht(S.text(e))}},select:{get:function(e){var t,n,r,i=e.options,o=e.selectedIndex,a="select-one"===e.type,s=a?null:[],u=a?o+1:i.length;for(r=o<0?u:a?o:0;r<u;r++)if(((n=i[r]).selected||r===o)&&!n.disabled&&(!n.parentNode.disabled||!A(n.parentNode,"optgroup"))){if(t=S(n).val(),a)return t;s.push(t)}return s},set:function(e,t){var n,r,i=e.options,o=S.makeArray(t),a=i.length;while(a--)((r=i[a]).selected=-1<S.inArray(S.valHooks.option.get(r),o))&&(n=!0);return n||(e.selectedIndex=-1),o}}}}),S.each(["radio","checkbox"],function(){S.valHooks[this]={set:function(e,t){if(Array.isArray(t))return e.checked=-1<S.inArray(S(e).val(),t)}},y.checkOn||(S.valHooks[this].get=function(e){return null===e.getAttribute("value")?"on":e.value})}),y.focusin="onfocusin"in C;var mt=/^(?:focusinfocus|focusoutblur)$/,xt=function(e){e.stopPropagation()};S.extend(S.event,{trigger:function(e,t,n,r){var i,o,a,s,u,l,c,f,p=[n||E],d=v.call(e,"type")?e.type:e,h=v.call(e,"namespace")?e.namespace.split("."):[];if(o=f=a=n=n||E,3!==n.nodeType&&8!==n.nodeType&&!mt.test(d+S.event.triggered)&&(-1<d.indexOf(".")&&(d=(h=d.split(".")).shift(),h.sort()),u=d.indexOf(":")<0&&"on"+d,(e=e[S.expando]?e:new S.Event(d,"object"==typeof e&&e)).isTrigger=r?2:3,e.namespace=h.join("."),e.rnamespace=e.namespace?new RegExp("(^|\\.)"+h.join("\\.(?:.*\\.|)")+"(\\.|$)"):null,e.result=void 0,e.target||(e.target=n),t=null==t?[e]:S.makeArray(t,[e]),c=S.event.special[d]||{},r||!c.trigger||!1!==c.trigger.apply(n,t))){if(!r&&!c.noBubble&&!x(n)){for(s=c.delegateType||d,mt.test(s+d)||(o=o.parentNode);o;o=o.parentNode)p.push(o),a=o;a===(n.ownerDocument||E)&&p.push(a.defaultView||a.parentWindow||C)}i=0;while((o=p[i++])&&!e.isPropagationStopped())f=o,e.type=1<i?s:c.bindType||d,(l=(Y.get(o,"events")||Object.create(null))[e.type]&&Y.get(o,"handle"))&&l.apply(o,t),(l=u&&o[u])&&l.apply&&V(o)&&(e.result=l.apply(o,t),!1===e.result&&e.preventDefault());return e.type=d,r||e.isDefaultPrevented()||c._default&&!1!==c._default.apply(p.pop(),t)||!V(n)||u&&m(n[d])&&!x(n)&&((a=n[u])&&(n[u]=null),S.event.triggered=d,e.isPropagationStopped()&&f.addEventListener(d,xt),n[d](),e.isPropagationStopped()&&f.removeEventListener(d,xt),S.event.triggered=void 0,a&&(n[u]=a)),e.result}},simulate:function(e,t,n){var r=S.extend(new S.Event,n,{type:e,isSimulated:!0});S.event.trigger(r,null,t)}}),S.fn.extend({trigger:function(e,t){return this.each(function(){S.event.trigger(e,t,this)})},triggerHandler:function(e,t){var n=this[0];if(n)return S.event.trigger(e,t,n,!0)}}),y.focusin||S.each({focus:"focusin",blur:"focusout"},function(n,r){var i=function(e){S.event.simulate(r,e.target,S.event.fix(e))};S.event.special[r]={setup:function(){var e=this.ownerDocument||this.document||this,t=Y.access(e,r);t||e.addEventListener(n,i,!0),Y.access(e,r,(t||0)+1)},teardown:function(){var e=this.ownerDocument||this.document||this,t=Y.access(e,r)-1;t?Y.access(e,r,t):(e.removeEventListener(n,i,!0),Y.remove(e,r))}}});var bt=C.location,wt={guid:Date.now()},Tt=/\?/;S.parseXML=function(e){var t,n;if(!e||"string"!=typeof e)return null;try{t=(new C.DOMParser).parseFromString(e,"text/xml")}catch(e){}return n=t&&t.getElementsByTagName("parsererror")[0],t&&!n||S.error("Invalid XML: "+(n?S.map(n.childNodes,function(e){return e.textContent}).join("\n"):e)),t};var Ct=/\[\]$/,Et=/\r?\n/g,St=/^(?:submit|button|image|reset|file)$/i,kt=/^(?:input|select|textarea|keygen)/i;function At(n,e,r,i){var t;if(Array.isArray(e))S.each(e,function(e,t){r||Ct.test(n)?i(n,t):At(n+"["+("object"==typeof t&&null!=t?e:"")+"]",t,r,i)});else if(r||"object"!==w(e))i(n,e);else for(t in e)At(n+"["+t+"]",e[t],r,i)}S.param=function(e,t){var n,r=[],i=function(e,t){var n=m(t)?t():t;r[r.length]=encodeURIComponent(e)+"="+encodeURIComponent(null==n?"":n)};if(null==e)return"";if(Array.isArray(e)||e.jquery&&!S.isPlainObject(e))S.each(e,function(){i(this.name,this.value)});else for(n in e)At(n,e[n],t,i);return r.join("&")},S.fn.extend({serialize:function(){return S.param(this.serializeArray())},serializeArray:function(){return this.map(function(){var e=S.prop(this,"elements");return e?S.makeArray(e):this}).filter(function(){var e=this.type;return this.name&&!S(this).is(":disabled")&&kt.test(this.nodeName)&&!St.test(e)&&(this.checked||!pe.test(e))}).map(function(e,t){var n=S(this).val();return null==n?null:Array.isArray(n)?S.map(n,function(e){return{name:t.name,value:e.replace(Et,"\r\n")}}):{name:t.name,value:n.replace(Et,"\r\n")}}).get()}});var Nt=/%20/g,jt=/#.*$/,Dt=/([?&])_=[^&]*/,qt=/^(.*?):[ \t]*([^\r\n]*)$/gm,Lt=/^(?:GET|HEAD)$/,Ht=/^\/\//,Ot={},Pt={},Rt="*/".concat("*"),Mt=E.createElement("a");function It(o){return function(e,t){"string"!=typeof e&&(t=e,e="*");var n,r=0,i=e.toLowerCase().match(P)||[];if(m(t))while(n=i[r++])"+"===n[0]?(n=n.slice(1)||"*",(o[n]=o[n]||[]).unshift(t)):(o[n]=o[n]||[]).push(t)}}function Wt(t,i,o,a){var s={},u=t===Pt;function l(e){var r;return s[e]=!0,S.each(t[e]||[],function(e,t){var n=t(i,o,a);return"string"!=typeof n||u||s[n]?u?!(r=n):void 0:(i.dataTypes.unshift(n),l(n),!1)}),r}return l(i.dataTypes[0])||!s["*"]&&l("*")}function Ft(e,t){var n,r,i=S.ajaxSettings.flatOptions||{};for(n in t)void 0!==t[n]&&((i[n]?e:r||(r={}))[n]=t[n]);return r&&S.extend(!0,e,r),e}Mt.href=bt.href,S.extend({active:0,lastModified:{},etag:{},ajaxSettings:{url:bt.href,type:"GET",isLocal:/^(?:about|app|app-storage|.+-extension|file|res|widget):$/.test(bt.protocol),global:!0,processData:!0,async:!0,contentType:"application/x-www-form-urlencoded; charset=UTF-8",accepts:{"*":Rt,text:"text/plain",html:"text/html",xml:"application/xml, text/xml",json:"application/json, text/javascript"},contents:{xml:/\bxml\b/,html:/\bhtml/,json:/\bjson\b/},responseFields:{xml:"responseXML",text:"responseText",json:"responseJSON"},converters:{"* text":String,"text html":!0,"text json":JSON.parse,"text xml":S.parseXML},flatOptions:{url:!0,context:!0}},ajaxSetup:function(e,t){return t?Ft(Ft(e,S.ajaxSettings),t):Ft(S.ajaxSettings,e)},ajaxPrefilter:It(Ot),ajaxTransport:It(Pt),ajax:function(e,t){"object"==typeof e&&(t=e,e=void 0),t=t||{};var c,f,p,n,d,r,h,g,i,o,v=S.ajaxSetup({},t),y=v.context||v,m=v.context&&(y.nodeType||y.jquery)?S(y):S.event,x=S.Deferred(),b=S.Callbacks("once memory"),w=v.statusCode||{},a={},s={},u="canceled",T={readyState:0,getResponseHeader:function(e){var t;if(h){if(!n){n={};while(t=qt.exec(p))n[t[1].toLowerCase()+" "]=(n[t[1].toLowerCase()+" "]||[]).concat(t[2])}t=n[e.toLowerCase()+" "]}return null==t?null:t.join(", ")},getAllResponseHeaders:function(){return h?p:null},setRequestHeader:function(e,t){return null==h&&(e=s[e.toLowerCase()]=s[e.toLowerCase()]||e,a[e]=t),this},overrideMimeType:function(e){return null==h&&(v.mimeType=e),this},statusCode:function(e){var t;if(e)if(h)T.always(e[T.status]);else for(t in e)w[t]=[w[t],e[t]];return this},abort:function(e){var t=e||u;return c&&c.abort(t),l(0,t),this}};if(x.promise(T),v.url=((e||v.url||bt.href)+"").replace(Ht,bt.protocol+"//"),v.type=t.method||t.type||v.method||v.type,v.dataTypes=(v.dataType||"*").toLowerCase().match(P)||[""],null==v.crossDomain){r=E.createElement("a");try{r.href=v.url,r.href=r.href,v.crossDomain=Mt.protocol+"//"+Mt.host!=r.protocol+"//"+r.host}catch(e){v.crossDomain=!0}}if(v.data&&v.processData&&"string"!=typeof v.data&&(v.data=S.param(v.data,v.traditional)),Wt(Ot,v,t,T),h)return T;for(i in(g=S.event&&v.global)&&0==S.active++&&S.event.trigger("ajaxStart"),v.type=v.type.toUpperCase(),v.hasContent=!Lt.test(v.type),f=v.url.replace(jt,""),v.hasContent?v.data&&v.processData&&0===(v.contentType||"").indexOf("application/x-www-form-urlencoded")&&(v.data=v.data.replace(Nt,"+")):(o=v.url.slice(f.length),v.data&&(v.processData||"string"==typeof v.data)&&(f+=(Tt.test(f)?"&":"?")+v.data,delete v.data),!1===v.cache&&(f=f.replace(Dt,"$1"),o=(Tt.test(f)?"&":"?")+"_="+wt.guid+++o),v.url=f+o),v.ifModified&&(S.lastModified[f]&&T.setRequestHeader("If-Modified-Since",S.lastModified[f]),S.etag[f]&&T.setRequestHeader("If-None-Match",S.etag[f])),(v.data&&v.hasContent&&!1!==v.contentType||t.contentType)&&T.setRequestHeader("Content-Type",v.contentType),T.setRequestHeader("Accept",v.dataTypes[0]&&v.accepts[v.dataTypes[0]]?v.accepts[v.dataTypes[0]]+("*"!==v.dataTypes[0]?", "+Rt+"; q=0.01":""):v.accepts["*"]),v.headers)T.setRequestHeader(i,v.headers[i]);if(v.beforeSend&&(!1===v.beforeSend.call(y,T,v)||h))return T.abort();if(u="abort",b.add(v.complete),T.done(v.success),T.fail(v.error),c=Wt(Pt,v,t,T)){if(T.readyState=1,g&&m.trigger("ajaxSend",[T,v]),h)return T;v.async&&0<v.timeout&&(d=C.setTimeout(function(){T.abort("timeout")},v.timeout));try{h=!1,c.send(a,l)}catch(e){if(h)throw e;l(-1,e)}}else l(-1,"No Transport");function l(e,t,n,r){var i,o,a,s,u,l=t;h||(h=!0,d&&C.clearTimeout(d),c=void 0,p=r||"",T.readyState=0<e?4:0,i=200<=e&&e<300||304===e,n&&(s=function(e,t,n){var r,i,o,a,s=e.contents,u=e.dataTypes;while("*"===u[0])u.shift(),void 0===r&&(r=e.mimeType||t.getResponseHeader("Content-Type"));if(r)for(i in s)if(s[i]&&s[i].test(r)){u.unshift(i);break}if(u[0]in n)o=u[0];else{for(i in n){if(!u[0]||e.converters[i+" "+u[0]]){o=i;break}a||(a=i)}o=o||a}if(o)return o!==u[0]&&u.unshift(o),n[o]}(v,T,n)),!i&&-1<S.inArray("script",v.dataTypes)&&S.inArray("json",v.dataTypes)<0&&(v.converters["text script"]=function(){}),s=function(e,t,n,r){var i,o,a,s,u,l={},c=e.dataTypes.slice();if(c[1])for(a in e.converters)l[a.toLowerCase()]=e.converters[a];o=c.shift();while(o)if(e.responseFields[o]&&(n[e.responseFields[o]]=t),!u&&r&&e.dataFilter&&(t=e.dataFilter(t,e.dataType)),u=o,o=c.shift())if("*"===o)o=u;else if("*"!==u&&u!==o){if(!(a=l[u+" "+o]||l["* "+o]))for(i in l)if((s=i.split(" "))[1]===o&&(a=l[u+" "+s[0]]||l["* "+s[0]])){!0===a?a=l[i]:!0!==l[i]&&(o=s[0],c.unshift(s[1]));break}if(!0!==a)if(a&&e["throws"])t=a(t);else try{t=a(t)}catch(e){return{state:"parsererror",error:a?e:"No conversion from "+u+" to "+o}}}return{state:"success",data:t}}(v,s,T,i),i?(v.ifModified&&((u=T.getResponseHeader("Last-Modified"))&&(S.lastModified[f]=u),(u=T.getResponseHeader("etag"))&&(S.etag[f]=u)),204===e||"HEAD"===v.type?l="nocontent":304===e?l="notmodified":(l=s.state,o=s.data,i=!(a=s.error))):(a=l,!e&&l||(l="error",e<0&&(e=0))),T.status=e,T.statusText=(t||l)+"",i?x.resolveWith(y,[o,l,T]):x.rejectWith(y,[T,l,a]),T.statusCode(w),w=void 0,g&&m.trigger(i?"ajaxSuccess":"ajaxError",[T,v,i?o:a]),b.fireWith(y,[T,l]),g&&(m.trigger("ajaxComplete",[T,v]),--S.active||S.event.trigger("ajaxStop")))}return T},getJSON:function(e,t,n){return S.get(e,t,n,"json")},getScript:function(e,t){return S.get(e,void 0,t,"script")}}),S.each(["get","post"],function(e,i){S[i]=function(e,t,n,r){return m(t)&&(r=r||n,n=t,t=void 0),S.ajax(S.extend({url:e,type:i,dataType:r,data:t,success:n},S.isPlainObject(e)&&e))}}),S.ajaxPrefilter(function(e){var t;for(t in e.headers)"content-type"===t.toLowerCase()&&(e.contentType=e.headers[t]||"")}),S._evalUrl=function(e,t,n){return S.ajax({url:e,type:"GET",dataType:"script",cache:!0,async:!1,global:!1,converters:{"text script":function(){}},dataFilter:function(e){S.globalEval(e,t,n)}})},S.fn.extend({wrapAll:function(e){var t;return this[0]&&(m(e)&&(e=e.call(this[0])),t=S(e,this[0].ownerDocument).eq(0).clone(!0),this[0].parentNode&&t.insertBefore(this[0]),t.map(function(){var e=this;while(e.firstElementChild)e=e.firstElementChild;return e}).append(this)),this},wrapInner:function(n){return m(n)?this.each(function(e){S(this).wrapInner(n.call(this,e))}):this.each(function(){var e=S(this),t=e.contents();t.length?t.wrapAll(n):e.append(n)})},wrap:function(t){var n=m(t);return this.each(function(e){S(this).wrapAll(n?t.call(this,e):t)})},unwrap:function(e){return this.parent(e).not("body").each(function(){S(this).replaceWith(this.childNodes)}),this}}),S.expr.pseudos.hidden=function(e){return!S.expr.pseudos.visible(e)},S.expr.pseudos.visible=function(e){return!!(e.offsetWidth||e.offsetHeight||e.getClientRects().length)},S.ajaxSettings.xhr=function(){try{return new C.XMLHttpRequest}catch(e){}};var Bt={0:200,1223:204},$t=S.ajaxSettings.xhr();y.cors=!!$t&&"withCredentials"in $t,y.ajax=$t=!!$t,S.ajaxTransport(function(i){var o,a;if(y.cors||$t&&!i.crossDomain)return{send:function(e,t){var n,r=i.xhr();if(r.open(i.type,i.url,i.async,i.username,i.password),i.xhrFields)for(n in i.xhrFields)r[n]=i.xhrFields[n];for(n in i.mimeType&&r.overrideMimeType&&r.overrideMimeType(i.mimeType),i.crossDomain||e["X-Requested-With"]||(e["X-Requested-With"]="XMLHttpRequest"),e)r.setRequestHeader(n,e[n]);o=function(e){return function(){o&&(o=a=r.onload=r.onerror=r.onabort=r.ontimeout=r.onreadystatechange=null,"abort"===e?r.abort():"error"===e?"number"!=typeof r.status?t(0,"error"):t(r.status,r.statusText):t(Bt[r.status]||r.status,r.statusText,"text"!==(r.responseType||"text")||"string"!=typeof r.responseText?{binary:r.response}:{text:r.responseText},r.getAllResponseHeaders()))}},r.onload=o(),a=r.onerror=r.ontimeout=o("error"),void 0!==r.onabort?r.onabort=a:r.onreadystatechange=function(){4===r.readyState&&C.setTimeout(function(){o&&a()})},o=o("abort");try{r.send(i.hasContent&&i.data||null)}catch(e){if(o)throw e}},abort:function(){o&&o()}}}),S.ajaxPrefilter(function(e){e.crossDomain&&(e.contents.script=!1)}),S.ajaxSetup({accepts:{script:"text/javascript, application/javascript, application/ecmascript, application/x-ecmascript"},contents:{script:/\b(?:java|ecma)script\b/},converters:{"text script":function(e){return S.globalEval(e),e}}}),S.ajaxPrefilter("script",function(e){void 0===e.cache&&(e.cache=!1),e.crossDomain&&(e.type="GET")}),S.ajaxTransport("script",function(n){var r,i;if(n.crossDomain||n.scriptAttrs)return{send:function(e,t){r=S("<script>").attr(n.scriptAttrs||{}).prop({charset:n.scriptCharset,src:n.url}).on("load error",i=function(e){r.remove(),i=null,e&&t("error"===e.type?404:200,e.type)}),E.head.appendChild(r[0])},abort:function(){i&&i()}}});var _t,zt=[],Ut=/(=)\?(?=&|$)|\?\?/;S.ajaxSetup({jsonp:"callback",jsonpCallback:function(){var e=zt.pop()||S.expando+"_"+wt.guid++;return this[e]=!0,e}}),S.ajaxPrefilter("json jsonp",function(e,t,n){var r,i,o,a=!1!==e.jsonp&&(Ut.test(e.url)?"url":"string"==typeof e.data&&0===(e.contentType||"").indexOf("application/x-www-form-urlencoded")&&Ut.test(e.data)&&"data");if(a||"jsonp"===e.dataTypes[0])return r=e.jsonpCallback=m(e.jsonpCallback)?e.jsonpCallback():e.jsonpCallback,a?e[a]=e[a].replace(Ut,"$1"+r):!1!==e.jsonp&&(e.url+=(Tt.test(e.url)?"&":"?")+e.jsonp+"="+r),e.converters["script json"]=function(){return o||S.error(r+" was not called"),o[0]},e.dataTypes[0]="json",i=C[r],C[r]=function(){o=arguments},n.always(function(){void 0===i?S(C).removeProp(r):C[r]=i,e[r]&&(e.jsonpCallback=t.jsonpCallback,zt.push(r)),o&&m(i)&&i(o[0]),o=i=void 0}),"script"}),y.createHTMLDocument=((_t=E.implementation.createHTMLDocument("").body).innerHTML="<form></form><form></form>",2===_t.childNodes.length),S.parseHTML=function(e,t,n){return"string"!=typeof e?[]:("boolean"==typeof t&&(n=t,t=!1),t||(y.createHTMLDocument?((r=(t=E.implementation.createHTMLDocument("")).createElement("base")).href=E.location.href,t.head.appendChild(r)):t=E),o=!n&&[],(i=N.exec(e))?[t.createElement(i[1])]:(i=xe([e],t,o),o&&o.length&&S(o).remove(),S.merge([],i.childNodes)));var r,i,o},S.fn.load=function(e,t,n){var r,i,o,a=this,s=e.indexOf(" ");return-1<s&&(r=ht(e.slice(s)),e=e.slice(0,s)),m(t)?(n=t,t=void 0):t&&"object"==typeof t&&(i="POST"),0<a.length&&S.ajax({url:e,type:i||"GET",dataType:"html",data:t}).done(function(e){o=arguments,a.html(r?S("<div>").append(S.parseHTML(e)).find(r):e)}).always(n&&function(e,t){a.each(function(){n.apply(this,o||[e.responseText,t,e])})}),this},S.expr.pseudos.animated=function(t){return S.grep(S.timers,function(e){return t===e.elem}).length},S.offset={setOffset:function(e,t,n){var r,i,o,a,s,u,l=S.css(e,"position"),c=S(e),f={};"static"===l&&(e.style.position="relative"),s=c.offset(),o=S.css(e,"top"),u=S.css(e,"left"),("absolute"===l||"fixed"===l)&&-1<(o+u).indexOf("auto")?(a=(r=c.position()).top,i=r.left):(a=parseFloat(o)||0,i=parseFloat(u)||0),m(t)&&(t=t.call(e,n,S.extend({},s))),null!=t.top&&(f.top=t.top-s.top+a),null!=t.left&&(f.left=t.left-s.left+i),"using"in t?t.using.call(e,f):c.css(f)}},S.fn.extend({offset:function(t){if(arguments.length)return void 0===t?this:this.each(function(e){S.offset.setOffset(this,t,e)});var e,n,r=this[0];return r?r.getClientRects().length?(e=r.getBoundingClientRect(),n=r.ownerDocument.defaultView,{top:e.top+n.pageYOffset,left:e.left+n.pageXOffset}):{top:0,left:0}:void 0},position:function(){if(this[0]){var e,t,n,r=this[0],i={top:0,left:0};if("fixed"===S.css(r,"position"))t=r.getBoundingClientRect();else{t=this.offset(),n=r.ownerDocument,e=r.offsetParent||n.documentElement;while(e&&(e===n.body||e===n.documentElement)&&"static"===S.css(e,"position"))e=e.parentNode;e&&e!==r&&1===e.nodeType&&((i=S(e).offset()).top+=S.css(e,"borderTopWidth",!0),i.left+=S.css(e,"borderLeftWidth",!0))}return{top:t.top-i.top-S.css(r,"marginTop",!0),left:t.left-i.left-S.css(r,"marginLeft",!0)}}},offsetParent:function(){return this.map(function(){var e=this.offsetParent;while(e&&"static"===S.css(e,"position"))e=e.offsetParent;return e||re})}}),S.each({scrollLeft:"pageXOffset",scrollTop:"pageYOffset"},function(t,i){var o="pageYOffset"===i;S.fn[t]=function(e){return $(this,function(e,t,n){var r;if(x(e)?r=e:9===e.nodeType&&(r=e.defaultView),void 0===n)return r?r[i]:e[t];r?r.scrollTo(o?r.pageXOffset:n,o?n:r.pageYOffset):e[t]=n},t,e,arguments.length)}}),S.each(["top","left"],function(e,n){S.cssHooks[n]=Fe(y.pixelPosition,function(e,t){if(t)return t=We(e,n),Pe.test(t)?S(e).position()[n]+"px":t})}),S.each({Height:"height",Width:"width"},function(a,s){S.each({padding:"inner"+a,content:s,"":"outer"+a},function(r,o){S.fn[o]=function(e,t){var n=arguments.length&&(r||"boolean"!=typeof e),i=r||(!0===e||!0===t?"margin":"border");return $(this,function(e,t,n){var r;return x(e)?0===o.indexOf("outer")?e["inner"+a]:e.document.documentElement["client"+a]:9===e.nodeType?(r=e.documentElement,Math.max(e.body["scroll"+a],r["scroll"+a],e.body["offset"+a],r["offset"+a],r["client"+a])):void 0===n?S.css(e,t,i):S.style(e,t,n,i)},s,n?e:void 0,n)}})}),S.each(["ajaxStart","ajaxStop","ajaxComplete","ajaxError","ajaxSuccess","ajaxSend"],function(e,t){S.fn[t]=function(e){return this.on(t,e)}}),S.fn.extend({bind:function(e,t,n){return this.on(e,null,t,n)},unbind:function(e,t){return this.off(e,null,t)},delegate:function(e,t,n,r){return this.on(t,e,n,r)},undelegate:function(e,t,n){return 1===arguments.length?this.off(e,"**"):this.off(t,e||"**",n)},hover:function(e,t){return this.mouseenter(e).mouseleave(t||e)}}),S.each("blur focus focusin focusout resize scroll click dblclick mousedown mouseup mousemove mouseover mouseout mouseenter mouseleave change select submit keydown keypress keyup contextmenu".split(" "),function(e,n){S.fn[n]=function(e,t){return 0<arguments.length?this.on(n,null,e,t):this.trigger(n)}});var Xt=/^[\s﻿ ]+|[\s﻿ ]+$/g;S.proxy=function(e,t){var n,r,i;if("string"==typeof t&&(n=e[t],t=e,e=n),m(e))return r=s.call(arguments,2),(i=function(){return e.apply(t||this,r.concat(s.call(arguments)))}).guid=e.guid=e.guid||S.guid++,i},S.holdReady=function(e){e?S.readyWait++:S.ready(!0)},S.isArray=Array.isArray,S.parseJSON=JSON.parse,S.nodeName=A,S.isFunction=m,S.isWindow=x,S.camelCase=X,S.type=w,S.now=Date.now,S.isNumeric=function(e){var t=S.type(e);return("number"===t||"string"===t)&&!isNaN(e-parseFloat(e))},S.trim=function(e){return null==e?"":(e+"").replace(Xt,"")},"function"==typeof define&&define.amd&&define("jquery",[],function(){return S});var Vt=C.jQuery,Gt=C.$;return S.noConflict=function(e){return C.$===S&&(C.$=Gt),e&&C.jQuery===S&&(C.jQuery=Vt),S},"undefined"==typeof e&&(C.jQuery=C.$=S),S});



      jQInf = jQuery.noConflict(true);
      jQInf(window).ready(function() {
      if(!oncegoI) {

      specialTheme = 0;

      jQInf("body").append('<style> html:not(.theme-editor) .animate.animate-up { opacity: 1 !important; } .js .features--show-element-staggering .ProductList--grid .ProductItem { visibility: visible !important; } .product-block { opacity: 1 !important; } img[data-rimg="lazy"] { opacity: 1 !important; } .container-pushy-main { height: auto !important; }  </style>');


      if(jQInf(".container-pushy-main").length > 0 && jQInf("#category-sticky-parent").length > 0 && jQInf(".pagination-buttons").length > 0) {
      jQInf("#category-sticky-parent").after(jQInf(jQInf(".pagination-buttons").get(0)));
      }

      // TESTAMENT
      if((jQInf("#product-loop .product-index").length > 0) && (jQInf("#product-loop .first").length > 0)) {
      jQInf("body").append('<style> .gsProductAlias .hidden { opacity: 0 !important; }  .pagination-count { display: none !important; } .paginext { display: none !important; } </style>');
      specialTheme = 6;
      }

      // VENUE
      if(jQInf(".o-layout__item").length > 0) {
      jQInf("body").append("<style> .product-top { opacity: 1 !important; visibility: visible !important; } .o-layout__item .product { opacity: 1 !important; visibility: visible !important; } </style>");
      }

      // ENVY
      if(jQInf("#Collection .indiv-product-wrapper").length > 0) {
      specialTheme = 9;
      }

      // ICON
      if(jQInf("#bside #product-loop .product").length > 0) {
      specialTheme = 8;
      jQInf("body").append('<style> #gsloadmore { padding-top: 12px !important; padding-bottom: 12px !important; } .gsProductAlias .hidden { opacity: 0 !important; } </style>');
      }

      // TURBO 
      if((jQInf(".columns .collection-matrix .one-third").length > 0) || (jQInf(".columns .collection-matrix .four").length > 0) || (jQInf(".columns .collection-matrix .eight").length > 0)) {
      specialTheme = 2;
      setInterval(function() {
      jQInf(".js-forms .viewed").removeClass("viewed");
      }, 1000);
      }

      // PARALLAX 
      if((jQInf("#shopify-section-collection-template .one-third").length > 0) || (jQInf("#shopify-section-collection-template .four .product_image .image__container").length > 0) || (jQInf("#shopify-section-collection-template .eight .product_image .image__container").length > 0)) {
      jQInf("html").css("opacity", '1');
      jQInf("body").append("<style> #gsloadmore { height: 40px; } </style>");
      specialTheme = 2;
      }

      // VANTAGE
      if((jQInf(".product-loop .medium_grid .product-index-inner .box-ratio").length > 0) || (jQInf(".product-loop .large_grid .product-index-inner .box-ratio").length > 0)) {
      specialTheme = 13;
      jQInf("body").append('<style> #gsloadmore { background-color: #ddd !important; color: #111 !important; height: 35px; border: 0px !important; border-radius: 0px !important;  } </style>');

      }

      // SPLIT
      if(jQInf(".site-box-container .box__collection").length > 0) {
      $("body").append("<style> #gscollectionbottom { height: 70px; } #shopify-section-footer { margin-top: 70px; } </style>");
      specialTheme = 12;
      }

      if((jQInf(".quickshop .quickshop-spinner").length > 0) && (jQInf(".quick-shop-modal-trigger").length > 0)) {
      specialTheme = 15;
      }

      // ATLANTIC
      if(jQInf(".product-list .product .product-card-figure").length > 0) {
      specialTheme = 11;
      }

      // KINGDOM
      if((jQInf(".isotope-products .three .grid-item-image").length > 0)) {
      jQInf("body").append('<style> .grid-item .grid-item-image { padding-top: 100% !important; } .infobar { height: 150px !important; } .grid-item.loaded { position: relative !important; left: unset !important; top: unset !important;  } </style>');
      specialTheme = 17;
      }

      // SHOWCASE
      if((jQInf(".wide-container .jiggly-split").length > 0)) {
      specialTheme = 16;
      }

      // CASCADE
      if((jQInf(".collection-cascade .resp-img-wrapper .resp-img-placeholder").length > 0)) {
      specialTheme = 18;
      }

      if((jQInf('.collection-listing .product-crop-tall .product-list-item figure[data-rimg-template*="shopif"]').length > 0)) {
      specialTheme = 33;
      //jQInf("body").append('<style> .aspect-ratio > img, .no-js .aspect-ratio > noscript img { height: auto; width: auto; margin: auto; left: 0; right: 0; } </style>');
      }

      // COLORS
      if((jQInf(".col-0 .inner .table .cell").length > 0)) {
      specialTheme = 21;
      jQInf("body").append('<style> .HidGSden { visibility: visible !important; } #gscollectionbottom { clear: both; } </style>');

      }

      setInterval(function() {
      try {
      jQInf(".lazyloading").each(function() {
      jQInf(this).removeClass("lazyloading");
      jQInf(this).addClass("lazyloaded");
      });
      }
      catch(err) {
      }
      }, 3000);

      //console.debug("special theme " + specialTheme);

      try {
      jQInf("#bc-sf-filter-top-pagination").remove();
      } catch(error){
      }  

      if(jQInf(".pagination").length == 2) {
      jQInf(jQInf(".pagination").get(0)).remove();
      }

      gsLastUrl = window.location.href;

      if(!(window.location.href.indexOf("/products/") > 0)) {

      setInterval(function() {

      try {
      if(gsLastUrl.length > 5 && window.location.href != gsLastUrl && window.location.pathname.includes('return_prime') === false) {
      gsLastUrl = window.location.href;
      window.location.reload();
      }
      }
      catch(err) {}


      try {
      jQInf(jQInf('body').get(0)).find("img[src*='loader.gif']").each(function() {
                      if(jQInf(this).hasClass("product_image--current")) {
                      jQInf(this).attr("src", jQInf(this).attr('data-src'));
                      }
      });
      }
                      catch(err) {}


      }, 1000);

      }

      jQInf("body").append("<style> .thumbnail .product_container .quick_shop { display: block !important; }  .card { opacity: 1 !important; } </style>");
      oncegoI = true;

      if(jQInf("#wrapper1 #collection_sorted .product_listing_controls .products_count").length > 0) {
      specialTheme = 1;
      }

      if(specialTheme == 1) {
      setTimeout(function()
      {
      gsscroller = new GSLoader();
      }, 1000);
      }
      else {
      gsscroller = new GSLoader();
      }

      }
      });

      paginateSel = null;
      paginateSelector = '';
      collectionParent = '';
      collectionPageNr = 1;
      gsscroller = null;
      containerPos = 1;
      productsParentTmp = null;

      function getUrlParamsGS( prop ) {
          var params = {};
          var search = decodeURIComponent( window.location.href.slice( window.location.href.indexOf( '?' ) + 1 ) );
          var definitions = search.split( '&' );

          definitions.forEach( function( val, key ) {
              var parts = val.split( '=', 2 );
              params[ parts[ 0 ] ] = parts[ 1 ];
          } );

          return ( prop && prop in params ) ? params[ prop ] : null;
      }

      var fixThemeSpecial = function() {
      if(specialTheme == 6) {

      var gsProductsPerRow = 0;
      var gsCntProductsInRow = 0;

      if(jQInf("#product-loop").find(".desktop-6").length > 0) {
      gsProductsPerRow = 2;
      }
      if(jQInf("#product-loop").find(".desktop-4").length > 0) {
      gsProductsPerRow = 3;
      }
      if(jQInf("#product-loop").find(".desktop-3").length > 0) {
      gsProductsPerRow = 4;
      }
      if(jQInf("#product-loop").find(".desktop-2").length > 0) {
      gsProductsPerRow = 6;
      }
      if(jQInf("#product-loop").find(".desktop-fifth").length > 0) {
      gsProductsPerRow = 5;
      }

      if(gsProductsPerRow == 0) {
      gsProductsPerRow = 4;
      }

      var gsCounterOdds = 1;
      jQInf("#product-loop .product-index").each(function(index) {

      var loazyloaders = jQInf(this).find(".lazyloading");
      if(loazyloaders.length > 0) {
      var mainlazyloader = $(loazyloaders.get(0));
      mainlazyloader.removeClass("lazyloading");
      mainlazyloader.addClass("lazyloaded");
      }

      jQInf(this).removeClass("first");
      jQInf(this).removeClass("last");

      if(gsCounterOdds == 1) {

      jQInf(this).addClass("first");
      }

      if(gsCounterOdds == gsProductsPerRow) {
      jQInf(this).addClass("last");
      }

      if(gsCounterOdds == gsProductsPerRow) {
      gsCounterOdds = 0;
      }
      gsCounterOdds++;
      }); 
      }


      if(specialTheme == 16) {
      colCnt = 1;
      jQInf(".product-block").each(function(index){
      var cardImage = jQInf(jQInf(this).find(".lazyloading").get(0));
      cardImage.removeClass("lazyloading");
      cardImage.addClass("lazyloaded");
      var productBlockGS = jQInf(".col-" + colCnt).find(".product-block").get(0);
      jQInf(productBlockGS).appendTo("#page-content");
      colCnt++;
      if(colCnt == 4) {
      colCnt = 1;
      }
      });

      jQInf(".product-list .product-block").each(function(index){
      jQInf(this).appendTo("#page-content");
      });


      colCnt = 1;
      jQInf(".product-block").each(function(index){
      jQInf(".col-" + colCnt).append(jQInf(this));
      colCnt++;
      if(colCnt == 4) {
      colCnt = 1;
      }
      });
      }

      if(specialTheme == 17) {
      try {
      jQInf(".grid-item").each(function(index) {
      jQInf(this).addClass("loaded");
      });
      if ( jQuery('.isotope-products').length > 0 ) {
      jQuery('.isotope-products').each(function(){
      window.KINGDOM.Grid.mount(jQuery(this))
      });
      }
      } catch(err) {}
      }

      if(specialTheme == 18) {
      try {
      jQInf("body").append($('script[src*="assets/theme.min.js"]').get(0).outerHTML.replace('defer="defer"', ''));

      }
      catch(err) {
      }
      }

      if(specialTheme == 9) {
      
      var gsNumberOfColumns = 0
      if(jQInf("#Collection").find(".six_columns").length > 0) {
      gsNumberOfColumns = 6;
      }
      if(jQInf("#Collection").find(".five_columns").length > 0) {
      gsNumberOfColumns = 5;
      }
      if(jQInf("#Collection").find(".four_columns").length > 0) {
      gsNumberOfColumns = 4;
      }
      if(jQInf("#Collection").find(".three_columns").length > 0) {
      gsNumberOfColumns = 3;
      }
      if(jQInf("#Collection").find(".two_columns").length > 0) {
      gsNumberOfColumns = 2;
      }
      if(gsNumberOfColumns == 0) {
      gsNumberOfColumns = 4;
      }
      
      jQInf(".product_clear").remove();
      var gsCounterOdds = 1;
      var gsCounterThree = 1;
      jQInf("#Collection .indiv-product-wrapper").each(function(index) {
      jQInf(this).removeClass("alpha");
      jQInf(this).removeClass("omega");
      jQInf(this).removeClass("even");
      jQInf(this).removeClass("odd");
      jQInf(this).removeClass("tablet-clear");
      jQInf(this).removeClass("mobile-clear");

      if(gsCounterOdds == 1) {
      jQInf(this).addClass("even");
      jQInf(this).addClass("tablet-clear");
      jQInf(this).addClass("mobile-clear");
      }
      else {
      jQInf(this).addClass("odd");
      }

      if(gsCounterThree == 1) {
      jQInf(this).addClass("alpha");
      }
      if(gsCounterThree == gsNumberOfColumns) {
      jQInf(this).addClass("omega");
      jQInf(this).after('<br class="clear product_clear">');
      }

      if(gsCounterOdds == 2) {
      gsCounterOdds = 0;
      }

      if(gsCounterThree == gsNumberOfColumns) {
      gsCounterThree = 0;
      }
      gsCounterOdds++;
      gsCounterThree++;
      });
      }

      if(specialTheme == 12) {

      jQInf("#section-collection .site-box").each(function(index) {
      jQInf(this).addClass("active");
      });
      }


      if(specialTheme == 13) {
      var gsCounterOdds = 1;
      
      var gsNumberOfColumns = 0
      if(jQInf(jQInf(".product-loop").get(0)).find(".desktop-6").length > 0) {
      gsNumberOfColumns = 2;
      }
      if(jQInf(jQInf(".product-loop").get(0)).find(".desktop-4").length > 0) {
      gsNumberOfColumns = 3;
      }
      if(jQInf(jQInf(".product-loop").get(0)).find(".desktop-3").length > 0) {
      gsNumberOfColumns = 4;
      }
      if(gsNumberOfColumns == 0) {
      gsNumberOfColumns = 3;
      }
        
      
      jQInf(".product-loop .product-index").each(function(index) {
      jQInf(this).removeClass("first");
      jQInf(this).removeClass("last");

      if(gsCounterOdds == 1) {

      jQInf(this).addClass("first");
      }

      if(gsCounterOdds == gsNumberOfColumns) {
      jQInf(this).addClass("last");
      }

      if(gsCounterOdds == gsNumberOfColumns) {
      gsCounterOdds = 0;
      }
      gsCounterOdds++;
      }); 
      }

      if(specialTheme == 8) {
      var gsNumberOfColumns = 0
      if(jQInf("#product-loop").find(".desktop-6").length > 0) {
      gsNumberOfColumns = 2;
      }
      if(jQInf("#product-loop").find(".desktop-4").length > 0) {
      gsNumberOfColumns = 3;
      }
      if(jQInf("#product-loop").find(".desktop-3").length > 0) {
      gsNumberOfColumns = 4;
      }
      if(gsNumberOfColumns == 0) {
      gsNumberOfColumns = 4;
      } 
      
      var gsCounterOdds = 1;
      jQInf("#product-loop .product").each(function(index) {
      jQInf(this).removeClass("first");
      jQInf(this).removeClass("last");

      if(gsCounterOdds == 1) {

      jQInf(this).addClass("first");
      }

      if(gsCounterOdds == gsNumberOfColumns) {
      jQInf(this).addClass("last");
      }

      if(gsCounterOdds == gsNumberOfColumns) {
      gsCounterOdds = 0;
      }
      gsCounterOdds++;
      });
      }

      if(specialTheme == 2 || specialTheme == 10) {
      jQInf(".product_clear").remove();
      var gsCounterOdds = 1;
      var gsCounterThree = 1;

      var gsNumberOfColumns = 3;
      var GSproductQuery = '#shopify-section-collection-template .products .one-third';

      if(jQInf(".collection-matrix .columns").length > 0) {
      GSproductQuery = '.collection-matrix .columns';
      }

      if(jQInf("#shopify-section-collection-template .products .eight").length > 0) {
      gsNumberOfColumns = 2;
      GSproductQuery = '#shopify-section-collection-template .products .eight';
      }

      if(jQInf("#shopify-section-collection-template .products .one-third").length > 0) {
      gsNumberOfColumns = 3;
      GSproductQuery = '#shopify-section-collection-template .products .one-third';
      }
      if(jQInf("#shopify-section-collection-template .products .four").length > 0) {
      gsNumberOfColumns = 4;
      GSproductQuery = '#shopify-section-collection-template .products .four';
      }




      jQInf(GSproductQuery).not(".modal_image").each(function(index) {


      jQInf(this).removeClass("alpha");
      jQInf(this).removeClass("omega");
      jQInf(this).removeClass("even");
      jQInf(this).removeClass("odd");
      if(gsCounterOdds == 1) {
      jQInf(this).addClass("even");
      }
      else {
      jQInf(this).addClass("odd");
      }

      if(gsCounterThree == 1) {
      jQInf(this).addClass("alpha");
      }
      if(gsCounterThree == gsNumberOfColumns) {
      jQInf(this).addClass("omega");
      jQInf(this).after('<br class="clear product_clear">');
      }

      if(gsCounterOdds == 2) {
      gsCounterOdds = 0;
      }

      if(gsCounterThree == gsNumberOfColumns) {
      gsCounterThree = 0;
      }
      gsCounterOdds++;
      gsCounterThree++;
      });

      }



      jQInf(".lazyloading").each(function() {
      jQInf(this).removeClass("lazyloading");
      jQInf(this).addClass("lazyloaded");
      });


      try {
      collection.init();
      }
      catch(err) {
      }
      }

      var GSLoader = function() {


      if((window.location.href.indexOf("/products/") > 0)) {
      try {
      sessionStorage.setItem('gsproductviewed', '1');
      }
      catch(err) {
      }
      }

      if( (window.location.href.indexOf("/products/") > 0)) {
      return;
      }

      if((window.location.href.indexOf("/products/") > 0)) {
      return;
      }

      try {
      //if(sessionStorage.getItem('gscollectionurl') != window.location.href) {
      if((sessionStorage.getItem('gscollectionurl') != window.location.href) || (jQInf(".medium-up--one-half, .medium-up--one-third").length > 1 && (jQInf('.card').length > 0)) ){
        sessionStorage.setItem('gscollectionurl', window.location.href); 
        sessionStorage.setItem('gscollectioncontent', '');
        sessionStorage.setItem('gspaginatecontent', '');
        sessionStorage.setItem('gscollectionpagenr', '');
      }

      if(sessionStorage.getItem('gsproductviewed') == null || sessionStorage.getItem('gsproductviewed') == '0') {
          sessionStorage.setItem('gscollectionurl', window.location.href); 
          sessionStorage.setItem('gscollectioncontent', '');
          sessionStorage.setItem('gspaginatecontent', '');
          sessionStorage.setItem('gscollectionpagenr', '');
      }

      sessionStorage.setItem('gsproductviewed', '0');
      }
      catch(err) {
      }  
        
        
      paginateSelector = '.pagination';

      collectionParent = '.products';
      collectionParent = this.findCollectionParent();  

      if(jQInf('.pagination').length == 0) {

      paginateSelector = '';

      var paginationNodes = jQInf(collectionParent).find('*[class*="agination"]');
      if(paginationNodes.length > 0) {
      paginateSelector = '.' + jQInf.trim(paginationNodes.first().attr("class")).replace(/\s\s+/g, ' ').replace(/ /gi, '.');
      }
      else {
      if(jQInf('#pagination').length > 0) {
      paginateSelector = '#pagination';
      }
      else {
      paginationNodes = jQInf('*[id*="agination"]');
      if(paginationNodes.length > 0) {
      paginateSelector = '#' + paginationNodes.first().attr("id");
      }
      else {
      paginationNodes = jQInf('*[class*="aginate"]');
      if(paginationNodes.length > 0) {
      paginateSelector = '.' + jQInf.trim(paginationNodes.first().attr("class")).replace(/\s\s+/g, ' ').replace(/ /gi, '.');
      }
      else {
      paginationNodes = jQInf('*[id*="aginate"]');
      if(paginationNodes.length > 0) {
      paginateSelector = '#' + paginationNodes.first().attr("id");
      }
      }
      }
      }
      }

      if(paginateSelector == '') {
      var paginationNodes = jQInf(collectionParent).parent().nextAll().find('*[class*="agination"]');
      if(paginationNodes.length > 0) {
      paginateSelector = '.' + jQInf.trim(paginationNodes.first().attr("class")).replace(/\s\s+/g, ' ').replace(/ /gi, '.');
      }
      else {
      if(jQInf('#pagination').length > 0) {
      paginateSelector = '#pagination';
      }
      else {
      paginationNodes = jQInf('*[id*="agination"]');
      if(paginationNodes.length > 0) {
      paginateSelector = '#' + paginationNodes.first().attr("id");
      }
      else {
      paginationNodes = jQInf('*[class*="aginate"]');
      if(paginationNodes.length > 0) {

      paginateSelector = '.' + jQInf.trim(paginationNodes.first().attr("class")).replace(/\s\s+/g, ' ').replace(/ /gi, '.');

      }
      else {
      paginationNodes = jQInf('*[id*="aginate"]');
      if(paginationNodes.length > 0) {
      paginateSelector = '#' + paginationNodes.first().attr("id");
      }
      }
      }
      }
      }
      }

      if(paginateSelector == '#modal-pagination-wrapper') {
      paginateSelector = '';
      }

      if(paginateSelector == '') {
      var paginationNodes = jQInf('*[class*="agination"]');
      if(paginationNodes.length > 0) {
      paginateSelector = '.' + jQInf.trim(paginationNodes.first().attr("class")).replace(/\s\s+/g, ' ').replace(/ /gi, '.');
      }
      else {
      if(jQInf('#pagination').length > 0) {
      paginateSelector = '#pagination';
      }
      else {
      paginationNodes = jQInf('*[id*="agination"]');
      if(paginationNodes.length > 0) {
      paginateSelector = '#' + paginationNodes.first().attr("id");
      }
      else {
      paginationNodes = jQInf('*[class*="aginate"]');
      if(paginationNodes.length > 0) {
      paginateSelector = '.' + jQInf.trim(paginationNodes.first().attr("class")).replace(/\s\s+/g, ' ').replace(/ /gi, '.');
      }
      else {
      paginationNodes = jQInf('*[id*="aginate"]');
      if(paginationNodes.length > 0) {
      paginateSelector = '#' + paginationNodes.first().attr("id");
      }
      }
      }
      }
      }
      }
      }

      if(jQInf(".container-pushy-main").length > 0 && jQInf("#category-sticky-parent").length > 0 && jQInf(".pagination-buttons").length > 0) {
      paginateSelector = '.pagination-buttons';
      }


      if(paginateSelector == '') {
      if(jQInf('#paging').length > 0) {
      paginateSelector = '#paging';
      }
      }

      if((jQInf(".wide-container .jiggly-split").length > 0)) { 
      paginateSelector = ".pager-button, .pagination";
      }

      if(paginateSelector == '') {
      if(jQInf('.page_c').length > 0) {
      paginateSelector = '.page_c';
      collectionParent = collectionParent.replace('.animation-done', '');
      jQInf("body").append("<style> .mb30 { min-height: 426px; } </style>");

      }

      }


      if (jQInf(".shopify-pagination").length > 0 && jQInf(".pagination-gl_default").length > 0) {
      paginateSelector = '.shopify-pagination';
      jQInf("body").append("<style> #gscollectionbottom { margin-bottom: 20px; } </style>");

      }

      if (jQInf(".pull-right.pagination-btns").length > 0 && jQInf(".product-listing").length > 0 && jQInf(".filters-row__pagination").length > 0) {

      jQInf('<center id="forcegscenter"></center>').insertAfter( ".product-listing" );
      jQInf("#forcegscenter").append(jQInf(jQInf(".filters-row__pagination").get(0)));
      }

      if(specialTheme == 1) {
      jQInf("body").append("<style> .products_count { display: none !important; } .product_listing_controls { background: unset !important; border: 0px solid #fff; } #gsloadmore { font-size: 16px !important; } </style>");
      }

      paginateSelector = paginateSelector.replace('..', '.').replace('..', '.').replace('..', '.').replace('..', '.').replace('..', '.');

      if(jQInf(paginateSelector).length > 0) {
      jQInf("body").append("<style> .grid-product__image-mask .grid-product__image { opacity: 1 !important; } .js .ProductList--grid .ProductItem { visibility: visible; } .cata-product.cp-grid .product-grid-item { min-height: 452px; } .cata-product.cp-grid .product-wrapper { min-height: 402px; } [data-rimg-canvas] { display: none !important; } </style>");
      }

      if(jQInf("#gscollectionbottom").length > 0) {
      jQInf("#gscollectionbottom").remove();
      }
      if(jQInf("#bc-sf-filter-products").length == 0) {
      if(loaderMode == 1) {
      jQInf(jQInf(paginateSelector).get(0)).after('<div style="width: 100%;" id="gscollectionbottom"><center><img style="margin-top: 10px;" src="https://i.imgur.com/d0gsrX4.gif"></center></div>');
      }
      else {
      jQInf(jQInf(paginateSelector).get(0)).after('<div style="width: 100%;" id="gscollectionbottom"><center> <button id="gsloadmore" style="border-width: 1px; border-radius: 0; font-size: 14px; border-color: #ffffff; background-color: #7d0101; color: #ffffff; font-family:; margin-bottom: 24px; width: 12%; height: 40px; cursor: pointer; font-weight: BOLD; border: 1px solid #ffffff;" type="button">' + loadMoreBtnText + '</button> <img id="gsloaderimg" style="margin-top: 10px; display: none;" src="https://i.imgur.com/d0gsrX4.gif"> </center></div>');
      }
      }
      else {
      if(loaderMode == 1) {
      jQInf(jQInf("#bc-sf-filter-products").get(0)).after('<div style="width: 100%;" id="gscollectionbottom"><center><img style="margin-top: 10px;" src="https://i.imgur.com/d0gsrX4.gif"></center></div>');
      }
      else {
      jQInf(jQInf("#bc-sf-filter-products").get(0)).after('<div style="width: 100%;" id="gscollectionbottom"><center> <button id="gsloadmore" style="max-width: 250px; border: 1px solid; border-radius: 5px; padding-left: 20px; padding-right: 20px; padding-bottom: 3px; padding-top: 3px; margin-top: 20px;" type="button">' + loadMoreBtnText + '</button> <img id="gsloaderimg" style="margin-top: 10px; display: none;" src="https://i.imgur.com/d0gsrX4.gif"> </center></div>');
      }
      }

      jQInf(jQInf(paginateSelector)).hide();
      jQInf("body").append("<style> " + paginateSelector + " { display: none !important; } </style>");

      setInterval(function() {
      try {
      if(jQInf(paginateSelector).css('float').length > 0) {
      jQInf("#gscollectionbottom").css('float', jQInf(paginateSelector).css('float'));
      }
      }
      catch(err) {
      }
      }, 500);


      jQInf( "*:contains('Page 1')" ).each(function() {
      if(jQInf(this).children().length == 0) {
      jQInf(this).hide();
      }
      });
        
        if(jQInf(collectionParent).length > 1) {
        var tmpCnt = 1;
        jQInf(collectionParent).each(function() {
        if(productsParentTmp.get(0).innerHTML.localeCompare(jQInf(this).get(0).innerHTML) == 0) {
        containerPos = tmpCnt;
        }
        tmpCnt++;
        });
        }
        
        
        if(jQInf(collectionParent).find(paginateSelector).length > 0) {
        jQInf(collectionParent).after(jQInf("#gscollectionbottom"));
        }  
        

        this.listenToScroll = this.listenToScroll.bind(this);
        this.analyseView = this.analyseView.bind(this);

        if(productsParentTmp === null) {
        jQInf("#gscollectionbottom img").remove();
        jQInf("#gscollectionbottom button").remove();
        return;
        }

        this.containerElement = productsParentTmp.get(0);

        if(jQInf(".grid-link__container").length > 0) {
      this.containerElement = jQInf(".grid-link__container").get(0);
        }

      if(jQInf(".custom-category .toolbar-amount").length > 0 && jQInf(".custom-products").length > 0) { 
      this.containerElement = jQInf(".custom-products .row").get(0);
      }


        if(!this.containerElement) {
        return;
        }
        
        
        this.paginateSection = document.querySelector(paginateSelector);
        paginateSel = this.paginateSection;


        if(sessionStorage.getItem('gscollectioncontent') != null && sessionStorage.getItem('gscollectioncontent') != "") {
              this.containerElement.insertAdjacentHTML('beforeend', sessionStorage.getItem('gscollectioncontent'));

      fixThemeSpecial();

      this.paginateSection = document.querySelector(paginateSelector);
      this.paginateSection.innerHTML = sessionStorage.getItem('gspaginatecontent');
      collectionPageNr = parseInt(sessionStorage.getItem('gscollectionpagenr'));

      setTimeout(function()
      {
      try {
      var resizeEvent = window.document.createEvent('UIEvents');
      resizeEvent .initUIEvent('resize', true, false, window, 0);
      window.dispatchEvent(resizeEvent);
      $(window).trigger('forceproductblockheights');
      } catch(err) {
      }
      //jQInf(window).trigger('resize');
      }, 1000);

              if(jQInf(".medium-up--one-half, .medium-up--one-third").length > 0) {
      try {
                    jQInf(".card").css("opacity", '1');
      } catch(err) {}
              }

      if(collectionPageNr == -1) {
        jQInf("#gscollectionbottom button").remove();
      jQInf("#gscollectionbottom img").remove();
      }
        }


      this.listenToScroll();
      };



      GSLoader.prototype.findCollectionParent = function() {

      var limititerations = 20;
      var colllectionParentTmp = jQInf("a[href*='page=2']");
      if(jQInf("#bc-sf-filter-bottom-pagination").length > 0) {
      colllectionParentTmp = jQInf("#bc-sf-filter-bottom-pagination");
      }

      var collectionParentFound = false;
      while(limititerations > 0) {

      colllectionParentTmp = colllectionParentTmp.parent();

      limititerations--;
      //console.debug(jQInf(colllectionParentTmp));
      if(jQInf(colllectionParentTmp).find('a[href*="/products/"]').length > 0) {
      collectionParentFound = true;
      limititerations = 0;
      }

      }

      if(!collectionParentFound) {
      return false;
      }

      var productInCollection = jQInf(colllectionParentTmp).find('a[href*="/products/"]');

      if(productInCollection.length < 2) {
      return false;
      }


      try {
      if(jQInf('#collection-display #product-loop').length > 0) {
      productsParentTmp = jQInf('#product-loop');
      return '#product-loop';
      }
      } catch(err) { }

      var productInCollectionFirst = productInCollection[0];
      var productInCollectionLast = productInCollection[productInCollection.length - 1];
      productsParentTmp = productInCollectionFirst;

      limititerations = 20;
      while(limititerations > 0) {

      productsParentTmp = jQInf(productsParentTmp).parent();

      if(jQInf(".custom-category .toolbar-amount").length > 0 && jQInf(".custom-products").length > 0) {

      jQInf("body").append("<style> .toolbar-amount { display: none !important; } .ajax_pagination { float: none !important; } #pagination { border: 0px !important; } </style>");
      productsParentTmp = jQInf(jQInf('.custom-products').get(0));
      return '.custom-products .row';
      }

      limititerations--;
      //console.debug(jQInf(colllectionParentTmp));
      if(jQInf(productsParentTmp).find(productInCollectionLast).length > 0) {

      if(productsParentTmp.attr("id")) {
      var idName = '#' + productsParentTmp.attr("id");
      return idName ;
      }

      if(productsParentTmp.attr("class")) {
      //var className = '.' + productsParentTmp.attr("class").split(" ").join(".");
      //className = className.replace('..', '.').replace('..', '.').replace('..', '.').replace('..', '.').replace('..', '.');
      var className = '.' + jQInf.trim(productsParentTmp.attr("class")).replace(/\s\s+/g, ' ').replace(/ /gi, '.')
      return className;
      }

      limititerations = 0;
      }

      }

      return false;
      }



      GSLoader.prototype.listenToScroll = function() {
        if (this.paginateSection) {
        if(loaderMode == 1) {
          document.addEventListener('scroll', this.analyseView);
          window.addEventListener('resize', this.analyseView);
          window.addEventListener('orientationchange', this.analyseView);
      }
      else {
      jQInf("#gsloadmore").click(this.clickMoreBtn);
      }
        }
      };

      async function postData(url = '', data = {}) {
        // Default options are marked with *
        const response = await fetch(url, {
          method: 'GET', // *GET, POST, PUT, DELETE, etc.
          mode: 'cors', // no-cors, *cors, same-origin
          cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
          credentials: 'same-origin', // include, *same-origin, omit
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
            // 'Content-Type': 'application/x-www-form-urlencoded',
          },
          redirect: 'follow', // manual, *follow, error
          referrerPolicy: 'no-referrer', // no-referrer, *no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
        
        });
        return response.text(); // parses JSON response into native JavaScript objects
      };

      GSLoader.prototype.fetchNextPage = function() {



        httpRequest = new XMLHttpRequest();
      try {
        httpRequest.responseType = 'document';
      } catch(error){
        }
        httpRequest.onreadystatechange = function loadingfinished() {  try {
        
        

        
      
      if(jQInf(".debugbygss").length == 0) {
        jQInf("body").first().append('<div style="display: none !important;" id="debugbygss" class="debugbygss" ></div>');
      }

      jQInf(".gsdebuglisten10").remove();
      jQInf("#debugbygss").append("<div class='gsdebuglisten10'> Response status: " + httpRequest.status + " ready state: " + httpRequest.readyState + " </div>");
      } catch(err) {} 

          if (httpRequest.status == 200 && httpRequest.readyState == 4) {


          if(httpRequest.responseXML == null) {

          postData(this.nextStepLink, { })
            .then(data => {
        
            var data = jQInf(data);
        
        
            var appendedSection = data.find(collectionParent).get(0);

                    var appendaedPage = data.find(paginateSelector).get(0);
                    var nextPageNr = collectionPageNr + 1;

                    jQInf("#gsloaderimg").hide();
                    jQInf("#gsloadmore").show();


                    if (data.find("a[href*='page=" + nextPageNr + "']").length == 0) {
                        jQInf("#gscollectionbottom button").remove();
                        jQInf("#gscollectionbottom img").remove();
                    }

                    if (jQInf(".medium-up--one-half").length > 1 && (jQInf(data).find('.card').length > 0)) {

                        var columnCnt = 0;
                        jQInf(data).find('.card').each(function () {
                            jQInf(jQInf(jQInf(".medium-up--one-half").get(columnCnt))).get(0).insertAdjacentHTML('beforeend', jQInf(jQInf(this)).get(0).outerHTML);

        //jQInf(jQInf(".medium-up--one-half").get(columnCnt)).html(jQInf(this).innerHTML);
                            columnCnt++;
                            if (columnCnt > (jQInf(".medium-up--one-half").length - 1)) {
                                columnCnt = 0;
                            }
                        });

        // var appendedSection2 = httpRequest.responseXML.querySelectorAll('.medium-up--one-half')[0];
        // jQInf(jQInf(".medium-up--one-half").get(1)).insertAdjacentHTML('beforeend', appendedSection2.innerHTML);
                    } else {


                        jQInf(data).find('img').each(function () {
                            try {
                                jQInf(this).removeAttr("srcset");
                            } catch (err) {
                            }
                        });


                        jQInf(".more-views-slider").each(function(){
                            var images = jQInf(this).find(".image-list");

                            jQInf(images[0]).css('display', 'none');
                            jQInf(images[0]).removeClass('lightSlider lsGrab lSSlide');

                            jQInf(this).append(images[0]);

                            jQInf(this).find(".lSSlideOuter").each(function(){
                                jQInf(this).remove();
                            });

                            jQInf(images[0]).css('display', 'block');
                        });


                        this.containerElement.insertAdjacentHTML('beforeend', appendedSection.innerHTML);
                        //jQInf("body").append(jQInf('script[src*="application.min"]').get(0).outerHTML);

                        var thumbLoader = jQInf(this.containerElement).find(".thumb-loader");

                        if(thumbLoader.length > 0)
                        {
                            jQInf(thumbLoader).each(function () {
                                jQInf(this).css("opacity", '1');
                            });

                        }

                    }

                    var productImages = jQInf(this.containerElement).find(".product-item .product-image img");

                    jQInf(productImages).each(function(){
                        if(!jQInf(this).hasClass('loaded')){
                            jQInf(this).addClass('loaded');
                        }
                    });

                    if (collectionParent.indexOf("medium-up--one-half") > 0) {
                        jQInf(".card").css("opacity", '1');
                    }


                    if (jQInf(collectionParent).find(paginateSelector).length > 0) {
                        jQInf(this.containerElement).after(jQInf("#gscollectionbottom"));
                    }
                    this.paginateSection.innerHTML = appendaedPage.innerHTML;

                    if (jQInf(".cata-product .product-list-item").length > 0) {
                        jQInf(".cata-product .product-grid-item").each(function () {
                            jQInf(this).removeClass("product-grid-item");
                            jQInf(this).addClass("product-list-item");
                        });
                    }

                    if (loaderMode == 1) {
                        this.listenToScroll();
                    }
                
                    HsCartDrawer.quickBuyByttonByCollections(HsCartDrawer.json,HsCartDrawer.query);
                    HsCartDrawer.addToCart(HsCartDrawer.json,HsCartDrawer.query);   
        });  
        return;
          }

      if(specialTheme == 17) {
          collectionParent = collectionParent.replace(".isotope-products.border-no.loaded", ".isotope-products");
        }

      if(specialTheme == 21) {
          collectionParent = '.collection-products div';
        }

            var appendedSection = httpRequest.responseXML.querySelectorAll(collectionParent)[0];
      
      
        if(httpRequest.responseXML.querySelectorAll(collectionParent).length > 1) {
        appendedSection = httpRequest.responseXML.querySelectorAll(collectionParent)[containerPos - 1];
        } 
      

        try {
        jQInf(appendedSection).find(".slide-up-animation").removeClass("slide-up-animation");  
        } catch(err) {}
      
        if(specialTheme == 12) {
        jQInf(appendedSection).find(".box--add-hr").remove();
          }  

        // FIX FOR PARALAX THEME
        var paralaxImgs = jQInf(appendedSection).find(".product_image .product_container img");
        if(paralaxImgs.length > 0) {  
        paralaxImgs.each(function() {
        jQInf(this).css("opacity", "1");
        });     
        }


        var appHeaderEls = jQInf(appendedSection).find("header");
        if(appHeaderEls.length > 0) {  
        appHeaderEls.each(function() {
        jQInf(this).hide();
        });     
        }

      var containerForProducts = jQInf(this.containerElement);
      jQInf(appendedSection).find("script").each(function() {
            try {
                    if(containerForProducts.attr("class") == jQInf(this).parent().attr("class")) {
                            jQInf(this).remove();
                    }
            
            } catch(err) {}
      });
      
        if(jQInf(appendedSection).find("img:not(\"[src*='/products/']\")").length > 0 && jQInf(appendedSection).find("img[src*='/products/']").length == 0) {
          jQInf(appendedSection).find("img:not(\"[src*='/products/']\")").each(function() {
        var imgReference = jQInf(this).get(0);
        var suggestedImageUrl = '';
        var productImgContHtml = jQInf(this).parent().get(0).innerHTML;
        var splitImgUrls = productImgContHtml.split('cdn.shopify.com');
        
        var splitCnt = 0;
        var stringToExaminForImageUrl = '';
        jQInf.each(splitImgUrls, function(index) {
        if(splitCnt > 0) {
        if(this.indexOf('/products/') > 0) {
        if(stringToExaminForImageUrl == '') {
        stringToExaminForImageUrl = this;
          }
        }
        }
        splitCnt++;
        });
        
        if(splitImgUrls.length > 1) {
        var remainingpath = stringToExaminForImageUrl.replace("'", " ").replace('"', " ").replace(',', " ").replace(';', " ");
        splitImgUrls =  remainingpath.split(" ");
        suggestedImageUrl = splitImgUrls[0];
        suggestedImageUrl = '//cdn.shopify.com' + suggestedImageUrl;
        jQInf(imgReference).attr('src', suggestedImageUrl);
        }
        });
        }

        
            var appendaedPage = httpRequest.responseXML.querySelectorAll(paginateSelector)[0];
        var nextPageNr = collectionPageNr + 1;
        
            //this.containerElement.insertAdjacentHTML('beforeend', sessionStorage.getItem('gscollectioncontent'));
            //sessionStorage.setItem('gscollectioncontent', sessionStorage.getItem('gscollectioncontent') + '' + appendedSection.innerHTML);
        
        
        jQInf("#gsloaderimg").hide();
        jQInf("#gsloadmore").show();
        
        
      window.gscollectionpagenr = collectionPageNr;
        
        
        if(!httpRequest.responseXML.querySelector("a[href*='page=" + nextPageNr +  "']")) {
      try {
        //sessionStorage.setItem('gscollectionpagenr', -1);
        window.gscollectionpagenr = -1;
          
        }
        catch(err) {
        }  
        jQInf("#gscollectionbottom button").remove();
      jQInf("#gscollectionbottom img").remove();
        }
        else {
      try {
      window.gscollectionpagenr = collectionPageNr;
        //sessionStorage.setItem('gscollectionpagenr', collectionPageNr);
          }
          catch(err) {
          }  
        }
      if(jQInf(".medium-up--one-half, .medium-up--one-third").length > 1 && (jQInf(httpRequest.responseXML).find('.card').length > 0)) {

      var columnCnt = 0;
      jQInf(httpRequest.responseXML).find('.card').each(function() {
      jQInf(jQInf(jQInf(".medium-up--one-half, .medium-up--one-third").get(columnCnt))).get(0).insertAdjacentHTML('beforeend', jQInf(jQInf(this)).get(0).outerHTML);

      //jQInf(jQInf(".medium-up--one-half, .medium-up--one-third").get(columnCnt)).html(jQInf(this).innerHTML);
      columnCnt++;
      if(columnCnt > (jQInf(".medium-up--one-half, .medium-up--one-third").length - 1)) {
      columnCnt = 0;
      }
      });

      // var appendedSection2 = httpRequest.responseXML.querySelectorAll('.medium-up--one-half')[0];
      // jQInf(jQInf(".medium-up--one-half").get(1)).insertAdjacentHTML('beforeend', appendedSection2.innerHTML);
      }
      else { 

      if(jQInf(appendedSection).find(".hidden-handheld").length > 0) {
      jQInf(appendedSection).find(".hidden-handheld").remove();
      }

      jQInf(appendedSection).find("img[src*='loader.gif']").each(function() {
      if(jQInf(this).hasClass("product_image--current")) {
              jQInf(this).attr("src", jQInf(this).attr('data-src'));
      }
      });


      jQInf(httpRequest.responseXML).find('img').each(function() {
      try {
      jQInf(this).removeAttr("srcset");
      } catch(err) {}
      });


      //console.debug(sessionStorage.getItem('gscollectioncontent'));

      if(jQInf('.collection-grid-uninit .collection-header').length > 0) {
      if(jQInf(appendedSection).find("header").length > 0) {
      jQInf(appendedSection).find("header").remove();
      }

      var containerForChildren = jQInf("<div></div>");
      jQInf(appendedSection).find(".collection-grid-item").each(function() {
      containerForChildren.append(jQInf(this));
      });
      appendedSection = containerForChildren.get(0);
      }

      if(specialTheme == 33) {
      jQInf(appendedSection).find("figure").each(function() {
      var backgroundFromTemplate = jQInf(this).attr('data-rimg-template').replace("{size}", '544x800');
      jQInf(this).attr("style", 'background-image: url("' + backgroundFromTemplate + '");');
      });
      }


      if(jQInf("#bc-sf-filter-products").length > 0) {
      jQInf("#bc-sf-filter-products").append(appendedSection.innerHTML);
      }
      else {

      this.containerElement.insertAdjacentHTML('beforeend', appendedSection.innerHTML);

      try {
      jQInf(this.containerElement).children("style").each(function() {
      jQInf(this).hide();
      });
      } catch( error ){}


        try {
      var api = new Yotpo.API(yotpo);
      api.refreshWidgets();
        } catch(err) { }

        try {
      DoublyGlobalCurrency.convertAll($('[name=doubly-currencies]').val());
      setTimeout(function() {
        try {
      DoublyGlobalCurrency.convertAll($('[name=doubly-currencies]').val());
      } catch(err) { }

      }, 1000);

        }
        catch(err) { }


        try {
          if($(".fw-variants").length > 0) {
            $(".product_item").hover(function () {
            $(this).find(".fw-variant-list").stop().slideDown("slow");
            }, function(){
                $(this).find(".fw-variant-list").stop().slideUp("slow");
            })
        }
        }
        catch(err) { }  

        try {
      if ((typeof SCAShopify) !== 'undefined') {
      SCAShopify.jQuery(document).unbind('click.fb-start');
      SCAShopify.loaded = false;
      SCAQVinit = undefined;
      jQInf.getScript(jQInf('script[src*="sca-qv-"]').attr('src'));
      } 
        }
        catch(err) { }

        try {

      if (typeof ReloadSmartWishlist !== "undefined" && $.isFunction(ReloadSmartWishlist)) ReloadSmartWishlist();

        }
        catch(err) { }
          if(specialTheme == 15) {
          //jQInf("body").append(jQInf('script[src*="assets/theme.js"]').get(0).outerHTML);
          }  

          if(specialTheme == 11) {
          jQInf("body").append(jQInf('script[src*="assets/atlantic"]').get(0).outerHTML);
          }

      try {
      jQInf("body").append(jQInf('script[src*="assets/empire.js"]').get(0).outerHTML);
        }
        catch(err) { }

      if(specialTheme == 17) {
      window.scrollBy( 0, -2);
      }

            //this.containerElement.insertAdjacentHTML('beforeend', appendedSection.innerHTML);
      fixThemeSpecial();

      }

      try {
      jQInf(productsParentTmp.get(0)).find("script").hide();
      } catch(err) {}

      jQInf(jQInf(this.containerElement).find(".thumb-loader").length > 0)
      {
      jQInf(this.containerElement).find(".thumb-loader").each(function() {
      jQInf(this).css("opacity", '1');
      });     

      }

      }
                if(collectionParent.indexOf("medium-up--one-half") > 0 || collectionParent.indexOf("medium-up--one-third") > 0) {
                      jQInf(".card").css("opacity", '1');
                }


        if(jQInf(collectionParent).find(paginateSelector).length > 0) {
        jQInf(this.containerElement).after(jQInf("#gscollectionbottom"));
        }
            //this.paginateSection.innerHTML = appendaedPage.innerHTML;

      jQInf(this.paginateSection).innerHTML = '';
      //jQInf(this.paginateSection).append(jQInf(appendaedPage.innerHTML));
      jQInf(this.paginateSection).append(jQInf(appendaedPage));
        

        
        if(jQInf(".custom-category .toolbar-amount").length > 0 && jQInf(".custom-products").length > 0) { 
        jQInf('.modes').find(".active").trigger("click");
        }  

        if(jQInf(".cata-product .product-list-item").length > 0) {
        jQInf(".cata-product .product-grid-item").each(function() {
      jQInf(this).removeClass("product-grid-item");
      jQInf(this).addClass("product-list-item");
      });
        }

        if(loaderMode == 1) {
        this.listenToScroll();
          }

                        setTimeout(function()
                        {
      try {
      SPR.initRatingHandler();
      SPR.initDomEls();
      SPR.loadBadges();
      } catch( error ){}
      }, 1000);


      setTimeout(function()
      {
      try {
      var resizeEvent = window.document.createEvent('UIEvents');
      resizeEvent .initUIEvent('resize', true, false, window, 0);
      window.dispatchEvent(resizeEvent);
      $(window).trigger('forceproductblockheights');
      } catch(err) {
      }
      //jQInf(window).trigger('resize');
      }, 1000);


      sessionStorage.setItem('gscollectionpagenr', window.gscollectionpagenr);

      try {
      if(sessionStorage.getItem('gscollectioncontent') != null && sessionStorage.getItem('gscollectioncontent') != "") {
      sessionStorage.setItem('gscollectioncontent', sessionStorage.getItem('gscollectioncontent') + '' + appendedSection.innerHTML);
      }
      else {
      sessionStorage.setItem('gscollectionurl', window.location.href);
      sessionStorage.setItem('gscollectioncontent', appendedSection.innerHTML);
      }
      } catch(err) {
      try {
      sessionStorage.setItem('gscollectioncontent', '');
      } catch(err) {}
      }



      try {
      sessionStorage.setItem('gspaginatecontent', appendaedPage.innerHTML);
      }
      catch(err) {
      }



          }
        }.bind(this);

      try {
        httpRequest.gsOpen('GET', this.nextStepLink);
        httpRequest.responseType = 'document';
        httpRequest.gsSend();
      }
      catch(err) {
        httpRequest.open('GET', this.nextStepLink);
      httpRequest.responseType = 'document';
        httpRequest.send();
      }

      };

      GSLoader.prototype.analyseView = function() {
        
        if (document.getElementById("gscollectionbottom").getBoundingClientRect().top <= window.innerHeight && document.getElementById("gscollectionbottom").getBoundingClientRect().bottom >= 0) {
        window.collectionPageNr = collectionPageNr + 1;  
          this.nextSetUrl = this.paginateSection.querySelector("a[href*='page=" + collectionPageNr +  "']");

      var pageUrl = window.location.href;
      if(pageUrl.indexOf('?')) {
      var exploded = pageUrl.split("?");
      pageUrl = exploded[0];
      }
      if(pageUrl.indexOf('#')) {
      var exploded = pageUrl.split("#");
      pageUrl = exploded[0];
      }

          document.removeEventListener('scroll', this.analyseView);
          window.removeEventListener('resize', this.analyseView);
          window.removeEventListener('orientationchange', this.analyseView);

          if (this.nextSetUrl || (jQInf("#bc-sf-filter-products").length > 0)) {

              var paramGSStr = '';

              if(getUrlParamsGS("sort_by") != null) {
              paramGSStr = paramGSStr + "&sort_by=" + getUrlParamsGS("sort_by");
              }

              if(getUrlParamsGS("view") != null) {
              paramGSStr = paramGSStr + "&view=" + getUrlParamsGS("view");
              }

              if(getUrlParamsGS("q") != null) {
              paramGSStr = paramGSStr + "&q=" + getUrlParamsGS("q");
              }

              if(getUrlParamsGS("constraint") != null) {
              paramGSStr = paramGSStr + "&constraint=" + getUrlParamsGS("constraint");
              }

            this.nextStepLink = pageUrl + '?page=' + collectionPageNr + paramGSStr;
        this.fetchNextPage();
          }
      else {
      jQInf("#gscollectionbottom img").remove();
      }
        }
      };

      GSLoader.prototype.clickMoreBtn = function() {
        
        window.collectionPageNr = collectionPageNr + 1;  
          gsscroller.nextSetUrl = paginateSel.querySelector("a[href*='page=" + collectionPageNr +  "']");

      var pageUrl = window.location.href;
      if(pageUrl.indexOf('?')) {
      var exploded = pageUrl.split("?");
      pageUrl = exploded[0];
      }
      if(pageUrl.indexOf('#')) {
      var exploded = pageUrl.split("#");
      pageUrl = exploded[0];
      }
      jQInf("#gsloaderimg").show();
      jQInf("#gsloadmore").hide();

          if (gsscroller.nextSetUrl) {

              var paramGSStr = '';

              if(getUrlParamsGS("sort_by") != null) {
              paramGSStr = paramGSStr + "&sort_by=" + getUrlParamsGS("sort_by");
              }

              if(getUrlParamsGS("view") != null) {
              paramGSStr = paramGSStr + "&view=" + getUrlParamsGS("view");
              }

              if(getUrlParamsGS("q") != null) {
              paramGSStr = paramGSStr + "&q=" + getUrlParamsGS("q");
              }

              if(getUrlParamsGS("constraint") != null) {
              paramGSStr = paramGSStr + "&constraint=" + getUrlParamsGS("constraint");
              }

            gsscroller.nextStepLink = pageUrl + '?page=' + collectionPageNr + paramGSStr;
        gsscroller.fetchNextPage();
          }
      else {
      jQInf("#gscollectionbottom button").remove();
      jQInf("#gscollectionbottom img").remove();
      }
        
      };

      if((window.location.href.indexOf("/collections/") > 0)) {
      if((window.location.href.indexOf("&page=") > 0) || (window.location.href.indexOf("?page=") > 0)) {
      var newUrlRedirect = window.location.href.replace("page=", "redirect=");
      window.location.href = newUrlRedirect;
      }
      }
      }
  </script>










  <script src="//jisora.com/cdn/shop/t/29/assets/smk-sections.js?v=124175246122752485611679922258" defer="defer">
  </script>


  <!-- START BEAE POPUP BUILDER -->
  <!-- END BEAE POPUP BUILDER -->
  <!-- PickyStory code, do not modify. Safe to remove after the app is uninstalled -->

  <!-- PickyStory code end -->
  <!-- PickyStory snippet "main_widget_script", do not modify. Safe to remove after the app is uninstalled -->

  <!-- PickyStory end snippet "main_widget_script" -->

  <!--  Magic Checkout Code Starts -->

  <script>
        window.widgetIDForMagicCheckout = "one-click-popup-5291483133846-pull-out-5635";


    window.onCompleteMagiCheckout = (id, price) => {
      gtag('event', 'conversion', {
          'send_to': 'AW-340852420/uMCQCNS91roDEMT9w6IB',
          'value': price/100,
          'currency': 'INR',
          'transaction_id': `${id}`
      });
    }

  </script>



  <input id="rzpKey" type="hidden" name="rzpKey" value="rzp_live_SeVF4kApMclxt4">

  <script src="https://cdn.razorpay.com/static/shopify/analytics.js"></script>
  <script src="https://cdn.razorpay.com/static/shopify/magic-rzp.js" data-email="" data-phonenumber=""></script>



  <div id="rzp-spinner-backdrop">
    <div id="rzp-spinner">
      <div id="loading-indicator" />
    </div>
  </div>


  <style>
    #rzp-spinner-backdrop {
      position: fixed;
      top: 0;
      left: 0;
      z-index: 9999;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0);
      visibility: hidden;
      opacity: 0;
    }

    #rzp-spinner-backdrop.show {
      visibility: visible;
      opacity: 0.4;
    }

    #rzp-spinner {
      visibility: hidden;
      opacity: 0;
      /* positioning and centering */
      position: fixed;
      left: 0;
      top: 0;
      bottom: 0;
      right: 0;
      margin: auto;
      z-index: 10000;
      display: flex !important;
      align-items: center;
      justify-content: center;
    }

    #rzp-spinner.show {
      visibility: visible;
      opacity: 1;
    }

    @keyframes rotate {
      0% {
        transform: rotate(0);
      }

      100% {
        transform: rotate(360deg);
      }
    }

    #loading-indicator {
      border-radius: 50%;
      width: 80px;
      height: 80px;
      border: 4px solid;
      border-color: rgb(59, 124, 245) transparent rgb(59, 124, 245) rgb(59, 124, 245) !important;
      animation: 1s linear 0s infinite normal none running rotate;
      margin-top: 2px;
      box-sizing: content-box;
    }
  </style>


  <!--  Magic Checkout Code Ends -->




  <script
    src="https://app.kiwisizing.com/web/js/dist/kiwiSizing/plugin/SizingPlugin.prod.js?v=308&shop=jisora-india.myshopify.com">
  </script>
  <script>
      jQuery(document).ready(function ($) {
      
        var win_width = $(window).width();
    
        if(win_width < 769){
            
            jQuery('#CartDrawer form#CartDrawerForm .drawer__close .drawer__close-button,#CollectionSidebar #FilterDrawer .drawer__close .drawer__close-button').click(function(e){
                e.preventDefault();
                e.stopPropagation();
                  setTimeout(() => {
                        $('.header-wrapper header.site-header').removeClass('draweractive');
                    }, 200);
                
            });
    
            jQuery('a.site-nav__link.js-drawer-open-cart, .collection-filter button.js-drawer-open-collection-filters').click(function(e){
                setTimeout(() => {
                        $('.header-wrapper header.site-header').addClass('draweractive');
                }, 200);
            });
    
        }
    
    });
  </script>
  <div id="shopify-block-17309853810776502128" class="shopify-block shopify-app-block">
    <script>
      var pify_shop = "jisora-india.myshopify.com";
    </script>


  </div>
  <div id="shopify-block-18071494811699525790" class="shopify-block shopify-app-block">
    <!-- artic app -->
    <!-- artic script -->
    <script>
          (function() {
      function asyncLoad() {
        var url = "https://app.getartic.com/scripts/artic-overlay.js?v=1672298995090\u0026shop=jisora-india.myshopify.com"
        var s = document.createElement('script');
        s.type = 'text/javascript';
        s.async = true;
        s.src = url;
        var x = document.getElementsByTagName('script')[0];
        x.parentNode.insertBefore(s, x);
      };
      if(window.attachEvent) {
        window.attachEvent('onload', asyncLoad);
      } else {
        window.addEventListener('load', asyncLoad, false);
      }
      })();
    </script>
  </div>
  <div id="shopify-block-13070091535480640111" class="shopify-block shopify-app-block"><input type="hidden"
      class="aph_bars_app_embed" value=[{"id":"272014_630590","type":"bar"},{"id":"559601_109535","type":"bar"}] />

  </div>
</body>

</html>