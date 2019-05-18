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
/******/ 	__webpack_require__.p = "";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./public/src/js/index.js":
/*!********************************!*\
  !*** ./public/src/js/index.js ***!
  \********************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _modules_main_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./modules/main.js */ \"./public/src/js/modules/main.js\");\n/* harmony import */ var _modules_main_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_modules_main_js__WEBPACK_IMPORTED_MODULE_0__);\n/* harmony import */ var _modules_upload_button_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./modules/upload-button.js */ \"./public/src/js/modules/upload-button.js\");\n/* harmony import */ var _modules_upload_button_js__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_modules_upload_button_js__WEBPACK_IMPORTED_MODULE_1__);\n\r\n\n\n//# sourceURL=webpack:///./public/src/js/index.js?");

/***/ }),

/***/ "./public/src/js/modules/main.js":
/*!***************************************!*\
  !*** ./public/src/js/modules/main.js ***!
  \***************************************/
/*! no static exports found */
/***/ (function(module, exports) {

eval("(function($) {\r\n    \"use strict\"\r\n    jQuery(document).ready(function() {\r\n        // Navigation for Mobile Device\r\n        $('.custom-navbar').on('click', function(){\r\n            $('.main-menu ul').slideToggle(500);\r\n        });\r\n        $(window).on('resize', function(){\r\n            if ( $(window).width() > 767 ) {\r\n                $('.main-menu ul').removeAttr('style');\r\n            }\r\n        });\r\n\r\n        // Employee Slider\r\n        $('.client-slider').owlCarousel({\r\n            loop: true,\r\n            margin: 20,\r\n            autoplay: true,\r\n            autoplayTimeout: 2000,\r\n            autoplayHoverPause: true,\r\n            nav: false,\r\n            dots: false,\r\n            responsiveClass: true,\r\n            responsive: {\r\n                0: {\r\n                    items: 1\r\n                },\r\n                576: {\r\n                    items: 1\r\n                },\r\n                768: {\r\n                    items: 2\r\n                },\r\n                992: {\r\n                    items: 3\r\n                }\r\n            }\r\n        });\r\n\r\n        // Nice Select\r\n        $('select').niceSelect();\r\n\r\n        // Bmi\r\n        $(\"#bmi\").submit(function(e) {\r\n\t\t\te.preventDefault();\r\n\t\t\tvar weight = $(\"[name='weight']\").val();\r\n\t\t\tvar height = $(\"[name='height']\").val();\r\n\t\t\tif (weight > 0 && height > 0) {\r\n\t\t\t\tvar finalBmi = (weight / (height * height)) * 703;\r\n\t\t\t\t$(\"#dopeBMI\").val(finalBmi);\r\n\t\t\t\tif (finalBmi < 18.5) {\r\n\t\t\t\t\t$(\"#meaning\").val(\"You are underweight.\");\r\n\t\t\t\t}\r\n\t\t\t\tif (finalBmi > 18.5 && finalBmi < 24.9) {\r\n\t\t\t\t\t$(\"#meaning\").val(\"You are normal.\");\r\n\t\t\t\t}\r\n\t\t\t\tif (finalBmi > 24.9 && finalBmi < 29.99) {\r\n\t\t\t\t\t$(\"#meaning\").val(\"You are overweight.\");\r\n\t\t\t\t}\r\n\t\t\t} else {\r\n\t\t\t\t$(\"#meaning\").val(\"You are obese.\");\r\n\t\t\t\t}   \r\n\t\t});\r\n\r\n        // Google Map\r\n        if ( $('#mapBox').length ){\r\n            var $lat = $('#mapBox').data('lat');\r\n            var $lon = $('#mapBox').data('lon');\r\n            var $zoom = $('#mapBox').data('zoom');\r\n            var $marker = $('#mapBox').data('marker');\r\n            var $info = $('#mapBox').data('info');\r\n            var $markerLat = $('#mapBox').data('mlat');\r\n            var $markerLon = $('#mapBox').data('mlon');\r\n            var map = new GMaps({\r\n            el: '#mapBox',\r\n            lat: $lat,\r\n            lng: $lon,\r\n            scrollwheel: false,\r\n            scaleControl: true,\r\n            streetViewControl: false,\r\n            panControl: true,\r\n            disableDoubleClickZoom: true,\r\n            mapTypeControl: false,\r\n            zoom: $zoom,\r\n                styles: [\r\n                    {\r\n                        \"featureType\": \"water\",\r\n                        \"elementType\": \"geometry.fill\",\r\n                        \"stylers\": [\r\n                            {\r\n                                \"color\": \"#dcdfe6\"\r\n                            }\r\n                        ]\r\n                    },\r\n                    {\r\n                        \"featureType\": \"transit\",\r\n                        \"stylers\": [\r\n                            {\r\n                                \"color\": \"#808080\"\r\n                            },\r\n                            {\r\n                                \"visibility\": \"off\"\r\n                            }\r\n                        ]\r\n                    },\r\n                    {\r\n                        \"featureType\": \"road.highway\",\r\n                        \"elementType\": \"geometry.stroke\",\r\n                        \"stylers\": [\r\n                            {\r\n                                \"visibility\": \"on\"\r\n                            },\r\n                            {\r\n                                \"color\": \"#dcdfe6\"\r\n                            }\r\n                        ]\r\n                    },\r\n                    {\r\n                        \"featureType\": \"road.highway\",\r\n                        \"elementType\": \"geometry.fill\",\r\n                        \"stylers\": [\r\n                            {\r\n                                \"color\": \"#ffffff\"\r\n                            }\r\n                        ]\r\n                    },\r\n                    {\r\n                        \"featureType\": \"road.local\",\r\n                        \"elementType\": \"geometry.fill\",\r\n                        \"stylers\": [\r\n                            {\r\n                                \"visibility\": \"on\"\r\n                            },\r\n                            {\r\n                                \"color\": \"#ffffff\"\r\n                            },\r\n                            {\r\n                                \"weight\": 1.8\r\n                            }\r\n                        ]\r\n                    },\r\n                    {\r\n                        \"featureType\": \"road.local\",\r\n                        \"elementType\": \"geometry.stroke\",\r\n                        \"stylers\": [\r\n                            {\r\n                                \"color\": \"#d7d7d7\"\r\n                            }\r\n                        ]\r\n                    },\r\n                    {\r\n                        \"featureType\": \"poi\",\r\n                        \"elementType\": \"geometry.fill\",\r\n                        \"stylers\": [\r\n                            {\r\n                                \"visibility\": \"on\"\r\n                            },\r\n                            {\r\n                                \"color\": \"#ebebeb\"\r\n                            }\r\n                        ]\r\n                    },\r\n                    {\r\n                        \"featureType\": \"administrative\",\r\n                        \"elementType\": \"geometry\",\r\n                        \"stylers\": [\r\n                            {\r\n                                \"color\": \"#a7a7a7\"\r\n                            }\r\n                        ]\r\n                    },\r\n                    {\r\n                        \"featureType\": \"road.arterial\",\r\n                        \"elementType\": \"geometry.fill\",\r\n                        \"stylers\": [\r\n                            {\r\n                                \"color\": \"#ffffff\"\r\n                            }\r\n                        ]\r\n                    },\r\n                    {\r\n                        \"featureType\": \"road.arterial\",\r\n                        \"elementType\": \"geometry.fill\",\r\n                        \"stylers\": [\r\n                            {\r\n                                \"color\": \"#ffffff\"\r\n                            }\r\n                        ]\r\n                    },\r\n                    {\r\n                        \"featureType\": \"landscape\",\r\n                        \"elementType\": \"geometry.fill\",\r\n                        \"stylers\": [\r\n                            {\r\n                                \"visibility\": \"on\"\r\n                            },\r\n                            {\r\n                                \"color\": \"#efefef\"\r\n                            }\r\n                        ]\r\n                    },\r\n                    {\r\n                        \"featureType\": \"road\",\r\n                        \"elementType\": \"labels.text.fill\",\r\n                        \"stylers\": [\r\n                            {\r\n                                \"color\": \"#696969\"\r\n                            }\r\n                        ]\r\n                    },\r\n                    {\r\n                        \"featureType\": \"administrative\",\r\n                        \"elementType\": \"labels.text.fill\",\r\n                        \"stylers\": [\r\n                            {\r\n                                \"visibility\": \"on\"\r\n                            },\r\n                            {\r\n                                \"color\": \"#737373\"\r\n                            }\r\n                        ]\r\n                    },\r\n                    {\r\n                        \"featureType\": \"poi\",\r\n                        \"elementType\": \"labels.icon\",\r\n                        \"stylers\": [\r\n                            {\r\n                                \"visibility\": \"off\"\r\n                            }\r\n                        ]\r\n                    },\r\n                    {\r\n                        \"featureType\": \"poi\",\r\n                        \"elementType\": \"labels\",\r\n                        \"stylers\": [\r\n                            {\r\n                                \"visibility\": \"off\"\r\n                            }\r\n                        ]\r\n                    },\r\n                    {\r\n                        \"featureType\": \"road.arterial\",\r\n                        \"elementType\": \"geometry.stroke\",\r\n                        \"stylers\": [\r\n                            {\r\n                                \"color\": \"#d6d6d6\"\r\n                            }\r\n                        ]\r\n                    },\r\n                    {\r\n                        \"featureType\": \"road\",\r\n                        \"elementType\": \"labels.icon\",\r\n                        \"stylers\": [\r\n                            {\r\n                                \"visibility\": \"off\"\r\n                            }\r\n                        ]\r\n                    },\r\n                    {},\r\n                    {\r\n                        \"featureType\": \"poi\",\r\n                        \"elementType\": \"geometry.fill\",\r\n                        \"stylers\": [\r\n                            {\r\n                                \"color\": \"#dadada\"\r\n                            }\r\n                        ]\r\n                    }\r\n                ]\r\n            });\r\n        }\r\n\r\n    });\r\n\r\n    jQuery(window).on('load', function() {\r\n        // WOW JS\r\n        new WOW().init();\r\n        // Preloader\r\n\t\t$('.preloader').fadeOut(500);\r\n    });\r\n})(jQuery);\r\n\n\n//# sourceURL=webpack:///./public/src/js/modules/main.js?");

/***/ }),

/***/ "./public/src/js/modules/upload-button.js":
/*!************************************************!*\
  !*** ./public/src/js/modules/upload-button.js ***!
  \************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

eval("/**\r\n * upload button behaviour\r\n */\r\nif($('#real-input').length){\r\n    (function () {\r\n        // variables\r\n        const uploadButton = document.querySelector('.browse-btn');\r\n        const fileInfo = document.querySelector('.file-info');\r\n        const realInput = document.getElementById('real-input');\r\n\r\n        /**\r\n         * @name        displayFileName\r\n         * @desc        Functions displays file name in file info field.\r\n         */\r\n        function displayFileName() {\r\n            const name = realInput.files[0].name;\r\n            fileInfo.innerHTML = name.length > 20 ? name.substr(name.length - 20) : name;\r\n        }\r\n\r\n        function eventHandler() {\r\n            uploadButton.addEventListener('click', function() {\r\n                realInput.click();\r\n            });\r\n            realInput.addEventListener('change', function () {\r\n                displayFileName();\r\n            })\r\n        }\r\n\r\n        function init() {\r\n            eventHandler();\r\n        }\r\n\r\n        window.addEventListener(\"load\", init);\r\n    })();\r\n}\r\n\n\n//# sourceURL=webpack:///./public/src/js/modules/upload-button.js?");

/***/ }),

/***/ "./public/src/scss/style.scss":
/*!************************************!*\
  !*** ./public/src/scss/style.scss ***!
  \************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

eval("// extracted by mini-css-extract-plugin\n\n//# sourceURL=webpack:///./public/src/scss/style.scss?");

/***/ }),

/***/ 0:
/*!*******************************************************************!*\
  !*** multi ./public/src/js/index.js ./public/src/scss/style.scss ***!
  \*******************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

eval("__webpack_require__(/*! ./public/src/js/index.js */\"./public/src/js/index.js\");\nmodule.exports = __webpack_require__(/*! ./public/src/scss/style.scss */\"./public/src/scss/style.scss\");\n\n\n//# sourceURL=webpack:///multi_./public/src/js/index.js_./public/src/scss/style.scss?");

/***/ })

/******/ });