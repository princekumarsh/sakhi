if (typeof jQuery != 'undefined') {
    createBarUrls();
  } else {
    var head = document.getElementsByTagName('head')[0];
    var jq = document.createElement('script');
    jq.src = 'https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js';
    head.appendChild(jq);
    jq.onload = function () {
      createBarUrls();
    }
  }
  //this function will create bars URLs
  function createBarUrls() {
    try {
      var barLinksArray = [];
      var embedBarsObj = $(".aph_bars_app_embed");
      var jsonVal = embedBarsObj.val();
      barLinksArray = $.parseJSON(jsonVal.trim());
      embedBarsObj.remove();
      for (var i = 0; i < barLinksArray.length; i++) {
        var rndNumber = Math.floor(Math.random() * 100);
        var barItem = barLinksArray[i];
        if (barItem["id"] != undefined) {
          var subFolder = "";
          if (barItem["type"] == "embed") {
            subFolder = "embeds/";
          } else if (barItem["type"] == "popup") {
            subFolder = "popups/";
          }
          var barUrl = "https://assets.apphero.co/script_tags/" + subFolder + barItem["id"] +".js";
          $.get(barUrl, function (data) {
            var head = document.getElementsByTagName("head")[0];
            var script = document.createElement('script');
            script.type = "text/javascript";
            script.appendChild(document.createTextNode(data));
            head.appendChild(script);
        }, 'text');
        }
      }
    }
    catch(err) {
      //an error has been detected
    }
  }