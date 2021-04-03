/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 3);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/generar_cuota.vue?vue&type=script&lang=js&":
/*!************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/generar_cuota.vue?vue&type=script&lang=js& ***!
  \************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
/* harmony default export */ __webpack_exports__["default"] = ({
  name: 'generar_cuota',
  props: ['venta_total'],
  data: function data() {
    return {
      total: this.venta_total,
      cant_cuota: 0,
      sentrega: '',
      entrega: 0,
      saldo: this.venta_total,
      interes: 0,
      cuota: {
        nro: 0,
        interes: 0,
        vencimiento: 0,
        monto: 0,
        tipo: 0
      },
      cuotas: [],
      redondear: true
    };
  },
  methods: {
    generar: function generar() {
      this.cuotas = [];
      var monto_cuota, Importe, cantidad, restoDivision;
      var Dia;
      var i_plus = 0;
      Importe = this.saldo;
      cantidad = this.cant_cuota;

      if (cantidad < 1) {
        Swal.fire('Atención...', 'Cantidad de cuota es 0!', 'warning');
        return;
      }

      if (Importe < 1) {
        Swal.fire('Atención...', 'No se puede generar cuota Saldo es 0!', 'warning');
        return;
      }

      monto_cuota = Number.parseInt(Importe / cantidad);
      restoDivision = Importe % cantidad;
      console.log("Monto cuota:", monto_cuota);

      if (this.interes > 0) {
        monto_cuota = monto_cuota + monto_cuota * this.interes / 100;
      }

      var d = new Date();

      this._setCuota(0, this._nextMonth(d, false), this.entrega, 'Entrega'); //Entrega 


      if (this.redondear && cantidad > 1 && restoDivision != 0) {
        if (monto_cuota.toString().length > 3) {
          var ultimo_digito = monto_cuota.toString().substr(monto_cuota.toString().length - 1, 3);
          var ultimos_tresdigitos = monto_cuota.toString().substr(monto_cuota.toString().length - 3, 3);

          if (ultimos_tresdigitos == ultimo_digito.repeat(3)) {
            var primera_cuota = monto_cuota.toString().substr(0, monto_cuota.toString().length - 4);
            primera_cuota = (Number.parseInt(primera_cuota) + 1) * 10000;

            this._setCuota(1, this._nextMonth(d, true), primera_cuota, 'Cuota');

            cantidad--;
            i_plus++;
            monto_cuota = (Importe - primera_cuota) / cantidad;
          }
        }
      }

      for (var i = 1; i <= cantidad; i++) {
        this._setCuota(i + i_plus, this._nextMonth(d, true), monto_cuota, 'Cuota');
      }

      this.getCuotas();
    },
    _nextMonth: function _nextMonth(d, next) {
      if (next) {
        d.setMonth(d.getMonth() + 1);
      }

      return d.getDate().toString().padStart(2, '0') + '-' + (d.getMonth() + 1).toString().padStart(2, '0') + '-' + d.getFullYear();
    },
    _setCuota: function _setCuota(n, vencimiento, monto, tipo) {
      var cuota = {
        nro: n,
        interes: this.interes,
        vencimiento: vencimiento,
        monto: monto,
        tipo: tipo
      };
      this.cuotas.push(cuota);
    },
    getCuotas: function getCuotas() {
      this.$emit('cuotas', this.cuotas);
    },
    getSaldo: function getSaldo() {
      var sentrega = $('#entrega').val();
      this.entrega = sentrega.replaceAll(',', '');

      if (this.total >= this.entrega) {
        this.saldo = this.total - this.entrega;
      } else {
        Swal.fire('Atención...', 'Número ingresado es mayor a Monto de Venta!', 'warning');
        this.saldo = 0;
      }
    },
    _setTota: function _setTota() {
      this.total = this.venta_total;
      this.saldo = this.venta_total;
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/generar_cuota.vue?vue&type=template&id=5a0d83c4&":
/*!****************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/generar_cuota.vue?vue&type=template&id=5a0d83c4& ***!
  \****************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", [
    _c("div", { staticClass: "row" }, [
      _c("div", { staticClass: "col-6" }, [
        _c("div", { staticClass: "form-group" }, [
          _c("label", [_vm._v("Monto de Venta")]),
          _vm._v(" "),
          _c("p", { staticClass: "font-weight-bold text-primary" }, [
            _vm._v(_vm._s(new Intl.NumberFormat("de-DE").format(_vm.total)))
          ])
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "form-group" }, [
          _c("label", [_vm._v("Entrega")]),
          _vm._v(" "),
          _c("input", {
            staticClass: "form-control number-separator",
            staticStyle: { "text-align": "right" },
            attrs: { type: "text", id: "entrega", placeholder: "Monto ..." },
            on: { keyup: _vm.getSaldo }
          })
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "form-group" }, [
          _c("label", [_vm._v("Cantidad Cuota")]),
          _vm._v(" "),
          _c("input", {
            directives: [
              {
                name: "model",
                rawName: "v-model",
                value: _vm.cant_cuota,
                expression: "cant_cuota"
              }
            ],
            staticClass: "form-control",
            attrs: { type: "Number", placeholder: "Cant. Cuota ..." },
            domProps: { value: _vm.cant_cuota },
            on: {
              input: function($event) {
                if ($event.target.composing) {
                  return
                }
                _vm.cant_cuota = $event.target.value
              }
            }
          })
        ])
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "col-6" }, [
        _c("div", { staticClass: "form-group" }, [
          _c("label", [_vm._v("Saldo")]),
          _vm._v(" "),
          _c("p", { staticClass: "font-weight-bold text-danger" }, [
            _vm._v(_vm._s(new Intl.NumberFormat("de-DE").format(_vm.saldo)))
          ])
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "form-group" }, [
          _c("label", [_vm._v("Interes %")]),
          _vm._v(" "),
          _c("input", {
            directives: [
              {
                name: "model",
                rawName: "v-model",
                value: _vm.interes,
                expression: "interes"
              }
            ],
            staticClass: "form-control",
            attrs: { type: "number", placeholder: "Porcentaje ..." },
            domProps: { value: _vm.interes },
            on: {
              input: function($event) {
                if ($event.target.composing) {
                  return
                }
                _vm.interes = $event.target.value
              }
            }
          })
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "form-group" }, [
          _c("label", [
            _c("input", {
              directives: [
                {
                  name: "model",
                  rawName: "v-model",
                  value: _vm.redondear,
                  expression: "redondear"
                }
              ],
              attrs: { type: "checkbox" },
              domProps: {
                checked: Array.isArray(_vm.redondear)
                  ? _vm._i(_vm.redondear, null) > -1
                  : _vm.redondear
              },
              on: {
                change: function($event) {
                  var $$a = _vm.redondear,
                    $$el = $event.target,
                    $$c = $$el.checked ? true : false
                  if (Array.isArray($$a)) {
                    var $$v = null,
                      $$i = _vm._i($$a, $$v)
                    if ($$el.checked) {
                      $$i < 0 && (_vm.redondear = $$a.concat([$$v]))
                    } else {
                      $$i > -1 &&
                        (_vm.redondear = $$a
                          .slice(0, $$i)
                          .concat($$a.slice($$i + 1)))
                    }
                  } else {
                    _vm.redondear = $$c
                  }
                }
              }
            }),
            _vm._v(" Redondear Monto Cuota")
          ]),
          _vm._v(" "),
          _c(
            "button",
            {
              staticClass: "btn btn-success btn-block",
              on: { click: _vm.generar }
            },
            [_c("span", { staticClass: "fa fa-cog" }), _vm._v(" Generar Cuota")]
          )
        ])
      ])
    ]),
    _vm._v(" "),
    _c("hr"),
    _vm._v(" "),
    _c("table", { staticClass: "table table-striped table-hover table-sm" }, [
      _c(
        "tbody",
        [
          _vm._l(_vm.cuotas, function(c) {
            return [
              _c("tr", [
                _c("td", [_vm._v(_vm._s(c.nro))]),
                _vm._v(" "),
                _c("td", [
                  _vm._v(_vm._s(new Intl.NumberFormat("de-DE").format(c.monto)))
                ]),
                _vm._v(" "),
                _c("td", [_vm._v(_vm._s(c.vencimiento))]),
                _vm._v(" "),
                _c("td", [_vm._v(_vm._s(c.tipo))])
              ])
            ]
          })
        ],
        2
      )
    ])
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js":
/*!********************************************************************!*\
  !*** ./node_modules/vue-loader/lib/runtime/componentNormalizer.js ***!
  \********************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "default", function() { return normalizeComponent; });
/* globals __VUE_SSR_CONTEXT__ */

// IMPORTANT: Do NOT use ES2015 features in this file (except for modules).
// This module is a runtime utility for cleaner component module output and will
// be included in the final webpack user bundle.

function normalizeComponent (
  scriptExports,
  render,
  staticRenderFns,
  functionalTemplate,
  injectStyles,
  scopeId,
  moduleIdentifier, /* server only */
  shadowMode /* vue-cli only */
) {
  // Vue.extend constructor export interop
  var options = typeof scriptExports === 'function'
    ? scriptExports.options
    : scriptExports

  // render functions
  if (render) {
    options.render = render
    options.staticRenderFns = staticRenderFns
    options._compiled = true
  }

  // functional template
  if (functionalTemplate) {
    options.functional = true
  }

  // scopedId
  if (scopeId) {
    options._scopeId = 'data-v-' + scopeId
  }

  var hook
  if (moduleIdentifier) { // server build
    hook = function (context) {
      // 2.3 injection
      context =
        context || // cached call
        (this.$vnode && this.$vnode.ssrContext) || // stateful
        (this.parent && this.parent.$vnode && this.parent.$vnode.ssrContext) // functional
      // 2.2 with runInNewContext: true
      if (!context && typeof __VUE_SSR_CONTEXT__ !== 'undefined') {
        context = __VUE_SSR_CONTEXT__
      }
      // inject component styles
      if (injectStyles) {
        injectStyles.call(this, context)
      }
      // register component module identifier for async chunk inferrence
      if (context && context._registeredComponents) {
        context._registeredComponents.add(moduleIdentifier)
      }
    }
    // used by ssr in case component is cached and beforeCreate
    // never gets called
    options._ssrRegister = hook
  } else if (injectStyles) {
    hook = shadowMode
      ? function () { injectStyles.call(this, this.$root.$options.shadowRoot) }
      : injectStyles
  }

  if (hook) {
    if (options.functional) {
      // for template-only hot-reload because in that case the render fn doesn't
      // go through the normalizer
      options._injectStyles = hook
      // register for functioal component in vue file
      var originalRender = options.render
      options.render = function renderWithStyleInjection (h, context) {
        hook.call(context)
        return originalRender(h, context)
      }
    } else {
      // inject component registration as beforeCreate hook
      var existing = options.beforeCreate
      options.beforeCreate = existing
        ? [].concat(existing, hook)
        : [hook]
    }
  }

  return {
    exports: scriptExports,
    options: options
  }
}


/***/ }),

/***/ "./resources/js/components/generar_cuota.vue":
/*!***************************************************!*\
  !*** ./resources/js/components/generar_cuota.vue ***!
  \***************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _generar_cuota_vue_vue_type_template_id_5a0d83c4___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./generar_cuota.vue?vue&type=template&id=5a0d83c4& */ "./resources/js/components/generar_cuota.vue?vue&type=template&id=5a0d83c4&");
/* harmony import */ var _generar_cuota_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./generar_cuota.vue?vue&type=script&lang=js& */ "./resources/js/components/generar_cuota.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _generar_cuota_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _generar_cuota_vue_vue_type_template_id_5a0d83c4___WEBPACK_IMPORTED_MODULE_0__["render"],
  _generar_cuota_vue_vue_type_template_id_5a0d83c4___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/generar_cuota.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/generar_cuota.vue?vue&type=script&lang=js&":
/*!****************************************************************************!*\
  !*** ./resources/js/components/generar_cuota.vue?vue&type=script&lang=js& ***!
  \****************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_generar_cuota_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./generar_cuota.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/generar_cuota.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_generar_cuota_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/generar_cuota.vue?vue&type=template&id=5a0d83c4&":
/*!**********************************************************************************!*\
  !*** ./resources/js/components/generar_cuota.vue?vue&type=template&id=5a0d83c4& ***!
  \**********************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_generar_cuota_vue_vue_type_template_id_5a0d83c4___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib??vue-loader-options!./generar_cuota.vue?vue&type=template&id=5a0d83c4& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/generar_cuota.vue?vue&type=template&id=5a0d83c4&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_generar_cuota_vue_vue_type_template_id_5a0d83c4___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_generar_cuota_vue_vue_type_template_id_5a0d83c4___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/venta.js":
/*!*******************************!*\
  !*** ./resources/js/venta.js ***!
  \*******************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

Vue.component('generar_cuota', __webpack_require__(/*! ./components/generar_cuota.vue */ "./resources/js/components/generar_cuota.vue")["default"]);

/***/ }),

/***/ 3:
/*!*************************************!*\
  !*** multi ./resources/js/venta.js ***!
  \*************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /var/www/html/softsystemapp/resources/js/venta.js */"./resources/js/venta.js");


/***/ })

/******/ });