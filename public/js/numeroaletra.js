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

/***/ "./resources/js/numeroaletra.js":
/*!**************************************!*\
  !*** ./resources/js/numeroaletra.js ***!
  \**************************************/
/*! no static exports found */
/***/ (function(module, exports) {

throw new Error("Module build failed (from ./node_modules/babel-loader/lib/index.js):\nSyntaxError: C:\\laragon\\www\\softsystem\\resources\\js\\numeroaletra.js: Unexpected character '“' (33:23)\n\n\u001b[0m \u001b[90m 31 | \u001b[39m    \u001b[36mswitch\u001b[39m(num)\u001b[0m\n\u001b[0m \u001b[90m 32 | \u001b[39m    {\u001b[0m\n\u001b[0m\u001b[31m\u001b[1m>\u001b[22m\u001b[39m\u001b[90m 33 | \u001b[39m        \u001b[36mcase\u001b[39m \u001b[35m1\u001b[39m\u001b[33m:\u001b[39m \u001b[36mreturn\u001b[39m “UN”\u001b[33m;\u001b[39m\u001b[0m\n\u001b[0m \u001b[90m    | \u001b[39m                       \u001b[31m\u001b[1m^\u001b[22m\u001b[39m\u001b[0m\n\u001b[0m \u001b[90m 34 | \u001b[39m        \u001b[36mcase\u001b[39m \u001b[35m2\u001b[39m\u001b[33m:\u001b[39m \u001b[36mreturn\u001b[39m “DOS”\u001b[33m;\u001b[39m\u001b[0m\n\u001b[0m \u001b[90m 35 | \u001b[39m        \u001b[36mcase\u001b[39m \u001b[35m3\u001b[39m\u001b[33m:\u001b[39m \u001b[36mreturn\u001b[39m “TRES”\u001b[33m;\u001b[39m\u001b[0m\n\u001b[0m \u001b[90m 36 | \u001b[39m        \u001b[36mcase\u001b[39m \u001b[35m4\u001b[39m\u001b[33m:\u001b[39m \u001b[36mreturn\u001b[39m “CUATRO”\u001b[33m;\u001b[39m\u001b[0m\n    at Parser.raise (C:\\laragon\\www\\softsystem\\node_modules\\@babel\\parser\\lib\\index.js:6322:17)\n    at Parser.getTokenFromCode (C:\\laragon\\www\\softsystem\\node_modules\\@babel\\parser\\lib\\index.js:7011:10)\n    at Parser.nextToken (C:\\laragon\\www\\softsystem\\node_modules\\@babel\\parser\\lib\\index.js:6520:12)\n    at Parser.next (C:\\laragon\\www\\softsystem\\node_modules\\@babel\\parser\\lib\\index.js:6460:10)\n    at Parser.parseReturnStatement (C:\\laragon\\www\\softsystem\\node_modules\\@babel\\parser\\lib\\index.js:10127:10)\n    at Parser.parseStatementContent (C:\\laragon\\www\\softsystem\\node_modules\\@babel\\parser\\lib\\index.js:9811:21)\n    at Parser.parseStatement (C:\\laragon\\www\\softsystem\\node_modules\\@babel\\parser\\lib\\index.js:9763:17)\n    at Parser.parseSwitchStatement (C:\\laragon\\www\\softsystem\\node_modules\\@babel\\parser\\lib\\index.js:10170:36)\n    at Parser.parseStatementContent (C:\\laragon\\www\\softsystem\\node_modules\\@babel\\parser\\lib\\index.js:9814:21)\n    at Parser.parseStatement (C:\\laragon\\www\\softsystem\\node_modules\\@babel\\parser\\lib\\index.js:9763:17)\n    at Parser.parseBlockOrModuleBlockBody (C:\\laragon\\www\\softsystem\\node_modules\\@babel\\parser\\lib\\index.js:10340:25)\n    at Parser.parseBlockBody (C:\\laragon\\www\\softsystem\\node_modules\\@babel\\parser\\lib\\index.js:10327:10)\n    at Parser.parseBlock (C:\\laragon\\www\\softsystem\\node_modules\\@babel\\parser\\lib\\index.js:10311:10)\n    at Parser.parseFunctionBody (C:\\laragon\\www\\softsystem\\node_modules\\@babel\\parser\\lib\\index.js:9382:24)\n    at Parser.parseFunctionBodyAndFinish (C:\\laragon\\www\\softsystem\\node_modules\\@babel\\parser\\lib\\index.js:9352:10)\n    at C:\\laragon\\www\\softsystem\\node_modules\\@babel\\parser\\lib\\index.js:10474:12\n    at Parser.withTopicForbiddingContext (C:\\laragon\\www\\softsystem\\node_modules\\@babel\\parser\\lib\\index.js:9657:14)\n    at Parser.parseFunction (C:\\laragon\\www\\softsystem\\node_modules\\@babel\\parser\\lib\\index.js:10473:10)\n    at Parser.parseFunctionStatement (C:\\laragon\\www\\softsystem\\node_modules\\@babel\\parser\\lib\\index.js:10111:17)\n    at Parser.parseStatementContent (C:\\laragon\\www\\softsystem\\node_modules\\@babel\\parser\\lib\\index.js:9801:21)\n    at Parser.parseStatement (C:\\laragon\\www\\softsystem\\node_modules\\@babel\\parser\\lib\\index.js:9763:17)\n    at Parser.parseBlockOrModuleBlockBody (C:\\laragon\\www\\softsystem\\node_modules\\@babel\\parser\\lib\\index.js:10340:25)\n    at Parser.parseBlockBody (C:\\laragon\\www\\softsystem\\node_modules\\@babel\\parser\\lib\\index.js:10327:10)\n    at Parser.parseTopLevel (C:\\laragon\\www\\softsystem\\node_modules\\@babel\\parser\\lib\\index.js:9692:10)\n    at Parser.parse (C:\\laragon\\www\\softsystem\\node_modules\\@babel\\parser\\lib\\index.js:11209:17)\n    at parse (C:\\laragon\\www\\softsystem\\node_modules\\@babel\\parser\\lib\\index.js:11245:38)\n    at parser (C:\\laragon\\www\\softsystem\\node_modules\\@babel\\core\\lib\\transformation\\normalize-file.js:170:34)\n    at normalizeFile (C:\\laragon\\www\\softsystem\\node_modules\\@babel\\core\\lib\\transformation\\normalize-file.js:138:11)\n    at runSync (C:\\laragon\\www\\softsystem\\node_modules\\@babel\\core\\lib\\transformation\\index.js:44:43)\n    at runAsync (C:\\laragon\\www\\softsystem\\node_modules\\@babel\\core\\lib\\transformation\\index.js:35:14)\n    at C:\\laragon\\www\\softsystem\\node_modules\\@babel\\core\\lib\\transform.js:34:34\n    at processTicksAndRejections (internal/process/task_queues.js:72:11)");

/***/ }),

/***/ 3:
/*!********************************************!*\
  !*** multi ./resources/js/numeroaletra.js ***!
  \********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\laragon\www\softsystem\resources\js\numeroaletra.js */"./resources/js/numeroaletra.js");


/***/ })

/******/ });