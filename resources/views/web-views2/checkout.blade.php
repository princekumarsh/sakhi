
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
      position : relative;
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
      position : absolute;
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



    
        <link rel="preload" href="//jisora.com/cdn/shop/files/SMP02530.jpg?v=1699620993">
    
        <link rel="preload" href="//jisora.com/cdn/shop/files/SMP02532.jpg?v=1699620991">
    
        <link rel="preload" href="//jisora.com/cdn/shop/files/SMP02534.jpg?v=1699620990">
    
        <link rel="preload" href="//jisora.com/cdn/shop/files/SMP02537.jpg?v=1699620992">
    
        <link rel="preload" href="//jisora.com/cdn/shop/files/SMP02542.jpg?v=1699620990">
    
        <link rel="preload" href="//jisora.com/cdn/shop/files/SMP02547.jpg?v=1699620995">
    
        <link rel="preload" href="//jisora.com/cdn/shop/files/SMP02549.jpg?v=1699620990">
    
        <link rel="preload" href="//jisora.com/cdn/shop/files/SMP02555.jpg?v=1699620993">
    
        <link rel="preload" href="//jisora.com/cdn/shop/files/SMP02558.jpg?v=1699620992">
    
        <link rel="preload" href="//jisora.com/cdn/shop/files/SMP02561.jpg?v=1699620994">
    
        <link rel="preload" href="//jisora.com/cdn/shop/files/SMP02564.jpg?v=1699620994">
    
        <link rel="preload" href="//jisora.com/cdn/shop/files/SMP02566.jpg?v=1699620991">
    




<script src="https://cdn.beae.com/vendors/js-v2/jquery.min.js"  crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="https://cdn.ecomposer.app/vendors/js/jquery.min.js"  crossorigin="anonymous" referrerpolicy="no-referrer"></script><meta name="facebook-domain-verification" content="4vkzi7rxmd3wy3jkmwulv32u2prlfw" />

	<!-- Added by AVADA SEO Suite -->
	


	<!-- /Added by AVADA SEO Suite -->
<script>
window.KiwiSizing = window.KiwiSizing === undefined ? {} : window.KiwiSizing;
KiwiSizing.shop = "jisora-india.myshopify.com";


KiwiSizing.data = {
  collections: "399990030561,267755454622,238747582622,276996063390,403154665697,238747254942,238747353246",
  tags: "8TBS,Black Friday,Co-ord Sets,New,Sale,Shrug Sets,TBS,Western Wear",
  product: "8149411725537",
  vendor: "JISORA",
  type: "Co-ord Sets",
  title: "Ebony blossom three piece cotton co-ord set",
  images: ["\/\/jisora.com\/cdn\/shop\/files\/SMP02530.jpg?v=1699620993","\/\/jisora.com\/cdn\/shop\/files\/SMP02532.jpg?v=1699620991","\/\/jisora.com\/cdn\/shop\/files\/SMP02534.jpg?v=1699620990","\/\/jisora.com\/cdn\/shop\/files\/SMP02537.jpg?v=1699620992","\/\/jisora.com\/cdn\/shop\/files\/SMP02542.jpg?v=1699620990","\/\/jisora.com\/cdn\/shop\/files\/SMP02547.jpg?v=1699620995","\/\/jisora.com\/cdn\/shop\/files\/SMP02549.jpg?v=1699620990","\/\/jisora.com\/cdn\/shop\/files\/SMP02555.jpg?v=1699620993","\/\/jisora.com\/cdn\/shop\/files\/SMP02558.jpg?v=1699620992","\/\/jisora.com\/cdn\/shop\/files\/SMP02561.jpg?v=1699620994","\/\/jisora.com\/cdn\/shop\/files\/SMP02564.jpg?v=1699620994","\/\/jisora.com\/cdn\/shop\/files\/SMP02566.jpg?v=1699620991"],
  options: [{"name":"Size","position":1,"values":["S","M","L","XL"]}],
  variants: [{"id":44218255900897,"title":"S","option1":"S","option2":null,"option3":null,"sku":"9TBS2234-S","requires_shipping":true,"taxable":true,"featured_image":null,"available":true,"name":"Ebony blossom three piece cotton co-ord set - S","public_title":"S","options":["S"],"price":179910,"weight":240,"compare_at_price":199900,"inventory_management":"shopify","barcode":"9TBS2234-S","requires_selling_plan":false,"selling_plan_allocations":[]},{"id":44218255933665,"title":"M","option1":"M","option2":null,"option3":null,"sku":"9TBS2234-M","requires_shipping":true,"taxable":true,"featured_image":null,"available":true,"name":"Ebony blossom three piece cotton co-ord set - M","public_title":"M","options":["M"],"price":179910,"weight":240,"compare_at_price":199900,"inventory_management":"shopify","barcode":"9TBS2234-M","requires_selling_plan":false,"selling_plan_allocations":[]},{"id":44218255966433,"title":"L","option1":"L","option2":null,"option3":null,"sku":"9TBS2234-L","requires_shipping":true,"taxable":true,"featured_image":null,"available":false,"name":"Ebony blossom three piece cotton co-ord set - L","public_title":"L","options":["L"],"price":179910,"weight":240,"compare_at_price":199900,"inventory_management":"shopify","barcode":"9TBS2234-L","requires_selling_plan":false,"selling_plan_allocations":[]},{"id":44218255999201,"title":"XL","option1":"XL","option2":null,"option3":null,"sku":"9TBS2234-XL","requires_shipping":true,"taxable":true,"featured_image":null,"available":false,"name":"Ebony blossom three piece cotton co-ord set - XL","public_title":"XL","options":["XL"],"price":179910,"weight":240,"compare_at_price":199900,"inventory_management":"shopify","barcode":"9TBS2234-XL","requires_selling_plan":false,"selling_plan_allocations":[]}],
};

</script>


  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="theme-color" content="#750902">
  <link rel="canonical" href="https://jisora.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
  <link rel="preconnect" href="https://cdn.shopify.com">
  <link rel="preconnect" href="https://fonts.shopifycdn.com">
  <link rel="dns-prefetch" href="https://productreviews.shopifycdn.com">
  <link rel="dns-prefetch" href="https://ajax.googleapis.com">
  <link rel="dns-prefetch" href="https://maps.googleapis.com">
  <link rel="dns-prefetch" href="https://maps.gstatic.com"><link rel="shortcut icon" href="//jisora.com/cdn/shop/files/jisora-logo_32x32_5c13bc54-2d3d-4bd0-870d-d4b7dd3ca847_32x32.webp?v=1648472682" type="image/png" /><title>Ebony blossom three piece cotton co-ord set
&ndash; JISORA
</title>
<meta name="description" content="Dress up your wardrobe with this one-of-a-kind Ebony Blossom three piece set! Perfect for all seasons, this cotton co-ord set is as comfy as it is stylish - don&#39;t miss out on this blooming beauty!"><meta property="og:site_name" content="JISORA">
  <meta property="og:url" content="https://jisora.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
  <meta property="og:title" content="Ebony blossom three piece cotton co-ord set">
  <meta property="og:type" content="product">
  <meta property="og:description" content="Dress up your wardrobe with this one-of-a-kind Ebony Blossom three piece set! Perfect for all seasons, this cotton co-ord set is as comfy as it is stylish - don&#39;t miss out on this blooming beauty!"><meta property="og:image" content="http://jisora.com/cdn/shop/files/SMP02530.jpg?v=1699620993">
    <meta property="og:image:secure_url" content="https://jisora.com/cdn/shop/files/SMP02530.jpg?v=1699620993">
    <meta property="og:image:width" content="1800">
    <meta property="og:image:height" content="2700"><meta name="twitter:site" content="@">
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="Ebony blossom three piece cotton co-ord set">
  <meta name="twitter:description" content="Dress up your wardrobe with this one-of-a-kind Ebony Blossom three piece set! Perfect for all seasons, this cotton co-ord set is as comfy as it is stylish - don&#39;t miss out on this blooming beauty!">
<style data-shopify>@font-face {
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

</style><link href="//jisora.com/cdn/shop/t/29/assets/theme.css?v=17779316306180987911700637277" rel="stylesheet" type="text/css" media="all" />
<style data-shopify>:root {
    --typeHeaderPrimary: "Avenir Next";
    --typeHeaderFallback: sans-serif;
    --typeHeaderSize: 36px;
    --typeHeaderWeight: 400;
    --typeHeaderLineHeight: 1;
    --typeHeaderSpacing: 0.0em;

    --typeBasePrimary:"Avenir Next";
    --typeBaseFallback:sans-serif;
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
  }</style><link rel="preconnect" href="https://fonts.googleapis.com">
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
      moneyFormat: "\u003cspan class=money\u003eRs. 123\u003c\/span\u003e",
      saveType: "percent",
      productImageSize: "natural",
      productImageCover: false,
      predictiveSearch: true,
      predictiveSearchType: "product,article,page,collection",
      quickView: true,
      themeName: 'Impulse',
      themeVersion: "5.5.0"
    };
  </script>

  <script>window.performance && window.performance.mark && window.performance.mark('shopify.content_for_header.start');</script><meta name="google-site-verification" content="9lv5hlWXCHUa4Q2jZ4xiry7kd3WguvMa_2hkdGO-8x8">
<meta name="facebook-domain-verification" content="knxteuct9pabnw13m9brd9itwey6c7">
<meta name="google-site-verification" content="XOv7JCPoi141qVPtmm7XJ3cofxzagP7Kl9kS-ioC7uY">
<meta id="shopify-digital-wallet" name="shopify-digital-wallet" content="/52435222686/digital_wallets/dialog">
<link rel="alternate" hreflang="x-default" href="https://jisora.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-IN" href="https://jisora.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-AC" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-AD" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-AF" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-AG" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-AI" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-AL" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-AM" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-AO" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-AR" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-AT" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-AU" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-AW" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-AX" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-AZ" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-BA" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-BB" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-BD" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-BE" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-BF" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-BG" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-BH" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-BI" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-BJ" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-BL" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-BM" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-BN" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-BO" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-BQ" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-BR" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-BS" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-BT" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-BW" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-BY" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-BZ" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-CA" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-CC" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-CD" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-CF" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-CG" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-CH" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-CI" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-CK" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-CL" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-CM" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-CN" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-CO" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-CR" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-CV" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-CW" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-CX" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-CY" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-CZ" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-DE" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-DJ" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-DK" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-DM" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-DO" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-DZ" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-EC" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-EE" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-EG" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-EH" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-ER" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-ES" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-ET" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-FI" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-FJ" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-FK" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-FO" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-FR" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-GA" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-GB" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-GD" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-GE" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-GF" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-GG" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-GH" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-GI" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-GL" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-GM" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-GN" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-GP" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-GQ" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-GR" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-GS" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-GT" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-GW" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-GY" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-HK" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-HN" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-HR" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-HT" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-HU" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-ID" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-IE" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-IL" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-IM" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-IO" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-IQ" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-IS" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-IT" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-JE" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-JM" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-JO" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-JP" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-KE" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-KG" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-KH" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-KI" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-KM" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-KN" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-KR" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-KW" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-KY" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-KZ" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-LA" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-LB" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-LC" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-LI" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-LK" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-LR" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-LS" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-LT" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-LU" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-LV" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-LY" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-MA" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-MC" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-MD" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-ME" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-MF" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-MG" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-MK" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-ML" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-MM" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-MN" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-MO" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-MQ" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-MR" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-MS" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-MT" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-MU" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-MV" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-MW" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-MX" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-MY" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-MZ" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-NA" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-NC" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-NE" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-NF" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-NG" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-NI" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-NL" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-NO" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-NP" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-NR" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-NU" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-NZ" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-OM" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-PA" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-PE" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-PF" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-PG" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-PH" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-PK" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-PL" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-PM" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-PN" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-PS" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-PT" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-PY" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-QA" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-RE" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-RO" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-RS" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-RU" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-RW" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-SA" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-SB" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-SC" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-SD" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-SE" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-SG" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-SH" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-SI" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-SJ" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-SK" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-SL" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-SM" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-SN" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-SO" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-SR" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-SS" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-ST" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-SV" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-SX" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-SZ" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-TA" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-TC" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-TD" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-TF" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-TG" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-TH" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-TJ" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-TK" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-TL" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-TM" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-TN" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-TO" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-TR" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-TT" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-TV" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-TW" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-TZ" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-UA" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-UG" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-UM" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-UY" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-UZ" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-VA" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-VC" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-VE" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-VG" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-VN" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-VU" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-WF" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-WS" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-XK" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-YE" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-YT" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-ZA" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-ZM" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-ZW" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-AE" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" hreflang="en-US" href="https://jisoraglobal.com/products/ebony-blossom-three-piece-cotton-co-ord-set">
<link rel="alternate" type="application/json+oembed" href="https://jisora.com/products/ebony-blossom-three-piece-cotton-co-ord-set.oembed">
<script async="async" src="/checkouts/internal/preloads.js?locale=en-IN"></script><script id="shopify-features" type="application/json">{"accessToken":"eb2593c7ceb54a8a758b01334c292035","betas":["rich-media-storefront-analytics"],"domain":"jisora.com","predictiveSearch":true,"shopId":52435222686,"smart_payment_buttons_url":"https:\/\/jisora.com\/cdn\/shopifycloud\/payment-sheet\/assets\/latest\/spb.en.js","dynamic_checkout_cart_url":"https:\/\/jisora.com\/cdn\/shopifycloud\/payment-sheet\/assets\/latest\/dynamic-checkout-cart.en.js","locale":"en","optimusEnabled":true,"optimusHidden":false,"betterDynamicCheckoutRecommendationVariant":"control","shopPromisePDPV3Enabled":true}</script>
<script>var Shopify = Shopify || {};
Shopify.shop = "jisora-india.myshopify.com";
Shopify.locale = "en";
Shopify.currency = {"active":"INR","rate":"1.0"};
Shopify.country = "IN";
Shopify.theme = {"name":"Zecpe [27 March]","id":136894873825,"theme_store_id":null,"role":"main"};
Shopify.theme.handle = "null";
Shopify.theme.style = {"id":null,"handle":null};
Shopify.cdnHost = "jisora.com/cdn";
Shopify.routes = Shopify.routes || {};
Shopify.routes.root = "/";</script>
<script type="module">!function(o){(o.Shopify=o.Shopify||{}).modules=!0}(window);</script>
<script>!function(o){function n(){var o=[];function n(){o.push(Array.prototype.slice.apply(arguments))}return n.q=o,n}var t=o.Shopify=o.Shopify||{};t.loadFeatures=n(),t.autoloadFeatures=n()}(window);</script>
<script>(function() {
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
})();</script>
<script id="__st">var __st={"a":52435222686,"offset":19800,"reqid":"92442978-8557-4f94-8083-b26f411585eb","pageurl":"jisora.com\/collections\/new-arrivals\/products\/ebony-blossom-three-piece-cotton-co-ord-set?variant=44218255933665","t":"prospect","u":"981ed6ba0d5d","p":"product","rtyp":"product","rid":8149411725537};</script>
<script>window.ShopifyPaypalV4VisibilityTracking = true;</script>
<script>!function(o){o.addEventListener("DOMContentLoaded",function(){window.Shopify=window.Shopify||{},window.Shopify.recaptchaV3=window.Shopify.recaptchaV3||{siteKey:"6LcCR2cUAAAAANS1Gpq_mDIJ2pQuJphsSQaUEuc9"};var t=['form[action*="/contact"] input[name="form_type"][value="contact"]','form[action*="/comments"] input[name="form_type"][value="new_comment"]','form[action*="/account"] input[name="form_type"][value="customer_login"]','form[action*="/account"] input[name="form_type"][value="recover_customer_password"]','form[action*="/account"] input[name="form_type"][value="create_customer"]','form[action*="/contact"] input[name="form_type"][value="customer"]'].join(",");function n(e){e=e.target;null==e||null!=(e=function e(t,n){if(null==t.parentElement)return null;if("FORM"!=t.parentElement.tagName)return e(t.parentElement,n);for(var o=t.parentElement.action,r=0;r<n.length;r++)if(-1!==o.indexOf(n[r]))return t.parentElement;return null}(e,["/contact","/comments","/account"]))&&null!=e.querySelector(t)&&((e=o.createElement("script")).setAttribute("src","https://cdn.shopify.com/shopifycloud/storefront-recaptcha-v3/v0.6/index.js"),o.body.appendChild(e),o.removeEventListener("focus",n,!0),o.removeEventListener("change",n,!0),o.removeEventListener("click",n,!0))}o.addEventListener("click",n,!0),o.addEventListener("change",n,!0),o.addEventListener("focus",n,!0)})}(document);</script>
<script integrity="sha256-h4dvokWvGcvRSqiG7VnGqoonxF0k3NeoHPLSMjUGIz4=" data-source-attribution="shopify.loadfeatures" defer="defer" src="//jisora.com/cdn/shopifycloud/shopify/assets/storefront/load_feature-87876fa245af19cbd14aa886ed59c6aa8a27c45d24dcd7a81cf2d2323506233e.js" crossorigin="anonymous"></script>
<script data-source-attribution="shopify.dynamic_checkout.dynamic.init">var Shopify=Shopify||{};Shopify.PaymentButton=Shopify.PaymentButton||{isStorefrontPortableWallets:!0,init:function(){window.Shopify.PaymentButton.init=function(){};var t=document.createElement("script");t.src="https://jisora.com/cdn/shopifycloud/portable-wallets/latest/portable-wallets.en.js",t.type="module",document.head.appendChild(t)}};
</script>
<script integrity="sha256-HAs5a9TQVLlKuuHrahvWuke+s1UlxXohfHeoYv8G2D8=" data-source-attribution="shopify.dynamic-checkout" defer="defer" src="//jisora.com/cdn/shopifycloud/shopify/assets/storefront/features-1c0b396bd4d054b94abae1eb6a1bd6ba47beb35525c57a217c77a862ff06d83f.js" crossorigin="anonymous"></script>


<script>window.performance && window.performance.mark && window.performance.mark('shopify.content_for_header.end');</script>

  <script src="//jisora.com/cdn/shop/t/29/assets/vendor-scripts-v11.js" defer="defer"></script><script src="//jisora.com/cdn/shop/t/29/assets/theme.js?v=19629914627915677641679922258" defer="defer"></script><script
  src="https://code.jquery.com/jquery-3.6.0.min.js"
  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
  crossorigin="anonymous"></script><link rel="stylesheet" href="https://unpkg.com/flickity@2/dist/flickity.min.css">
  
  <script src="https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js"></script><style type='text/css'>
  .baCountry{width:30px;height:20px;display:inline-block;vertical-align:middle;margin-right:6px;background-size:30px!important;border-radius:4px;background-repeat:no-repeat}
  .baCountry-traditional .baCountry{background-image:url(https://cdn.shopify.com/s/files/1/0194/1736/6592/t/1/assets/ba-flags.png?=14261939516959647149);height:19px!important}
  .baCountry-modern .baCountry{background-image:url(https://cdn.shopify.com/s/files/1/0194/1736/6592/t/1/assets/ba-flags.png?=14261939516959647149)}
  .baCountry-NO-FLAG{background-position:0 0}.baCountry-AD{background-position:0 -20px}.baCountry-AED{background-position:0 -40px}.baCountry-AFN{background-position:0 -60px}.baCountry-AG{background-position:0 -80px}.baCountry-AI{background-position:0 -100px}.baCountry-ALL{background-position:0 -120px}.baCountry-AMD{background-position:0 -140px}.baCountry-AOA{background-position:0 -160px}.baCountry-ARS{background-position:0 -180px}.baCountry-AS{background-position:0 -200px}.baCountry-AT{background-position:0 -220px}.baCountry-AUD{background-position:0 -240px}.baCountry-AWG{background-position:0 -260px}.baCountry-AZN{background-position:0 -280px}.baCountry-BAM{background-position:0 -300px}.baCountry-BBD{background-position:0 -320px}.baCountry-BDT{background-position:0 -340px}.baCountry-BE{background-position:0 -360px}.baCountry-BF{background-position:0 -380px}.baCountry-BGN{background-position:0 -400px}.baCountry-BHD{background-position:0 -420px}.baCountry-BIF{background-position:0 -440px}.baCountry-BJ{background-position:0 -460px}.baCountry-BMD{background-position:0 -480px}.baCountry-BND{background-position:0 -500px}.baCountry-BOB{background-position:0 -520px}.baCountry-BRL{background-position:0 -540px}.baCountry-BSD{background-position:0 -560px}.baCountry-BTN{background-position:0 -580px}.baCountry-BWP{background-position:0 -600px}.baCountry-BYN{background-position:0 -620px}.baCountry-BZD{background-position:0 -640px}.baCountry-CAD{background-position:0 -660px}.baCountry-CC{background-position:0 -680px}.baCountry-CDF{background-position:0 -700px}.baCountry-CG{background-position:0 -720px}.baCountry-CHF{background-position:0 -740px}.baCountry-CI{background-position:0 -760px}.baCountry-CK{background-position:0 -780px}.baCountry-CLP{background-position:0 -800px}.baCountry-CM{background-position:0 -820px}.baCountry-CNY{background-position:0 -840px}.baCountry-COP{background-position:0 -860px}.baCountry-CRC{background-position:0 -880px}.baCountry-CU{background-position:0 -900px}.baCountry-CX{background-position:0 -920px}.baCountry-CY{background-position:0 -940px}.baCountry-CZK{background-position:0 -960px}.baCountry-DE{background-position:0 -980px}.baCountry-DJF{background-position:0 -1000px}.baCountry-DKK{background-position:0 -1020px}.baCountry-DM{background-position:0 -1040px}.baCountry-DOP{background-position:0 -1060px}.baCountry-DZD{background-position:0 -1080px}.baCountry-EC{background-position:0 -1100px}.baCountry-EE{background-position:0 -1120px}.baCountry-EGP{background-position:0 -1140px}.baCountry-ER{background-position:0 -1160px}.baCountry-ES{background-position:0 -1180px}.baCountry-ETB{background-position:0 -1200px}.baCountry-EUR{background-position:0 -1220px}.baCountry-FI{background-position:0 -1240px}.baCountry-FJD{background-position:0 -1260px}.baCountry-FKP{background-position:0 -1280px}.baCountry-FO{background-position:0 -1300px}.baCountry-FR{background-position:0 -1320px}.baCountry-GA{background-position:0 -1340px}.baCountry-GBP{background-position:0 -1360px}.baCountry-GD{background-position:0 -1380px}.baCountry-GEL{background-position:0 -1400px}.baCountry-GHS{background-position:0 -1420px}.baCountry-GIP{background-position:0 -1440px}.baCountry-GL{background-position:0 -1460px}.baCountry-GMD{background-position:0 -1480px}.baCountry-GNF{background-position:0 -1500px}.baCountry-GQ{background-position:0 -1520px}.baCountry-GR{background-position:0 -1540px}.baCountry-GTQ{background-position:0 -1560px}.baCountry-GU{background-position:0 -1580px}.baCountry-GW{background-position:0 -1600px}.baCountry-HKD{background-position:0 -1620px}.baCountry-HNL{background-position:0 -1640px}.baCountry-HRK{background-position:0 -1660px}.baCountry-HTG{background-position:0 -1680px}.baCountry-HUF{background-position:0 -1700px}.baCountry-IDR{background-position:0 -1720px}.baCountry-IE{background-position:0 -1740px}.baCountry-ILS{background-position:0 -1760px}.baCountry-INR{background-position:0 -1780px}.baCountry-IO{background-position:0 -1800px}.baCountry-IQD{background-position:0 -1820px}.baCountry-IRR{background-position:0 -1840px}.baCountry-ISK{background-position:0 -1860px}.baCountry-IT{background-position:0 -1880px}.baCountry-JMD{background-position:0 -1900px}.baCountry-JOD{background-position:0 -1920px}.baCountry-JPY{background-position:0 -1940px}.baCountry-KES{background-position:0 -1960px}.baCountry-KGS{background-position:0 -1980px}.baCountry-KHR{background-position:0 -2000px}.baCountry-KI{background-position:0 -2020px}.baCountry-KMF{background-position:0 -2040px}.baCountry-KN{background-position:0 -2060px}.baCountry-KP{background-position:0 -2080px}.baCountry-KRW{background-position:0 -2100px}.baCountry-KWD{background-position:0 -2120px}.baCountry-KYD{background-position:0 -2140px}.baCountry-KZT{background-position:0 -2160px}.baCountry-LBP{background-position:0 -2180px}.baCountry-LI{background-position:0 -2200px}.baCountry-LKR{background-position:0 -2220px}.baCountry-LRD{background-position:0 -2240px}.baCountry-LSL{background-position:0 -2260px}.baCountry-LT{background-position:0 -2280px}.baCountry-LU{background-position:0 -2300px}.baCountry-LV{background-position:0 -2320px}.baCountry-LYD{background-position:0 -2340px}.baCountry-MAD{background-position:0 -2360px}.baCountry-MC{background-position:0 -2380px}.baCountry-MDL{background-position:0 -2400px}.baCountry-ME{background-position:0 -2420px}.baCountry-MGA{background-position:0 -2440px}.baCountry-MKD{background-position:0 -2460px}.baCountry-ML{background-position:0 -2480px}.baCountry-MMK{background-position:0 -2500px}.baCountry-MN{background-position:0 -2520px}.baCountry-MOP{background-position:0 -2540px}.baCountry-MQ{background-position:0 -2560px}.baCountry-MR{background-position:0 -2580px}.baCountry-MS{background-position:0 -2600px}.baCountry-MT{background-position:0 -2620px}.baCountry-MUR{background-position:0 -2640px}.baCountry-MVR{background-position:0 -2660px}.baCountry-MWK{background-position:0 -2680px}.baCountry-MXN{background-position:0 -2700px}.baCountry-MYR{background-position:0 -2720px}.baCountry-MZN{background-position:0 -2740px}.baCountry-NAD{background-position:0 -2760px}.baCountry-NE{background-position:0 -2780px}.baCountry-NF{background-position:0 -2800px}.baCountry-NG{background-position:0 -2820px}.baCountry-NIO{background-position:0 -2840px}.baCountry-NL{background-position:0 -2860px}.baCountry-NOK{background-position:0 -2880px}.baCountry-NPR{background-position:0 -2900px}.baCountry-NR{background-position:0 -2920px}.baCountry-NU{background-position:0 -2940px}.baCountry-NZD{background-position:0 -2960px}.baCountry-OMR{background-position:0 -2980px}.baCountry-PAB{background-position:0 -3000px}.baCountry-PEN{background-position:0 -3020px}.baCountry-PGK{background-position:0 -3040px}.baCountry-PHP{background-position:0 -3060px}.baCountry-PKR{background-position:0 -3080px}.baCountry-PLN{background-position:0 -3100px}.baCountry-PR{background-position:0 -3120px}.baCountry-PS{background-position:0 -3140px}.baCountry-PT{background-position:0 -3160px}.baCountry-PW{background-position:0 -3180px}.baCountry-QAR{background-position:0 -3200px}.baCountry-RON{background-position:0 -3220px}.baCountry-RSD{background-position:0 -3240px}.baCountry-RUB{background-position:0 -3260px}.baCountry-RWF{background-position:0 -3280px}.baCountry-SAR{background-position:0 -3300px}.baCountry-SBD{background-position:0 -3320px}.baCountry-SCR{background-position:0 -3340px}.baCountry-SDG{background-position:0 -3360px}.baCountry-SEK{background-position:0 -3380px}.baCountry-SGD{background-position:0 -3400px}.baCountry-SI{background-position:0 -3420px}.baCountry-SK{background-position:0 -3440px}.baCountry-SLL{background-position:0 -3460px}.baCountry-SM{background-position:0 -3480px}.baCountry-SN{background-position:0 -3500px}.baCountry-SO{background-position:0 -3520px}.baCountry-SRD{background-position:0 -3540px}.baCountry-SSP{background-position:0 -3560px}.baCountry-STD{background-position:0 -3580px}.baCountry-SV{background-position:0 -3600px}.baCountry-SYP{background-position:0 -3620px}.baCountry-SZL{background-position:0 -3640px}.baCountry-TC{background-position:0 -3660px}.baCountry-TD{background-position:0 -3680px}.baCountry-TG{background-position:0 -3700px}.baCountry-THB{background-position:0 -3720px}.baCountry-TJS{background-position:0 -3740px}.baCountry-TK{background-position:0 -3760px}.baCountry-TMT{background-position:0 -3780px}.baCountry-TND{background-position:0 -3800px}.baCountry-TOP{background-position:0 -3820px}.baCountry-TRY{background-position:0 -3840px}.baCountry-TTD{background-position:0 -3860px}.baCountry-TWD{background-position:0 -3880px}.baCountry-TZS{background-position:0 -3900px}.baCountry-UAH{background-position:0 -3920px}.baCountry-UGX{background-position:0 -3940px}.baCountry-USD{background-position:0 -3960px}.baCountry-UYU{background-position:0 -3980px}.baCountry-UZS{background-position:0 -4000px}.baCountry-VEF{background-position:0 -4020px}.baCountry-VG{background-position:0 -4040px}.baCountry-VI{background-position:0 -4060px}.baCountry-VND{background-position:0 -4080px}.baCountry-VUV{background-position:0 -4100px}.baCountry-WST{background-position:0 -4120px}.baCountry-XAF{background-position:0 -4140px}.baCountry-XPF{background-position:0 -4160px}.baCountry-YER{background-position:0 -4180px}.baCountry-ZAR{background-position:0 -4200px}.baCountry-ZM{background-position:0 -4220px}.baCountry-ZW{background-position:0 -4240px}
  .bacurr-checkoutNotice{margin: 3px 10px 0 10px;left: 0;right: 0;text-align: center;}
  @media (min-width:750px) {.bacurr-checkoutNotice{position: absolute;}}
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
      money_format: "\u003cspan class=money\u003eRs. 1234\u003c\/span\u003e",
      money_with_currency_format: "\u003cspan class=money\u003eRs. 1234 INR\u003c\/span\u003e",
      user_curr: "INR"
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
<script title="winads_engine" type="text/javascript">
    //AGILITY_PLACEHOLDER
    //BOUNCER_PLACEHOLDER
</script>

<meta name="wa:tags" content="8TBS, Black Friday, Co-ord Sets, New, Sale, Shrug Sets, TBS, Western Wear">
<meta name="wa:collections" content="All Products, Best Sellers, Co-ord Sets For Women, New Arrivals, Sale, Shrug Sets, Western Wear">




<!-- Era of Ecom Engine Hook end -->




<script>(() => {const installerKey = 'docapp-free-gift-auto-install'; const urlParams = new URLSearchParams(window.location.search); if (urlParams.get(installerKey)) {window.sessionStorage.setItem(installerKey, JSON.stringify({integrationId: urlParams.get('docapp-integration-id'), divClass: urlParams.get('docapp-install-class'), check: urlParams.get('docapp-check')}));}})();</script>

<script>(() => {const previewKey = 'docapp-free-gift-test'; const urlParams = new URLSearchParams(window.location.search); if (urlParams.get(previewKey)) {window.sessionStorage.setItem(previewKey, JSON.stringify({active: true, integrationId: urlParams.get('docapp-free-gift-inst-test')}));}})();</script>
<link href="//jisora.com/cdn/shop/t/29/assets/smk-sections.css?v=147244019065819453361679922258" rel="stylesheet" type="text/css" media="all" />

 

 
 


 
 


                  <script src="//jisora.com/cdn/shop/t/29/assets/bss-file-configdata.js?v=19453381437224918031679922258" type="text/javascript"></script><script>
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
</style><script>function fixBugForStores($, BSS_PL, parent, page, htmlLabel) { return false;}</script>
                    
	
	
	<!-- BEGIN app block: shopify://apps/back-in-stock-restock-alerts/blocks/app-embed/8b875ab4-abf0-4c7c-b35c-43d33469852d --><!-- BEGIN app snippet: hulkapps-restock-theme-ext --><script type="text/javascript">
      if (typeof window.restockext_config != "object") {
        window.restockext_config = {}
      }
      
      
      window.restockext = {
        shop_slug: "jisora-india",
        store_id: "jisora-india.myshopify.com",
        money_format: "<span class=money>Rs. 9123</span>",
        customer: null,
        cart: null,
      }

      

      

      
      
        
        window.restockext.product = {
          id: 8149411725537,
          price: 179910,
          tags: ["8TBS","Black Friday","Co-ord Sets","New","Sale","Shrug Sets","TBS","Western Wear"],
          variants: [{"id":44218255900897,"title":"S","option1":"S","option2":null,"option3":null,"sku":"9TBS2234-S","requires_shipping":true,"taxable":true,"featured_image":null,"available":true,"name":"Ebony blossom three piece cotton co-ord set - S","public_title":"S","options":["S"],"price":179910,"weight":240,"compare_at_price":199900,"inventory_management":"shopify","barcode":"9TBS2234-S","requires_selling_plan":false,"selling_plan_allocations":[]},{"id":44218255933665,"title":"M","option1":"M","option2":null,"option3":null,"sku":"9TBS2234-M","requires_shipping":true,"taxable":true,"featured_image":null,"available":true,"name":"Ebony blossom three piece cotton co-ord set - M","public_title":"M","options":["M"],"price":179910,"weight":240,"compare_at_price":199900,"inventory_management":"shopify","barcode":"9TBS2234-M","requires_selling_plan":false,"selling_plan_allocations":[]},{"id":44218255966433,"title":"L","option1":"L","option2":null,"option3":null,"sku":"9TBS2234-L","requires_shipping":true,"taxable":true,"featured_image":null,"available":false,"name":"Ebony blossom three piece cotton co-ord set - L","public_title":"L","options":["L"],"price":179910,"weight":240,"compare_at_price":199900,"inventory_management":"shopify","barcode":"9TBS2234-L","requires_selling_plan":false,"selling_plan_allocations":[]},{"id":44218255999201,"title":"XL","option1":"XL","option2":null,"option3":null,"sku":"9TBS2234-XL","requires_shipping":true,"taxable":true,"featured_image":null,"available":false,"name":"Ebony blossom three piece cotton co-ord set - XL","public_title":"XL","options":["XL"],"price":179910,"weight":240,"compare_at_price":199900,"inventory_management":"shopify","barcode":"9TBS2234-XL","requires_selling_plan":false,"selling_plan_allocations":[]}]
        };
        window.restockext.product_json = {"id":8149411725537,"title":"Ebony blossom three piece cotton co-ord set","handle":"ebony-blossom-three-piece-cotton-co-ord-set","description":"\u003cp data-mce-fragment=\"1\"\u003eDress up your wardrobe with this one-of-a-kind Ebony Blossom three piece set! Perfect for all seasons, this cotton co-ord set is as comfy as it is stylish - don't miss out on this blooming beauty!\u003c\/p\u003e","published_at":"2023-11-10T18:24:23+05:30","created_at":"2023-11-10T18:24:26+05:30","vendor":"JISORA","type":"Co-ord Sets","tags":["8TBS","Black Friday","Co-ord Sets","New","Sale","Shrug Sets","TBS","Western Wear"],"price":179910,"price_min":179910,"price_max":179910,"available":true,"price_varies":false,"compare_at_price":199900,"compare_at_price_min":199900,"compare_at_price_max":199900,"compare_at_price_varies":false,"variants":[{"id":44218255900897,"title":"S","option1":"S","option2":null,"option3":null,"sku":"9TBS2234-S","requires_shipping":true,"taxable":true,"featured_image":null,"available":true,"name":"Ebony blossom three piece cotton co-ord set - S","public_title":"S","options":["S"],"price":179910,"weight":240,"compare_at_price":199900,"inventory_management":"shopify","barcode":"9TBS2234-S","requires_selling_plan":false,"selling_plan_allocations":[]},{"id":44218255933665,"title":"M","option1":"M","option2":null,"option3":null,"sku":"9TBS2234-M","requires_shipping":true,"taxable":true,"featured_image":null,"available":true,"name":"Ebony blossom three piece cotton co-ord set - M","public_title":"M","options":["M"],"price":179910,"weight":240,"compare_at_price":199900,"inventory_management":"shopify","barcode":"9TBS2234-M","requires_selling_plan":false,"selling_plan_allocations":[]},{"id":44218255966433,"title":"L","option1":"L","option2":null,"option3":null,"sku":"9TBS2234-L","requires_shipping":true,"taxable":true,"featured_image":null,"available":false,"name":"Ebony blossom three piece cotton co-ord set - L","public_title":"L","options":["L"],"price":179910,"weight":240,"compare_at_price":199900,"inventory_management":"shopify","barcode":"9TBS2234-L","requires_selling_plan":false,"selling_plan_allocations":[]},{"id":44218255999201,"title":"XL","option1":"XL","option2":null,"option3":null,"sku":"9TBS2234-XL","requires_shipping":true,"taxable":true,"featured_image":null,"available":false,"name":"Ebony blossom three piece cotton co-ord set - XL","public_title":"XL","options":["XL"],"price":179910,"weight":240,"compare_at_price":199900,"inventory_management":"shopify","barcode":"9TBS2234-XL","requires_selling_plan":false,"selling_plan_allocations":[]}],"images":["\/\/jisora.com\/cdn\/shop\/files\/SMP02530.jpg?v=1699620993","\/\/jisora.com\/cdn\/shop\/files\/SMP02532.jpg?v=1699620991","\/\/jisora.com\/cdn\/shop\/files\/SMP02534.jpg?v=1699620990","\/\/jisora.com\/cdn\/shop\/files\/SMP02537.jpg?v=1699620992","\/\/jisora.com\/cdn\/shop\/files\/SMP02542.jpg?v=1699620990","\/\/jisora.com\/cdn\/shop\/files\/SMP02547.jpg?v=1699620995","\/\/jisora.com\/cdn\/shop\/files\/SMP02549.jpg?v=1699620990","\/\/jisora.com\/cdn\/shop\/files\/SMP02555.jpg?v=1699620993","\/\/jisora.com\/cdn\/shop\/files\/SMP02558.jpg?v=1699620992","\/\/jisora.com\/cdn\/shop\/files\/SMP02561.jpg?v=1699620994","\/\/jisora.com\/cdn\/shop\/files\/SMP02564.jpg?v=1699620994","\/\/jisora.com\/cdn\/shop\/files\/SMP02566.jpg?v=1699620991"],"featured_image":"\/\/jisora.com\/cdn\/shop\/files\/SMP02530.jpg?v=1699620993","options":["Size"],"media":[{"alt":null,"id":33337201918177,"position":1,"preview_image":{"aspect_ratio":0.667,"height":2700,"width":1800,"src":"\/\/jisora.com\/cdn\/shop\/files\/SMP02530.jpg?v=1699620993"},"aspect_ratio":0.667,"height":2700,"media_type":"image","src":"\/\/jisora.com\/cdn\/shop\/files\/SMP02530.jpg?v=1699620993","width":1800},{"alt":null,"id":33337201950945,"position":2,"preview_image":{"aspect_ratio":0.667,"height":2700,"width":1800,"src":"\/\/jisora.com\/cdn\/shop\/files\/SMP02532.jpg?v=1699620991"},"aspect_ratio":0.667,"height":2700,"media_type":"image","src":"\/\/jisora.com\/cdn\/shop\/files\/SMP02532.jpg?v=1699620991","width":1800},{"alt":null,"id":33337201983713,"position":3,"preview_image":{"aspect_ratio":0.667,"height":2700,"width":1800,"src":"\/\/jisora.com\/cdn\/shop\/files\/SMP02534.jpg?v=1699620990"},"aspect_ratio":0.667,"height":2700,"media_type":"image","src":"\/\/jisora.com\/cdn\/shop\/files\/SMP02534.jpg?v=1699620990","width":1800},{"alt":null,"id":33337202016481,"position":4,"preview_image":{"aspect_ratio":0.667,"height":2700,"width":1800,"src":"\/\/jisora.com\/cdn\/shop\/files\/SMP02537.jpg?v=1699620992"},"aspect_ratio":0.667,"height":2700,"media_type":"image","src":"\/\/jisora.com\/cdn\/shop\/files\/SMP02537.jpg?v=1699620992","width":1800},{"alt":null,"id":33337202049249,"position":5,"preview_image":{"aspect_ratio":0.667,"height":2700,"width":1800,"src":"\/\/jisora.com\/cdn\/shop\/files\/SMP02542.jpg?v=1699620990"},"aspect_ratio":0.667,"height":2700,"media_type":"image","src":"\/\/jisora.com\/cdn\/shop\/files\/SMP02542.jpg?v=1699620990","width":1800},{"alt":null,"id":33337202082017,"position":6,"preview_image":{"aspect_ratio":0.667,"height":2700,"width":1800,"src":"\/\/jisora.com\/cdn\/shop\/files\/SMP02547.jpg?v=1699620995"},"aspect_ratio":0.667,"height":2700,"media_type":"image","src":"\/\/jisora.com\/cdn\/shop\/files\/SMP02547.jpg?v=1699620995","width":1800},{"alt":null,"id":33337202114785,"position":7,"preview_image":{"aspect_ratio":0.667,"height":2700,"width":1800,"src":"\/\/jisora.com\/cdn\/shop\/files\/SMP02549.jpg?v=1699620990"},"aspect_ratio":0.667,"height":2700,"media_type":"image","src":"\/\/jisora.com\/cdn\/shop\/files\/SMP02549.jpg?v=1699620990","width":1800},{"alt":null,"id":33337202147553,"position":8,"preview_image":{"aspect_ratio":0.667,"height":2700,"width":1800,"src":"\/\/jisora.com\/cdn\/shop\/files\/SMP02555.jpg?v=1699620993"},"aspect_ratio":0.667,"height":2700,"media_type":"image","src":"\/\/jisora.com\/cdn\/shop\/files\/SMP02555.jpg?v=1699620993","width":1800},{"alt":null,"id":33337202180321,"position":9,"preview_image":{"aspect_ratio":0.667,"height":2700,"width":1800,"src":"\/\/jisora.com\/cdn\/shop\/files\/SMP02558.jpg?v=1699620992"},"aspect_ratio":0.667,"height":2700,"media_type":"image","src":"\/\/jisora.com\/cdn\/shop\/files\/SMP02558.jpg?v=1699620992","width":1800},{"alt":null,"id":33337202213089,"position":10,"preview_image":{"aspect_ratio":0.667,"height":2700,"width":1800,"src":"\/\/jisora.com\/cdn\/shop\/files\/SMP02561.jpg?v=1699620994"},"aspect_ratio":0.667,"height":2700,"media_type":"image","src":"\/\/jisora.com\/cdn\/shop\/files\/SMP02561.jpg?v=1699620994","width":1800},{"alt":null,"id":33337202245857,"position":11,"preview_image":{"aspect_ratio":0.667,"height":2700,"width":1800,"src":"\/\/jisora.com\/cdn\/shop\/files\/SMP02564.jpg?v=1699620994"},"aspect_ratio":0.667,"height":2700,"media_type":"image","src":"\/\/jisora.com\/cdn\/shop\/files\/SMP02564.jpg?v=1699620994","width":1800},{"alt":null,"id":33337202278625,"position":12,"preview_image":{"aspect_ratio":0.667,"height":2700,"width":1800,"src":"\/\/jisora.com\/cdn\/shop\/files\/SMP02566.jpg?v=1699620991"},"aspect_ratio":0.667,"height":2700,"media_type":"image","src":"\/\/jisora.com\/cdn\/shop\/files\/SMP02566.jpg?v=1699620991","width":1800}],"requires_selling_plan":false,"selling_plan_groups":[],"content":"\u003cp data-mce-fragment=\"1\"\u003eDress up your wardrobe with this one-of-a-kind Ebony Blossom three piece set! Perfect for all seasons, this cotton co-ord set is as comfy as it is stylish - don't miss out on this blooming beauty!\u003c\/p\u003e"}
        window.restockext.product_collections = []
        
        window.restockext.product_collections.push(399990030561)
        
        window.restockext.product_collections.push(267755454622)
        
        window.restockext.product_collections.push(238747582622)
        
        window.restockext.product_collections.push(276996063390)
        
        window.restockext.product_collections.push(403154665697)
        
        window.restockext.product_collections.push(238747254942)
        
        window.restockext.product_collections.push(238747353246)
        
      
      
        
      

      
        window.restockext.cart = {"note":"","attributes":{},"original_total_price":359820,"total_price":359820,"total_discount":0,"total_weight":480.0,"item_count":2,"items":[{"id":44218255933665,"properties":{},"quantity":2,"variant_id":44218255933665,"key":"44218255933665:778e651a5f0f3490dd0dbb7995fc4305","title":"Ebony blossom three piece cotton co-ord set - M","price":179910,"original_price":179910,"discounted_price":179910,"line_price":359820,"original_line_price":359820,"total_discount":0,"discounts":[],"sku":"9TBS2234-M","grams":240,"vendor":"JISORA","taxable":true,"product_id":8149411725537,"product_has_only_default_variant":false,"gift_card":false,"final_price":179910,"final_line_price":359820,"url":"\/products\/ebony-blossom-three-piece-cotton-co-ord-set?variant=44218255933665","featured_image":{"aspect_ratio":0.667,"alt":"Ebony blossom three piece cotton co-ord set","height":2700,"url":"\/\/jisora.com\/cdn\/shop\/files\/SMP02530.jpg?v=1699620993","width":1800},"image":"\/\/jisora.com\/cdn\/shop\/files\/SMP02530.jpg?v=1699620993","handle":"ebony-blossom-three-piece-cotton-co-ord-set","requires_shipping":true,"product_type":"Co-ord Sets","product_title":"Ebony blossom three piece cotton co-ord set","product_description":"Dress up your wardrobe with this one-of-a-kind Ebony Blossom three piece set! Perfect for all seasons, this cotton co-ord set is as comfy as it is stylish - don't miss out on this blooming beauty!","variant_title":"M","variant_options":["M"],"options_with_values":[{"name":"Size","value":"M"}],"line_level_discount_allocations":[],"line_level_total_discount":0}],"requires_shipping":true,"currency":"INR","items_subtotal_price":359820,"cart_level_discount_applications":[]}
        delete window.restockext.cart.note
        window.restockext.cart_collections = {}
        
          window.restockext.cart_collections["v44218255933665"] = []
            
            window.restockext.cart_collections["v44218255933665"].push(399990030561)
            
            window.restockext.cart_collections["v44218255933665"].push(267755454622)
            
            window.restockext.cart_collections["v44218255933665"].push(238747582622)
            
            window.restockext.cart_collections["v44218255933665"].push(276996063390)
            
            window.restockext.cart_collections["v44218255933665"].push(403154665697)
            
            window.restockext.cart_collections["v44218255933665"].push(238747254942)
            
            window.restockext.cart_collections["v44218255933665"].push(238747353246)
            
        
      if (typeof window.restockext.cart.items == "object") {
          for (var i=0; i<window.restockext.cart.items.length; i++) {
              ["sku", "grams", "vendor", "url", "image", "handle", "requires_shipping", "product_type", "product_description"].map(function(a) {
                  delete window.restockext.cart.items[i][a]
              })
          }
        }
      
      window.restockext.page_type = "product"
      window.restockext.partner_url = "https://restock-master.hulkapps.com";
    </script>
    <!-- END app snippet --><!-- END app app block --><!-- BEGIN app block: shopify://apps/limechat-ai/blocks/app-embed/61514426-688a-4566-b284-a0d7a70fd103 --><!-- END app app block --><!-- BEGIN app block: shopify://apps/frequently-bought-together/blocks/app-embed-block/b1a8cbea-c844-4842-9529-7c62dbab1b1f --><script src="//cdn.codeblackbelt.com/scripts/frequently-bought-together/main.min.js?version=2023120511+0530" async></script>
<!-- END app app block --><!-- BEGIN app block: shopify://apps/whatmore-live/blocks/app-embed/20db8a72-315a-4364-8885-64219ee48303 -->

<div class="whatmore-base">
  <div id="whatmoreShopId" data="52435222686"> </div>
  <div id="whatmoreProductId" data="8149411725537"> </div>
  <div id="whatmoreExtensionType" data="product"> </div>
  <div class="whatmore-template-type" data="template-embed"> </div><div id="whatmoreVariantId" data="44218255933665"> </div><div id="whatmoreSecondaryColor" data="#750902"> </div><div id="whatmoreEmbedAppPositionPortrait" data="right"> </div><div id="whatmoreEmbedAppHorizontalPaddingPortrait" data="15"> </div><div id="whatmoreEmbedAppVerticalPaddingPortrait" data="170"> </div><div id="whatmoreEmbedAppVideoPlayerSizePortrait" data="45"> </div><div id="whatmoreEmbedAppPositionLandscape" data="right"> </div><div id="whatmoreEmbedAppHorizontalPaddingLandscape" data="15"> </div><div id="whatmoreEmbedAppVerticalPaddingLandscape" data="148"> </div><div id="whatmoreEmbedAppVideoPlayerSizeLandscape" data="50"> </div><div id="whatmoreEmbedAppUseVariant" data="false"> </div>

      <style data-shopify>
        @font-face {
  font-family: whatmorePrimaryFontFamily;
  font-weight: 400;
  font-style: normal;
  src: url("//jisora.com/cdn/fonts/avenir_next/avenirnext_n4.7fd0287595be20cd5a683102bf49d073b6abf144.woff2?h1=amlzb3JhLmNvbQ&h2=amlzb3JhLmlu&h3=amlzb3JhZ2xvYmFsLmNvbQ&h4=amlzb3JhLWluZGlhLmFjY291bnQubXlzaG9waWZ5LmNvbQ&h5=amlzb3JhLm5ldA&h6=amlzb3JhLmNvLmlu&h7=amlzb3JhLm9yZw&h8=amlzb3JhamFpcHVyLmlu&h9=amlzb3JhamFpcHVyLmNvbQ&hmac=e21d093732075835a1cf68e7c36f5a299c9eca653361d806593feb2a13442307") format("woff2"),
       url("//jisora.com/cdn/fonts/avenir_next/avenirnext_n4.a26a334a0852627a5f36b195112385b0cd700077.woff?h1=amlzb3JhLmNvbQ&h2=amlzb3JhLmlu&h3=amlzb3JhZ2xvYmFsLmNvbQ&h4=amlzb3JhLWluZGlhLmFjY291bnQubXlzaG9waWZ5LmNvbQ&h5=amlzb3JhLm5ldA&h6=amlzb3JhLmNvLmlu&h7=amlzb3JhLm9yZw&h8=amlzb3JhamFpcHVyLmlu&h9=amlzb3JhamFpcHVyLmNvbQ&hmac=d6e56143d9459a0e2a2a96f84b58865e2e725f3994d0445139f7f91661b689d3") format("woff");
}

      </style>

      <div id="whatmorePrimaryFont" data="whatmorePrimaryFontFamily"> </div><div id="whatmoreEmbedAppVideoTitle" data=""> </div>
    <div id="whatmoreIsInDesignMode" data='false'> </div>
  
<div id="whatmoreUITheme" data="round"> </div><div class="whatmore-render-root"> </div>

</div>
<!-- END app app block --><script src="https://cdn.shopify.com/extensions/858ac0e7-a26c-4da3-9f45-b76a12f28ab8/back-in-stock-restock-alerts-1/assets/mha-rn-popup-theme-ext.js" type="text/javascript" defer="defer"></script>
<link href="https://cdn.shopify.com/extensions/858ac0e7-a26c-4da3-9f45-b76a12f28ab8/back-in-stock-restock-alerts-1/assets/restock-master-theme-ext.css" rel="stylesheet" type="text/css" media="all">
<script src="https://cdn.shopify.com/extensions/a0a521a7-1cf8-4aea-ae46-6f9787cfa8f2/limechat-ai-3/assets/conversion-tracking.js" type="text/javascript" defer="defer"></script>
<script src="https://cdn.shopify.com/extensions/297ea48f-d444-4177-8225-5789f2d55fb4/attrac-2/assets/attrac-embed-bars.js" type="text/javascript" defer="defer"></script>
<script src="https://cdn.shopify.com/extensions/f80356b8-ac61-41e8-b746-e91fafa7f277/whatmore-shoppable-videos-80/assets/whatmore.js" type="text/javascript" defer="defer"></script>
<script src="https://cdn.shopify.com/extensions/b5af8dc1-9891-449e-898c-9915a28c3ae3/pify-form-builder-contact-form-16/assets/popup.js" type="text/javascript" defer="defer"></script>
<link href="https://monorail-edge.shopifysvc.com" rel="dns-prefetch">
<script>(function(){if ("sendBeacon" in navigator && "performance" in window) {var session_token = document.cookie.match(/_shopify_s=([^;]*)/);function handle_abandonment_event(e) {var entries = performance.getEntries().filter(function(entry) {return /monorail-edge.shopifysvc.com/.test(entry.name);});if (!window.abandonment_tracked && entries.length === 0) {window.abandonment_tracked = true;var currentMs = Date.now();var navigation_start = performance.timing.navigationStart;var payload = {shop_id: 52435222686,url: window.location.href,navigation_start,duration: currentMs - navigation_start,session_token: session_token && session_token.length === 2 ? session_token[1] : "",page_type: "product"};window.navigator.sendBeacon("https://monorail-edge.shopifysvc.com/v1/produce", JSON.stringify({schema_id: "online_store_buyer_site_abandonment/1.1",payload: payload,metadata: {event_created_at_ms: currentMs,event_sent_at_ms: currentMs}}));}}window.addEventListener('pagehide', handle_abandonment_event);}}());</script>
<script id="web-pixels-manager-setup">(function e(e,n,a,t,o,r,i){var s=null!==e,l=("function"==typeof BigInt&&BigInt.toString().indexOf("[native code]")?"modern":"legacy").substring(0,1),c=t.substring(0,1);if(s){window.Shopify=window.Shopify||{};var d=window.Shopify;d.analytics=d.analytics||{};var u=d.analytics;u.replayQueue=[],u.publish=function(e,n,a){u.replayQueue.push([e,n,a])};try{self.performance.mark("wpm:start")}catch(e){}}var p,f,y,h,v,m,w,g,b,_=[a,"/wpm","/",c,r,l,".js"].join("");f=(p={src:_,async:!0,onload:function(){if(e){var a=window.webPixelsManager.init(e);null==n||n(a);var t=window.Shopify.analytics;t.replayQueue.forEach((function(e){var n=e[0],t=e[1],o=e[2];a.publishCustomEvent(n,t,o)})),t.replayQueue=[],t.publish=a.publishCustomEvent,t.visitor=a.visitor}},onerror:function(){var n=(null==e?void 0:e.storefrontBaseUrl)?e.storefrontBaseUrl.replace(/\/$/,""):self.location.origin,a="".concat(n,"/.well-known/shopify/monorail/unstable/produce_batch"),t=JSON.stringify({metadata:{event_sent_at_ms:(new Date).getTime()},events:[{schema_id:"web_pixels_manager_load/2.0",payload:{version:o||"latest",page_url:self.location.href,status:"failed",error_msg:"".concat(_," has failed to load")},metadata:{event_created_at_ms:(new Date).getTime()}}]});try{if(self.navigator.sendBeacon.bind(self.navigator)(a,t))return!0}catch(e){}var r=new XMLHttpRequest;try{return r.open("POST",a,!0),r.setRequestHeader("Content-Type","text/plain"),r.send(t),!0}catch(e){console&&console.warn&&console.warn("[Web Pixels Manager] Got an unhandled error while logging a load error.")}return!1}}).src,y=p.async,h=void 0===y||y,v=p.onload,m=p.onerror,w=document.createElement("script"),g=document.head,b=document.body,w.async=h,w.src=f,v&&w.addEventListener("load",v),m&&w.addEventListener("error",m),g?g.appendChild(w):b?b.appendChild(w):console.error("Did not find a head or body element to append the script")})({shopId: 52435222686,storefrontBaseUrl: "https://jisora.com",cdnBaseUrl: "https://jisora.com/cdn",surface: "storefront-renderer",enabledBetaFlags: ["web_pixels_async_pixel_refactor","web_pixels_manager_performance_improvement"],webPixelsConfigList: [{"id":"7766241","configuration":"{\"pixelId\":\"ba34b297-9ff9-457b-a466-1c10e853640a\"}","eventPayloadVersion":"v1","runtimeContext":"STRICT","scriptVersion":"bb41bf091d86ec09beb5141ead6fafc0","type":"APP","apiClientId":2556259},{"id":"shopify-app-pixel","configuration":"{}","eventPayloadVersion":"v1","runtimeContext":"STRICT","scriptVersion":"0570","apiClientId":"shopify-pixel","type":"APP"},{"id":"shopify-custom-pixel","eventPayloadVersion":"v1","runtimeContext":"LAX","scriptVersion":"0570","apiClientId":"shopify-pixel","type":"CUSTOM"}],initData: {"cart":{"cost":{"totalAmount":{"amount":3598.2,"currencyCode":"INR"}},"id":"c1-3e9c9444c2bf86c6d6b80d452372e2a3","lines":[{"cost":{"totalAmount":{"amount":3598.2,"currencyCode":"INR"}},"merchandise":{"id":"44218255933665","image":{"src":"\/\/jisora.com\/cdn\/shop\/files\/SMP02530.jpg?v=1699620993"},"price":{"amount":1799.1,"currencyCode":"INR"},"product":{"id":"8149411725537","title":"Ebony blossom three piece cotton co-ord set","untranslatedTitle":"Ebony blossom three piece cotton co-ord set","url":"\/products\/ebony-blossom-three-piece-cotton-co-ord-set","vendor":"JISORA","type":"Co-ord Sets"},"sku":"9TBS2234-M","title":"M","untranslatedTitle":"M"},"quantity":2}],"totalQuantity":2},"checkout":null,"customer":null,"productVariants":[{"id":"44218255900897","image":{"src":"\/\/jisora.com\/cdn\/shop\/files\/SMP02530.jpg?v=1699620993"},"price":{"amount":1799.1,"currencyCode":"INR"},"product":{"id":"8149411725537","title":"Ebony blossom three piece cotton co-ord set","untranslatedTitle":"Ebony blossom three piece cotton co-ord set","url":"\/products\/ebony-blossom-three-piece-cotton-co-ord-set","vendor":"JISORA","type":"Co-ord Sets"},"sku":"9TBS2234-S","title":"S","untranslatedTitle":"S"},{"id":"44218255933665","image":{"src":"\/\/jisora.com\/cdn\/shop\/files\/SMP02530.jpg?v=1699620993"},"price":{"amount":1799.1,"currencyCode":"INR"},"product":{"id":"8149411725537","title":"Ebony blossom three piece cotton co-ord set","untranslatedTitle":"Ebony blossom three piece cotton co-ord set","url":"\/products\/ebony-blossom-three-piece-cotton-co-ord-set","vendor":"JISORA","type":"Co-ord Sets"},"sku":"9TBS2234-M","title":"M","untranslatedTitle":"M"},{"id":"44218255966433","image":{"src":"\/\/jisora.com\/cdn\/shop\/files\/SMP02530.jpg?v=1699620993"},"price":{"amount":1799.1,"currencyCode":"INR"},"product":{"id":"8149411725537","title":"Ebony blossom three piece cotton co-ord set","untranslatedTitle":"Ebony blossom three piece cotton co-ord set","url":"\/products\/ebony-blossom-three-piece-cotton-co-ord-set","vendor":"JISORA","type":"Co-ord Sets"},"sku":"9TBS2234-L","title":"L","untranslatedTitle":"L"},{"id":"44218255999201","image":{"src":"\/\/jisora.com\/cdn\/shop\/files\/SMP02530.jpg?v=1699620993"},"price":{"amount":1799.1,"currencyCode":"INR"},"product":{"id":"8149411725537","title":"Ebony blossom three piece cotton co-ord set","untranslatedTitle":"Ebony blossom three piece cotton co-ord set","url":"\/products\/ebony-blossom-three-piece-cotton-co-ord-set","vendor":"JISORA","type":"Co-ord Sets"},"sku":"9TBS2234-XL","title":"XL","untranslatedTitle":"XL"}]},},function pageEvents(webPixelsManagerAPI) {webPixelsManagerAPI.publish("page_viewed");webPixelsManagerAPI.publish("product_viewed", {"productVariant":{"id":"44218255933665","image":{"src":"\/\/jisora.com\/cdn\/shop\/files\/SMP02530.jpg?v=1699620993"},"price":{"amount":1799.1,"currencyCode":"INR"},"product":{"id":"8149411725537","title":"Ebony blossom three piece cotton co-ord set","untranslatedTitle":"Ebony blossom three piece cotton co-ord set","url":"\/products\/ebony-blossom-three-piece-cotton-co-ord-set","vendor":"JISORA","type":"Co-ord Sets"},"sku":"9TBS2234-M","title":"M","untranslatedTitle":"M"}});},"https://jisora.com/cdn","browser","0.0.407","f25882c1w423ab3d2p8df04b18m261f6c04",["web_pixels_async_pixel_refactor","web_pixels_manager_performance_improvement"]);</script>  <script>window.ShopifyAnalytics = window.ShopifyAnalytics || {};
window.ShopifyAnalytics.meta = window.ShopifyAnalytics.meta || {};
window.ShopifyAnalytics.meta.currency = 'INR';
var meta = {"product":{"id":8149411725537,"gid":"gid:\/\/shopify\/Product\/8149411725537","vendor":"JISORA","type":"Co-ord Sets","variants":[{"id":44218255900897,"price":179910,"name":"Ebony blossom three piece cotton co-ord set - S","public_title":"S","sku":"9TBS2234-S"},{"id":44218255933665,"price":179910,"name":"Ebony blossom three piece cotton co-ord set - M","public_title":"M","sku":"9TBS2234-M"},{"id":44218255966433,"price":179910,"name":"Ebony blossom three piece cotton co-ord set - L","public_title":"L","sku":"9TBS2234-L"},{"id":44218255999201,"price":179910,"name":"Ebony blossom three piece cotton co-ord set - XL","public_title":"XL","sku":"9TBS2234-XL"}]},"page":{"pageType":"product","resourceType":"product","resourceId":8149411725537}};
for (var attr in meta) {
  window.ShopifyAnalytics.meta[attr] = meta[attr];
}</script>
<script>window.ShopifyAnalytics.merchantGoogleAnalytics = function() {
  
};
</script>
<script class="analytics">(window.gaDevIds=window.gaDevIds||[]).push('BwiEti');


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
      source_url: "//jisora.com/cdn/s/trekkie.storefront.7a4225caf9379fe42103e492053220a7195df1ae.min.js"});

        };
        scriptFallback.async = true;
        scriptFallback.src = '//jisora.com/cdn/s/trekkie.storefront.7a4225caf9379fe42103e492053220a7195df1ae.min.js';
        first.parentNode.insertBefore(scriptFallback, first);
      };
      script.async = true;
      script.src = '//jisora.com/cdn/s/trekkie.storefront.7a4225caf9379fe42103e492053220a7195df1ae.min.js';
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

      window.ShopifyAnalytics.lib.page(null,{"pageType":"product","resourceType":"product","resourceId":8149411725537});

      var match = window.location.pathname.match(/checkouts\/(.+)\/(thank_you|post_purchase)/)
      var token = match? match[1]: undefined;
      if (!hasLoggedConversion(token)) {
        setCookieIfConversion(token);
        window.ShopifyAnalytics.lib.track("Viewed Product",{"currency":"INR","variantId":44218255933665,"productId":8149411725537,"productGid":"gid:\/\/shopify\/Product\/8149411725537","name":"Ebony blossom three piece cotton co-ord set - M","price":"1799.10","sku":"9TBS2234-M","brand":"JISORA","variant":"M","category":"Co-ord Sets","nonInteraction":true});
      window.ShopifyAnalytics.lib.track("monorail:\/\/trekkie_storefront_viewed_product\/1.1",{"currency":"INR","variantId":44218255933665,"productId":8149411725537,"productGid":"gid:\/\/shopify\/Product\/8149411725537","name":"Ebony blossom three piece cotton co-ord set - M","price":"1799.10","sku":"9TBS2234-M","brand":"JISORA","variant":"M","category":"Co-ord Sets","nonInteraction":true,"referer":"https:\/\/jisora.com\/collections\/new-arrivals\/products\/ebony-blossom-three-piece-cotton-co-ord-set?variant=44218255933665"});
      }
    });


        var eventsListenerScript = document.createElement('script');
        eventsListenerScript.async = true;
        eventsListenerScript.src = "//jisora.com/cdn/shopifycloud/shopify/assets/shop_events_listener-a7c63dba65ccddc484f77541dc8ca437e60e1e9e297fe1c3faebf6523a0ede9b.js";
        document.getElementsByTagName('head')[0].appendChild(eventsListenerScript);

})();</script>
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
  window.BOOMR.renderRegion = "gcp-us-central1";
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
})();</script>
</head>
             
  

<body class="template-product" data-center-text="true" data-button_style="square" data-type_header_capitalize="true" data-type_headers_align_text="true" data-type_product_capitalize="true" data-swatch_style="round" data-disable-animations="true">

  <a class="in-page-link visually-hidden skip-link" href="#MainContent">Skip to content</a><div id="shopify-section-header" class="shopify-section">

<div id="NavDrawer" class="drawer drawer--left">
  <div class="drawer__contents">
    <div class="drawer__fixed-header">
      <div class="drawer__header appear-animation appear-delay-1">
        <div class="h2 drawer__title"></div>
        <div class="drawer__close">
          <button type="button" class="drawer__close-button js-drawer-close">
            <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-close" viewBox="0 0 64 64"><path d="M19 17.61l27.12 27.13m0-27.12L19 44.74"/></svg>
            <span class="icon__fallback-text">Close menu</span>
          </button>
        </div>
      </div>
    </div>
    <div class="drawer__scrollable">
      <ul class="mobile-nav" role="navigation" aria-label="Primary"><li class="mobile-nav__item appear-animation appear-delay-2"><a href="/" class="mobile-nav__link mobile-nav__link--top-level">Home</a></li><li class="mobile-nav__item appear-animation appear-delay-3"><a href="/collections/new-arrivals" class="mobile-nav__link mobile-nav__link--top-level" data-active="true">New Arrivals</a></li><li class="mobile-nav__item appear-animation appear-delay-4"><div class="mobile-nav__has-sublist"><a href="/collections/lounge-wear"
                    class="mobile-nav__link mobile-nav__link--top-level"
                    id="Label-collections-lounge-wear3"
                    >
                    Lounge Wear
                  </a>
                  <div class="mobile-nav__toggle">
                    <button type="button"
                      aria-controls="Linklist-collections-lounge-wear3"
                      aria-labelledby="Label-collections-lounge-wear3"
                      class="collapsible-trigger collapsible--auto-height"><span class="collapsible-trigger__icon collapsible-trigger__icon--open" role="presentation">
  <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon--wide icon-chevron-down" viewBox="0 0 28 16"><path d="M1.57 1.59l12.76 12.77L27.1 1.59" stroke-width="2" stroke="#000" fill="none" fill-rule="evenodd"/></svg>
</span>
</button>
                  </div></div><div id="Linklist-collections-lounge-wear3"
                class="mobile-nav__sublist collapsible-content collapsible-content--all"
                >
                <div class="collapsible-content__inner">
                  <ul class="mobile-nav__sublist"><li class="mobile-nav__item">
                        <div class="mobile-nav__child-item"><a href="/collections/kaftan"
                              class="mobile-nav__link"
                              id="Sublabel-collections-kaftan1"
                              >
                              Kaftan
                            </a><button type="button"
                              aria-controls="Sublinklist-collections-lounge-wear3-collections-kaftan1"
                              aria-labelledby="Sublabel-collections-kaftan1"
                              class="collapsible-trigger"><span class="collapsible-trigger__icon collapsible-trigger__icon--circle collapsible-trigger__icon--open" role="presentation">
  <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon--wide icon-chevron-down" viewBox="0 0 28 16"><path d="M1.57 1.59l12.76 12.77L27.1 1.59" stroke-width="2" stroke="#000" fill="none" fill-rule="evenodd"/></svg>
</span>
</button></div><div
                            id="Sublinklist-collections-lounge-wear3-collections-kaftan1"
                            aria-labelledby="Sublabel-collections-kaftan1"
                            class="mobile-nav__sublist collapsible-content collapsible-content--all"
                            >
                            <div class="collapsible-content__inner">
                              <ul class="mobile-nav__grandchildlist"><li class="mobile-nav__item">
                                    <a href="/collections/kaftan-maxi" class="mobile-nav__link">
                                      Kaftan Maxi
                                    </a>
                                  </li><li class="mobile-nav__item">
                                    <a href="/collections/kaftan-midi" class="mobile-nav__link">
                                      Kaftan Midi
                                    </a>
                                  </li><li class="mobile-nav__item">
                                    <a href="/collections/kaftan-top-set" class="mobile-nav__link">
                                      Kaftan Top Set
                                    </a>
                                  </li><li class="mobile-nav__item">
                                    <a href="/collections/front-buttoned-kaftan" class="mobile-nav__link">
                                      Front-Buttoned Kaftan
                                    </a>
                                  </li></ul>
                            </div>
                          </div></li><li class="mobile-nav__item">
                        <div class="mobile-nav__child-item"><a href="/collections/pyjama-sets"
                              class="mobile-nav__link"
                              id="Sublabel-collections-pyjama-sets2"
                              >
                              Pyjama Sets
                            </a><button type="button"
                              aria-controls="Sublinklist-collections-lounge-wear3-collections-pyjama-sets2"
                              aria-labelledby="Sublabel-collections-pyjama-sets2"
                              class="collapsible-trigger"><span class="collapsible-trigger__icon collapsible-trigger__icon--circle collapsible-trigger__icon--open" role="presentation">
  <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon--wide icon-chevron-down" viewBox="0 0 28 16"><path d="M1.57 1.59l12.76 12.77L27.1 1.59" stroke-width="2" stroke="#000" fill="none" fill-rule="evenodd"/></svg>
</span>
</button></div><div
                            id="Sublinklist-collections-lounge-wear3-collections-pyjama-sets2"
                            aria-labelledby="Sublabel-collections-pyjama-sets2"
                            class="mobile-nav__sublist collapsible-content collapsible-content--all"
                            >
                            <div class="collapsible-content__inner">
                              <ul class="mobile-nav__grandchildlist"><li class="mobile-nav__item">
                                    <a href="/collections/top-set" class="mobile-nav__link">
                                      Top Set
                                    </a>
                                  </li><li class="mobile-nav__item">
                                    <a href="/collections/kaftan-top-set" class="mobile-nav__link">
                                      Kaftan Top Set
                                    </a>
                                  </li><li class="mobile-nav__item">
                                    <a href="/collections/peplum-top-set" class="mobile-nav__link">
                                      Peplum Top Set
                                    </a>
                                  </li><li class="mobile-nav__item">
                                    <a href="/collections/angrakha-top-set" class="mobile-nav__link">
                                      Angrakha Top Set
                                    </a>
                                  </li><li class="mobile-nav__item">
                                    <a href="/collections/shirt-sets" class="mobile-nav__link">
                                      Shirt Sets
                                    </a>
                                  </li></ul>
                            </div>
                          </div></li><li class="mobile-nav__item">
                        <div class="mobile-nav__child-item"><a href="/collections/short-sets"
                              class="mobile-nav__link"
                              id="Sublabel-collections-short-sets3"
                              >
                              Short Sets
                            </a></div></li><li class="mobile-nav__item">
                        <div class="mobile-nav__child-item"><a href="/collections/shrug-sets"
                              class="mobile-nav__link"
                              id="Sublabel-collections-shrug-sets4"
                              >
                              Shrug Sets
                            </a></div></li><li class="mobile-nav__item">
                        <div class="mobile-nav__child-item"><a href="/collections/palazzo-sets"
                              class="mobile-nav__link"
                              id="Sublabel-collections-palazzo-sets5"
                              >
                              Palazzo Sets
                            </a></div></li><li class="mobile-nav__item">
                        <div class="mobile-nav__child-item"><a href="/collections/t-shirt-dresses"
                              class="mobile-nav__link"
                              id="Sublabel-collections-t-shirt-dresses6"
                              >
                              T-shirt Dresses
                            </a></div></li><li class="mobile-nav__item">
                        <div class="mobile-nav__child-item"><a href="/collections/night-robes"
                              class="mobile-nav__link"
                              id="Sublabel-collections-night-robes7"
                              >
                              Night Robes 
                            </a></div></li><li class="mobile-nav__item">
                        <div class="mobile-nav__child-item"><a href="/collections/maternity-dresses"
                              class="mobile-nav__link"
                              id="Sublabel-collections-maternity-dresses8"
                              >
                              Maternity Dresses
                            </a></div></li><li class="mobile-nav__item">
                        <div class="mobile-nav__child-item"><a href="/collections/slip-dress"
                              class="mobile-nav__link"
                              id="Sublabel-collections-slip-dress9"
                              >
                              Slip Dress
                            </a></div></li><li class="mobile-nav__item">
                        <div class="mobile-nav__child-item"><a href="https://jisora.com/collections/lounge-dresses"
                              class="mobile-nav__link"
                              id="Sublabel-https-jisora-com-collections-lounge-dresses10"
                              >
                              Lounge Dresses
                            </a></div></li><li class="mobile-nav__item">
                        <div class="mobile-nav__child-item"><a href="/collections/plus-size"
                              class="mobile-nav__link"
                              id="Sublabel-collections-plus-size11"
                              >
                              Plus Size
                            </a></div></li></ul>
                </div>
              </div></li><li class="mobile-nav__item appear-animation appear-delay-5"><div class="mobile-nav__has-sublist"><a href="/collections/western-wear"
                    class="mobile-nav__link mobile-nav__link--top-level"
                    id="Label-collections-western-wear4"
                    >
                    Western Wear
                  </a>
                  <div class="mobile-nav__toggle">
                    <button type="button"
                      aria-controls="Linklist-collections-western-wear4"
                      aria-labelledby="Label-collections-western-wear4"
                      class="collapsible-trigger collapsible--auto-height"><span class="collapsible-trigger__icon collapsible-trigger__icon--open" role="presentation">
  <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon--wide icon-chevron-down" viewBox="0 0 28 16"><path d="M1.57 1.59l12.76 12.77L27.1 1.59" stroke-width="2" stroke="#000" fill="none" fill-rule="evenodd"/></svg>
</span>
</button>
                  </div></div><div id="Linklist-collections-western-wear4"
                class="mobile-nav__sublist collapsible-content collapsible-content--all"
                >
                <div class="collapsible-content__inner">
                  <ul class="mobile-nav__sublist"><li class="mobile-nav__item">
                        <div class="mobile-nav__child-item"><a href="/collections/tops-tunics"
                              class="mobile-nav__link"
                              id="Sublabel-collections-tops-tunics1"
                              >
                              Tops &amp; Tunics
                            </a></div></li><li class="mobile-nav__item">
                        <div class="mobile-nav__child-item"><a href="/collections/dresses"
                              class="mobile-nav__link"
                              id="Sublabel-collections-dresses2"
                              >
                              Dresses
                            </a><button type="button"
                              aria-controls="Sublinklist-collections-western-wear4-collections-dresses2"
                              aria-labelledby="Sublabel-collections-dresses2"
                              class="collapsible-trigger"><span class="collapsible-trigger__icon collapsible-trigger__icon--circle collapsible-trigger__icon--open" role="presentation">
  <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon--wide icon-chevron-down" viewBox="0 0 28 16"><path d="M1.57 1.59l12.76 12.77L27.1 1.59" stroke-width="2" stroke="#000" fill="none" fill-rule="evenodd"/></svg>
</span>
</button></div><div
                            id="Sublinklist-collections-western-wear4-collections-dresses2"
                            aria-labelledby="Sublabel-collections-dresses2"
                            class="mobile-nav__sublist collapsible-content collapsible-content--all"
                            >
                            <div class="collapsible-content__inner">
                              <ul class="mobile-nav__grandchildlist"><li class="mobile-nav__item">
                                    <a href="/collections/dresses-mini" class="mobile-nav__link">
                                      Dresses Mini
                                    </a>
                                  </li><li class="mobile-nav__item">
                                    <a href="/collections/dresses-midi" class="mobile-nav__link">
                                      Dresses Midi
                                    </a>
                                  </li><li class="mobile-nav__item">
                                    <a href="/collections/dresses-maxi" class="mobile-nav__link">
                                      Dresses Maxi
                                    </a>
                                  </li></ul>
                            </div>
                          </div></li><li class="mobile-nav__item">
                        <div class="mobile-nav__child-item"><a href="/collections/dungaree-jumpsuits"
                              class="mobile-nav__link"
                              id="Sublabel-collections-dungaree-jumpsuits3"
                              >
                              Jumpsuits &amp; Playsuits
                            </a></div></li><li class="mobile-nav__item">
                        <div class="mobile-nav__child-item"><a href="/collections/co-ord-sets"
                              class="mobile-nav__link"
                              id="Sublabel-collections-co-ord-sets4"
                              >
                              Co-ord Sets
                            </a></div></li><li class="mobile-nav__item">
                        <div class="mobile-nav__child-item"><a href="/collections/pants"
                              class="mobile-nav__link"
                              id="Sublabel-collections-pants5"
                              >
                              Pants
                            </a></div></li></ul>
                </div>
              </div></li><li class="mobile-nav__item appear-animation appear-delay-6"><a href="/collections/co-ord-sets" class="mobile-nav__link mobile-nav__link--top-level">Co-ord Sets</a></li><li class="mobile-nav__item appear-animation appear-delay-7"><a href="/collections/luxe" class="mobile-nav__link mobile-nav__link--top-level">Luxe</a></li><li class="mobile-nav__item appear-animation appear-delay-8"><a href="/collections/maternity-wear" class="mobile-nav__link mobile-nav__link--top-level">Maternity Wear</a></li><li class="mobile-nav__item appear-animation appear-delay-9"><a href="/collections/low-stock-sale" class="mobile-nav__link mobile-nav__link--top-level">Sale</a></li><li class="mobile-nav__item appear-animation appear-delay-10"><a href="/pages/sell-our-products" class="mobile-nav__link mobile-nav__link--top-level">Sell our products</a></li><li class="mobile-nav__item mobile-nav__item--secondary">
            <div class="grid"><div class="grid__item one-half appear-animation appear-delay-11">
                  <a href="/account" class="mobile-nav__link">Log in
</a>
                </div></div>
          </li></ul><ul class="mobile-nav__social appear-animation appear-delay-12"></ul>
    </div>
  </div>
</div>
<div id="CartDrawer" class="drawer drawer--right">
    <form id="CartDrawerForm" action="/cart" method="post" novalidate class="drawer__contents">
      <div class="drawer__fixed-header">
        <div class="drawer__header appear-animation appear-delay-1">
          <div class="h2 drawer__title">Cart</div>
          <div class="drawer__close">
            <button type="button" class="drawer__close-button js-drawer-close">
              <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-close" viewBox="0 0 64 64"><path d="M19 17.61l27.12 27.13m0-27.12L19 44.74"/></svg>
              <span class="icon__fallback-text">Close cart</span>
            </button>
          </div>
        </div>
      </div>

      <div class="drawer__inner">
        <div class="drawer__scrollable">
          <div data-products class="appear-animation appear-delay-2"></div>

          
        </div>

        <div class="drawer__footer appear-animation appear-delay-4">
          <div data-discounts>
            
          </div>

          <div class="cart__item-sub cart__item-row">
            <div class="ajaxcart__subtotal">Subtotal</div>
            <div data-subtotal><span class=money>Rs. 3,598.20</span></div>
          </div>

          <div class="cart__item-row text-center">
            <small>
              Shipping, taxes, and discount codes calculated at checkout.<br />
            </small>
          </div>

          

          <div class="cart__checkout-wrapper">
<!--             <button type="submit" name="checkout" data-terms-required="false" class="btn cart__checkout">
              Check out
            </button> -->
            <button type="button" style="height : 44px" onclick="window.zecpeCheckFunctionAndCall ? window.zecpeCheckFunctionAndCall('handleOcc', this) : window.location.href = '/cart/checkout'; event.stopPropagation(); event.stopImmediatePropagation();" name="checkout" data-terms-required="false" class="btn cart__checkout zecpe-btn">
               <div class="lds-ring"><div>&nbsp;</div><div>&nbsp;</div><div>&nbsp;</div><div>&nbsp;</div></div>
              <span class="occ-btn-text" style="display : flex;align-items : center;justify-content : center;"> 
                  Check out
              </span> 
            </button>
              <div style="display: flex; align-items: center; margin-top: 8px; border-radius : 4px; border: 1px solid #DDDDDD; height : 52px" class="button button--full button--outline">
                <div>
                  <input type="checkbox" id="zecpe-gift-card" name="zecpe-gc" value="gc" style="margin: 10px; cursor: pointer;">
                </div>
                <div>
                  <label style="display: inline; letter-spacing: 1px; cursor: pointer; font-size : 12px" for="zecpe-gift-card">Gift Card/ International Shipping/ local delivery/ pickup</label>
                </div>
              </div>

            <!--  Magic Checkout 1CC Begins -->
<!--<div style="margin-top:10px;"  >      
                <magic-checkout-btn onclick="openRzpCheckout(event)" border-radius="4px" width="" > </magic-checkout-btn>
        		</div>-->
            
            <!--  Magic Checkout 1CC Ends -->

            
          </div>
        </div>
      </div>

      <div class="drawer__cart-empty appear-animation appear-delay-2">
        <div class="drawer__scrollable">
          Your cart is currently empty.
        </div>
      </div>
    </form>
  </div><style>
  .site-nav__link,
  .site-nav__dropdown-link:not(.site-nav__dropdown-link--top-level) {
    font-size: 16px;
  }
  
    .site-nav__link, .mobile-nav__link--top-level {
      text-transform: uppercase;
      letter-spacing: 0.2em;
    }
    .mobile-nav__link--top-level {
      font-size: 1.1em;
    }
  

  

  
.site-header {
      box-shadow: 0 0 1px rgba(0,0,0,0.2);
    }

    .toolbar + .header-sticky-wrapper .site-header {
      border-top: 0;
    }</style>

<div data-section-id="header" data-section-type="header"><div class="toolbar small--hide">
  <div class="page-width">
    <div class="toolbar__content"><div class="toolbar__item">
          <ul class="inline-list toolbar__social"></ul>
        </div></div>

  </div>
</div>

<div class="header-sticky-wrapper">
    <div id="HeaderWrapper" class="header-wrapper"><header
        id="SiteHeader"
        class="site-header"
        data-sticky="true"
        data-overlay="false">
        <div class="page-width">
          <div
            class="header-layout header-layout--center"
            data-logo-align="center"><div class="header-item header-item--left header-item--navigation"><div class="site-nav small--hide">
                      <a href="/search" class="site-nav__link site-nav__link--icon js-search-header">
                        <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-search" viewBox="0 0 64 64"><path d="M47.16 28.58A18.58 18.58 0 1 1 28.58 10a18.58 18.58 0 0 1 18.58 18.58zM54 54L41.94 42"/></svg>
                        <span class="icon__fallback-text">Search</span>
                      </a>
                    </div><div class="site-nav medium-up--hide">
                  <div class="drawer__close">
                    <button type="button" class="drawer__close-button js-drawer-close">
                      <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-close" viewBox="0 0 64 64"><path d="M19 17.61l27.12 27.13m0-27.12L19 44.74"/></svg>
                      <span class="icon__fallback-text">Close menu</span>
                    </button>
                  </div>
                  <button
                    type="button"
                    class="site-nav__link site-nav__link--icon js-drawer-open-nav"
                    aria-controls="NavDrawer">
                    <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-hamburger" viewBox="0 0 64 64"><path d="M7 15h51M7 32h43M7 49h51"/></svg>
                    <span class="icon__fallback-text">Site navigation</span>
                  </button>
                </div>
              </div><div class="header-item header-item--logo"><style data-shopify>.header-item--logo,
    .header-layout--left-center .header-item--logo,
    .header-layout--left-center .header-item--icons {
      -webkit-box-flex: 0 1 110px;
      -ms-flex: 0 1 110px;
      flex: 0 1 110px;
    }

    @media only screen and (min-width: 769px) {
      .header-item--logo,
      .header-layout--left-center .header-item--logo,
      .header-layout--left-center .header-item--icons {
        -webkit-box-flex: 0 0 140px;
        -ms-flex: 0 0 140px;
        flex: 0 0 140px;
      }
    }

    .site-header__logo a {
      width: 110px;
    }
    .is-light .site-header__logo .logo--inverted {
      width: 110px;
    }
    @media only screen and (min-width: 769px) {
      .site-header__logo a {
        width: 140px;
      }

      .is-light .site-header__logo .logo--inverted {
        width: 140px;
      }
    }</style><div class="h1 site-header__logo" itemscope itemtype="http://schema.org/Organization">
      <a
        href="/"
        itemprop="url"
        class="site-header__logo-link logo--has-inverted"
        style="padding-top: 28.333333333333336%"> 
        <img
          class="small--hide"
          src="//jisora.com/cdn/shop/files/jisora-logo_180x_98ef8eae-7a4c-484c-b842-cf3c18a7c1a1_140x.png?v=1647944899"
          srcset="//jisora.com/cdn/shop/files/jisora-logo_180x_98ef8eae-7a4c-484c-b842-cf3c18a7c1a1_140x.png?v=1647944899 1x, //jisora.com/cdn/shop/files/jisora-logo_180x_98ef8eae-7a4c-484c-b842-cf3c18a7c1a1_140x@2x.png?v=1647944899 2x"
          alt="JISORA"
          itemprop="logo">
        <img
          class="medium-up--hide"
          src="//jisora.com/cdn/shop/files/jisora-logo_180x_98ef8eae-7a4c-484c-b842-cf3c18a7c1a1_110x.png?v=1647944899"
          srcset="//jisora.com/cdn/shop/files/jisora-logo_180x_98ef8eae-7a4c-484c-b842-cf3c18a7c1a1_110x.png?v=1647944899 1x, //jisora.com/cdn/shop/files/jisora-logo_180x_98ef8eae-7a4c-484c-b842-cf3c18a7c1a1_110x@2x.png?v=1647944899 2x"
          alt="JISORA">
      </a><a
          href="/"
          itemprop="url"
          class="site-header__logo-link logo--inverted"
          style="padding-top: 28.333333333333336%">
          <img
            class="small--hide"
            src="//jisora.com/cdn/shop/files/jisora-logo_light_140x.png?v=1647944909"
            srcset="//jisora.com/cdn/shop/files/jisora-logo_light_140x.png?v=1647944909 1x, //jisora.com/cdn/shop/files/jisora-logo_light_140x@2x.png?v=1647944909 2x"
            alt="JISORA"
            itemprop="logo">
          <img
            class="medium-up--hide"
            src="//jisora.com/cdn/shop/files/jisora-logo_light_110x.png?v=1647944909"
            srcset="//jisora.com/cdn/shop/files/jisora-logo_light_110x.png?v=1647944909 1x, //jisora.com/cdn/shop/files/jisora-logo_light_110x@2x.png?v=1647944909 2x"
            alt="JISORA">
        </a></div></div><div class="header-item header-item--icons"><div class="site-nav">
  <div class="site-nav__icons"><a class="site-nav__link site-nav__link--icon" href="/account">
        <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-user" viewBox="0 0 64 64"><path d="M35 39.84v-2.53c3.3-1.91 6-6.66 6-11.41 0-7.63 0-13.82-9-13.82s-9 6.19-9 13.82c0 4.75 2.7 9.51 6 11.41v2.53c-10.18.85-18 6-18 12.16h42c0-6.19-7.82-11.31-18-12.16z"/></svg>
        <span class="icon__fallback-text">Log in
</span>
      </a> 
   <!-- <a href="#"><span class="wishlist"><svg width="20" height="20" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"><path d="M1664 596q0-81-21.5-143t-55-98.5-81.5-59.5-94-31-98-8-112 25.5-110.5 64-86.5 72-60 61.5q-18 22-49 22t-49-22q-24-28-60-61.5t-86.5-72-110.5-64-112-25.5-98 8-94 31-81.5 59.5-55 98.5-21.5 143q0 168 187 355l581 560 580-559q188-188 188-356zm128 0q0 221-229 450l-623 600q-18 18-44 18t-44-18l-624-602q-10-8-27.5-26t-55.5-65.5-68-97.5-53.5-121-23.5-138q0-220 127-344t351-124q62 0 126.5 21.5t120 58 95.5 68.5 76 68q36-36 76-68t95.5-68.5 120-58 126.5-21.5q224 0 351 124t127 344z"></path></svg></span></a>--><a href="/search" class="site-nav__link site-nav__link--icon js-search-header medium-up--hide">
        <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-search" viewBox="0 0 64 64"><path d="M47.16 28.58A18.58 18.58 0 1 1 28.58 10a18.58 18.58 0 0 1 18.58 18.58zM54 54L41.94 42"/></svg>
        <span class="icon__fallback-text">Search</span>
      </a><a href="/cart" class="site-nav__link site-nav__link--icon js-drawer-open-cart" aria-controls="CartDrawer" data-icon="cart">
      <span class="cart-link"><svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-cart" viewBox="0 0 64 64"><path fill="none" d="M14 17.44h46.79l-7.94 25.61H20.96l-9.65-35.1H3"/><circle cx="27" cy="53" r="2"/><circle cx="47" cy="53" r="2"/></svg><span class="icon__fallback-text">Cart</span>
        <span class="cart-link__bubble cart-link__bubble--visible"></span>
      </span>
    </a>
  </div>
</div>
</div>
          </div><div class="text-center"><ul
  class="site-nav site-navigation small--hide"
  
    role="navigation" aria-label="Primary"
  ><li
      class="site-nav__item site-nav__expanded-item"
      >

      <a href="/" class="site-nav__link site-nav__link--underline">
        Home
      </a></li><li
      class="site-nav__item site-nav__expanded-item"
      >

      <a href="/collections/new-arrivals" class="site-nav__link site-nav__link--underline">
        New Arrivals
      </a></li><li
      class="site-nav__item site-nav__expanded-item site-nav--has-dropdown site-nav--is-megamenu"
      aria-haspopup="true">

      <a href="/collections/lounge-wear" class="site-nav__link site-nav__link--underline site-nav__link--has-dropdown">
        Lounge Wear
      </a><div class="site-nav__dropdown megamenu text-left">
          <div class="page-width">
            <div class="grid grid--center">
              <div class="grid__item medium-up--one-fifth appear-animation appear-delay-1"></div>
              <div class="grid__item medium-up--one-fifth appear-animation appear-delay-2"><div class="h5">
                    <a href="/collections/kaftan" class="site-nav__dropdown-link site-nav__dropdown-link--top-level">Kaftan</a>
                  </div>
					<ul><li>
                      <a href="/collections/kaftan-maxi" class="site-nav__dropdown-link">
                        Kaftan Maxi
                      </a>
                    </li><li>
                      <a href="/collections/kaftan-midi" class="site-nav__dropdown-link">
                        Kaftan Midi
                      </a>
                    </li><li>
                      <a href="/collections/kaftan-top-set" class="site-nav__dropdown-link">
                        Kaftan Top Set
                      </a>
                    </li><li>
                      <a href="/collections/front-buttoned-kaftan" class="site-nav__dropdown-link">
                        Front-Buttoned Kaftan
                      </a>
                    </li></div>
              <div class="grid__item medium-up--one-fifth appear-animation appear-delay-3"><div class="h5">
                    <a href="/collections/pyjama-sets" class="site-nav__dropdown-link site-nav__dropdown-link--top-level">Pyjama Sets</a>
                  </div>
					<ul><li>
                      <a href="/collections/top-set" class="site-nav__dropdown-link">
                        Top Set
                      </a>
                    </li><li>
                      <a href="/collections/kaftan-top-set" class="site-nav__dropdown-link">
                        Kaftan Top Set
                      </a>
                    </li><li>
                      <a href="/collections/peplum-top-set" class="site-nav__dropdown-link">
                        Peplum Top Set
                      </a>
                    </li><li>
                      <a href="/collections/angrakha-top-set" class="site-nav__dropdown-link">
                        Angrakha Top Set
                      </a>
                    </li><li>
                      <a href="/collections/shirt-sets" class="site-nav__dropdown-link">
                        Shirt Sets
                      </a>
                    </li></div>
              <div class="grid__item medium-up--one-fifth appear-animation appear-delay-4"><div class="h5">
                    <a href="/collections/short-sets" class="site-nav__dropdown-link site-nav__dropdown-link--top-level">Short Sets</a>
                  </div>
					<ul></div>
              <div class="grid__item medium-up--one-fifth appear-animation appear-delay-5"><div class="h5">
                    <a href="/collections/shrug-sets" class="site-nav__dropdown-link site-nav__dropdown-link--top-level">Shrug Sets</a>
                  </div>
					<ul></div>
              <div class="grid__item medium-up--one-fifth appear-animation appear-delay-6"><div class="h5">
                    <a href="/collections/palazzo-sets" class="site-nav__dropdown-link site-nav__dropdown-link--top-level">Palazzo Sets</a>
                  </div>
					<ul></div>
              <div class="grid__item medium-up--one-fifth appear-animation appear-delay-7"><div class="h5">
                    <a href="/collections/t-shirt-dresses" class="site-nav__dropdown-link site-nav__dropdown-link--top-level">T-shirt Dresses</a>
                  </div>
					<ul></div>
              <div class="grid__item medium-up--one-fifth appear-animation appear-delay-8"><div class="h5">
                    <a href="/collections/night-robes" class="site-nav__dropdown-link site-nav__dropdown-link--top-level">Night Robes </a>
                  </div>
					<ul></div>
              <div class="grid__item medium-up--one-fifth appear-animation appear-delay-9"><div class="h5">
                    <a href="/collections/maternity-dresses" class="site-nav__dropdown-link site-nav__dropdown-link--top-level">Maternity Dresses</a>
                  </div>
					<ul></div>
              <div class="grid__item medium-up--one-fifth appear-animation appear-delay-10"><div class="h5">
                    <a href="/collections/slip-dress" class="site-nav__dropdown-link site-nav__dropdown-link--top-level">Slip Dress</a>
                  </div>
					<ul></div>
              <div class="grid__item medium-up--one-fifth appear-animation appear-delay-11"><div class="h5">
                    <a href="https://jisora.com/collections/lounge-dresses" class="site-nav__dropdown-link site-nav__dropdown-link--top-level">Lounge Dresses</a>
                  </div>
					<ul></div>
              <div class="grid__item medium-up--one-fifth appear-animation appear-delay-12"><div class="h5">
                    <a href="/collections/plus-size" class="site-nav__dropdown-link site-nav__dropdown-link--top-level">Plus Size</a>
                  </div>
					<ul></ul>
              </div>
            </div>
          </div>
        </div></li><li
      class="site-nav__item site-nav__expanded-item site-nav--has-dropdown site-nav--is-megamenu"
      aria-haspopup="true">

      <a href="/collections/western-wear" class="site-nav__link site-nav__link--underline site-nav__link--has-dropdown">
        Western Wear
      </a><div class="site-nav__dropdown megamenu text-left">
          <div class="page-width">
            <div class="grid grid--center">
              <div class="grid__item medium-up--one-fifth appear-animation appear-delay-1"></div>
              <div class="grid__item medium-up--one-fifth appear-animation appear-delay-2"><div class="h5">
                    <a href="/collections/tops-tunics" class="site-nav__dropdown-link site-nav__dropdown-link--top-level">Tops & Tunics</a>
                  </div>
					<ul></div>
              <div class="grid__item medium-up--one-fifth appear-animation appear-delay-3"><div class="h5">
                    <a href="/collections/dresses" class="site-nav__dropdown-link site-nav__dropdown-link--top-level">Dresses</a>
                  </div>
					<ul><li>
                      <a href="/collections/dresses-mini" class="site-nav__dropdown-link">
                        Dresses Mini
                      </a>
                    </li><li>
                      <a href="/collections/dresses-midi" class="site-nav__dropdown-link">
                        Dresses Midi
                      </a>
                    </li><li>
                      <a href="/collections/dresses-maxi" class="site-nav__dropdown-link">
                        Dresses Maxi
                      </a>
                    </li></div>
              <div class="grid__item medium-up--one-fifth appear-animation appear-delay-4"><div class="h5">
                    <a href="/collections/dungaree-jumpsuits" class="site-nav__dropdown-link site-nav__dropdown-link--top-level">Jumpsuits & Playsuits</a>
                  </div>
					<ul></div>
              <div class="grid__item medium-up--one-fifth appear-animation appear-delay-5"><div class="h5">
                    <a href="/collections/co-ord-sets" class="site-nav__dropdown-link site-nav__dropdown-link--top-level">Co-ord Sets</a>
                  </div>
					<ul></div>
              <div class="grid__item medium-up--one-fifth appear-animation appear-delay-6"><div class="h5">
                    <a href="/collections/pants" class="site-nav__dropdown-link site-nav__dropdown-link--top-level">Pants</a>
                  </div>
					<ul></ul>
              </div>
            </div>
          </div>
        </div></li><li
      class="site-nav__item site-nav__expanded-item"
      >

      <a href="/collections/co-ord-sets" class="site-nav__link site-nav__link--underline">
        Co-ord Sets
      </a></li><li
      class="site-nav__item site-nav__expanded-item"
      >

      <a href="/collections/luxe" class="site-nav__link site-nav__link--underline">
        Luxe
      </a></li><li
      class="site-nav__item site-nav__expanded-item"
      >

      <a href="/collections/maternity-wear" class="site-nav__link site-nav__link--underline">
        Maternity Wear
      </a></li><li
      class="site-nav__item site-nav__expanded-item"
      >

      <a href="/collections/low-stock-sale" class="site-nav__link site-nav__link--underline">
        Sale
      </a></li><li
      class="site-nav__item site-nav__expanded-item"
      >

      <a href="/pages/sell-our-products" class="site-nav__link site-nav__link--underline">
        Sell our products
      </a></li></ul>
</div></div>
        <div class="site-header__search-container">
          <div class="site-header__search">
            <div class="page-width">
              <form action="/search" method="get" role="search"
                id="HeaderSearchForm"
                class="site-header__search-form">
                <input type="hidden" name="type" value="product,article,page,collection">
                <input type="hidden" name="options[prefix]" value="last">
                <button type="submit" class="text-link site-header__search-btn site-header__search-btn--submit">
                  <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-search" viewBox="0 0 64 64"><path d="M47.16 28.58A18.58 18.58 0 1 1 28.58 10a18.58 18.58 0 0 1 18.58 18.58zM54 54L41.94 42"/></svg>
                  <span class="icon__fallback-text">Search</span>
                </button>
                <input type="search" name="q" value="" placeholder="Search our store" class="site-header__search-input" aria-label="Search our store">
              </form>
              <button type="button" id="SearchClose" class="js-search-header-close text-link site-header__search-btn">
                <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-close" viewBox="0 0 64 64"><path d="M19 17.61l27.12 27.13m0-27.12L19 44.74"/></svg>
                <span class="icon__fallback-text">"Close (esc)"</span>
              </button>
            </div>
          </div><div id="PredictiveWrapper" class="predictive-results hide" data-image-size="square">
              <div class="page-width">
                <div id="PredictiveResults" class="predictive-result__layout"></div>
                <div class="text-center predictive-results__footer">
                  <button type="button" class="btn btn--small" data-predictive-search-button>
                    <small>
                      View more
                    </small>
                  </button>
                </div>
              </div>
            </div></div>
      </header>
    </div>
  </div>


</div>


</div><div id="PageContainer" class="page-container">
    <div class="transition-body">

   
     
      <main class="main-content" id="MainContent">
        <div id="shopify-section-template--16763831779553__smarketly_sections" class="shopify-section"></div><div id="shopify-section-template--16763831779553__main" class="shopify-section"><div id="ProductSection-template--16763831779553__main-8149411725537"
  class="product-section"
  data-section-id="template--16763831779553__main"
  data-product-id="8149411725537"
  data-section-type="product"
  data-product-handle="ebony-blossom-three-piece-cotton-co-ord-set"
  data-product-title="Ebony blossom three piece cotton co-ord set"
  data-product-url="/collections/new-arrivals/products/ebony-blossom-three-piece-cotton-co-ord-set"
  data-aspect-ratio="150.00000000000003"
  data-img-url="//jisora.com/cdn/shop/files/SMP02530_{width}x.jpg?v=1699620993"
  
    data-history="true"
  
  data-modal="false"><script type="application/ld+json">
  {
    "@context": "http://schema.org",
    "@type": "Product",
    "offers": [{
          "@type" : "Offer","sku": "9TBS2234-S","availability" : "http://schema.org/InStock",
          "price" : 1799.1,
          "priceCurrency" : "INR",
          "priceValidUntil": "2023-12-15",
          "url" : "https:\/\/jisora.com\/products\/ebony-blossom-three-piece-cotton-co-ord-set?variant=44218255900897"
        },
{
          "@type" : "Offer","sku": "9TBS2234-M","availability" : "http://schema.org/InStock",
          "price" : 1799.1,
          "priceCurrency" : "INR",
          "priceValidUntil": "2023-12-15",
          "url" : "https:\/\/jisora.com\/products\/ebony-blossom-three-piece-cotton-co-ord-set?variant=44218255933665"
        },
{
          "@type" : "Offer","sku": "9TBS2234-L","availability" : "http://schema.org/OutOfStock",
          "price" : 1799.1,
          "priceCurrency" : "INR",
          "priceValidUntil": "2023-12-15",
          "url" : "https:\/\/jisora.com\/products\/ebony-blossom-three-piece-cotton-co-ord-set?variant=44218255966433"
        },
{
          "@type" : "Offer","sku": "9TBS2234-XL","availability" : "http://schema.org/OutOfStock",
          "price" : 1799.1,
          "priceCurrency" : "INR",
          "priceValidUntil": "2023-12-15",
          "url" : "https:\/\/jisora.com\/products\/ebony-blossom-three-piece-cotton-co-ord-set?variant=44218255999201"
        }
],
    "brand": "JISORA",
    "sku": "9TBS2234-M",
    "name": "Ebony blossom three piece cotton co-ord set",
    "description": "Dress up your wardrobe with this one-of-a-kind Ebony Blossom three piece set! Perfect for all seasons, this cotton co-ord set is as comfy as it is stylish - don't miss out on this blooming beauty!",
    "category": "",
    "url": "https://jisora.com/products/ebony-blossom-three-piece-cotton-co-ord-set",
      "mpn": "9TBS2234-M",
      "productId": "9TBS2234-M","image": {
      "@type": "ImageObject",
      "url": "https://jisora.com/cdn/shop/files/SMP02530_1024x1024.jpg?v=1699620993",
      "image": "https://jisora.com/cdn/shop/files/SMP02530_1024x1024.jpg?v=1699620993",
      "name": "Ebony blossom three piece cotton co-ord set",
      "width": 1024,
      "height": 1024
    }
  }
</script>
<div class="page-content page-content--product">
    <div class="page-width">

      <div class="grid grid--product-images--partial"><div class="grid__item medium-up--one-half product-single__sticky"><div
    data-product-images
    data-zoom="true"
    data-has-slideshow="true">
    <div class="product__photos product__photos-template--16763831779553__main product__photos--beside">

      <div class="product__main-photos" data-aos data-product-single-media-group>
        <div data-product-photos class="product-slideshow" id="ProductPhotos-template--16763831779553__main">
<div
  class="product-main-slide starting-slide"
  data-index="0"
  >

  <div data-product-image-main class="product-image-main"><div class="image-wrap" style="height: 0; padding-bottom: 150.00000000000003%;"><img class="photoswipe__image lazyload"
          data-photoswipe-src="//jisora.com/cdn/shop/files/SMP02530_1800x1800.jpg?v=1699620993"
          data-photoswipe-width="1800"
          data-photoswipe-height="2700"
          data-index="1"
          data-src="//jisora.com/cdn/shop/files/SMP02530_{width}x.jpg?v=1699620993"
          data-widths="[360, 540, 720, 900, 1080]"
          data-aspectratio="0.6666666666666666"
          data-sizes="auto"
          alt="Ebony blossom three piece cotton co-ord set">

        <noscript>
          <img class="lazyloaded"
            src="//jisora.com/cdn/shop/files/SMP02530_1400x.jpg?v=1699620993"
            alt="Ebony blossom three piece cotton co-ord set">
        </noscript><button type="button" class="btn btn--body btn--circle js-photoswipe__zoom product__photo-zoom">
            <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-search" viewBox="0 0 64 64"><path d="M47.16 28.58A18.58 18.58 0 1 1 28.58 10a18.58 18.58 0 0 1 18.58 18.58zM54 54L41.94 42"/></svg>
            <span class="icon__fallback-text">Close (esc)</span>
          </button></div></div>

</div>

<div
  class="product-main-slide secondary-slide"
  data-index="1"
  >

  <div data-product-image-main class="product-image-main"><div class="image-wrap" style="height: 0; padding-bottom: 150.00000000000003%;"><img class="photoswipe__image lazyload"
          data-photoswipe-src="//jisora.com/cdn/shop/files/SMP02532_1800x1800.jpg?v=1699620991"
          data-photoswipe-width="1800"
          data-photoswipe-height="2700"
          data-index="2"
          data-src="//jisora.com/cdn/shop/files/SMP02532_{width}x.jpg?v=1699620991"
          data-widths="[360, 540, 720, 900, 1080]"
          data-aspectratio="0.6666666666666666"
          data-sizes="auto"
          alt="Ebony blossom three piece cotton co-ord set">

        <noscript>
          <img class="lazyloaded"
            src="//jisora.com/cdn/shop/files/SMP02532_1400x.jpg?v=1699620991"
            alt="Ebony blossom three piece cotton co-ord set">
        </noscript><button type="button" class="btn btn--body btn--circle js-photoswipe__zoom product__photo-zoom">
            <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-search" viewBox="0 0 64 64"><path d="M47.16 28.58A18.58 18.58 0 1 1 28.58 10a18.58 18.58 0 0 1 18.58 18.58zM54 54L41.94 42"/></svg>
            <span class="icon__fallback-text">Close (esc)</span>
          </button></div></div>

</div>

<div
  class="product-main-slide secondary-slide"
  data-index="2"
  >

  <div data-product-image-main class="product-image-main"><div class="image-wrap" style="height: 0; padding-bottom: 150.00000000000003%;"><img class="photoswipe__image lazyload"
          data-photoswipe-src="//jisora.com/cdn/shop/files/SMP02534_1800x1800.jpg?v=1699620990"
          data-photoswipe-width="1800"
          data-photoswipe-height="2700"
          data-index="3"
          data-src="//jisora.com/cdn/shop/files/SMP02534_{width}x.jpg?v=1699620990"
          data-widths="[360, 540, 720, 900, 1080]"
          data-aspectratio="0.6666666666666666"
          data-sizes="auto"
          alt="Ebony blossom three piece cotton co-ord set">

        <noscript>
          <img class="lazyloaded"
            src="//jisora.com/cdn/shop/files/SMP02534_1400x.jpg?v=1699620990"
            alt="Ebony blossom three piece cotton co-ord set">
        </noscript><button type="button" class="btn btn--body btn--circle js-photoswipe__zoom product__photo-zoom">
            <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-search" viewBox="0 0 64 64"><path d="M47.16 28.58A18.58 18.58 0 1 1 28.58 10a18.58 18.58 0 0 1 18.58 18.58zM54 54L41.94 42"/></svg>
            <span class="icon__fallback-text">Close (esc)</span>
          </button></div></div>

</div>

<div
  class="product-main-slide secondary-slide"
  data-index="3"
  >

  <div data-product-image-main class="product-image-main"><div class="image-wrap" style="height: 0; padding-bottom: 150.00000000000003%;"><img class="photoswipe__image lazyload"
          data-photoswipe-src="//jisora.com/cdn/shop/files/SMP02537_1800x1800.jpg?v=1699620992"
          data-photoswipe-width="1800"
          data-photoswipe-height="2700"
          data-index="4"
          data-src="//jisora.com/cdn/shop/files/SMP02537_{width}x.jpg?v=1699620992"
          data-widths="[360, 540, 720, 900, 1080]"
          data-aspectratio="0.6666666666666666"
          data-sizes="auto"
          alt="Ebony blossom three piece cotton co-ord set">

        <noscript>
          <img class="lazyloaded"
            src="//jisora.com/cdn/shop/files/SMP02537_1400x.jpg?v=1699620992"
            alt="Ebony blossom three piece cotton co-ord set">
        </noscript><button type="button" class="btn btn--body btn--circle js-photoswipe__zoom product__photo-zoom">
            <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-search" viewBox="0 0 64 64"><path d="M47.16 28.58A18.58 18.58 0 1 1 28.58 10a18.58 18.58 0 0 1 18.58 18.58zM54 54L41.94 42"/></svg>
            <span class="icon__fallback-text">Close (esc)</span>
          </button></div></div>

</div>

<div
  class="product-main-slide secondary-slide"
  data-index="4"
  >

  <div data-product-image-main class="product-image-main"><div class="image-wrap" style="height: 0; padding-bottom: 150.00000000000003%;"><img class="photoswipe__image lazyload"
          data-photoswipe-src="//jisora.com/cdn/shop/files/SMP02542_1800x1800.jpg?v=1699620990"
          data-photoswipe-width="1800"
          data-photoswipe-height="2700"
          data-index="5"
          data-src="//jisora.com/cdn/shop/files/SMP02542_{width}x.jpg?v=1699620990"
          data-widths="[360, 540, 720, 900, 1080]"
          data-aspectratio="0.6666666666666666"
          data-sizes="auto"
          alt="Ebony blossom three piece cotton co-ord set">

        <noscript>
          <img class="lazyloaded"
            src="//jisora.com/cdn/shop/files/SMP02542_1400x.jpg?v=1699620990"
            alt="Ebony blossom three piece cotton co-ord set">
        </noscript><button type="button" class="btn btn--body btn--circle js-photoswipe__zoom product__photo-zoom">
            <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-search" viewBox="0 0 64 64"><path d="M47.16 28.58A18.58 18.58 0 1 1 28.58 10a18.58 18.58 0 0 1 18.58 18.58zM54 54L41.94 42"/></svg>
            <span class="icon__fallback-text">Close (esc)</span>
          </button></div></div>

</div>

<div
  class="product-main-slide secondary-slide"
  data-index="5"
  >

  <div data-product-image-main class="product-image-main"><div class="image-wrap" style="height: 0; padding-bottom: 150.00000000000003%;"><img class="photoswipe__image lazyload"
          data-photoswipe-src="//jisora.com/cdn/shop/files/SMP02547_1800x1800.jpg?v=1699620995"
          data-photoswipe-width="1800"
          data-photoswipe-height="2700"
          data-index="6"
          data-src="//jisora.com/cdn/shop/files/SMP02547_{width}x.jpg?v=1699620995"
          data-widths="[360, 540, 720, 900, 1080]"
          data-aspectratio="0.6666666666666666"
          data-sizes="auto"
          alt="Ebony blossom three piece cotton co-ord set">

        <noscript>
          <img class="lazyloaded"
            src="//jisora.com/cdn/shop/files/SMP02547_1400x.jpg?v=1699620995"
            alt="Ebony blossom three piece cotton co-ord set">
        </noscript><button type="button" class="btn btn--body btn--circle js-photoswipe__zoom product__photo-zoom">
            <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-search" viewBox="0 0 64 64"><path d="M47.16 28.58A18.58 18.58 0 1 1 28.58 10a18.58 18.58 0 0 1 18.58 18.58zM54 54L41.94 42"/></svg>
            <span class="icon__fallback-text">Close (esc)</span>
          </button></div></div>

</div>

<div
  class="product-main-slide secondary-slide"
  data-index="6"
  >

  <div data-product-image-main class="product-image-main"><div class="image-wrap" style="height: 0; padding-bottom: 150.00000000000003%;"><img class="photoswipe__image lazyload"
          data-photoswipe-src="//jisora.com/cdn/shop/files/SMP02549_1800x1800.jpg?v=1699620990"
          data-photoswipe-width="1800"
          data-photoswipe-height="2700"
          data-index="7"
          data-src="//jisora.com/cdn/shop/files/SMP02549_{width}x.jpg?v=1699620990"
          data-widths="[360, 540, 720, 900, 1080]"
          data-aspectratio="0.6666666666666666"
          data-sizes="auto"
          alt="Ebony blossom three piece cotton co-ord set">

        <noscript>
          <img class="lazyloaded"
            src="//jisora.com/cdn/shop/files/SMP02549_1400x.jpg?v=1699620990"
            alt="Ebony blossom three piece cotton co-ord set">
        </noscript><button type="button" class="btn btn--body btn--circle js-photoswipe__zoom product__photo-zoom">
            <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-search" viewBox="0 0 64 64"><path d="M47.16 28.58A18.58 18.58 0 1 1 28.58 10a18.58 18.58 0 0 1 18.58 18.58zM54 54L41.94 42"/></svg>
            <span class="icon__fallback-text">Close (esc)</span>
          </button></div></div>

</div>

<div
  class="product-main-slide secondary-slide"
  data-index="7"
  >

  <div data-product-image-main class="product-image-main"><div class="image-wrap" style="height: 0; padding-bottom: 150.00000000000003%;"><img class="photoswipe__image lazyload"
          data-photoswipe-src="//jisora.com/cdn/shop/files/SMP02555_1800x1800.jpg?v=1699620993"
          data-photoswipe-width="1800"
          data-photoswipe-height="2700"
          data-index="8"
          data-src="//jisora.com/cdn/shop/files/SMP02555_{width}x.jpg?v=1699620993"
          data-widths="[360, 540, 720, 900, 1080]"
          data-aspectratio="0.6666666666666666"
          data-sizes="auto"
          alt="Ebony blossom three piece cotton co-ord set">

        <noscript>
          <img class="lazyloaded"
            src="//jisora.com/cdn/shop/files/SMP02555_1400x.jpg?v=1699620993"
            alt="Ebony blossom three piece cotton co-ord set">
        </noscript><button type="button" class="btn btn--body btn--circle js-photoswipe__zoom product__photo-zoom">
            <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-search" viewBox="0 0 64 64"><path d="M47.16 28.58A18.58 18.58 0 1 1 28.58 10a18.58 18.58 0 0 1 18.58 18.58zM54 54L41.94 42"/></svg>
            <span class="icon__fallback-text">Close (esc)</span>
          </button></div></div>

</div>

<div
  class="product-main-slide secondary-slide"
  data-index="8"
  >

  <div data-product-image-main class="product-image-main"><div class="image-wrap" style="height: 0; padding-bottom: 150.00000000000003%;"><img class="photoswipe__image lazyload"
          data-photoswipe-src="//jisora.com/cdn/shop/files/SMP02558_1800x1800.jpg?v=1699620992"
          data-photoswipe-width="1800"
          data-photoswipe-height="2700"
          data-index="9"
          data-src="//jisora.com/cdn/shop/files/SMP02558_{width}x.jpg?v=1699620992"
          data-widths="[360, 540, 720, 900, 1080]"
          data-aspectratio="0.6666666666666666"
          data-sizes="auto"
          alt="Ebony blossom three piece cotton co-ord set">

        <noscript>
          <img class="lazyloaded"
            src="//jisora.com/cdn/shop/files/SMP02558_1400x.jpg?v=1699620992"
            alt="Ebony blossom three piece cotton co-ord set">
        </noscript><button type="button" class="btn btn--body btn--circle js-photoswipe__zoom product__photo-zoom">
            <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-search" viewBox="0 0 64 64"><path d="M47.16 28.58A18.58 18.58 0 1 1 28.58 10a18.58 18.58 0 0 1 18.58 18.58zM54 54L41.94 42"/></svg>
            <span class="icon__fallback-text">Close (esc)</span>
          </button></div></div>

</div>

<div
  class="product-main-slide secondary-slide"
  data-index="9"
  >

  <div data-product-image-main class="product-image-main"><div class="image-wrap" style="height: 0; padding-bottom: 150.00000000000003%;"><img class="photoswipe__image lazyload"
          data-photoswipe-src="//jisora.com/cdn/shop/files/SMP02561_1800x1800.jpg?v=1699620994"
          data-photoswipe-width="1800"
          data-photoswipe-height="2700"
          data-index="10"
          data-src="//jisora.com/cdn/shop/files/SMP02561_{width}x.jpg?v=1699620994"
          data-widths="[360, 540, 720, 900, 1080]"
          data-aspectratio="0.6666666666666666"
          data-sizes="auto"
          alt="Ebony blossom three piece cotton co-ord set">

        <noscript>
          <img class="lazyloaded"
            src="//jisora.com/cdn/shop/files/SMP02561_1400x.jpg?v=1699620994"
            alt="Ebony blossom three piece cotton co-ord set">
        </noscript><button type="button" class="btn btn--body btn--circle js-photoswipe__zoom product__photo-zoom">
            <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-search" viewBox="0 0 64 64"><path d="M47.16 28.58A18.58 18.58 0 1 1 28.58 10a18.58 18.58 0 0 1 18.58 18.58zM54 54L41.94 42"/></svg>
            <span class="icon__fallback-text">Close (esc)</span>
          </button></div></div>

</div>

<div
  class="product-main-slide secondary-slide"
  data-index="10"
  >

  <div data-product-image-main class="product-image-main"><div class="image-wrap" style="height: 0; padding-bottom: 150.00000000000003%;"><img class="photoswipe__image lazyload"
          data-photoswipe-src="//jisora.com/cdn/shop/files/SMP02564_1800x1800.jpg?v=1699620994"
          data-photoswipe-width="1800"
          data-photoswipe-height="2700"
          data-index="11"
          data-src="//jisora.com/cdn/shop/files/SMP02564_{width}x.jpg?v=1699620994"
          data-widths="[360, 540, 720, 900, 1080]"
          data-aspectratio="0.6666666666666666"
          data-sizes="auto"
          alt="Ebony blossom three piece cotton co-ord set">

        <noscript>
          <img class="lazyloaded"
            src="//jisora.com/cdn/shop/files/SMP02564_1400x.jpg?v=1699620994"
            alt="Ebony blossom three piece cotton co-ord set">
        </noscript><button type="button" class="btn btn--body btn--circle js-photoswipe__zoom product__photo-zoom">
            <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-search" viewBox="0 0 64 64"><path d="M47.16 28.58A18.58 18.58 0 1 1 28.58 10a18.58 18.58 0 0 1 18.58 18.58zM54 54L41.94 42"/></svg>
            <span class="icon__fallback-text">Close (esc)</span>
          </button></div></div>

</div>

<div
  class="product-main-slide secondary-slide"
  data-index="11"
  >

  <div data-product-image-main class="product-image-main"><div class="image-wrap" style="height: 0; padding-bottom: 150.00000000000003%;"><img class="photoswipe__image lazyload"
          data-photoswipe-src="//jisora.com/cdn/shop/files/SMP02566_1800x1800.jpg?v=1699620991"
          data-photoswipe-width="1800"
          data-photoswipe-height="2700"
          data-index="12"
          data-src="//jisora.com/cdn/shop/files/SMP02566_{width}x.jpg?v=1699620991"
          data-widths="[360, 540, 720, 900, 1080]"
          data-aspectratio="0.6666666666666666"
          data-sizes="auto"
          alt="Ebony blossom three piece cotton co-ord set">

        <noscript>
          <img class="lazyloaded"
            src="//jisora.com/cdn/shop/files/SMP02566_1400x.jpg?v=1699620991"
            alt="Ebony blossom three piece cotton co-ord set">
        </noscript><button type="button" class="btn btn--body btn--circle js-photoswipe__zoom product__photo-zoom">
            <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-search" viewBox="0 0 64 64"><path d="M47.16 28.58A18.58 18.58 0 1 1 28.58 10a18.58 18.58 0 0 1 18.58 18.58zM54 54L41.94 42"/></svg>
            <span class="icon__fallback-text">Close (esc)</span>
          </button></div></div>

</div>
</div></div>

      <div
        data-product-thumbs
        class="product__thumbs product__thumbs--beside product__thumbs-placement--left small--hide"
        data-position="beside"
        data-arrows="true"
        data-aos><button type="button" class="product__thumb-arrow product__thumb-arrow--prev hide">
            <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-chevron-left" viewBox="0 0 284.49 498.98"><path d="M249.49 0a35 35 0 0 1 24.75 59.75L84.49 249.49l189.75 189.74a35.002 35.002 0 1 1-49.5 49.5L10.25 274.24a35 35 0 0 1 0-49.5L224.74 10.25A34.89 34.89 0 0 1 249.49 0z"/></svg>
          </button><div class="product__thumbs--scroller"><div class="product__thumb-item"
                data-index="0"
                >
                <div class="image-wrap" style="height: 0; padding-bottom: 150.00000000000003%;">
                  <a
                    href="//jisora.com/cdn/shop/files/SMP02530_1800x1800.jpg?v=1699620993"
                    data-product-thumb
                    class="product__thumb"
                    data-index="0"
                    data-id="33337201918177"><img class="animation-delay-3 lazyload"
                        data-src="//jisora.com/cdn/shop/files/SMP02530_{width}x.jpg?v=1699620993"
                        data-widths="[120, 360, 540, 720]"
                        data-aspectratio="0.6666666666666666"
                        data-sizes="auto"
                        alt="">

                    <noscript>
                      <img class="lazyloaded"
                        src="//jisora.com/cdn/shop/files/SMP02530_400x.jpg?v=1699620993"
                        alt="Ebony blossom three piece cotton co-ord set">
                    </noscript>
                  </a>
                </div>
              </div><div class="product__thumb-item"
                data-index="1"
                >
                <div class="image-wrap" style="height: 0; padding-bottom: 150.00000000000003%;">
                  <a
                    href="//jisora.com/cdn/shop/files/SMP02532_1800x1800.jpg?v=1699620991"
                    data-product-thumb
                    class="product__thumb"
                    data-index="1"
                    data-id="33337201950945"><img class="animation-delay-6 lazyload"
                        data-src="//jisora.com/cdn/shop/files/SMP02532_{width}x.jpg?v=1699620991"
                        data-widths="[120, 360, 540, 720]"
                        data-aspectratio="0.6666666666666666"
                        data-sizes="auto"
                        alt="">

                    <noscript>
                      <img class="lazyloaded"
                        src="//jisora.com/cdn/shop/files/SMP02532_400x.jpg?v=1699620991"
                        alt="Ebony blossom three piece cotton co-ord set">
                    </noscript>
                  </a>
                </div>
              </div><div class="product__thumb-item"
                data-index="2"
                >
                <div class="image-wrap" style="height: 0; padding-bottom: 150.00000000000003%;">
                  <a
                    href="//jisora.com/cdn/shop/files/SMP02534_1800x1800.jpg?v=1699620990"
                    data-product-thumb
                    class="product__thumb"
                    data-index="2"
                    data-id="33337201983713"><img class="animation-delay-9 lazyload"
                        data-src="//jisora.com/cdn/shop/files/SMP02534_{width}x.jpg?v=1699620990"
                        data-widths="[120, 360, 540, 720]"
                        data-aspectratio="0.6666666666666666"
                        data-sizes="auto"
                        alt="">

                    <noscript>
                      <img class="lazyloaded"
                        src="//jisora.com/cdn/shop/files/SMP02534_400x.jpg?v=1699620990"
                        alt="Ebony blossom three piece cotton co-ord set">
                    </noscript>
                  </a>
                </div>
              </div><div class="product__thumb-item"
                data-index="3"
                >
                <div class="image-wrap" style="height: 0; padding-bottom: 150.00000000000003%;">
                  <a
                    href="//jisora.com/cdn/shop/files/SMP02537_1800x1800.jpg?v=1699620992"
                    data-product-thumb
                    class="product__thumb"
                    data-index="3"
                    data-id="33337202016481"><img class="animation-delay-12 lazyload"
                        data-src="//jisora.com/cdn/shop/files/SMP02537_{width}x.jpg?v=1699620992"
                        data-widths="[120, 360, 540, 720]"
                        data-aspectratio="0.6666666666666666"
                        data-sizes="auto"
                        alt="">

                    <noscript>
                      <img class="lazyloaded"
                        src="//jisora.com/cdn/shop/files/SMP02537_400x.jpg?v=1699620992"
                        alt="Ebony blossom three piece cotton co-ord set">
                    </noscript>
                  </a>
                </div>
              </div><div class="product__thumb-item"
                data-index="4"
                >
                <div class="image-wrap" style="height: 0; padding-bottom: 150.00000000000003%;">
                  <a
                    href="//jisora.com/cdn/shop/files/SMP02542_1800x1800.jpg?v=1699620990"
                    data-product-thumb
                    class="product__thumb"
                    data-index="4"
                    data-id="33337202049249"><img class="animation-delay-15 lazyload"
                        data-src="//jisora.com/cdn/shop/files/SMP02542_{width}x.jpg?v=1699620990"
                        data-widths="[120, 360, 540, 720]"
                        data-aspectratio="0.6666666666666666"
                        data-sizes="auto"
                        alt="">

                    <noscript>
                      <img class="lazyloaded"
                        src="//jisora.com/cdn/shop/files/SMP02542_400x.jpg?v=1699620990"
                        alt="Ebony blossom three piece cotton co-ord set">
                    </noscript>
                  </a>
                </div>
              </div><div class="product__thumb-item"
                data-index="5"
                >
                <div class="image-wrap" style="height: 0; padding-bottom: 150.00000000000003%;">
                  <a
                    href="//jisora.com/cdn/shop/files/SMP02547_1800x1800.jpg?v=1699620995"
                    data-product-thumb
                    class="product__thumb"
                    data-index="5"
                    data-id="33337202082017"><img class="animation-delay-18 lazyload"
                        data-src="//jisora.com/cdn/shop/files/SMP02547_{width}x.jpg?v=1699620995"
                        data-widths="[120, 360, 540, 720]"
                        data-aspectratio="0.6666666666666666"
                        data-sizes="auto"
                        alt="">

                    <noscript>
                      <img class="lazyloaded"
                        src="//jisora.com/cdn/shop/files/SMP02547_400x.jpg?v=1699620995"
                        alt="Ebony blossom three piece cotton co-ord set">
                    </noscript>
                  </a>
                </div>
              </div><div class="product__thumb-item"
                data-index="6"
                >
                <div class="image-wrap" style="height: 0; padding-bottom: 150.00000000000003%;">
                  <a
                    href="//jisora.com/cdn/shop/files/SMP02549_1800x1800.jpg?v=1699620990"
                    data-product-thumb
                    class="product__thumb"
                    data-index="6"
                    data-id="33337202114785"><img class="animation-delay-21 lazyload"
                        data-src="//jisora.com/cdn/shop/files/SMP02549_{width}x.jpg?v=1699620990"
                        data-widths="[120, 360, 540, 720]"
                        data-aspectratio="0.6666666666666666"
                        data-sizes="auto"
                        alt="">

                    <noscript>
                      <img class="lazyloaded"
                        src="//jisora.com/cdn/shop/files/SMP02549_400x.jpg?v=1699620990"
                        alt="Ebony blossom three piece cotton co-ord set">
                    </noscript>
                  </a>
                </div>
              </div><div class="product__thumb-item"
                data-index="7"
                >
                <div class="image-wrap" style="height: 0; padding-bottom: 150.00000000000003%;">
                  <a
                    href="//jisora.com/cdn/shop/files/SMP02555_1800x1800.jpg?v=1699620993"
                    data-product-thumb
                    class="product__thumb"
                    data-index="7"
                    data-id="33337202147553"><img class="animation-delay-24 lazyload"
                        data-src="//jisora.com/cdn/shop/files/SMP02555_{width}x.jpg?v=1699620993"
                        data-widths="[120, 360, 540, 720]"
                        data-aspectratio="0.6666666666666666"
                        data-sizes="auto"
                        alt="">

                    <noscript>
                      <img class="lazyloaded"
                        src="//jisora.com/cdn/shop/files/SMP02555_400x.jpg?v=1699620993"
                        alt="Ebony blossom three piece cotton co-ord set">
                    </noscript>
                  </a>
                </div>
              </div><div class="product__thumb-item"
                data-index="8"
                >
                <div class="image-wrap" style="height: 0; padding-bottom: 150.00000000000003%;">
                  <a
                    href="//jisora.com/cdn/shop/files/SMP02558_1800x1800.jpg?v=1699620992"
                    data-product-thumb
                    class="product__thumb"
                    data-index="8"
                    data-id="33337202180321"><img class="animation-delay-27 lazyload"
                        data-src="//jisora.com/cdn/shop/files/SMP02558_{width}x.jpg?v=1699620992"
                        data-widths="[120, 360, 540, 720]"
                        data-aspectratio="0.6666666666666666"
                        data-sizes="auto"
                        alt="">

                    <noscript>
                      <img class="lazyloaded"
                        src="//jisora.com/cdn/shop/files/SMP02558_400x.jpg?v=1699620992"
                        alt="Ebony blossom three piece cotton co-ord set">
                    </noscript>
                  </a>
                </div>
              </div><div class="product__thumb-item"
                data-index="9"
                >
                <div class="image-wrap" style="height: 0; padding-bottom: 150.00000000000003%;">
                  <a
                    href="//jisora.com/cdn/shop/files/SMP02561_1800x1800.jpg?v=1699620994"
                    data-product-thumb
                    class="product__thumb"
                    data-index="9"
                    data-id="33337202213089"><img class="animation-delay-30 lazyload"
                        data-src="//jisora.com/cdn/shop/files/SMP02561_{width}x.jpg?v=1699620994"
                        data-widths="[120, 360, 540, 720]"
                        data-aspectratio="0.6666666666666666"
                        data-sizes="auto"
                        alt="">

                    <noscript>
                      <img class="lazyloaded"
                        src="//jisora.com/cdn/shop/files/SMP02561_400x.jpg?v=1699620994"
                        alt="Ebony blossom three piece cotton co-ord set">
                    </noscript>
                  </a>
                </div>
              </div><div class="product__thumb-item"
                data-index="10"
                >
                <div class="image-wrap" style="height: 0; padding-bottom: 150.00000000000003%;">
                  <a
                    href="//jisora.com/cdn/shop/files/SMP02564_1800x1800.jpg?v=1699620994"
                    data-product-thumb
                    class="product__thumb"
                    data-index="10"
                    data-id="33337202245857"><img class="animation-delay-33 lazyload"
                        data-src="//jisora.com/cdn/shop/files/SMP02564_{width}x.jpg?v=1699620994"
                        data-widths="[120, 360, 540, 720]"
                        data-aspectratio="0.6666666666666666"
                        data-sizes="auto"
                        alt="">

                    <noscript>
                      <img class="lazyloaded"
                        src="//jisora.com/cdn/shop/files/SMP02564_400x.jpg?v=1699620994"
                        alt="Ebony blossom three piece cotton co-ord set">
                    </noscript>
                  </a>
                </div>
              </div><div class="product__thumb-item"
                data-index="11"
                >
                <div class="image-wrap" style="height: 0; padding-bottom: 150.00000000000003%;">
                  <a
                    href="//jisora.com/cdn/shop/files/SMP02566_1800x1800.jpg?v=1699620991"
                    data-product-thumb
                    class="product__thumb"
                    data-index="11"
                    data-id="33337202278625"><img class="animation-delay-36 lazyload"
                        data-src="//jisora.com/cdn/shop/files/SMP02566_{width}x.jpg?v=1699620991"
                        data-widths="[120, 360, 540, 720]"
                        data-aspectratio="0.6666666666666666"
                        data-sizes="auto"
                        alt="">

                    <noscript>
                      <img class="lazyloaded"
                        src="//jisora.com/cdn/shop/files/SMP02566_400x.jpg?v=1699620991"
                        alt="Ebony blossom three piece cotton co-ord set">
                    </noscript>
                  </a>
                </div>
              </div></div><button type="button" class="product__thumb-arrow product__thumb-arrow--next">
            <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-chevron-right" viewBox="0 0 284.49 498.98"><path d="M35 498.98a35 35 0 0 1-24.75-59.75l189.74-189.74L10.25 59.75a35.002 35.002 0 0 1 49.5-49.5l214.49 214.49a35 35 0 0 1 0 49.5L59.75 488.73A34.89 34.89 0 0 1 35 498.98z"/></svg>
          </button></div>
    </div>
  
    <div class="product__photosmobile product__photos-12 product__photos--beside">

      <div class="product__main-photo" data-aos data-product-single-media-group>
        <div data-product-photos class="product-slideshow1" id="ProductPhotos-12">
<div
  class="product-main-slide starting-slide"
  data-index="0"
  >

  <div data-product-image-main class="product-image-main"><div class="image-wrap" style="height: 0; padding-bottom: 150.00000000000003%;"><img class="photoswipe__image lazyload"
          data-photoswipe-src="//jisora.com/cdn/shop/files/SMP02530_1800x1800.jpg?v=1699620993"
          data-photoswipe-width="1800"
          data-photoswipe-height="2700"
          data-index="1"
          data-src="//jisora.com/cdn/shop/files/SMP02530_{width}x.jpg?v=1699620993"
          data-widths="[360, 540, 720, 900, 1080]"
          data-aspectratio="0.6666666666666666"
          data-sizes="auto"
          alt="Ebony blossom three piece cotton co-ord set">

        <noscript>
          <img class="lazyloaded"
            src="//jisora.com/cdn/shop/files/SMP02530_1400x.jpg?v=1699620993"
            alt="Ebony blossom three piece cotton co-ord set">
        </noscript><button type="button" class="btn btn--body btn--circle js-photoswipe__zoom product__photo-zoom">
            <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-search" viewBox="0 0 64 64"><path d="M47.16 28.58A18.58 18.58 0 1 1 28.58 10a18.58 18.58 0 0 1 18.58 18.58zM54 54L41.94 42"/></svg>
            <span class="icon__fallback-text">Close (esc)</span>
          </button></div></div>

</div>

<div
  class="product-main-slide secondary-slide"
  data-index="1"
  >

  <div data-product-image-main class="product-image-main"><div class="image-wrap" style="height: 0; padding-bottom: 150.00000000000003%;"><img class="photoswipe__image lazyload"
          data-photoswipe-src="//jisora.com/cdn/shop/files/SMP02532_1800x1800.jpg?v=1699620991"
          data-photoswipe-width="1800"
          data-photoswipe-height="2700"
          data-index="2"
          data-src="//jisora.com/cdn/shop/files/SMP02532_{width}x.jpg?v=1699620991"
          data-widths="[360, 540, 720, 900, 1080]"
          data-aspectratio="0.6666666666666666"
          data-sizes="auto"
          alt="Ebony blossom three piece cotton co-ord set">

        <noscript>
          <img class="lazyloaded"
            src="//jisora.com/cdn/shop/files/SMP02532_1400x.jpg?v=1699620991"
            alt="Ebony blossom three piece cotton co-ord set">
        </noscript><button type="button" class="btn btn--body btn--circle js-photoswipe__zoom product__photo-zoom">
            <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-search" viewBox="0 0 64 64"><path d="M47.16 28.58A18.58 18.58 0 1 1 28.58 10a18.58 18.58 0 0 1 18.58 18.58zM54 54L41.94 42"/></svg>
            <span class="icon__fallback-text">Close (esc)</span>
          </button></div></div>

</div>

<div
  class="product-main-slide secondary-slide"
  data-index="2"
  >

  <div data-product-image-main class="product-image-main"><div class="image-wrap" style="height: 0; padding-bottom: 150.00000000000003%;"><img class="photoswipe__image lazyload"
          data-photoswipe-src="//jisora.com/cdn/shop/files/SMP02534_1800x1800.jpg?v=1699620990"
          data-photoswipe-width="1800"
          data-photoswipe-height="2700"
          data-index="3"
          data-src="//jisora.com/cdn/shop/files/SMP02534_{width}x.jpg?v=1699620990"
          data-widths="[360, 540, 720, 900, 1080]"
          data-aspectratio="0.6666666666666666"
          data-sizes="auto"
          alt="Ebony blossom three piece cotton co-ord set">

        <noscript>
          <img class="lazyloaded"
            src="//jisora.com/cdn/shop/files/SMP02534_1400x.jpg?v=1699620990"
            alt="Ebony blossom three piece cotton co-ord set">
        </noscript><button type="button" class="btn btn--body btn--circle js-photoswipe__zoom product__photo-zoom">
            <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-search" viewBox="0 0 64 64"><path d="M47.16 28.58A18.58 18.58 0 1 1 28.58 10a18.58 18.58 0 0 1 18.58 18.58zM54 54L41.94 42"/></svg>
            <span class="icon__fallback-text">Close (esc)</span>
          </button></div></div>

</div>

<div
  class="product-main-slide secondary-slide"
  data-index="3"
  >

  <div data-product-image-main class="product-image-main"><div class="image-wrap" style="height: 0; padding-bottom: 150.00000000000003%;"><img class="photoswipe__image lazyload"
          data-photoswipe-src="//jisora.com/cdn/shop/files/SMP02537_1800x1800.jpg?v=1699620992"
          data-photoswipe-width="1800"
          data-photoswipe-height="2700"
          data-index="4"
          data-src="//jisora.com/cdn/shop/files/SMP02537_{width}x.jpg?v=1699620992"
          data-widths="[360, 540, 720, 900, 1080]"
          data-aspectratio="0.6666666666666666"
          data-sizes="auto"
          alt="Ebony blossom three piece cotton co-ord set">

        <noscript>
          <img class="lazyloaded"
            src="//jisora.com/cdn/shop/files/SMP02537_1400x.jpg?v=1699620992"
            alt="Ebony blossom three piece cotton co-ord set">
        </noscript><button type="button" class="btn btn--body btn--circle js-photoswipe__zoom product__photo-zoom">
            <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-search" viewBox="0 0 64 64"><path d="M47.16 28.58A18.58 18.58 0 1 1 28.58 10a18.58 18.58 0 0 1 18.58 18.58zM54 54L41.94 42"/></svg>
            <span class="icon__fallback-text">Close (esc)</span>
          </button></div></div>

</div>

<div
  class="product-main-slide secondary-slide"
  data-index="4"
  >

  <div data-product-image-main class="product-image-main"><div class="image-wrap" style="height: 0; padding-bottom: 150.00000000000003%;"><img class="photoswipe__image lazyload"
          data-photoswipe-src="//jisora.com/cdn/shop/files/SMP02542_1800x1800.jpg?v=1699620990"
          data-photoswipe-width="1800"
          data-photoswipe-height="2700"
          data-index="5"
          data-src="//jisora.com/cdn/shop/files/SMP02542_{width}x.jpg?v=1699620990"
          data-widths="[360, 540, 720, 900, 1080]"
          data-aspectratio="0.6666666666666666"
          data-sizes="auto"
          alt="Ebony blossom three piece cotton co-ord set">

        <noscript>
          <img class="lazyloaded"
            src="//jisora.com/cdn/shop/files/SMP02542_1400x.jpg?v=1699620990"
            alt="Ebony blossom three piece cotton co-ord set">
        </noscript><button type="button" class="btn btn--body btn--circle js-photoswipe__zoom product__photo-zoom">
            <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-search" viewBox="0 0 64 64"><path d="M47.16 28.58A18.58 18.58 0 1 1 28.58 10a18.58 18.58 0 0 1 18.58 18.58zM54 54L41.94 42"/></svg>
            <span class="icon__fallback-text">Close (esc)</span>
          </button></div></div>

</div>

<div
  class="product-main-slide secondary-slide"
  data-index="5"
  >

  <div data-product-image-main class="product-image-main"><div class="image-wrap" style="height: 0; padding-bottom: 150.00000000000003%;"><img class="photoswipe__image lazyload"
          data-photoswipe-src="//jisora.com/cdn/shop/files/SMP02547_1800x1800.jpg?v=1699620995"
          data-photoswipe-width="1800"
          data-photoswipe-height="2700"
          data-index="6"
          data-src="//jisora.com/cdn/shop/files/SMP02547_{width}x.jpg?v=1699620995"
          data-widths="[360, 540, 720, 900, 1080]"
          data-aspectratio="0.6666666666666666"
          data-sizes="auto"
          alt="Ebony blossom three piece cotton co-ord set">

        <noscript>
          <img class="lazyloaded"
            src="//jisora.com/cdn/shop/files/SMP02547_1400x.jpg?v=1699620995"
            alt="Ebony blossom three piece cotton co-ord set">
        </noscript><button type="button" class="btn btn--body btn--circle js-photoswipe__zoom product__photo-zoom">
            <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-search" viewBox="0 0 64 64"><path d="M47.16 28.58A18.58 18.58 0 1 1 28.58 10a18.58 18.58 0 0 1 18.58 18.58zM54 54L41.94 42"/></svg>
            <span class="icon__fallback-text">Close (esc)</span>
          </button></div></div>

</div>

<div
  class="product-main-slide secondary-slide"
  data-index="6"
  >

  <div data-product-image-main class="product-image-main"><div class="image-wrap" style="height: 0; padding-bottom: 150.00000000000003%;"><img class="photoswipe__image lazyload"
          data-photoswipe-src="//jisora.com/cdn/shop/files/SMP02549_1800x1800.jpg?v=1699620990"
          data-photoswipe-width="1800"
          data-photoswipe-height="2700"
          data-index="7"
          data-src="//jisora.com/cdn/shop/files/SMP02549_{width}x.jpg?v=1699620990"
          data-widths="[360, 540, 720, 900, 1080]"
          data-aspectratio="0.6666666666666666"
          data-sizes="auto"
          alt="Ebony blossom three piece cotton co-ord set">

        <noscript>
          <img class="lazyloaded"
            src="//jisora.com/cdn/shop/files/SMP02549_1400x.jpg?v=1699620990"
            alt="Ebony blossom three piece cotton co-ord set">
        </noscript><button type="button" class="btn btn--body btn--circle js-photoswipe__zoom product__photo-zoom">
            <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-search" viewBox="0 0 64 64"><path d="M47.16 28.58A18.58 18.58 0 1 1 28.58 10a18.58 18.58 0 0 1 18.58 18.58zM54 54L41.94 42"/></svg>
            <span class="icon__fallback-text">Close (esc)</span>
          </button></div></div>

</div>

<div
  class="product-main-slide secondary-slide"
  data-index="7"
  >

  <div data-product-image-main class="product-image-main"><div class="image-wrap" style="height: 0; padding-bottom: 150.00000000000003%;"><img class="photoswipe__image lazyload"
          data-photoswipe-src="//jisora.com/cdn/shop/files/SMP02555_1800x1800.jpg?v=1699620993"
          data-photoswipe-width="1800"
          data-photoswipe-height="2700"
          data-index="8"
          data-src="//jisora.com/cdn/shop/files/SMP02555_{width}x.jpg?v=1699620993"
          data-widths="[360, 540, 720, 900, 1080]"
          data-aspectratio="0.6666666666666666"
          data-sizes="auto"
          alt="Ebony blossom three piece cotton co-ord set">

        <noscript>
          <img class="lazyloaded"
            src="//jisora.com/cdn/shop/files/SMP02555_1400x.jpg?v=1699620993"
            alt="Ebony blossom three piece cotton co-ord set">
        </noscript><button type="button" class="btn btn--body btn--circle js-photoswipe__zoom product__photo-zoom">
            <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-search" viewBox="0 0 64 64"><path d="M47.16 28.58A18.58 18.58 0 1 1 28.58 10a18.58 18.58 0 0 1 18.58 18.58zM54 54L41.94 42"/></svg>
            <span class="icon__fallback-text">Close (esc)</span>
          </button></div></div>

</div>

<div
  class="product-main-slide secondary-slide"
  data-index="8"
  >

  <div data-product-image-main class="product-image-main"><div class="image-wrap" style="height: 0; padding-bottom: 150.00000000000003%;"><img class="photoswipe__image lazyload"
          data-photoswipe-src="//jisora.com/cdn/shop/files/SMP02558_1800x1800.jpg?v=1699620992"
          data-photoswipe-width="1800"
          data-photoswipe-height="2700"
          data-index="9"
          data-src="//jisora.com/cdn/shop/files/SMP02558_{width}x.jpg?v=1699620992"
          data-widths="[360, 540, 720, 900, 1080]"
          data-aspectratio="0.6666666666666666"
          data-sizes="auto"
          alt="Ebony blossom three piece cotton co-ord set">

        <noscript>
          <img class="lazyloaded"
            src="//jisora.com/cdn/shop/files/SMP02558_1400x.jpg?v=1699620992"
            alt="Ebony blossom three piece cotton co-ord set">
        </noscript><button type="button" class="btn btn--body btn--circle js-photoswipe__zoom product__photo-zoom">
            <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-search" viewBox="0 0 64 64"><path d="M47.16 28.58A18.58 18.58 0 1 1 28.58 10a18.58 18.58 0 0 1 18.58 18.58zM54 54L41.94 42"/></svg>
            <span class="icon__fallback-text">Close (esc)</span>
          </button></div></div>

</div>

<div
  class="product-main-slide secondary-slide"
  data-index="9"
  >

  <div data-product-image-main class="product-image-main"><div class="image-wrap" style="height: 0; padding-bottom: 150.00000000000003%;"><img class="photoswipe__image lazyload"
          data-photoswipe-src="//jisora.com/cdn/shop/files/SMP02561_1800x1800.jpg?v=1699620994"
          data-photoswipe-width="1800"
          data-photoswipe-height="2700"
          data-index="10"
          data-src="//jisora.com/cdn/shop/files/SMP02561_{width}x.jpg?v=1699620994"
          data-widths="[360, 540, 720, 900, 1080]"
          data-aspectratio="0.6666666666666666"
          data-sizes="auto"
          alt="Ebony blossom three piece cotton co-ord set">

        <noscript>
          <img class="lazyloaded"
            src="//jisora.com/cdn/shop/files/SMP02561_1400x.jpg?v=1699620994"
            alt="Ebony blossom three piece cotton co-ord set">
        </noscript><button type="button" class="btn btn--body btn--circle js-photoswipe__zoom product__photo-zoom">
            <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-search" viewBox="0 0 64 64"><path d="M47.16 28.58A18.58 18.58 0 1 1 28.58 10a18.58 18.58 0 0 1 18.58 18.58zM54 54L41.94 42"/></svg>
            <span class="icon__fallback-text">Close (esc)</span>
          </button></div></div>

</div>

<div
  class="product-main-slide secondary-slide"
  data-index="10"
  >

  <div data-product-image-main class="product-image-main"><div class="image-wrap" style="height: 0; padding-bottom: 150.00000000000003%;"><img class="photoswipe__image lazyload"
          data-photoswipe-src="//jisora.com/cdn/shop/files/SMP02564_1800x1800.jpg?v=1699620994"
          data-photoswipe-width="1800"
          data-photoswipe-height="2700"
          data-index="11"
          data-src="//jisora.com/cdn/shop/files/SMP02564_{width}x.jpg?v=1699620994"
          data-widths="[360, 540, 720, 900, 1080]"
          data-aspectratio="0.6666666666666666"
          data-sizes="auto"
          alt="Ebony blossom three piece cotton co-ord set">

        <noscript>
          <img class="lazyloaded"
            src="//jisora.com/cdn/shop/files/SMP02564_1400x.jpg?v=1699620994"
            alt="Ebony blossom three piece cotton co-ord set">
        </noscript><button type="button" class="btn btn--body btn--circle js-photoswipe__zoom product__photo-zoom">
            <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-search" viewBox="0 0 64 64"><path d="M47.16 28.58A18.58 18.58 0 1 1 28.58 10a18.58 18.58 0 0 1 18.58 18.58zM54 54L41.94 42"/></svg>
            <span class="icon__fallback-text">Close (esc)</span>
          </button></div></div>

</div>

<div
  class="product-main-slide secondary-slide"
  data-index="11"
  >

  <div data-product-image-main class="product-image-main"><div class="image-wrap" style="height: 0; padding-bottom: 150.00000000000003%;"><img class="photoswipe__image lazyload"
          data-photoswipe-src="//jisora.com/cdn/shop/files/SMP02566_1800x1800.jpg?v=1699620991"
          data-photoswipe-width="1800"
          data-photoswipe-height="2700"
          data-index="12"
          data-src="//jisora.com/cdn/shop/files/SMP02566_{width}x.jpg?v=1699620991"
          data-widths="[360, 540, 720, 900, 1080]"
          data-aspectratio="0.6666666666666666"
          data-sizes="auto"
          alt="Ebony blossom three piece cotton co-ord set">

        <noscript>
          <img class="lazyloaded"
            src="//jisora.com/cdn/shop/files/SMP02566_1400x.jpg?v=1699620991"
            alt="Ebony blossom three piece cotton co-ord set">
        </noscript><button type="button" class="btn btn--body btn--circle js-photoswipe__zoom product__photo-zoom">
            <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-search" viewBox="0 0 64 64"><path d="M47.16 28.58A18.58 18.58 0 1 1 28.58 10a18.58 18.58 0 0 1 18.58 18.58zM54 54L41.94 42"/></svg>
            <span class="icon__fallback-text">Close (esc)</span>
          </button></div></div>

</div>
</div></div>

      <div
        data-product-thumbs
        class="product__thumbs product__thumbs--beside product__thumbs-placement--left small--hide"
        data-position="beside"
        data-arrows="true"
        data-aos><button type="button" class="product__thumb-arrow product__thumb-arrow--prev hide">
            <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-chevron-left" viewBox="0 0 284.49 498.98"><path d="M249.49 0a35 35 0 0 1 24.75 59.75L84.49 249.49l189.75 189.74a35.002 35.002 0 1 1-49.5 49.5L10.25 274.24a35 35 0 0 1 0-49.5L224.74 10.25A34.89 34.89 0 0 1 249.49 0z"/></svg>
          </button><div class="product__thumbs--scroller"><div class="product__thumb-item"
                data-index="0"
                >
                <div class="image-wrap" style="height: 0; padding-bottom: 150.00000000000003%;">
                  <a
                    href="//jisora.com/cdn/shop/files/SMP02530_1800x1800.jpg?v=1699620993"
                    data-product-thumb
                    class="product__thumb"
                    data-index="0"
                    data-id="33337201918177"><img class="animation-delay-3 lazyload"
                        data-src="//jisora.com/cdn/shop/files/SMP02530_{width}x.jpg?v=1699620993"
                        data-widths="[120, 360, 540, 720]"
                        data-aspectratio="0.6666666666666666"
                        data-sizes="auto"
                        alt="">

                    <noscript>
                      <img class="lazyloaded"
                        src="//jisora.com/cdn/shop/files/SMP02530_400x.jpg?v=1699620993"
                        alt="Ebony blossom three piece cotton co-ord set">
                    </noscript>
                  </a>
                </div>
              </div><div class="product__thumb-item"
                data-index="1"
                >
                <div class="image-wrap" style="height: 0; padding-bottom: 150.00000000000003%;">
                  <a
                    href="//jisora.com/cdn/shop/files/SMP02532_1800x1800.jpg?v=1699620991"
                    data-product-thumb
                    class="product__thumb"
                    data-index="1"
                    data-id="33337201950945"><img class="animation-delay-6 lazyload"
                        data-src="//jisora.com/cdn/shop/files/SMP02532_{width}x.jpg?v=1699620991"
                        data-widths="[120, 360, 540, 720]"
                        data-aspectratio="0.6666666666666666"
                        data-sizes="auto"
                        alt="">

                    <noscript>
                      <img class="lazyloaded"
                        src="//jisora.com/cdn/shop/files/SMP02532_400x.jpg?v=1699620991"
                        alt="Ebony blossom three piece cotton co-ord set">
                    </noscript>
                  </a>
                </div>
              </div><div class="product__thumb-item"
                data-index="2"
                >
                <div class="image-wrap" style="height: 0; padding-bottom: 150.00000000000003%;">
                  <a
                    href="//jisora.com/cdn/shop/files/SMP02534_1800x1800.jpg?v=1699620990"
                    data-product-thumb
                    class="product__thumb"
                    data-index="2"
                    data-id="33337201983713"><img class="animation-delay-9 lazyload"
                        data-src="//jisora.com/cdn/shop/files/SMP02534_{width}x.jpg?v=1699620990"
                        data-widths="[120, 360, 540, 720]"
                        data-aspectratio="0.6666666666666666"
                        data-sizes="auto"
                        alt="">

                    <noscript>
                      <img class="lazyloaded"
                        src="//jisora.com/cdn/shop/files/SMP02534_400x.jpg?v=1699620990"
                        alt="Ebony blossom three piece cotton co-ord set">
                    </noscript>
                  </a>
                </div>
              </div><div class="product__thumb-item"
                data-index="3"
                >
                <div class="image-wrap" style="height: 0; padding-bottom: 150.00000000000003%;">
                  <a
                    href="//jisora.com/cdn/shop/files/SMP02537_1800x1800.jpg?v=1699620992"
                    data-product-thumb
                    class="product__thumb"
                    data-index="3"
                    data-id="33337202016481"><img class="animation-delay-12 lazyload"
                        data-src="//jisora.com/cdn/shop/files/SMP02537_{width}x.jpg?v=1699620992"
                        data-widths="[120, 360, 540, 720]"
                        data-aspectratio="0.6666666666666666"
                        data-sizes="auto"
                        alt="">

                    <noscript>
                      <img class="lazyloaded"
                        src="//jisora.com/cdn/shop/files/SMP02537_400x.jpg?v=1699620992"
                        alt="Ebony blossom three piece cotton co-ord set">
                    </noscript>
                  </a>
                </div>
              </div><div class="product__thumb-item"
                data-index="4"
                >
                <div class="image-wrap" style="height: 0; padding-bottom: 150.00000000000003%;">
                  <a
                    href="//jisora.com/cdn/shop/files/SMP02542_1800x1800.jpg?v=1699620990"
                    data-product-thumb
                    class="product__thumb"
                    data-index="4"
                    data-id="33337202049249"><img class="animation-delay-15 lazyload"
                        data-src="//jisora.com/cdn/shop/files/SMP02542_{width}x.jpg?v=1699620990"
                        data-widths="[120, 360, 540, 720]"
                        data-aspectratio="0.6666666666666666"
                        data-sizes="auto"
                        alt="">

                    <noscript>
                      <img class="lazyloaded"
                        src="//jisora.com/cdn/shop/files/SMP02542_400x.jpg?v=1699620990"
                        alt="Ebony blossom three piece cotton co-ord set">
                    </noscript>
                  </a>
                </div>
              </div><div class="product__thumb-item"
                data-index="5"
                >
                <div class="image-wrap" style="height: 0; padding-bottom: 150.00000000000003%;">
                  <a
                    href="//jisora.com/cdn/shop/files/SMP02547_1800x1800.jpg?v=1699620995"
                    data-product-thumb
                    class="product__thumb"
                    data-index="5"
                    data-id="33337202082017"><img class="animation-delay-18 lazyload"
                        data-src="//jisora.com/cdn/shop/files/SMP02547_{width}x.jpg?v=1699620995"
                        data-widths="[120, 360, 540, 720]"
                        data-aspectratio="0.6666666666666666"
                        data-sizes="auto"
                        alt="">

                    <noscript>
                      <img class="lazyloaded"
                        src="//jisora.com/cdn/shop/files/SMP02547_400x.jpg?v=1699620995"
                        alt="Ebony blossom three piece cotton co-ord set">
                    </noscript>
                  </a>
                </div>
              </div><div class="product__thumb-item"
                data-index="6"
                >
                <div class="image-wrap" style="height: 0; padding-bottom: 150.00000000000003%;">
                  <a
                    href="//jisora.com/cdn/shop/files/SMP02549_1800x1800.jpg?v=1699620990"
                    data-product-thumb
                    class="product__thumb"
                    data-index="6"
                    data-id="33337202114785"><img class="animation-delay-21 lazyload"
                        data-src="//jisora.com/cdn/shop/files/SMP02549_{width}x.jpg?v=1699620990"
                        data-widths="[120, 360, 540, 720]"
                        data-aspectratio="0.6666666666666666"
                        data-sizes="auto"
                        alt="">

                    <noscript>
                      <img class="lazyloaded"
                        src="//jisora.com/cdn/shop/files/SMP02549_400x.jpg?v=1699620990"
                        alt="Ebony blossom three piece cotton co-ord set">
                    </noscript>
                  </a>
                </div>
              </div><div class="product__thumb-item"
                data-index="7"
                >
                <div class="image-wrap" style="height: 0; padding-bottom: 150.00000000000003%;">
                  <a
                    href="//jisora.com/cdn/shop/files/SMP02555_1800x1800.jpg?v=1699620993"
                    data-product-thumb
                    class="product__thumb"
                    data-index="7"
                    data-id="33337202147553"><img class="animation-delay-24 lazyload"
                        data-src="//jisora.com/cdn/shop/files/SMP02555_{width}x.jpg?v=1699620993"
                        data-widths="[120, 360, 540, 720]"
                        data-aspectratio="0.6666666666666666"
                        data-sizes="auto"
                        alt="">

                    <noscript>
                      <img class="lazyloaded"
                        src="//jisora.com/cdn/shop/files/SMP02555_400x.jpg?v=1699620993"
                        alt="Ebony blossom three piece cotton co-ord set">
                    </noscript>
                  </a>
                </div>
              </div><div class="product__thumb-item"
                data-index="8"
                >
                <div class="image-wrap" style="height: 0; padding-bottom: 150.00000000000003%;">
                  <a
                    href="//jisora.com/cdn/shop/files/SMP02558_1800x1800.jpg?v=1699620992"
                    data-product-thumb
                    class="product__thumb"
                    data-index="8"
                    data-id="33337202180321"><img class="animation-delay-27 lazyload"
                        data-src="//jisora.com/cdn/shop/files/SMP02558_{width}x.jpg?v=1699620992"
                        data-widths="[120, 360, 540, 720]"
                        data-aspectratio="0.6666666666666666"
                        data-sizes="auto"
                        alt="">

                    <noscript>
                      <img class="lazyloaded"
                        src="//jisora.com/cdn/shop/files/SMP02558_400x.jpg?v=1699620992"
                        alt="Ebony blossom three piece cotton co-ord set">
                    </noscript>
                  </a>
                </div>
              </div><div class="product__thumb-item"
                data-index="9"
                >
                <div class="image-wrap" style="height: 0; padding-bottom: 150.00000000000003%;">
                  <a
                    href="//jisora.com/cdn/shop/files/SMP02561_1800x1800.jpg?v=1699620994"
                    data-product-thumb
                    class="product__thumb"
                    data-index="9"
                    data-id="33337202213089"><img class="animation-delay-30 lazyload"
                        data-src="//jisora.com/cdn/shop/files/SMP02561_{width}x.jpg?v=1699620994"
                        data-widths="[120, 360, 540, 720]"
                        data-aspectratio="0.6666666666666666"
                        data-sizes="auto"
                        alt="">

                    <noscript>
                      <img class="lazyloaded"
                        src="//jisora.com/cdn/shop/files/SMP02561_400x.jpg?v=1699620994"
                        alt="Ebony blossom three piece cotton co-ord set">
                    </noscript>
                  </a>
                </div>
              </div><div class="product__thumb-item"
                data-index="10"
                >
                <div class="image-wrap" style="height: 0; padding-bottom: 150.00000000000003%;">
                  <a
                    href="//jisora.com/cdn/shop/files/SMP02564_1800x1800.jpg?v=1699620994"
                    data-product-thumb
                    class="product__thumb"
                    data-index="10"
                    data-id="33337202245857"><img class="animation-delay-33 lazyload"
                        data-src="//jisora.com/cdn/shop/files/SMP02564_{width}x.jpg?v=1699620994"
                        data-widths="[120, 360, 540, 720]"
                        data-aspectratio="0.6666666666666666"
                        data-sizes="auto"
                        alt="">

                    <noscript>
                      <img class="lazyloaded"
                        src="//jisora.com/cdn/shop/files/SMP02564_400x.jpg?v=1699620994"
                        alt="Ebony blossom three piece cotton co-ord set">
                    </noscript>
                  </a>
                </div>
              </div><div class="product__thumb-item"
                data-index="11"
                >
                <div class="image-wrap" style="height: 0; padding-bottom: 150.00000000000003%;">
                  <a
                    href="//jisora.com/cdn/shop/files/SMP02566_1800x1800.jpg?v=1699620991"
                    data-product-thumb
                    class="product__thumb"
                    data-index="11"
                    data-id="33337202278625"><img class="animation-delay-36 lazyload"
                        data-src="//jisora.com/cdn/shop/files/SMP02566_{width}x.jpg?v=1699620991"
                        data-widths="[120, 360, 540, 720]"
                        data-aspectratio="0.6666666666666666"
                        data-sizes="auto"
                        alt="">

                    <noscript>
                      <img class="lazyloaded"
                        src="//jisora.com/cdn/shop/files/SMP02566_400x.jpg?v=1699620991"
                        alt="Ebony blossom three piece cotton co-ord set">
                    </noscript>
                  </a>
                </div>
              </div></div><button type="button" class="product__thumb-arrow product__thumb-arrow--next">
            <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-chevron-right" viewBox="0 0 284.49 498.98"><path d="M35 498.98a35 35 0 0 1-24.75-59.75l189.74-189.74L10.25 59.75a35.002 35.002 0 0 1 49.5-49.5l214.49 214.49a35 35 0 0 1 0 49.5L59.75 488.73A34.89 34.89 0 0 1 35 498.98z"/></svg>
          </button></div>
    </div>
  </div>

  <script type="application/json" id="ModelJson-template--16763831779553__main">
    []
  </script></div><div class="grid__item medium-up--one-half">
          <div class="product_rightdic">
          	<div class="product-single__meta">
            <div class="product-block product-block--header"><h1 class="h2 product-single__title">Ebony blossom three piece cotton co-ord set
</h1><p data-sku class="product-single__sku">9TBS2234-M
</p></div>

            <div data-product-blocks><div class="product-block product-block--price" ><span
                          data-a11y-price
                          class="visually-hidden"
                          aria-hidden="false">
                            Regular price
                        </span>
                        <span data-product-price-wrap class="">
                          <span data-compare-price class="product__price product__price--compare"><span class=money>Rs. 1,999.00</span>
</span>
                        </span>
                        <span data-compare-price-a11y class="visually-hidden">Sale price</span><span data-product-price
                        class="product__price on-sale"><span class=money>Rs. 1,799.10</span>
</span><span data-save-price class="product__price-savings">Save 10%
</span><div
                        data-unit-price-wrapper
                        class="product__unit-price product__unit-price--spacing  hide"><span data-unit-price></span>/<span data-unit-base></span>
                      </div><div class="product__policies rte small--text-center">Tax included.

                        </div></div><div class="product-block"><hr></div><div class="product-block" ><div class="variant-wrapper js" data-type="button">
  <label class="variant__label"
    for="ProductSelect-template--16763831779553__main-8149411725537-option-0">
    Size
</label><fieldset class="variant-input-wrap"
    name="Size"
    data-index="option1"
    data-handle="size"
    id="ProductSelect-template--16763831779553__main-8149411725537-option-0">
    <legend class="hide">Size</legend><div
        class="variant-input"
        data-index="option1"
        data-value="S">
        <input type="radio"
          form="AddToCartForm-template--16763831779553__main-8149411725537"
          value="S"
          data-index="option1"
          name="Size"
          data-variant-input
          class="select-choice"
          
          
          id="ProductSelect-template--16763831779553__main-8149411725537-option-size-S"><label
            for="ProductSelect-template--16763831779553__main-8149411725537-option-size-S"
            class="select-choice variant__button-label">S
        </label></div><div
        class="variant-input"
        data-index="option1"
        data-value="M">
        <input type="radio"
          form="AddToCartForm-template--16763831779553__main-8149411725537"
          value="M"
          data-index="option1"
          name="Size"
          data-variant-input
          class="select-choice"
          
          
          id="ProductSelect-template--16763831779553__main-8149411725537-option-size-M"><label
            for="ProductSelect-template--16763831779553__main-8149411725537-option-size-M"
            class="select-choice variant__button-label">M
        </label></div><div
        class="variant-input"
        data-index="option1"
        data-value="L">
        <input type="radio"
          form="AddToCartForm-template--16763831779553__main-8149411725537"
          value="L"
          data-index="option1"
          name="Size"
          data-variant-input
          class="select-choice disabled"
          
          
          id="ProductSelect-template--16763831779553__main-8149411725537-option-size-L"><label
            for="ProductSelect-template--16763831779553__main-8149411725537-option-size-L"
            class="select-choice variant__button-label disabled">L
        </label></div><div
        class="variant-input"
        data-index="option1"
        data-value="XL">
        <input type="radio"
          form="AddToCartForm-template--16763831779553__main-8149411725537"
          value="XL"
          data-index="option1"
          name="Size"
          data-variant-input
          class="select-choice disabled"
          
          
          id="ProductSelect-template--16763831779553__main-8149411725537-option-size-XL"><label
            for="ProductSelect-template--16763831779553__main-8149411725537-option-size-XL"
            class="select-choice variant__button-label disabled">XL
        </label></div></fieldset>
</div>


  
  <script>

</script></div><div class="product-block product-block--sales-point" >
                        <ul class="sales-points">
                          <li class="sales-point">
                            <span class="icon-and-text">
                               <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-globe" viewBox="0 0 64 64"><defs><style>.a{fill:none;stroke:#000;stroke-width:2px}</style></defs><circle class="a" cx="32" cy="32" r="22"/><path class="a" d="M13 21h38M10 32h44M13 43h38M32 10c-12 8-12 37 0 44M32 10c12 8 12 37 0 44"/></svg>
                                
                              <span>Free Worldwide Shipping</span>
                            </span>
                          </li>
                        </ul>
                      </div><div class="product-block product-block--sales-point" >
                        <ul class="sales-points">
                          <li class="sales-point">
                            <span class="icon-and-text">
                               <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-heart" viewBox="0 0 64 64"><defs><style>.a{fill:none;stroke:#000;stroke-width:2px}</style></defs><path class="a" d="M51.27 15.05a13 13 0 0 0-18.44 0l-.83.83-.83-.83a13 13 0 0 0-18.44 18.44l.83.83L32 52.77l18.44-18.45.83-.83a13 13 0 0 0 0-18.44z"/></svg>
                                
                              <span>Made in India</span>
                            </span>
                          </li>
                        </ul>
                      </div><div class="product-block" >
                      
                    </div><div class="product-block" >
                      
                    </div><div class="product-block" ><div class="product-block"><form method="post" action="/cart/add" id="AddToCartForm-template--16763831779553__main-8149411725537" accept-charset="UTF-8" class="product-single__form" enctype="multipart/form-data"><input type="hidden" name="form_type" value="product" /><input type="hidden" name="utf8" value="✓" /><button id="div"
      type="submit"
      name="add"
      data-add-to-cart
      class="dis no-click btn btn--full add-to-cart"
      >
      <span class="product-name">
       SELECT SIZE
      </span>
    </button>





  <div class="shopify-payment-terms product__policies"></div>

  <select name="id" data-product-select class="product-single__variants no-js"><option 
          value="44218255900897">
          S - <span class=money>Rs. 1,799.10 INR</span>
        </option><option 
          selected="selected"
          value="44218255933665">
          M - <span class=money>Rs. 1,799.10 INR</span>
        </option><option disabled="disabled">
          L - Sold Out
        </option><option disabled="disabled">
          XL - Sold Out
        </option></select>

  <textarea data-variant-json class="hide" aria-hidden="true" aria-label="Product JSON">
    [{"id":44218255900897,"title":"S","option1":"S","option2":null,"option3":null,"sku":"9TBS2234-S","requires_shipping":true,"taxable":true,"featured_image":null,"available":true,"name":"Ebony blossom three piece cotton co-ord set - S","public_title":"S","options":["S"],"price":179910,"weight":240,"compare_at_price":199900,"inventory_management":"shopify","barcode":"9TBS2234-S","requires_selling_plan":false,"selling_plan_allocations":[]},{"id":44218255933665,"title":"M","option1":"M","option2":null,"option3":null,"sku":"9TBS2234-M","requires_shipping":true,"taxable":true,"featured_image":null,"available":true,"name":"Ebony blossom three piece cotton co-ord set - M","public_title":"M","options":["M"],"price":179910,"weight":240,"compare_at_price":199900,"inventory_management":"shopify","barcode":"9TBS2234-M","requires_selling_plan":false,"selling_plan_allocations":[]},{"id":44218255966433,"title":"L","option1":"L","option2":null,"option3":null,"sku":"9TBS2234-L","requires_shipping":true,"taxable":true,"featured_image":null,"available":false,"name":"Ebony blossom three piece cotton co-ord set - L","public_title":"L","options":["L"],"price":179910,"weight":240,"compare_at_price":199900,"inventory_management":"shopify","barcode":"9TBS2234-L","requires_selling_plan":false,"selling_plan_allocations":[]},{"id":44218255999201,"title":"XL","option1":"XL","option2":null,"option3":null,"sku":"9TBS2234-XL","requires_shipping":true,"taxable":true,"featured_image":null,"available":false,"name":"Ebony blossom three piece cotton co-ord set - XL","public_title":"XL","options":["XL"],"price":179910,"weight":240,"compare_at_price":199900,"inventory_management":"shopify","barcode":"9TBS2234-XL","requires_selling_plan":false,"selling_plan_allocations":[]}]
  </textarea><input type="hidden" name="product-id" value="8149411725537" /></form></div><div data-store-availability-holder
                          data-product-name="Ebony blossom three piece cotton co-ord set"
                          data-base-url="https://jisora.com/"
                          ></div></div><div class="product-block product-block--tab" >

<div class="collapsibles-wrapper collapsibles-wrapper--border-bottom">
    <button type="button"
      class="label collapsible-trigger collapsible-trigger-btn collapsible-trigger-btn--borders collapsible--auto-height" aria-controls="Product-content-6bcd9404-8a60-47d0-b88d-0453303ddfc28149411725537"
      >
      Description
<span class="collapsible-trigger__icon collapsible-trigger__icon--open" role="presentation">
  <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon--wide icon-chevron-down" viewBox="0 0 28 16"><path d="M1.57 1.59l12.76 12.77L27.1 1.59" stroke-width="2" stroke="#000" fill="none" fill-rule="evenodd"/></svg>
</span>
</button>
    <div id="Product-content-6bcd9404-8a60-47d0-b88d-0453303ddfc28149411725537"
      class="collapsible-content collapsible-content--all"
      >
      <div class="collapsible-content__inner rte">
        
<p data-mce-fragment="1">Dress up your wardrobe with this one-of-a-kind Ebony Blossom three piece set! Perfect for all seasons, this cotton co-ord set is as comfy as it is stylish - don't miss out on this blooming beauty!</p>

      </div>
    </div>
  </div></div><div class="product-block product-block--tab" >
                      
                      
<div class="collapsibles-wrapper collapsibles-wrapper--border-bottom">
    <button type="button"
      class="label collapsible-trigger collapsible-trigger-btn collapsible-trigger-btn--borders collapsible--auto-height" aria-controls="Product-content-363ce012-c10a-4b0c-a1b5-85e92e793c7f8149411725537"
      >
      Washing Care
<span class="collapsible-trigger__icon collapsible-trigger__icon--open" role="presentation">
  <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon--wide icon-chevron-down" viewBox="0 0 28 16"><path d="M1.57 1.59l12.76 12.77L27.1 1.59" stroke-width="2" stroke="#000" fill="none" fill-rule="evenodd"/></svg>
</span>
</button>
    <div id="Product-content-363ce012-c10a-4b0c-a1b5-85e92e793c7f8149411725537"
      class="collapsible-content collapsible-content--all"
      >
      <div class="collapsible-content__inner rte">
        
                        
                        <p>Wash garments only when necessary.<br>
We strongly recommend Hand Wash of our products.<br>
Do not put them in a washing machine or dryer.<br>
Do not soak any cotton dress and do not wash with another garment.<br>
Dry inside out in shade.<br>
Drying your clothes under the sun causes color-fading. Therefore had them out to dry in evening or in shade.</p>
                      
      </div>
    </div>
  </div></div><div class="product-block product-block--tab" >
                      
                      
<div class="collapsibles-wrapper collapsibles-wrapper--border-bottom">
    <button type="button"
      class="label collapsible-trigger collapsible-trigger-btn collapsible-trigger-btn--borders collapsible--auto-height" aria-controls="Product-content-b02920e0-55a5-4838-b604-781ddbc8e09f8149411725537"
      >
      Return and Exchange Policy
<span class="collapsible-trigger__icon collapsible-trigger__icon--open" role="presentation">
  <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon--wide icon-chevron-down" viewBox="0 0 28 16"><path d="M1.57 1.59l12.76 12.77L27.1 1.59" stroke-width="2" stroke="#000" fill="none" fill-rule="evenodd"/></svg>
</span>
</button>
    <div id="Product-content-b02920e0-55a5-4838-b604-781ddbc8e09f8149411725537"
      class="collapsible-content collapsible-content--all"
      >
      <div class="collapsible-content__inner rte">
        
                        <p>We are committed to make your shopping experience as fuss-free and enjoyable as much as possible. Please read through the following terms & conditions prior to making a purchase.</p><p>Making a purchase indicates that you have acknowledged, understood, and agree to adhere to the following terms and conditions.</p><p><strong>Return or exchange request will only be allowed within 5 days from the date of delivery.</strong></p><p>Return or Exchange request can be placed from the ‘Return or Exchange’ option at the footer of the website or through this link directly.</p><p><a href="https://jisora.com/apps/return_prime">https://jisora.com/apps/return_prime</a></p><p>In case of return, the amount will be refunded in form of store credit with validity up to one year.</p><p>In case of exchange, if you select an item with a higher value compared to the item you're exchanging, we will ask you to pay the price difference. In case the value is lower, we will credit you with the difference.</p><p>Only after receiving our confirmation for the return, we will schedule a pickup for the order within 1-3 business days of placing the request with no additional costs. </p><p>Usually we receive the product in 6-7 days. On receiving, within 2-3 days we will issue the store credit or dispatch the exchanged product if all conditions are met. </p><p>If the item requested for exchange is not available, we will try to give you best possible alternatives or issue a store credit for the same.</p><p>This process usually takes 10-15 business days. </p><p><strong>We do not accept return or exchange for international orders.</strong></p><p><strong>All Items are eligible for return and exchange except following :</strong></p><ul><li>Sale or Discounted Products</li><li>Mystery Products</li><li>Gift Cards</li><li>Customized Products</li></ul><p><strong>In order for the product to be eligible for return or exchange make sure that these following conditions are met:</strong></p><ul><li>Product must be returned in its original packaging</li><li>Product wasn't used or damaged</li><li>Product must include original tags </li></ul><p>To know more about the return and exchange policy, click on the link below.</p><p><a href="https://jisora.com/pages/return-policy">https://jisora.com/pages/return-policy</a></p>
                        
                      
      </div>
    </div>
  </div></div><div class="product-block product-block--tab" >
                      
                      
<div class="collapsibles-wrapper collapsibles-wrapper--border-bottom">
    <button type="button"
      class="label collapsible-trigger collapsible-trigger-btn collapsible-trigger-btn--borders collapsible--auto-height" aria-controls="Product-content-f7a94104-00ce-43b8-9418-005d126e0b6a8149411725537"
      >
      Manufactured & Packaged By
<span class="collapsible-trigger__icon collapsible-trigger__icon--open" role="presentation">
  <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon--wide icon-chevron-down" viewBox="0 0 28 16"><path d="M1.57 1.59l12.76 12.77L27.1 1.59" stroke-width="2" stroke="#000" fill="none" fill-rule="evenodd"/></svg>
</span>
</button>
    <div id="Product-content-f7a94104-00ce-43b8-9418-005d126e0b6a8149411725537"
      class="collapsible-content collapsible-content--all"
      >
      <div class="collapsible-content__inner rte">
        
                        <p>Dhapi India<br/>E-258A 1st & 2nd Floor, Opp. Inland Container Depot, RIICO Industrial Area, Mansarovar, Jaipur - 302020<br/>Contact - 9358935828<br/>GSTIN - 08AATFD7443D1Z7</p>
                        
                      
      </div>
    </div>
  </div></div><div class="product-block product-block--tab" >
                      
                      
<div class="collapsibles-wrapper collapsibles-wrapper--border-bottom">
    <button type="button"
      class="label collapsible-trigger collapsible-trigger-btn collapsible-trigger-btn--borders collapsible--auto-height" aria-controls="Product-content-8bf1f884-904d-489c-9c61-8bf015db0b288149411725537"
      >
      For complaints
<span class="collapsible-trigger__icon collapsible-trigger__icon--open" role="presentation">
  <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon--wide icon-chevron-down" viewBox="0 0 28 16"><path d="M1.57 1.59l12.76 12.77L27.1 1.59" stroke-width="2" stroke="#000" fill="none" fill-rule="evenodd"/></svg>
</span>
</button>
    <div id="Product-content-8bf1f884-904d-489c-9c61-8bf015db0b288149411725537"
      class="collapsible-content collapsible-content--all"
      >
      <div class="collapsible-content__inner rte">
        
                        <p><a href="mailto:grievance@jisora.com" title="mailto:grievance@jisora.com">grievance@jisora.com</a></p>
                        
                      
      </div>
    </div>
  </div></div><div class="product-block product-block--tab" >
                      
                      
<div class="collapsibles-wrapper collapsibles-wrapper--border-bottom">
    <button type="button"
      class="label collapsible-trigger collapsible-trigger-btn collapsible-trigger-btn--borders collapsible--auto-height" aria-controls="Product-content-77982f48-4551-4f7d-877f-3253deb519348149411725537"
      >
      Shipping information
<span class="collapsible-trigger__icon collapsible-trigger__icon--open" role="presentation">
  <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon--wide icon-chevron-down" viewBox="0 0 28 16"><path d="M1.57 1.59l12.76 12.77L27.1 1.59" stroke-width="2" stroke="#000" fill="none" fill-rule="evenodd"/></svg>
</span>
</button>
    <div id="Product-content-77982f48-4551-4f7d-877f-3253deb519348149411725537"
      class="collapsible-content collapsible-content--all"
      >
      <div class="collapsible-content__inner rte">
        
                        <p>Usually Delivers in 7-8 working days in India<br/>Usually Delivers in 10-12 working days outside India</p>
                        
                      
      </div>
    </div>
  </div></div></div>
          </div>
          </div>
        </div></div>
    </div>
  </div>
</div>

</div><div id="shopify-section-template--16763831779553__product-recommendations" class="shopify-section"><div
    id="Recommendations-8149411725537"
    data-section-id="8149411725537"
    data-section-type="product-recommendations"
    data-enable="true"
    data-product-id="8149411725537"
    data-url="/recommendations/products"
    data-limit="4">

    <div
      data-section-id="8149411725537"
      data-subsection
      data-section-type="collection-grid"
      class="index-section">
      <div class="page-width">
        <header class="section-header">
          <h3 class="section-header__title">
            You may also like
          </h3>
        </header>
      </div>

      <div class="page-width page-width--flush-small">
        <div class="grid-overflow-wrapper"><div class="product-recommendations-placeholder">
              
              <div class="grid grid--uniform visually-invisible" aria-hidden="true">
<div class="grid__item grid-product small--one-half medium-up--one-quarter grid-product__has-quick-shop" data-aos="row-of-4" data-product-handle="ebony-blossom-three-piece-cotton-co-ord-set" data-product-id="8149411725537">
  <div class="grid-product__content"><div class="grid-product__tag grid-product__tag--sale">
          Sale
        </div><div class="grid-product__image-mask"><div class="quick-product__btn quick-product__btn--not-ready js-modal-open-quick-modal-8149411725537 small--hide">
            <span class="quick-product__label"><svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-theme-154" viewBox="0 0 24 24"><path d="M8.528 17.238c-1.107-.592-2.074-1.25-2.9-1.973-.827-.723-1.491-1.393-1.992-2.012-.501-.618-.771-.96-.811-1.025a.571.571 0 0 1-.117-.352c0-.13.039-.247.117-.352.039-.064.306-.406.801-1.025.495-.618 1.159-1.289 1.992-2.012.833-.723 1.803-1.38 2.91-1.973a7.424 7.424 0 0 1 3.555-.889c1.263 0 2.448.297 3.555.889 1.106.593 2.073 1.25 2.9 1.973.827.723 1.491 1.394 1.992 2.012.501.619.771.961.811 1.025a.573.573 0 0 1 .117.352.656.656 0 0 1-.117.371c-.039.053-.31.391-.811 1.016-.501.625-1.169 1.296-2.002 2.012-.833.717-1.804 1.371-2.91 1.963a7.375 7.375 0 0 1-3.535.889 7.415 7.415 0 0 1-3.555-.889zm.869-9.746c-.853.41-1.631.889-2.334 1.436s-1.312 1.101-1.826 1.66c-.515.561-.889.99-1.123 1.289.234.3.608.729 1.123 1.289.514.561 1.123 1.113 1.826 1.66s1.484 1.025 2.344 1.436 1.751.615 2.676.615c.924 0 1.813-.205 2.666-.615.853-.41 1.634-.889 2.344-1.436.709-.547 1.318-1.1 1.826-1.66.508-.56.885-.989 1.133-1.289a41.634 41.634 0 0 0-1.133-1.289c-.508-.56-1.113-1.113-1.816-1.66s-1.484-1.025-2.344-1.436-1.751-.615-2.676-.615c-.937 0-1.833.205-2.686.615zm.04 7.031c-.736-.735-1.104-1.617-1.104-2.646 0-1.028.368-1.91 1.104-2.646.735-.735 1.618-1.104 2.646-1.104 1.028 0 1.911.368 2.646 1.104.735.736 1.104 1.618 1.104 2.646 0 1.029-.368 1.911-1.104 2.646-.736.736-1.618 1.104-2.646 1.104-1.029 0-1.911-.367-2.646-1.104zm.878-4.414a2.41 2.41 0 0 0-.732 1.768c0 .69.244 1.279.732 1.768s1.077.732 1.768.732c.69 0 1.279-.244 1.768-.732s.732-1.077.732-1.768c0-.689-.244-1.279-.732-1.768s-1.078-.732-1.768-.732-1.279.244-1.768.732z"></path></svg></span>
          </div>
        







<div class="col-wish"><div data-wlh-id="8149411725537" 
 data-wlh-link="/products/ebony-blossom-three-piece-cotton-co-ord-set?variant=44218255933665"
data-wlh-variantid="44218255933665" 
 data-wlh-price="1799.1" 
 data-wlh-name="Ebony blossom three piece cotton co-ord set" 
 data-wlh-image="//jisora.com/cdn/shop/files/SMP02530_1024x.jpg?v=1699620993" 
 class="wishlist-hero-custom-button wishlisthero-floating" 
 data-wlh-mode="icon_only"
 data-wlh-view="Collection"
 style="left: auto;"></div> </div> 
      <!--  <div class="uwl-btn"></div><div class="uwl-btn-wrap uwl-btn-position-right" style="width: 100%;"><div class="uwl-btn-position"><div data-productid="8149411725537" data-variant="44218255933665" class="uwl-wishlist"><div class="uwl-heart-btn-icon"><svg width="20" height="20" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"><path d="M1664 596q0-81-21.5-143t-55-98.5-81.5-59.5-94-31-98-8-112 25.5-110.5 64-86.5 72-60 61.5q-18 22-49 22t-49-22q-24-28-60-61.5t-86.5-72-110.5-64-112-25.5-98 8-94 31-81.5 59.5-55 98.5-21.5 143q0 168 187 355l581 560 580-559q188-188 188-356zm128 0q0 221-229 450l-623 600q-18 18-44 18t-44-18l-624-602q-10-8-27.5-26t-55.5-65.5-68-97.5-53.5-121-23.5-138q0-220 127-344t351-124q62 0 126.5 21.5t120 58 95.5 68.5 76 68q36-36 76-68t95.5-68.5 120-58 126.5-21.5q224 0 351 124t127 344z"></path></svg></div><span></span></div></div></div>--><!-- Slider -->
        <div class="flickity-section-1 flickity-index-slider collection" style="">
<div class="page-width">

<div class="flickity-section__carousel carousel-1 text-center"
data-flickity='{
 "adaptiveHeight": true,
"cellAlign": "left",
"pageDots": true,
"freeScroll": false,
"contain": true,
"imagesLoaded": true,
"wrapAround": true
}'>

  
  

 
<div class="carousel__cell" style="width:100%;margin-right:0px">
<a href="/collections/new-arrivals/products/ebony-blossom-three-piece-cotton-co-ord-set">
 <img class="lazy2" src="//jisora.com/cdn/shop/files/SMP02530_460x550.jpg?v=1699620993" data-src="//jisora.com/cdn/shop/files/SMP02530_460x550.jpg?v=1699620993" />
 </a>

</div>

 
<div class="carousel__cell" style="width:100%;margin-right:0px">
<a href="/collections/new-arrivals/products/ebony-blossom-three-piece-cotton-co-ord-set">
 <img class="lazy2" src="//jisora.com/cdn/shop/files/SMP02532_460x550.jpg?v=1699620991" data-src="//jisora.com/cdn/shop/files/SMP02532_460x550.jpg?v=1699620991" />
 </a>

</div>

 
<div class="carousel__cell" style="width:100%;margin-right:0px">
<a href="/collections/new-arrivals/products/ebony-blossom-three-piece-cotton-co-ord-set">
 <img class="lazy2" src="//jisora.com/cdn/shop/files/SMP02534_460x550.jpg?v=1699620990" data-src="//jisora.com/cdn/shop/files/SMP02534_460x550.jpg?v=1699620990" />
 </a>

</div>

 
<div class="carousel__cell" style="width:100%;margin-right:0px">
<a href="/collections/new-arrivals/products/ebony-blossom-three-piece-cotton-co-ord-set">
 <img class="lazy2" src="//jisora.com/cdn/shop/files/SMP02537_460x550.jpg?v=1699620992" data-src="//jisora.com/cdn/shop/files/SMP02537_460x550.jpg?v=1699620992" />
 </a>

</div>

 
<div class="carousel__cell" style="width:100%;margin-right:0px">
<a href="/collections/new-arrivals/products/ebony-blossom-three-piece-cotton-co-ord-set">
 <img class="lazy2" src="//jisora.com/cdn/shop/files/SMP02542_460x550.jpg?v=1699620990" data-src="//jisora.com/cdn/shop/files/SMP02542_460x550.jpg?v=1699620990" />
 </a>

</div>

 
<div class="carousel__cell" style="width:100%;margin-right:0px">
<a href="/collections/new-arrivals/products/ebony-blossom-three-piece-cotton-co-ord-set">
 <img class="lazy2" src="//jisora.com/cdn/shop/files/SMP02547_460x550.jpg?v=1699620995" data-src="//jisora.com/cdn/shop/files/SMP02547_460x550.jpg?v=1699620995" />
 </a>

</div>

 
<div class="carousel__cell" style="width:100%;margin-right:0px">
<a href="/collections/new-arrivals/products/ebony-blossom-three-piece-cotton-co-ord-set">
 <img class="lazy2" src="//jisora.com/cdn/shop/files/SMP02549_460x550.jpg?v=1699620990" data-src="//jisora.com/cdn/shop/files/SMP02549_460x550.jpg?v=1699620990" />
 </a>

</div>

 
<div class="carousel__cell" style="width:100%;margin-right:0px">
<a href="/collections/new-arrivals/products/ebony-blossom-three-piece-cotton-co-ord-set">
 <img class="lazy2" src="//jisora.com/cdn/shop/files/SMP02555_460x550.jpg?v=1699620993" data-src="//jisora.com/cdn/shop/files/SMP02555_460x550.jpg?v=1699620993" />
 </a>

</div>

 
<div class="carousel__cell" style="width:100%;margin-right:0px">
<a href="/collections/new-arrivals/products/ebony-blossom-three-piece-cotton-co-ord-set">
 <img class="lazy2" src="//jisora.com/cdn/shop/files/SMP02558_460x550.jpg?v=1699620992" data-src="//jisora.com/cdn/shop/files/SMP02558_460x550.jpg?v=1699620992" />
 </a>

</div>

 
<div class="carousel__cell" style="width:100%;margin-right:0px">
<a href="/collections/new-arrivals/products/ebony-blossom-three-piece-cotton-co-ord-set">
 <img class="lazy2" src="//jisora.com/cdn/shop/files/SMP02561_460x550.jpg?v=1699620994" data-src="//jisora.com/cdn/shop/files/SMP02561_460x550.jpg?v=1699620994" />
 </a>

</div>

 
<div class="carousel__cell" style="width:100%;margin-right:0px">
<a href="/collections/new-arrivals/products/ebony-blossom-three-piece-cotton-co-ord-set">
 <img class="lazy2" src="//jisora.com/cdn/shop/files/SMP02564_460x550.jpg?v=1699620994" data-src="//jisora.com/cdn/shop/files/SMP02564_460x550.jpg?v=1699620994" />
 </a>

</div>

 
<div class="carousel__cell" style="width:100%;margin-right:0px">
<a href="/collections/new-arrivals/products/ebony-blossom-three-piece-cotton-co-ord-set">
 <img class="lazy2" src="//jisora.com/cdn/shop/files/SMP02566_460x550.jpg?v=1699620991" data-src="//jisora.com/cdn/shop/files/SMP02566_460x550.jpg?v=1699620991" />
 </a>

</div>


</div>
</div>
</div>
        <!-- slider --></div>

      <div class="grid-product__meta">
        
        <div class="grid-product__title grid-product__title--body"><a href="/collections/new-arrivals/products/ebony-blossom-three-piece-cotton-co-ord-set">Ebony blossom three piece cotton co-ord set</a></div><div class="grid-product__price"><span class="visually-hidden">Regular price</span>
            <span class="grid-product__price--original"><span class=money>Rs. 1,999.00</span></span>
            <span class="visually-hidden">Sale price</span><span class=money>Rs. 1,799.10</span>
<span class="grid-product__price--savings">
                Save 10%
              </span></div>
      </div>
    
  </div><div id="QuickShopModal-8149411725537" class="modal modal--square modal--quick-shop" data-product-id="8149411725537">
  <div class="modal__inner">
    <div class="modal__centered">
      <div class="modal__centered-content">
        <div id="QuickShopHolder-ebony-blossom-three-piece-cotton-co-ord-set"></div>
      </div>

      <button type="button" class="modal__close js-modal-close text-link">
        <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-close" viewBox="0 0 64 64"><path d="M19 17.61l27.12 27.13m0-27.12L19 44.74"/></svg>
        <span class="icon__fallback-text">"Close (esc)"</span>
      </button>
    </div>
  </div>
</div>
</div>
</div>
            </div></div>
      </div>
    </div>
  </div>
</div><div id="shopify-section-template--16763831779553__recently-viewed" class="shopify-section"><div
  data-subsection
  data-section-id="template--16763831779553__recently-viewed"
  data-section-type="recently-viewed"
  data-product-handle="ebony-blossom-three-piece-cotton-co-ord-set"
  data-recent-count="3"
  data-grid-item-class="small--one-half medium-up--one-third"
  data-row-of="3">
  <hr class="hr--large">
  <div class="index-section index-section--small">
    <div class="page-width">
      <header class="section-header">
        <h3 class="section-header__title">Recently viewed</h3>
      </header>
    </div>

    <div class="page-width page-width--flush-small">
      <div class="grid-overflow-wrapper">
        <div id="RecentlyViewed-template--16763831779553__recently-viewed" class="grid grid--uniform" data-aos="overflow__animation"></div>
      </div>
    </div>
  </div>
</div>


</div><div id="shopify-section-template--16763831779553__collection-return" class="shopify-section">
  <div class="text-center page-content page-content--bottom">
    <a href="/collections/new-arrivals" class="btn btn--small return-link">
      <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon--wide icon-arrow-left" viewBox="0 0 50 15"><path d="M50 5.38v4.25H15V15L0 7.5 15 0v5.38z"/></svg> Back to New Arrivals
    </a>
  </div>



</div>
      </main><div id="shopify-section-footer-promotions" class="shopify-section index-section--footer">
</div><div id="shopify-section-footer" class="shopify-section"><footer class="site-footer" data-section-id="footer" data-section-type="footer-section">
  <div class="page-width">

    <div class="grid"><div  class="grid__item footer__item--360b4a0d-f5a0-4120-b5cd-605ea6ba85d3" data-type="custom"><style data-shopify>@media only screen and (min-width: 769px) and (max-width: 959px) {
              .footer__item--360b4a0d-f5a0-4120-b5cd-605ea6ba85d3 {
                width: 50%;
                padding-top: 40px;
              }
              .footer__item--360b4a0d-f5a0-4120-b5cd-605ea6ba85d3:nth-child(2n + 1) {
                clear: left;
              }
            }
            @media only screen and (min-width: 960px) {
              .footer__item--360b4a0d-f5a0-4120-b5cd-605ea6ba85d3 {
                width: 25%;
              }

            }</style><div class="footer__item-padding"><p class="h4 footer__title small--hide">About Jisora</p>
    <button type="button" class="h4 footer__title collapsible-trigger collapsible-trigger-btn medium-up--hide" aria-controls="Footer-360b4a0d-f5a0-4120-b5cd-605ea6ba85d3">
      About Jisora
<span class="collapsible-trigger__icon collapsible-trigger__icon--open" role="presentation">
  <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon--wide icon-chevron-down" viewBox="0 0 28 16"><path d="M1.57 1.59l12.76 12.77L27.1 1.59" stroke-width="2" stroke="#000" fill="none" fill-rule="evenodd"/></svg>
</span>
</button><div
    
      id="Footer-360b4a0d-f5a0-4120-b5cd-605ea6ba85d3" class="collapsible-content collapsible-content--small"
    >
    <div class="collapsible-content__inner">
      <div class="footer__collapsible"><p>Our objective is to design clothing that adds a touch of comfort and kindle a sense of elegant beauty towards the traditional cotton.</p><p>Elevated simplicity and style that is as comfortable to sleep in as it is beautiful to rise and grind.</p>
      </div>
    </div>
  </div>
</div>
</div><div  class="grid__item footer__item--1494301487049" data-type="menu"><style data-shopify>@media only screen and (min-width: 769px) and (max-width: 959px) {
              .footer__item--1494301487049 {
                width: 50%;
                padding-top: 40px;
              }
              .footer__item--1494301487049:nth-child(2n + 1) {
                clear: left;
              }
            }
            @media only screen and (min-width: 960px) {
              .footer__item--1494301487049 {
                width: 25%;
              }

            }</style><p class="h4 footer__title small--hide">
      Explore
    </p>
    <button type="button" class="h4 footer__title collapsible-trigger collapsible-trigger-btn medium-up--hide" aria-controls="Footer-1494301487049">
      Explore
<span class="collapsible-trigger__icon collapsible-trigger__icon--open" role="presentation">
  <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon--wide icon-chevron-down" viewBox="0 0 28 16"><path d="M1.57 1.59l12.76 12.77L27.1 1.59" stroke-width="2" stroke="#000" fill="none" fill-rule="evenodd"/></svg>
</span>
</button><div
    
      id="Footer-1494301487049" class="collapsible-content collapsible-content--small"
    >
    <div class="collapsible-content__inner">
      <div class="footer__collapsible">
        <ul class="no-bullets site-footer__linklist"><li><a href="/collections/all">Products</a></li><li><a href="/collections">Collections</a></li><li><a href="https://jisorajaipur.shiprocket.co/">Track your order</a></li><li><a href="https://jisora.com/apps/return_prime">Return or Exchange</a></li><li><a href="https://jisora.com/pages/size-guide">Size Guide</a></li><li><a href="/pages/sell-our-products">Sell our products</a></li><li><a href="/blogs/news">Blogs</a></li><li><a href="/pages/return-policy">Return and Exchange Policy</a></li><li><a href="/pages/privacy-policy">Privacy Policy</a></li><li><a href="/pages/terms-of-service">Terms Of Service</a></li><li><a href="/pages/contact">Contact</a></li><li><a href="/policies/refund-policy">Refund policy</a></li><li><a href="/pages/about-us">About us</a></li><li><a href="/pages/faq">FAQ</a></li><li><a href="/pages/publications">Publications</a></li><li><a href="/policies/terms-of-service">Terms of Service</a></li></ul>
      </div>
    </div>
  </div></div><div  class="grid__item footer__item--89997cb8-af85-48f8-a044-d0d1deb03b40" data-type="html"><style data-shopify>@media only screen and (min-width: 769px) and (max-width: 959px) {
              .footer__item--89997cb8-af85-48f8-a044-d0d1deb03b40 {
                width: 50%;
                padding-top: 40px;
              }
              .footer__item--89997cb8-af85-48f8-a044-d0d1deb03b40:nth-child(2n + 1) {
                clear: left;
              }
            }
            @media only screen and (min-width: 960px) {
              .footer__item--89997cb8-af85-48f8-a044-d0d1deb03b40 {
                width: 25%;
              }

            }</style><div class="footer__item-padding">

    <p class="h4 footer__title small--hide"><p class="h4 footer__title">
     CONTACT US
    </p>
<div class="foot_ctinfo">
<p><strong>Operational hours:</strong>10:00 a.m. to 7:00 p.m. (Monday - Saturday)</p>
<p><strong>Mobile:</strong><a href="tel:+9193589358%2028">+91 9358 9358 28</a></p>
<p><strong>Email:</strong><a href="mailto:customercare@jisora.com">customercare@jisora.com</a></p>
<p><strong>Address: </strong>Dhapi India <br> E-258A 1st &amp; 2nd Floor, Opp. Inland Container Depot, RIICO Industrial Area, Mansarovar -302020, Jaipur</p>
</div>
<ul class="footer__social unstyled inline-list">

<li>
        <a href="https://www.facebook.com/jisorajaipur/" title="JISORA on Facebook" target="_blank" class="fb_over"><svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-facebook" viewbox="0 0 20 20"><path fill="#444" d="M18.05.811q.439 0 .744.305t.305.744v16.637q0 .439-.305.744t-.744.305h-4.732v-7.221h2.415l.342-2.854h-2.757v-1.83q0-.659.293-1t1.073-.342h1.488V3.762q-.976-.098-2.171-.098-1.634 0-2.635.964t-1 2.72V9.47H7.951v2.854h2.415v7.221H1.413q-.439 0-.744-.305t-.305-.744V1.859q0-.439.305-.744T1.413.81H18.05z"></path></svg><span class="icon-fallback-text">Facebook</span>
        </a>
    </li>

<li>
        <a href="https://in.pinterest.com/jisoraj/" title="JISORA on Pinterest" target="_blank" class="pin_over"><svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-pinterest" viewbox="0 0 20 20"><path fill="#444" d="M9.958.811q1.903 0 3.635.744t2.988 2 2 2.988.744 3.635q0 2.537-1.256 4.696t-3.415 3.415-4.696 1.256q-1.39 0-2.659-.366.707-1.147.951-2.025l.659-2.561q.244.463.903.817t1.39.354q1.464 0 2.622-.842t1.793-2.305.634-3.293q0-2.171-1.671-3.769t-4.257-1.598q-1.586 0-2.903.537T5.298 5.897 4.066 7.775t-.427 2.037q0 1.268.476 2.22t1.427 1.342q.171.073.293.012t.171-.232q.171-.61.195-.756.098-.268-.122-.512-.634-.707-.634-1.83 0-1.854 1.281-3.183t3.354-1.329q1.83 0 2.854 1t1.025 2.61q0 1.342-.366 2.476t-1.049 1.817-1.561.683q-.732 0-1.195-.537t-.293-1.269q.098-.342.256-.878t.268-.915.207-.817.098-.732q0-.61-.317-1t-.927-.39q-.756 0-1.269.695t-.512 1.744q0 .39.061.756t.134.537l.073.171q-1 4.342-1.22 5.098-.195.927-.146 2.171-2.513-1.122-4.062-3.44T.59 10.177q0-3.879 2.744-6.623T9.957.81z"></path></svg><span class="icon-fallback-text">Pinterest</span>
        </a>
    </li>
<li>
        <a href="https://www.instagram.com/jisorajaipur/" title="JISORA on Instagram" target="_blank" class="insta_over"><svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-instagram" viewbox="0 0 512 512"><path d="M256 49.5c67.3 0 75.2.3 101.8 1.5 24.6 1.1 37.9 5.2 46.8 8.7 11.8 4.6 20.2 10 29 18.8s14.3 17.2 18.8 29c3.4 8.9 7.6 22.2 8.7 46.8 1.2 26.6 1.5 34.5 1.5 101.8s-.3 75.2-1.5 101.8c-1.1 24.6-5.2 37.9-8.7 46.8-4.6 11.8-10 20.2-18.8 29s-17.2 14.3-29 18.8c-8.9 3.4-22.2 7.6-46.8 8.7-26.6 1.2-34.5 1.5-101.8 1.5s-75.2-.3-101.8-1.5c-24.6-1.1-37.9-5.2-46.8-8.7-11.8-4.6-20.2-10-29-18.8s-14.3-17.2-18.8-29c-3.4-8.9-7.6-22.2-8.7-46.8-1.2-26.6-1.5-34.5-1.5-101.8s.3-75.2 1.5-101.8c1.1-24.6 5.2-37.9 8.7-46.8 4.6-11.8 10-20.2 18.8-29s17.2-14.3 29-18.8c8.9-3.4 22.2-7.6 46.8-8.7 26.6-1.3 34.5-1.5 101.8-1.5m0-45.4c-68.4 0-77 .3-103.9 1.5C125.3 6.8 107 11.1 91 17.3c-16.6 6.4-30.6 15.1-44.6 29.1-14 14-22.6 28.1-29.1 44.6-6.2 16-10.5 34.3-11.7 61.2C4.4 179 4.1 187.6 4.1 256s.3 77 1.5 103.9c1.2 26.8 5.5 45.1 11.7 61.2 6.4 16.6 15.1 30.6 29.1 44.6 14 14 28.1 22.6 44.6 29.1 16 6.2 34.3 10.5 61.2 11.7 26.9 1.2 35.4 1.5 103.9 1.5s77-.3 103.9-1.5c26.8-1.2 45.1-5.5 61.2-11.7 16.6-6.4 30.6-15.1 44.6-29.1 14-14 22.6-28.1 29.1-44.6 6.2-16 10.5-34.3 11.7-61.2 1.2-26.9 1.5-35.4 1.5-103.9s-.3-77-1.5-103.9c-1.2-26.8-5.5-45.1-11.7-61.2-6.4-16.6-15.1-30.6-29.1-44.6-14-14-28.1-22.6-44.6-29.1-16-6.2-34.3-10.5-61.2-11.7-27-1.1-35.6-1.4-104-1.4z"></path><path d="M256 126.6c-71.4 0-129.4 57.9-129.4 129.4s58 129.4 129.4 129.4 129.4-58 129.4-129.4-58-129.4-129.4-129.4zm0 213.4c-46.4 0-84-37.6-84-84s37.6-84 84-84 84 37.6 84 84-37.6 84-84 84z"></path><circle cx="390.5" cy="121.5" r="30.2"></circle></svg><span class="icon-fallback-text">Instagram</span>
        </a>
    </li>

 </ul></p>
    <button type="button" class="h4 footer__title collapsible-trigger collapsible-trigger-btn medium-up--hide" aria-controls="Footer-89997cb8-af85-48f8-a044-d0d1deb03b40">
      <p class="h4 footer__title">
     CONTACT US
    </p>
<div class="foot_ctinfo">
<p><strong>Operational hours:</strong>10:00 a.m. to 7:00 p.m. (Monday - Saturday)</p>
<p><strong>Mobile:</strong><a href="tel:+9193589358%2028">+91 9358 9358 28</a></p>
<p><strong>Email:</strong><a href="mailto:customercare@jisora.com">customercare@jisora.com</a></p>
<p><strong>Address: </strong>Dhapi India <br> E-258A 1st &amp; 2nd Floor, Opp. Inland Container Depot, RIICO Industrial Area, Mansarovar -302020, Jaipur</p>
</div>
<ul class="footer__social unstyled inline-list">

<li>
        <a href="https://www.facebook.com/jisorajaipur/" title="JISORA on Facebook" target="_blank" class="fb_over"><svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-facebook" viewbox="0 0 20 20"><path fill="#444" d="M18.05.811q.439 0 .744.305t.305.744v16.637q0 .439-.305.744t-.744.305h-4.732v-7.221h2.415l.342-2.854h-2.757v-1.83q0-.659.293-1t1.073-.342h1.488V3.762q-.976-.098-2.171-.098-1.634 0-2.635.964t-1 2.72V9.47H7.951v2.854h2.415v7.221H1.413q-.439 0-.744-.305t-.305-.744V1.859q0-.439.305-.744T1.413.81H18.05z"></path></svg><span class="icon-fallback-text">Facebook</span>
        </a>
    </li>

<li>
        <a href="https://in.pinterest.com/jisoraj/" title="JISORA on Pinterest" target="_blank" class="pin_over"><svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-pinterest" viewbox="0 0 20 20"><path fill="#444" d="M9.958.811q1.903 0 3.635.744t2.988 2 2 2.988.744 3.635q0 2.537-1.256 4.696t-3.415 3.415-4.696 1.256q-1.39 0-2.659-.366.707-1.147.951-2.025l.659-2.561q.244.463.903.817t1.39.354q1.464 0 2.622-.842t1.793-2.305.634-3.293q0-2.171-1.671-3.769t-4.257-1.598q-1.586 0-2.903.537T5.298 5.897 4.066 7.775t-.427 2.037q0 1.268.476 2.22t1.427 1.342q.171.073.293.012t.171-.232q.171-.61.195-.756.098-.268-.122-.512-.634-.707-.634-1.83 0-1.854 1.281-3.183t3.354-1.329q1.83 0 2.854 1t1.025 2.61q0 1.342-.366 2.476t-1.049 1.817-1.561.683q-.732 0-1.195-.537t-.293-1.269q.098-.342.256-.878t.268-.915.207-.817.098-.732q0-.61-.317-1t-.927-.39q-.756 0-1.269.695t-.512 1.744q0 .39.061.756t.134.537l.073.171q-1 4.342-1.22 5.098-.195.927-.146 2.171-2.513-1.122-4.062-3.44T.59 10.177q0-3.879 2.744-6.623T9.957.81z"></path></svg><span class="icon-fallback-text">Pinterest</span>
        </a>
    </li>
<li>
        <a href="https://www.instagram.com/jisorajaipur/" title="JISORA on Instagram" target="_blank" class="insta_over"><svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-instagram" viewbox="0 0 512 512"><path d="M256 49.5c67.3 0 75.2.3 101.8 1.5 24.6 1.1 37.9 5.2 46.8 8.7 11.8 4.6 20.2 10 29 18.8s14.3 17.2 18.8 29c3.4 8.9 7.6 22.2 8.7 46.8 1.2 26.6 1.5 34.5 1.5 101.8s-.3 75.2-1.5 101.8c-1.1 24.6-5.2 37.9-8.7 46.8-4.6 11.8-10 20.2-18.8 29s-17.2 14.3-29 18.8c-8.9 3.4-22.2 7.6-46.8 8.7-26.6 1.2-34.5 1.5-101.8 1.5s-75.2-.3-101.8-1.5c-24.6-1.1-37.9-5.2-46.8-8.7-11.8-4.6-20.2-10-29-18.8s-14.3-17.2-18.8-29c-3.4-8.9-7.6-22.2-8.7-46.8-1.2-26.6-1.5-34.5-1.5-101.8s.3-75.2 1.5-101.8c1.1-24.6 5.2-37.9 8.7-46.8 4.6-11.8 10-20.2 18.8-29s17.2-14.3 29-18.8c8.9-3.4 22.2-7.6 46.8-8.7 26.6-1.3 34.5-1.5 101.8-1.5m0-45.4c-68.4 0-77 .3-103.9 1.5C125.3 6.8 107 11.1 91 17.3c-16.6 6.4-30.6 15.1-44.6 29.1-14 14-22.6 28.1-29.1 44.6-6.2 16-10.5 34.3-11.7 61.2C4.4 179 4.1 187.6 4.1 256s.3 77 1.5 103.9c1.2 26.8 5.5 45.1 11.7 61.2 6.4 16.6 15.1 30.6 29.1 44.6 14 14 28.1 22.6 44.6 29.1 16 6.2 34.3 10.5 61.2 11.7 26.9 1.2 35.4 1.5 103.9 1.5s77-.3 103.9-1.5c26.8-1.2 45.1-5.5 61.2-11.7 16.6-6.4 30.6-15.1 44.6-29.1 14-14 22.6-28.1 29.1-44.6 6.2-16 10.5-34.3 11.7-61.2 1.2-26.9 1.5-35.4 1.5-103.9s-.3-77-1.5-103.9c-1.2-26.8-5.5-45.1-11.7-61.2-6.4-16.6-15.1-30.6-29.1-44.6-14-14-28.1-22.6-44.6-29.1-16-6.2-34.3-10.5-61.2-11.7-27-1.1-35.6-1.4-104-1.4z"></path><path d="M256 126.6c-71.4 0-129.4 57.9-129.4 129.4s58 129.4 129.4 129.4 129.4-58 129.4-129.4-58-129.4-129.4-129.4zm0 213.4c-46.4 0-84-37.6-84-84s37.6-84 84-84 84 37.6 84 84-37.6 84-84 84z"></path><circle cx="390.5" cy="121.5" r="30.2"></circle></svg><span class="icon-fallback-text">Instagram</span>
        </a>
    </li>

 </ul>
<span class="collapsible-trigger__icon collapsible-trigger__icon--open" role="presentation">
  <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon--wide icon-chevron-down" viewBox="0 0 28 16"><path d="M1.57 1.59l12.76 12.77L27.1 1.59" stroke-width="2" stroke="#000" fill="none" fill-rule="evenodd"/></svg>
</span>
</button>
 
 
</div>
</div><div  class="grid__item footer__item--1494292487693" data-type="newsletter"><style data-shopify>@media only screen and (min-width: 769px) and (max-width: 959px) {
              .footer__item--1494292487693 {
                width: 50%;
                padding-top: 40px;
              }
              .footer__item--1494292487693:nth-child(2n + 1) {
                clear: left;
              }
            }
            @media only screen and (min-width: 960px) {
              .footer__item--1494292487693 {
                width: 25%;
              }

            }</style><div class="footer__item-padding"><p class="h4 footer__title small--hide">NEWSLETTER</p>
    <button type="button" class="h4 footer__title collapsible-trigger collapsible-trigger-btn medium-up--hide" aria-controls="Footer-1494292487693">
      NEWSLETTER
<span class="collapsible-trigger__icon collapsible-trigger__icon--open" role="presentation">
  <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon--wide icon-chevron-down" viewBox="0 0 28 16"><path d="M1.57 1.59l12.76 12.77L27.1 1.59" stroke-width="2" stroke="#000" fill="none" fill-rule="evenodd"/></svg>
</span>
</button><div
    
      id="Footer-1494292487693" class="collapsible-content collapsible-content--small"
    >
    <div class="collapsible-content__inner">
      <div class="footer__collapsible"><p>Subscribe to get special offers, free giveaways, and once-in-a-lifetime deals.</p>
<form method="post" action="/contact#newsletter-footer" id="newsletter-footer" accept-charset="UTF-8" class="contact-form"><input type="hidden" name="form_type" value="customer" /><input type="hidden" name="utf8" value="✓" /><label for="Email-1494292487693" class="hidden-label">Enter your email</label>
          <input type="hidden" name="contact[tags]" value="prospect,newsletter">
          <input type="hidden" name="contact[context]" value="footer">
          <div class="footer__newsletter">
            <input type="email" value="" placeholder="Enter your email" name="contact[email]" id="Email-1494292487693" class="footer__newsletter-input" autocorrect="off" autocapitalize="off">
            <button type="submit" class="footer__newsletter-btn" name="commit" aria-label="Subscribe">
              <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-email" viewBox="0 0 64 64"><path d="M63 52H1V12h62zM1 12l25.68 24h9.72L63 12M21.82 31.68L1.56 51.16m60.78.78L41.27 31.68"/></svg>
              <span class="footer__newsletter-btn-label">
                Subscribe
              </span>
            </button>
          </div></form><ul class="no-bullets footer__social"></ul>
      </div>
    </div>
  </div>
</div>
</div></div><div class="footer_bottom"><ul class="inline-list payment-icons footer__section"><li class="icon--payment">
              <svg xmlns="http://www.w3.org/2000/svg" role="img" viewBox="0 0 38 24" width="38" height="24" aria-labelledby="pi-american_express"><title id="pi-american_express">American Express</title><g fill="none"><path fill="#000" d="M35,0 L3,0 C1.3,0 0,1.3 0,3 L0,21 C0,22.7 1.4,24 3,24 L35,24 C36.7,24 38,22.7 38,21 L38,3 C38,1.3 36.6,0 35,0 Z" opacity=".07"/><path fill="#006FCF" d="M35,1 C36.1,1 37,1.9 37,3 L37,21 C37,22.1 36.1,23 35,23 L3,23 C1.9,23 1,22.1 1,21 L1,3 C1,1.9 1.9,1 3,1 L35,1"/><path fill="#FFF" d="M8.971,10.268 L9.745,12.144 L8.203,12.144 L8.971,10.268 Z M25.046,10.346 L22.069,10.346 L22.069,11.173 L24.998,11.173 L24.998,12.412 L22.075,12.412 L22.075,13.334 L25.052,13.334 L25.052,14.073 L27.129,11.828 L25.052,9.488 L25.046,10.346 L25.046,10.346 Z M10.983,8.006 L14.978,8.006 L15.865,9.941 L16.687,8 L27.057,8 L28.135,9.19 L29.25,8 L34.013,8 L30.494,11.852 L33.977,15.68 L29.143,15.68 L28.065,14.49 L26.94,15.68 L10.03,15.68 L9.536,14.49 L8.406,14.49 L7.911,15.68 L4,15.68 L7.286,8 L10.716,8 L10.983,8.006 Z M19.646,9.084 L17.407,9.084 L15.907,12.62 L14.282,9.084 L12.06,9.084 L12.06,13.894 L10,9.084 L8.007,9.084 L5.625,14.596 L7.18,14.596 L7.674,13.406 L10.27,13.406 L10.764,14.596 L13.484,14.596 L13.484,10.661 L15.235,14.602 L16.425,14.602 L18.165,10.673 L18.165,14.603 L19.623,14.603 L19.647,9.083 L19.646,9.084 Z M28.986,11.852 L31.517,9.084 L29.695,9.084 L28.094,10.81 L26.546,9.084 L20.652,9.084 L20.652,14.602 L26.462,14.602 L28.076,12.864 L29.624,14.602 L31.499,14.602 L28.987,11.852 L28.986,11.852 Z"/></g></svg>

            </li><li class="icon--payment">
              <svg viewBox="0 0 38 24" xmlns="http://www.w3.org/2000/svg" role="img" width="38" height="24" aria-labelledby="pi-master"><title id="pi-master">Mastercard</title><path opacity=".07" d="M35 0H3C1.3 0 0 1.3 0 3v18c0 1.7 1.4 3 3 3h32c1.7 0 3-1.3 3-3V3c0-1.7-1.4-3-3-3z"/><path fill="#fff" d="M35 1c1.1 0 2 .9 2 2v18c0 1.1-.9 2-2 2H3c-1.1 0-2-.9-2-2V3c0-1.1.9-2 2-2h32"/><circle fill="#EB001B" cx="15" cy="12" r="7"/><circle fill="#F79E1B" cx="23" cy="12" r="7"/><path fill="#FF5F00" d="M22 12c0-2.4-1.2-4.5-3-5.7-1.8 1.3-3 3.4-3 5.7s1.2 4.5 3 5.7c1.8-1.2 3-3.3 3-5.7z"/></svg>
            </li><li class="icon--payment">
              <svg viewBox="0 0 38 24" xmlns="http://www.w3.org/2000/svg" role="img" width="38" height="24" aria-labelledby="pi-visa"><title id="pi-visa">Visa</title><path opacity=".07" d="M35 0H3C1.3 0 0 1.3 0 3v18c0 1.7 1.4 3 3 3h32c1.7 0 3-1.3 3-3V3c0-1.7-1.4-3-3-3z"/><path fill="#fff" d="M35 1c1.1 0 2 .9 2 2v18c0 1.1-.9 2-2 2H3c-1.1 0-2-.9-2-2V3c0-1.1.9-2 2-2h32"/><path d="M28.3 10.1H28c-.4 1-.7 1.5-1 3h1.9c-.3-1.5-.3-2.2-.6-3zm2.9 5.9h-1.7c-.1 0-.1 0-.2-.1l-.2-.9-.1-.2h-2.4c-.1 0-.2 0-.2.2l-.3.9c0 .1-.1.1-.1.1h-2.1l.2-.5L27 8.7c0-.5.3-.7.8-.7h1.5c.1 0 .2 0 .2.2l1.4 6.5c.1.4.2.7.2 1.1.1.1.1.1.1.2zm-13.4-.3l.4-1.8c.1 0 .2.1.2.1.7.3 1.4.5 2.1.4.2 0 .5-.1.7-.2.5-.2.5-.7.1-1.1-.2-.2-.5-.3-.8-.5-.4-.2-.8-.4-1.1-.7-1.2-1-.8-2.4-.1-3.1.6-.4.9-.8 1.7-.8 1.2 0 2.5 0 3.1.2h.1c-.1.6-.2 1.1-.4 1.7-.5-.2-1-.4-1.5-.4-.3 0-.6 0-.9.1-.2 0-.3.1-.4.2-.2.2-.2.5 0 .7l.5.4c.4.2.8.4 1.1.6.5.3 1 .8 1.1 1.4.2.9-.1 1.7-.9 2.3-.5.4-.7.6-1.4.6-1.4 0-2.5.1-3.4-.2-.1.2-.1.2-.2.1zm-3.5.3c.1-.7.1-.7.2-1 .5-2.2 1-4.5 1.4-6.7.1-.2.1-.3.3-.3H18c-.2 1.2-.4 2.1-.7 3.2-.3 1.5-.6 3-1 4.5 0 .2-.1.2-.3.2M5 8.2c0-.1.2-.2.3-.2h3.4c.5 0 .9.3 1 .8l.9 4.4c0 .1 0 .1.1.2 0-.1.1-.1.1-.1l2.1-5.1c-.1-.1 0-.2.1-.2h2.1c0 .1 0 .1-.1.2l-3.1 7.3c-.1.2-.1.3-.2.4-.1.1-.3 0-.5 0H9.7c-.1 0-.2 0-.2-.2L7.9 9.5c-.2-.2-.5-.5-.9-.6-.6-.3-1.7-.5-1.9-.5L5 8.2z" fill="#142688"/></svg>
            </li></ul><p class="footer__small-text">
        &copy; 2023 JISORA
</p><!--     <p class="footer__small-text"><a target="_blank" rel="nofollow" href="https://www.shopify.com?utm_campaign=poweredby&amp;utm_medium=shopify&amp;utm_source=onlinestore">Powered by Shopify</a></p> -->
  </div>
  </div>
</footer>
<a href="#" class="scrollToTop" style="display: none;">
	<i class="fa fa-angle-up" aria-hidden="true"></i>
</a>

<script>
  var isMobile = navigator.userAgent.match(/(iPhone|iPod|iPad|Android|webOS|BlackBerry|IEMobile|Opera Mini)/i);//	if(isMobile){
   //       setTimeout(function() {
     //       $( ".cool-image-loupe" ).each(function( index ) {
            //  console.log(index);
   //$( this ).remove() ;
//});
           // $( ".cool-image-listener" ).each(function( index ) {
            //  console.log(index);
   //$( this ).remove() ;
//});
                   //    $('.cool-image-loupe').remove();
                    //   $('.cool-image-listener').remove();
           //  $('.cool-image-tip').remove();
            

        
                  //  }, 10000);
        
        //}// see http://stackoverflow.com/q/35950735/145346
jQuery(document).ready(function($) {

  var visible = false;
  //Check to see if the window is top if not then display button
  $(window).scroll(function() {
    var scrollTop = $(this).scrollTop();
    if (!visible && scrollTop > 100) {
      $(".scrollToTop").fadeIn();
      visible = true;
    } else if (visible && scrollTop <= 100) {
      $(".scrollToTop").fadeOut();
      visible = false;
    }
  });

  //Click event to scroll to top
  $(".scrollToTop").click(function() {
    $("html, body").animate({
      scrollTop: 0
    }, 800);
    return false;
  });

});

$(".js-drawer-open-nav").click(function(){
  $(".site-header").toggleClass("draweractive");
});
  
$(".drawer__close").click(function(){
  $(".site-header").toggleClass("draweractive");
});
    

</script>
  

</div><script>
      jQuery('.product-slideshow1').flickity({
            
        pageDots: true, // mobile only with CSS
        autoPlay:false,
        draggable: true,
        prevNextButtons: false,
          freeScroll: false,
        contain:false,
          wrapAround: true
        }) ;

       
        
      </script></div>
  </div><div id="shopify-section-newsletter-popup" class="shopify-section index-section--hidden">
</div><div id="VideoModal" class="modal modal--solid">
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
    <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-close" viewBox="0 0 64 64"><path d="M19 17.61l27.12 27.13m0-27.12L19 44.74"/></svg>
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
        <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-chevron-left" viewBox="0 0 284.49 498.98"><path d="M249.49 0a35 35 0 0 1 24.75 59.75L84.49 249.49l189.75 189.74a35.002 35.002 0 1 1-49.5 49.5L10.25 274.24a35 35 0 0 1 0-49.5L224.74 10.25A34.89 34.89 0 0 1 249.49 0z"/></svg>
      </button>

      <button class="btn btn--body btn--circle btn--large pswp__button pswp__button--close" title="Close (esc)">
        <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-close" viewBox="0 0 64 64"><path d="M19 17.61l27.12 27.13m0-27.12L19 44.74"/></svg>
      </button>

      <button class="btn btn--body btn--circle pswp__button pswp__button--arrow--right" title="Next">
        <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-chevron-right" viewBox="0 0 284.49 498.98"><path d="M35 498.98a35 35 0 0 1-24.75-59.75l189.74-189.74L10.25 59.75a35.002 35.002 0 0 1 49.5-49.5l214.49 214.49a35 35 0 0 1 0 49.5L59.75 488.73A34.89 34.89 0 0 1 35 498.98z"/></svg>
      </button>
    </div>
  </div>
</div>
<tool-tip data-tool-tip="">
  <div class="tool-tip__inner" data-tool-tip-inner>
    <button class="tool-tip__close" data-tool-tip-close=""><svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-close" viewBox="0 0 64 64"><path d="M19 17.61l27.12 27.13m0-27.12L19 44.74"/></svg></button>
    <div class="tool-tip__content" data-tool-tip-content>
    </div>
  </div>
</tool-tip>
<!-- Avada Size Chart Script -->
 
<script src="//jisora.com/cdn/shop/t/29/assets/size-chart-data.js?v=78150491546977935781679922258" defer='defer'></script>

    
    
  





<script>
  const AVADA_SC = {};
  AVADA_SC.product = {"id":8149411725537,"title":"Ebony blossom three piece cotton co-ord set","handle":"ebony-blossom-three-piece-cotton-co-ord-set","description":"\u003cp data-mce-fragment=\"1\"\u003eDress up your wardrobe with this one-of-a-kind Ebony Blossom three piece set! Perfect for all seasons, this cotton co-ord set is as comfy as it is stylish - don't miss out on this blooming beauty!\u003c\/p\u003e","published_at":"2023-11-10T18:24:23+05:30","created_at":"2023-11-10T18:24:26+05:30","vendor":"JISORA","type":"Co-ord Sets","tags":["8TBS","Black Friday","Co-ord Sets","New","Sale","Shrug Sets","TBS","Western Wear"],"price":179910,"price_min":179910,"price_max":179910,"available":true,"price_varies":false,"compare_at_price":199900,"compare_at_price_min":199900,"compare_at_price_max":199900,"compare_at_price_varies":false,"variants":[{"id":44218255900897,"title":"S","option1":"S","option2":null,"option3":null,"sku":"9TBS2234-S","requires_shipping":true,"taxable":true,"featured_image":null,"available":true,"name":"Ebony blossom three piece cotton co-ord set - S","public_title":"S","options":["S"],"price":179910,"weight":240,"compare_at_price":199900,"inventory_management":"shopify","barcode":"9TBS2234-S","requires_selling_plan":false,"selling_plan_allocations":[]},{"id":44218255933665,"title":"M","option1":"M","option2":null,"option3":null,"sku":"9TBS2234-M","requires_shipping":true,"taxable":true,"featured_image":null,"available":true,"name":"Ebony blossom three piece cotton co-ord set - M","public_title":"M","options":["M"],"price":179910,"weight":240,"compare_at_price":199900,"inventory_management":"shopify","barcode":"9TBS2234-M","requires_selling_plan":false,"selling_plan_allocations":[]},{"id":44218255966433,"title":"L","option1":"L","option2":null,"option3":null,"sku":"9TBS2234-L","requires_shipping":true,"taxable":true,"featured_image":null,"available":false,"name":"Ebony blossom three piece cotton co-ord set - L","public_title":"L","options":["L"],"price":179910,"weight":240,"compare_at_price":199900,"inventory_management":"shopify","barcode":"9TBS2234-L","requires_selling_plan":false,"selling_plan_allocations":[]},{"id":44218255999201,"title":"XL","option1":"XL","option2":null,"option3":null,"sku":"9TBS2234-XL","requires_shipping":true,"taxable":true,"featured_image":null,"available":false,"name":"Ebony blossom three piece cotton co-ord set - XL","public_title":"XL","options":["XL"],"price":179910,"weight":240,"compare_at_price":199900,"inventory_management":"shopify","barcode":"9TBS2234-XL","requires_selling_plan":false,"selling_plan_allocations":[]}],"images":["\/\/jisora.com\/cdn\/shop\/files\/SMP02530.jpg?v=1699620993","\/\/jisora.com\/cdn\/shop\/files\/SMP02532.jpg?v=1699620991","\/\/jisora.com\/cdn\/shop\/files\/SMP02534.jpg?v=1699620990","\/\/jisora.com\/cdn\/shop\/files\/SMP02537.jpg?v=1699620992","\/\/jisora.com\/cdn\/shop\/files\/SMP02542.jpg?v=1699620990","\/\/jisora.com\/cdn\/shop\/files\/SMP02547.jpg?v=1699620995","\/\/jisora.com\/cdn\/shop\/files\/SMP02549.jpg?v=1699620990","\/\/jisora.com\/cdn\/shop\/files\/SMP02555.jpg?v=1699620993","\/\/jisora.com\/cdn\/shop\/files\/SMP02558.jpg?v=1699620992","\/\/jisora.com\/cdn\/shop\/files\/SMP02561.jpg?v=1699620994","\/\/jisora.com\/cdn\/shop\/files\/SMP02564.jpg?v=1699620994","\/\/jisora.com\/cdn\/shop\/files\/SMP02566.jpg?v=1699620991"],"featured_image":"\/\/jisora.com\/cdn\/shop\/files\/SMP02530.jpg?v=1699620993","options":["Size"],"media":[{"alt":null,"id":33337201918177,"position":1,"preview_image":{"aspect_ratio":0.667,"height":2700,"width":1800,"src":"\/\/jisora.com\/cdn\/shop\/files\/SMP02530.jpg?v=1699620993"},"aspect_ratio":0.667,"height":2700,"media_type":"image","src":"\/\/jisora.com\/cdn\/shop\/files\/SMP02530.jpg?v=1699620993","width":1800},{"alt":null,"id":33337201950945,"position":2,"preview_image":{"aspect_ratio":0.667,"height":2700,"width":1800,"src":"\/\/jisora.com\/cdn\/shop\/files\/SMP02532.jpg?v=1699620991"},"aspect_ratio":0.667,"height":2700,"media_type":"image","src":"\/\/jisora.com\/cdn\/shop\/files\/SMP02532.jpg?v=1699620991","width":1800},{"alt":null,"id":33337201983713,"position":3,"preview_image":{"aspect_ratio":0.667,"height":2700,"width":1800,"src":"\/\/jisora.com\/cdn\/shop\/files\/SMP02534.jpg?v=1699620990"},"aspect_ratio":0.667,"height":2700,"media_type":"image","src":"\/\/jisora.com\/cdn\/shop\/files\/SMP02534.jpg?v=1699620990","width":1800},{"alt":null,"id":33337202016481,"position":4,"preview_image":{"aspect_ratio":0.667,"height":2700,"width":1800,"src":"\/\/jisora.com\/cdn\/shop\/files\/SMP02537.jpg?v=1699620992"},"aspect_ratio":0.667,"height":2700,"media_type":"image","src":"\/\/jisora.com\/cdn\/shop\/files\/SMP02537.jpg?v=1699620992","width":1800},{"alt":null,"id":33337202049249,"position":5,"preview_image":{"aspect_ratio":0.667,"height":2700,"width":1800,"src":"\/\/jisora.com\/cdn\/shop\/files\/SMP02542.jpg?v=1699620990"},"aspect_ratio":0.667,"height":2700,"media_type":"image","src":"\/\/jisora.com\/cdn\/shop\/files\/SMP02542.jpg?v=1699620990","width":1800},{"alt":null,"id":33337202082017,"position":6,"preview_image":{"aspect_ratio":0.667,"height":2700,"width":1800,"src":"\/\/jisora.com\/cdn\/shop\/files\/SMP02547.jpg?v=1699620995"},"aspect_ratio":0.667,"height":2700,"media_type":"image","src":"\/\/jisora.com\/cdn\/shop\/files\/SMP02547.jpg?v=1699620995","width":1800},{"alt":null,"id":33337202114785,"position":7,"preview_image":{"aspect_ratio":0.667,"height":2700,"width":1800,"src":"\/\/jisora.com\/cdn\/shop\/files\/SMP02549.jpg?v=1699620990"},"aspect_ratio":0.667,"height":2700,"media_type":"image","src":"\/\/jisora.com\/cdn\/shop\/files\/SMP02549.jpg?v=1699620990","width":1800},{"alt":null,"id":33337202147553,"position":8,"preview_image":{"aspect_ratio":0.667,"height":2700,"width":1800,"src":"\/\/jisora.com\/cdn\/shop\/files\/SMP02555.jpg?v=1699620993"},"aspect_ratio":0.667,"height":2700,"media_type":"image","src":"\/\/jisora.com\/cdn\/shop\/files\/SMP02555.jpg?v=1699620993","width":1800},{"alt":null,"id":33337202180321,"position":9,"preview_image":{"aspect_ratio":0.667,"height":2700,"width":1800,"src":"\/\/jisora.com\/cdn\/shop\/files\/SMP02558.jpg?v=1699620992"},"aspect_ratio":0.667,"height":2700,"media_type":"image","src":"\/\/jisora.com\/cdn\/shop\/files\/SMP02558.jpg?v=1699620992","width":1800},{"alt":null,"id":33337202213089,"position":10,"preview_image":{"aspect_ratio":0.667,"height":2700,"width":1800,"src":"\/\/jisora.com\/cdn\/shop\/files\/SMP02561.jpg?v=1699620994"},"aspect_ratio":0.667,"height":2700,"media_type":"image","src":"\/\/jisora.com\/cdn\/shop\/files\/SMP02561.jpg?v=1699620994","width":1800},{"alt":null,"id":33337202245857,"position":11,"preview_image":{"aspect_ratio":0.667,"height":2700,"width":1800,"src":"\/\/jisora.com\/cdn\/shop\/files\/SMP02564.jpg?v=1699620994"},"aspect_ratio":0.667,"height":2700,"media_type":"image","src":"\/\/jisora.com\/cdn\/shop\/files\/SMP02564.jpg?v=1699620994","width":1800},{"alt":null,"id":33337202278625,"position":12,"preview_image":{"aspect_ratio":0.667,"height":2700,"width":1800,"src":"\/\/jisora.com\/cdn\/shop\/files\/SMP02566.jpg?v=1699620991"},"aspect_ratio":0.667,"height":2700,"media_type":"image","src":"\/\/jisora.com\/cdn\/shop\/files\/SMP02566.jpg?v=1699620991","width":1800}],"requires_selling_plan":false,"selling_plan_groups":[],"content":"\u003cp data-mce-fragment=\"1\"\u003eDress up your wardrobe with this one-of-a-kind Ebony Blossom three piece set! Perfect for all seasons, this cotton co-ord set is as comfy as it is stylish - don't miss out on this blooming beauty!\u003c\/p\u003e"};
  AVADA_SC.template = "product";
  AVADA_SC.collections = [];
  AVADA_SC.collectionsName = [];
  
    AVADA_SC.collections.push(`399990030561`);
    AVADA_SC.collectionsName.push(`All Products`);
  
    AVADA_SC.collections.push(`267755454622`);
    AVADA_SC.collectionsName.push(`Best Sellers`);
  
    AVADA_SC.collections.push(`238747582622`);
    AVADA_SC.collectionsName.push(`Co-ord Sets For Women`);
  
    AVADA_SC.collections.push(`276996063390`);
    AVADA_SC.collectionsName.push(`New Arrivals`);
  
    AVADA_SC.collections.push(`403154665697`);
    AVADA_SC.collectionsName.push(`Sale`);
  
    AVADA_SC.collections.push(`238747254942`);
    AVADA_SC.collectionsName.push(`Shrug Sets`);
  
    AVADA_SC.collections.push(`238747353246`);
    AVADA_SC.collectionsName.push(`Western Wear`);
  
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
        money_format: "<span class=money>Rs.342</span>",
        customer: null,
        cart: null,
      }

      

      

      
      
        
        window.restock.product = {
          id: 8149411725537,
          price: 179910,
          tags: ["8TBS","Black Friday","Co-ord Sets","New","Sale","Shrug Sets","TBS","Western Wear"],
          variants: [{"id":44218255900897,"title":"S","option1":"S","option2":null,"option3":null,"sku":"9TBS2234-S","requires_shipping":true,"taxable":true,"featured_image":null,"available":true,"name":"Ebony blossom three piece cotton co-ord set - S","public_title":"S","options":["S"],"price":179910,"weight":240,"compare_at_price":199900,"inventory_management":"shopify","barcode":"9TBS2234-S","requires_selling_plan":false,"selling_plan_allocations":[]},{"id":44218255933665,"title":"M","option1":"M","option2":null,"option3":null,"sku":"9TBS2234-M","requires_shipping":true,"taxable":true,"featured_image":null,"available":true,"name":"Ebony blossom three piece cotton co-ord set - M","public_title":"M","options":["M"],"price":179910,"weight":240,"compare_at_price":199900,"inventory_management":"shopify","barcode":"9TBS2234-M","requires_selling_plan":false,"selling_plan_allocations":[]},{"id":44218255966433,"title":"L","option1":"L","option2":null,"option3":null,"sku":"9TBS2234-L","requires_shipping":true,"taxable":true,"featured_image":null,"available":false,"name":"Ebony blossom three piece cotton co-ord set - L","public_title":"L","options":["L"],"price":179910,"weight":240,"compare_at_price":199900,"inventory_management":"shopify","barcode":"9TBS2234-L","requires_selling_plan":false,"selling_plan_allocations":[]},{"id":44218255999201,"title":"XL","option1":"XL","option2":null,"option3":null,"sku":"9TBS2234-XL","requires_shipping":true,"taxable":true,"featured_image":null,"available":false,"name":"Ebony blossom three piece cotton co-ord set - XL","public_title":"XL","options":["XL"],"price":179910,"weight":240,"compare_at_price":199900,"inventory_management":"shopify","barcode":"9TBS2234-XL","requires_selling_plan":false,"selling_plan_allocations":[]}]
        };
        window.restock.product_collections = []
        
        window.restock.product_collections.push(399990030561)
        
        window.restock.product_collections.push(267755454622)
        
        window.restock.product_collections.push(238747582622)
        
        window.restock.product_collections.push(276996063390)
        
        window.restock.product_collections.push(403154665697)
        
        window.restock.product_collections.push(238747254942)
        
        window.restock.product_collections.push(238747353246)
        
      
      
        
      

      
        window.restock.cart = {"note":"","attributes":{},"original_total_price":359820,"total_price":359820,"total_discount":0,"total_weight":480.0,"item_count":2,"items":[{"id":44218255933665,"properties":{},"quantity":2,"variant_id":44218255933665,"key":"44218255933665:778e651a5f0f3490dd0dbb7995fc4305","title":"Ebony blossom three piece cotton co-ord set - M","price":179910,"original_price":179910,"discounted_price":179910,"line_price":359820,"original_line_price":359820,"total_discount":0,"discounts":[],"sku":"9TBS2234-M","grams":240,"vendor":"JISORA","taxable":true,"product_id":8149411725537,"product_has_only_default_variant":false,"gift_card":false,"final_price":179910,"final_line_price":359820,"url":"\/products\/ebony-blossom-three-piece-cotton-co-ord-set?variant=44218255933665","featured_image":{"aspect_ratio":0.667,"alt":"Ebony blossom three piece cotton co-ord set","height":2700,"url":"\/\/jisora.com\/cdn\/shop\/files\/SMP02530.jpg?v=1699620993","width":1800},"image":"\/\/jisora.com\/cdn\/shop\/files\/SMP02530.jpg?v=1699620993","handle":"ebony-blossom-three-piece-cotton-co-ord-set","requires_shipping":true,"product_type":"Co-ord Sets","product_title":"Ebony blossom three piece cotton co-ord set","product_description":"Dress up your wardrobe with this one-of-a-kind Ebony Blossom three piece set! Perfect for all seasons, this cotton co-ord set is as comfy as it is stylish - don't miss out on this blooming beauty!","variant_title":"M","variant_options":["M"],"options_with_values":[{"name":"Size","value":"M"}],"line_level_discount_allocations":[],"line_level_total_discount":0}],"requires_shipping":true,"currency":"INR","items_subtotal_price":359820,"cart_level_discount_applications":[]}
        delete window.restock.cart.note
        window.restock.cart_collections = {}
        
          window.restock.cart_collections["v44218255933665"] = []
            
            window.restock.cart_collections["v44218255933665"].push(399990030561)
            
            window.restock.cart_collections["v44218255933665"].push(267755454622)
            
            window.restock.cart_collections["v44218255933665"].push(238747582622)
            
            window.restock.cart_collections["v44218255933665"].push(276996063390)
            
            window.restock.cart_collections["v44218255933665"].push(403154665697)
            
            window.restock.cart_collections["v44218255933665"].push(238747254942)
            
            window.restock.cart_collections["v44218255933665"].push(238747353246)
            
        
      if (typeof window.restock.cart.items == "object") {
          for (var i=0; i<window.restock.cart.items.length; i++) {
              ["sku", "grams", "vendor", "url", "image", "handle", "requires_shipping", "product_type", "product_description"].map(function(a) {
                  delete window.restock.cart.items[i][a]
              })
          }
        }
      
      window.restock.page_type = "product"
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
 


  






<script src="//jisora.com/cdn/shop/t/29/assets/smk-sections.js?v=124175246122752485611679922258" defer="defer"></script>


<!-- START BEAE POPUP BUILDER -->
<!-- END BEAE POPUP BUILDER -->
  <!-- PickyStory code, do not modify. Safe to remove after the app is uninstalled -->
  
  <!-- PickyStory code end -->
  <!-- PickyStory snippet "main_widget_script", do not modify. Safe to remove after the app is uninstalled -->
  
  <!-- PickyStory end snippet "main_widget_script" -->
  
<!--  Magic Checkout Code Starts -->

<script>
   window.widgetIDForMagicCheckout = "one-click-popup-5291483133846-pull-out-5635";
//    window.widgetClassForMagicCheckout = “shopify-section”;
//    window.configForMagicCheckout = {
//     display: {
//         sequence: [“cod”]
//     }
//   };
//  window.nameForMagicCheckout = “”;
//   window.onDismissMagiCheckout = () => {
//   		location.reload();
//   }

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
  		<div id="loading-indicator"/>
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




<script src="https://app.kiwisizing.com/web/js/dist/kiwiSizing/plugin/SizingPlugin.prod.js?v=308&shop=jisora-india.myshopify.com"></script>
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
	<div id="shopify-block-13070091535480640111" class="shopify-block shopify-app-block"><input type="hidden" class="aph_bars_app_embed"  value=[{"id":"559601_109535","type":"bar"},{"id":"153247_988292","type":"bar"}] />

</div><div id="shopify-block-18071494811699525790" class="shopify-block shopify-app-block"><!-- artic app --><!-- artic script -->
<script>(function() {
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
})();</script>
</div><div id="shopify-block-17309853810776502128" class="shopify-block shopify-app-block"><script>
  var pify_shop = "jisora-india.myshopify.com";
</script>


</div></body>
</html>

 


