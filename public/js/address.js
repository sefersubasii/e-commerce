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

/***/ "./resources/assets/js/address.js":
/*!****************************************!*\
  !*** ./resources/assets/js/address.js ***!
  \****************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _loader__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./loader */ "./resources/assets/js/loader.js");
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }



var AddressEdit = /*#__PURE__*/function () {
  function AddressEdit() {
    _classCallCheck(this, AddressEdit);

    this.getAddressUrl = baseUrl + '/getAddress';
    this.saveAddressUrl = baseUrl + '/saveAddress';
    this.loader = new _loader__WEBPACK_IMPORTED_MODULE_0__["default"]('.odeme_alan_bilgi');
    this.content = $('#addressEdit');
    this.checkoutContent = $('#checkout-content');
    $(document).on("change", 'input.billing-type', function () {
      if ($(this).val() == 1) {
        $('input[name=name]').attr('placeholder', 'Ad');
        $("#corporateArea").find('input').removeClass("billingRequired");
        $("#corporateArea").slideUp();
        $('input[name=surname]').show().addClass('billingRequired');

        if ($('input[name=surname]').next().attr('class') == "error") {
          $('input[name=surname]').next().show();
        }
      } else {
        $('input[name=name]').attr('placeholder', 'Ticari Ünvanı');
        $("#corporateArea").slideDown().find('input').addClass("billingRequired").val('');
        $('input[name=surname]').slideUp().removeClass('billingRequired').val('');

        if ($('input[name=surname]').next().attr('class') == "error") {
          $('input[name=surname]').next().slideUp();
        }
      }
    });
    $(document).on('change', 'select[name=city]', function () {
      var id = $('option:selected', this).attr('data-val');

      if (!id || id === "" || id === "Şehir Seçin") {
        return $("select[name=state]").html("<option>İlçe Seçin</option>");
      }

      $.post('getDistricts', {
        id: id,
        _token: $('meta[name=_token]').attr("content")
      }).done(function (response) {
        $("select[name=state]").empty();
        $.each(response, function (i, el) {
          $("select[name=state]").append("<option value='" + el.name + "'>" + el.name + "</option>");
        });
      });
    });
  }

  _createClass(AddressEdit, [{
    key: "show",
    value: function show(id, type) {
      this.getAddress("".concat(type, "Id=").concat(id));
    }
  }, {
    key: "getAddress",
    value: function getAddress(data) {
      var _this = this;

      this.loader.toggle();
      $.get(this.getAddressUrl, data).done(function (response) {
        _this.loader.toggle();

        _this.checkoutContent.hide();

        _this.content.html(response.view).slideDown();

        $('input[name=phone], .phoneMask').mask("+90 (zdd) ddd dd dd");

        _this.setPositionTop();
      });
    }
  }, {
    key: "save",
    value: function save() {
      var _this2 = this;

      var data = this.content.find(':input').serialize();
      this.loader.toggle();
      $.post(baseUrl + '/saveAddress', data).done(function (response) {
        _this2.loader.toggle();

        if (response.hasOwnProperty('view')) {
          _this2.checkoutContent.hide();

          _this2.content.html(response.view).slideDown();

          $('input[name=phone], .phoneMask').mask("+90 (zdd) ddd dd dd");

          _this2.setPositionTop();
        } else {
          _this2.close();

          _this2.reloadData(response);

          Toast.fire(response.message, "", response.type);
        }
      });
    }
  }, {
    key: "close",
    value: function close() {
      this.content.slideUp().delay(300).empty();
      this.checkoutContent.show();
    }
  }, {
    key: "reloadData",
    value: function reloadData(response) {
      var refreshSelectBox = function refreshSelectBox(element, response, type) {
        var el = $(element);
        el.empty();
        response[type].forEach(function (item) {
          el.append('<option value="' + item.id + '">' + item.address_name + '</option>');
        });
        el.change();
      };

      if (response.hasOwnProperty('shippingAddresses')) {
        refreshSelectBox('select#shippingAddress', response, 'shippingAddresses');
      }

      if (response.hasOwnProperty('billingAddresses')) {
        refreshSelectBox('select#billingAddress', response, 'billingAddresses');
      }
    }
  }, {
    key: "setPositionTop",
    value: function setPositionTop() {
      if (this.isMobile()) {
        $(window).scrollTop(this.content.position().top);
      }
    }
  }, {
    key: "isMobile",
    value: function isMobile() {
      return window.outerWidth < 699;
    }
  }]);

  return AddressEdit;
}();

window.AddressEdit = new AddressEdit();

/***/ }),

/***/ "./resources/assets/js/loader.js":
/*!***************************************!*\
  !*** ./resources/assets/js/loader.js ***!
  \***************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

var Loader = /*#__PURE__*/function () {
  function Loader(element) {
    _classCallCheck(this, Loader);

    this.showed = false;
    this.element = $(element);
  }

  _createClass(Loader, [{
    key: "show",
    value: function show() {
      var message = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : null;
      var width = '45%';

      if (window.outerWidth < 699) {
        width = '80%';
      }

      this.element.block({
        message: message || '<h3>İşlemler yapılıyor. Lütfen bekleyiniz...</h3>',
        css: {
          backgroundColor: '#000',
          color: '#fff',
          borderRadius: '7px',
          border: '1px solid #111',
          padding: '10px 5px',
          width: width
        }
      });
      this.showed = true;
    }
  }, {
    key: "hide",
    value: function hide() {
      this.element.unblock();
      this.showed = false;
    }
  }, {
    key: "toggle",
    value: function toggle() {
      this.showed ? this.hide() : this.show();
    }
  }]);

  return Loader;
}();

/* harmony default export */ __webpack_exports__["default"] = (window.Loader = Loader);

/***/ }),

/***/ 3:
/*!**********************************************!*\
  !*** multi ./resources/assets/js/address.js ***!
  \**********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /Users/ahmetbedir/Code/marketpaketi/resources/assets/js/address.js */"./resources/assets/js/address.js");


/***/ })

/******/ });