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

/***/ "./js/main.js":
/*!********************!*\
  !*** ./js/main.js ***!
  \********************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\nObject(function webpackMissingModule() { var e = new Error(\"Cannot find module './Components/MyComponent'\"); e.code = 'MODULE_NOT_FOUND'; throw e; }());\nObject(function webpackMissingModule() { var e = new Error(\"Cannot find module './Components/TableComponent'\"); e.code = 'MODULE_NOT_FOUND'; throw e; }());\n\n // const root = ReactDOM.createRoot(document.getElementById('react-root-id'));\n// root.render(<MyComponent/>)\n\n(function ($, Drupal) {\n  Drupal.behaviors.customElement = {\n    attach: function attach(context, settings) {\n      $('#react-root-id, .custom-react-list', context).each(function () {\n        var root = ReactDOM.createRoot($(this)[0]); // root.render(<MyComponent/>);\n\n        root.render( /*#__PURE__*/React.createElement(Object(function webpackMissingModule() { var e = new Error(\"Cannot find module './Components/TableComponent'\"); e.code = 'MODULE_NOT_FOUND'; throw e; }()), null));\n      });\n    }\n  };\n})(jQuery, Drupal);\n\n//# sourceURL=webpack://bda_bartik/./js/main.js?");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The require scope
/******/ 	var __webpack_require__ = {};
/******/ 	
/************************************************************************/
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
/******/ 	var __webpack_exports__ = {};
/******/ 	__webpack_modules__["./js/main.js"](0, __webpack_exports__, __webpack_require__);
/******/ 	
/******/ })()
;