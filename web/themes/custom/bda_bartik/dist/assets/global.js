/*
 * ATTENTION: The "eval" devtool has been used (maybe by default in mode: "development").
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./js/Components/MyComponent.js":
/*!**************************************!*\
  !*** ./js/Components/MyComponent.js ***!
  \**************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"MyComponent\": () => (/* binding */ MyComponent)\n/* harmony export */ });\n/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ \"react\");\n/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);\nfunction _slicedToArray(arr, i) { return _arrayWithHoles(arr) || _iterableToArrayLimit(arr, i) || _unsupportedIterableToArray(arr, i) || _nonIterableRest(); }\n\nfunction _nonIterableRest() { throw new TypeError(\"Invalid attempt to destructure non-iterable instance.\\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.\"); }\n\nfunction _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === \"string\") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === \"Object\" && o.constructor) n = o.constructor.name; if (n === \"Map\" || n === \"Set\") return Array.from(o); if (n === \"Arguments\" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }\n\nfunction _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }\n\nfunction _iterableToArrayLimit(arr, i) { var _i = arr == null ? null : typeof Symbol !== \"undefined\" && arr[Symbol.iterator] || arr[\"@@iterator\"]; if (_i == null) return; var _arr = []; var _n = true; var _d = false; var _s, _e; try { for (_i = _i.call(arr); !(_n = (_s = _i.next()).done); _n = true) { _arr.push(_s.value); if (i && _arr.length === i) break; } } catch (err) { _d = true; _e = err; } finally { try { if (!_n && _i[\"return\"] != null) _i[\"return\"](); } finally { if (_d) throw _e; } } return _arr; }\n\nfunction _arrayWithHoles(arr) { if (Array.isArray(arr)) return arr; }\n\n\nfunction MyComponent() {\n  var _useState = (0,react__WEBPACK_IMPORTED_MODULE_0__.useState)(null),\n      _useState2 = _slicedToArray(_useState, 2),\n      error = _useState2[0],\n      setError = _useState2[1];\n\n  var _useState3 = (0,react__WEBPACK_IMPORTED_MODULE_0__.useState)(false),\n      _useState4 = _slicedToArray(_useState3, 2),\n      isLoaded = _useState4[0],\n      setIsLoaded = _useState4[1];\n\n  var _useState5 = (0,react__WEBPACK_IMPORTED_MODULE_0__.useState)({}),\n      _useState6 = _slicedToArray(_useState5, 2),\n      data = _useState6[0],\n      setData = _useState6[1];\n\n  var listRef = (0,react__WEBPACK_IMPORTED_MODULE_0__.useRef)(null); // Note: the empty deps array [] means\n  // this useEffect will run once\n  // similar to componentDidMount()\n\n  (0,react__WEBPACK_IMPORTED_MODULE_0__.useEffect)(function () {\n    fetch(\"\".concat(document.location.origin, \"/jsonapi/node/article?include=field_tags&page[limit]=10\")).then(function (res) {\n      return res.json();\n    }).then(function (result) {\n      setIsLoaded(true);\n      setData(result.data);\n    }, // Note: it's important to handle errors here\n    // instead of a catch() block so that we don't swallow\n    // exceptions from actual bugs in components.\n    function (error) {\n      setIsLoaded(true);\n      setError(error);\n    });\n  }, []);\n  (0,react__WEBPACK_IMPORTED_MODULE_0__.useEffect)(function () {\n    if (listRef.current) {\n      Drupal.attachBehaviors(listRef.current);\n    }\n  });\n\n  if (error) {\n    return /*#__PURE__*/React.createElement(\"div\", null, \"Error: \", error);\n  } else if (!isLoaded) {\n    return /*#__PURE__*/React.createElement(\"div\", null, \"Loading...\");\n  } else {\n    return /*#__PURE__*/React.createElement(\"ul\", {\n      ref: listRef\n    }, data.map(function (node) {\n      return /*#__PURE__*/React.createElement(\"li\", null, /*#__PURE__*/React.createElement(\"a\", {\n        className: \"use-ajax\",\n        href: \"/node/\".concat(node.drupal_internal__nid)\n      }, node.title), node.tags.name !== undefined ? \" - \".concat(node.tags.name) : '');\n    }), /*#__PURE__*/React.createElement(\"li\", null, /*#__PURE__*/React.createElement(\"a\", {\n      href: \"/node/add/article\",\n      className: \"use-ajax\",\n      \"data-dialog-type\": \"modal\"\n    }, Drupal.t('Add content'))));\n  }\n}\n\n//# sourceURL=webpack://bda_bartik/./js/Components/MyComponent.js?");

/***/ }),

/***/ "./js/main.js":
/*!********************!*\
  !*** ./js/main.js ***!
  \********************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _Components_MyComponent__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Components/MyComponent */ \"./js/Components/MyComponent.js\");\n\n\n(function ($, Drupal) {\n  Drupal.behaviors.customElement = {\n    attach: function attach(context, settings) {\n      $('#block-exampleblock, .custom-react-list', context).each(function () {\n        var root = ReactDOM.createRoot($(this)[0]);\n        root.render( /*#__PURE__*/React.createElement(_Components_MyComponent__WEBPACK_IMPORTED_MODULE_0__.MyComponent, null));\n      });\n    }\n  };\n})(jQuery, Drupal);\n\n//# sourceURL=webpack://bda_bartik/./js/main.js?");

/***/ }),

/***/ "react":
/*!************************!*\
  !*** external "React" ***!
  \************************/
/***/ ((module) => {

module.exports = React;

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	(() => {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = (module) => {
/******/ 			var getter = module && module.__esModule ?
/******/ 				() => (module['default']) :
/******/ 				() => (module);
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval devtool is used.
/******/ 	var __webpack_exports__ = __webpack_require__("./js/main.js");
/******/ 	
/******/ })()
;