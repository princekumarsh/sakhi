! function() {
    if ("product" == window.restockext.page_type) {
        function e() {
            var e = [];
            if (document.querySelectorAll(".single-option-selector,.swatch-element input[type='radio'],.single-option-selector__radio:checked, select[data-option='option1'], select[data-option='option1']:checked, select[data-option='option2'], select[data-option='option1']:checked, select[data-option='option3'], select[data-option='option3']:checked, select[data-index='option1'], select[data-index='option1']:checked, select[data-index='option2'], select[data-index='option1']:checked, select[data-index='option3'], select[data-index='option3']:checked, ul li div[swatch-option='option1'], input[type='radio']:checked, .variant_selector, .main-product__blocks input, button.selected").forEach(function(t) {
                    e.push(t.value)
                }), 1 == (e = function(e, t) {
                    for (var r = [], o = e.length, n = 0; n < o; n++) {
                        var a = e[n];
                        t(a) && r.push(a)
                    }
                    return r
                }(e, function(e) {
                    return e
                })).length) var t = e;
            else var t = e.join(" / ");
            var r = 0,
                o = 0;
            Object.keys(variants).forEach(function(e) {
                let n = variants[e];
                t = t.toString().toLowerCase();
                var a = n.title.toString().toLowerCase();
                let i = n.id.toString().toLowerCase();
                (t.includes(a) || a.includes(t) || t.includes(i) || "" == t || "default title" == a) && !n.available && (document.querySelector(".email-when-available").style.display = "block", document.querySelector("#selectVariant").value = n.id, document.querySelector(".variant-sku").value = n.sku, "default title" == t && (t = n.name), document.querySelector(".variant-name").value = a, n.featured_image && (document.querySelector(".product-image > img").src = n.featured_image.src), r = 1), t == a && n.available && (o = 1)
            }), (0 == r || 1 == o) && (document.querySelector(".email-when-available").style.display = "none")
        }
        variants = window.restockext.product.variants, images = window.restockext.product.p_images, title = window.restockext.product.p_name;
        var t = window.matchMedia("only screen and (max-width: 767px)"),
            r = "desktop",
            o = "Conternt_scroll";
        t.matches && (r = "mobile", o = "Conternt_scroll_mobile");
        let n = new XMLHttpRequest,
            a = JSON.stringify({
                store_id: window.restockext.store_id,
                device: r,
                tags: window.restockext.product.tags
            }),
            i = window.restockext.partner_url + "/restock_notifier/frontend/get_product_page_btn?data=" + encodeURIComponent(a);
        n.onreadystatechange = function() {
            if (4 == this.readyState && 200 == this.status) {
                var t = JSON.parse(this.responseText);
                window.hulkappsc = {}, window.hulkappsc.$first_add_to_cart_el = null;
                var r = [];
                [".btn--add-to-cart", "button[name='add']", "#add-to-cart", "#AddToCartText", "#AddToCart", "#addToCart"].forEach(function(e) {
                    null != document.querySelector(e) && r.push(e), null == window.hulkappsc.$first_add_to_cart_el && r && (window.hulkappsc.$first_add_to_cart_el = r[0])
                }), (elChild = document.createElement("div")).setAttribute("id", "mhaRnProduct"), elChild.innerHTML = t.data, "custom" == t.type ? null != document.querySelector("#mhaRnProduct") ? document.querySelector("#mhaRnProduct").innerHTML = t.data : document.querySelector(window.hulkappsc.$first_add_to_cart_el).after(elChild) : document.querySelector("body").append(elChild);
                var n = new XMLHttpRequest;
                let a = JSON.stringify({
                    store_id: window.restockext.store_id,
                    product_id: window.restockext.product.id,
                    variants: variants,
                    title: title,
                    images: images,
                    product_json: window.restockext.product_json,
                    money_format: window.restockext.money_format.replace(/(<([^>]+)>)/ig, "")
                });
                var i = window.restockext.partner_url + "/restock_notifier/frontend/get_sign_up_form";
                n.onreadystatechange = function() {
                    if (4 == this.readyState && 200 == this.status) {
                        var t, r, n = document.getElementById("mhaRnProduct");
                        (elChild = document.createElement("div")).innerHTML = this.responseText, n.appendChild(elChild), window.restockext.customer && (document.querySelector(".hulkapp_popup-input #usr").value = window.restockext.customer.email), e(), document.querySelectorAll(".product-option-item").forEach(function(t) {
                            t.addEventListener("click", t => {
                                setTimeout(function() {
                                    e()
                                }, 500)
                            })
                        }), document.querySelectorAll(".single-option-selector,.swatch-element input[type='radio'],.single-option-selector__radio, select[data-option='option1'], select[data-option='option2'], select[data-option='option3'], select[data-index='option1'], select[data-index='option2'], select[data-index='option3'], ul li div[swatch-option='option1'], input[type='radio'], .variant_selector, .main-product__blocks input").forEach(function(t) {
                            t.addEventListener("change", t => {
                                e()
                            })
                        }), document.querySelectorAll("button").forEach(function(t) {
                            t.addEventListener("click", t => {
                                e()
                            })
                        }), null != document.body.querySelector(".page-container") && document.body.querySelector(".page-container").setAttribute("class", o), document.querySelector("#selectVariant").addEventListener("change", e => {
                            document.querySelector(".variant-name").value = e.target.options[e.target.selectedIndex].dataset.name, document.querySelector(".variant-sku").value = e.target.options[e.target.selectedIndex].dataset.sku;
                            var t = e.target.options[e.target.selectedIndex].dataset.price;
                            document.querySelector(".product-price .hulk_currency").innerText = t, document.querySelector(".product-image > img").src = e.target.options[e.target.selectedIndex].dataset.img
                        });
                        var a = document.querySelector(".subscribe-btn").innerText;
                        document.querySelector(".subscribe-btn").addEventListener("click", e => {
                            var t, r = (t = document.querySelector("#signUpForm #usr").value, /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(t)),
                                o = document.querySelector("#signUpForm #PhoneNo").value.trim();
                            if ("" == r && "" == o ? (document.querySelector("#signUpForm #usr").setAttribute("class", "rnpopup-error"), document.querySelector("#signUpForm #PhoneNo").setAttribute("class", "rnpopup-error")) : (document.querySelector("#signUpForm #usr").removeAttribute("class", "rnpopup-error"), document.querySelector("#signUpForm #PhoneNo").removeAttribute("class", "rnpopup-error"), o && (9 == o.length || 10 == o.length || 8 == o.length || 11 == o.length ? document.querySelector("#signUpForm #PhoneNo").removeAttribute("class", "rnpopup-error") : document.querySelector("#signUpForm #PhoneNo").setAttribute("class", "rnpopup-error"))), 0 == document.querySelectorAll(".rnpopup-error").length) {
                                var n = new XMLHttpRequest,
                                    i = window.restockext.partner_url + "/restock_notifier/frontend/add_notifier",
                                    s = document.getElementById("signUpForm"),
                                    l = new FormData(s);
                                l.append("device", "web"), n.onreadystatechange = function() {
                                    4 == this.readyState && 200 == this.status && n.response && ((already_exist = (response = JSON.parse(n.response)).already_exist) ? (document.querySelector(".popup-reg-message").style.display = "none", alert("You are already Subscribed")) : document.querySelector(".popup-reg-message").style.display = "")
                                }, n.open("POST", i, !0), n.send(l), document.querySelector(".subscribe-btn").text = a, document.querySelector(".subscribe-btn").disabled = !0, setTimeout(function() {
                                    document.getElementById("RnsignUpFormModal").style.display = "none", document.querySelector(".subscribe-btn").disabled = !1, document.querySelector(".popup-reg-message").style.display = "none", document.querySelector("#usr,#PhoneNo").value = "", document.querySelector("#productQty").value = "1", document.getElementById("is_mailing_list").checked = !1
                                }, 3e3)
                            }
                        }), document.querySelector("#mhaRnProduct .email-when-available").addEventListener("click", e => {
                            document.getElementById("RnsignUpFormModal").style.display = "block"
                        }), document.querySelector("#RnsignUpFormModal .hulkapp_close").addEventListener("click", e => {
                            document.querySelector("#usr,#PhoneNo").value = "", document.querySelector("#productQty").value = "1", document.querySelector("#RnsignUpFormModal").style.display = "none"
                        }), t = document.getElementById("PhoneNo"), r = function(e) {
                            return /^\d*\.?\d*$/.test(e)
                        }, ["input", "keydown", "keyup", "mousedown", "mouseup", "select", "contextmenu", "drop"].forEach(function(e) {
                            t.addEventListener(e, function() {
                                r(this.value) ? (this.oldValue = this.value, this.oldSelectionStart = this.selectionStart, this.oldSelectionEnd = this.selectionEnd) : this.hasOwnProperty("oldValue") ? (this.value = this.oldValue, this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd)) : this.value = ""
                            })
                        })
                    }
                }, n.open("POST", i, !0), n.setRequestHeader("Content-type", "application/x-www-form-urlencoded"), n.send("data=" + encodeURIComponent(a))
            }
        }, n.open("GET", i, !0), n.send(a)
    }
}();