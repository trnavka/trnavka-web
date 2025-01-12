/******/ (function() { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/scripts/blocks/dajnato-cta.block.jsx":
/*!********************************************************!*\
  !*** ./resources/scripts/blocks/dajnato-cta.block.jsx ***!
  \********************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function ownKeys(e, r) { var t = Object.keys(e); if (Object.getOwnPropertySymbols) { var o = Object.getOwnPropertySymbols(e); r && (o = o.filter(function (r) { return Object.getOwnPropertyDescriptor(e, r).enumerable; })), t.push.apply(t, o); } return t; }
function _objectSpread(e) { for (var r = 1; r < arguments.length; r++) { var t = null != arguments[r] ? arguments[r] : {}; r % 2 ? ownKeys(Object(t), !0).forEach(function (r) { _defineProperty(e, r, t[r]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(e, Object.getOwnPropertyDescriptors(t)) : ownKeys(Object(t)).forEach(function (r) { Object.defineProperty(e, r, Object.getOwnPropertyDescriptor(t, r)); }); } return e; }
function _defineProperty(obj, key, value) { key = _toPropertyKey(key); if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }
function _toPropertyKey(arg) { var key = _toPrimitive(arg, "string"); return _typeof(key) === "symbol" ? key : String(key); }
function _toPrimitive(input, hint) { if (_typeof(input) !== "object" || input === null) return input; var prim = input[Symbol.toPrimitive]; if (prim !== undefined) { var res = prim.call(input, hint || "default"); if (_typeof(res) !== "object") return res; throw new TypeError("@@toPrimitive must return a primitive value."); } return (hint === "string" ? String : Number)(input); }

/* harmony default export */ __webpack_exports__["default"] = ({
  name: 'theme/dajnato-cta-block',
  title: 'Daj na to CTA',
  category: 'theme',
  edit: function edit(props) {
    return /*#__PURE__*/React.createElement("div", {
      className: 'dajnato-cta-block-editor'
    }, /*#__PURE__*/React.createElement("textarea", {
      className: 'regular-text dajnato-title',
      onChange: function onChange(event) {
        props.setAttributes(_objectSpread(_objectSpread({}, props.attributes), {}, {
          title: event.target.value
        }));
      },
      value: props.attributes.title
    }), /*#__PURE__*/React.createElement("div", {
      className: 'dajnato-values'
    }, /*#__PURE__*/React.createElement("select", {
      onChange: function onChange(event) {
        props.setAttributes(_objectSpread(_objectSpread({}, props.attributes), {}, {
          campaign_id: event.target.value
        }));
      },
      value: props.attributes.campaign_id
    }, /*#__PURE__*/React.createElement("option", null, "automaticky zvolen\xE1 kampa\u0148"), /*#__PURE__*/React.createElement("option", {
      value: 'button'
    }, "len CTA tla\u010Didlo"), props.attributes.campaigns.map(function (campaign, index) {
      return /*#__PURE__*/React.createElement("option", {
        key: index,
        value: campaign['id']
      }, campaign['title']);
    }))), 'button' === props.attributes.campaign_id && /*#__PURE__*/React.createElement("div", {
      className: 'button-url'
    }, "Url tla\u010Didla: ", /*#__PURE__*/React.createElement("input", {
      type: "text",
      className: 'regular-text',
      onChange: function onChange(event) {
        props.setAttributes(_objectSpread(_objectSpread({}, props.attributes), {}, {
          button_url: event.target.value
        }));
      },
      value: props.attributes.button_url
    })), /*#__PURE__*/React.createElement("input", {
      type: "text",
      className: 'regular-text dajnato-button',
      onChange: function onChange(event) {
        props.setAttributes(_objectSpread(_objectSpread({}, props.attributes), {}, {
          button: event.target.value
        }));
      },
      value: props.attributes.button
    }));
  }
});

/***/ }),

/***/ "./resources/scripts/metaboxes/CampaignMetabox.jsx":
/*!*********************************************************!*\
  !*** ./resources/scripts/metaboxes/CampaignMetabox.jsx ***!
  \*********************************************************/
/***/ (function() {

var render = wp.element.render;
var _wp$data = wp.data,
  useSelect = _wp$data.useSelect,
  useDispatch = _wp$data.useDispatch;
var MyMetaBox = function MyMetaBox() {
  var meta = useSelect(function (select) {
    var data = select("core/editor").getEditedPostAttribute("meta");
    return data; // ? data['_better_meta_box_value'] : false;
  }, []);
  console.log(meta);
  var _useDispatch = useDispatch("core/editor"),
    editPost = _useDispatch.editPost;
  return /*#__PURE__*/React.createElement("div", null, /*#__PURE__*/React.createElement("p", null, "This is a better Meta Box."));
};

// render(<MyMetaBox />, document.getElementById("App_Metabox_CampaignMetabox"));

/***/ }),

/***/ "./resources/styles/editor.scss":
/*!**************************************!*\
  !*** ./resources/styles/editor.scss ***!
  \**************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


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
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	!function() {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = function(exports) {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	}();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be in strict mode.
!function() {
"use strict";
/*!*****************************!*\
  !*** ./resources/editor.js ***!
  \*****************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _styles_editor_scss__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./styles/editor.scss */ "./resources/styles/editor.scss");
/* harmony import */ var _scripts_blocks_dajnato_cta_block_jsx__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./scripts/blocks/dajnato-cta.block.jsx */ "./resources/scripts/blocks/dajnato-cta.block.jsx");
/* harmony import */ var _scripts_metaboxes_CampaignMetabox_jsx__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./scripts/metaboxes/CampaignMetabox.jsx */ "./resources/scripts/metaboxes/CampaignMetabox.jsx");



var registerBlockType = window.wp.blocks.registerBlockType;
registerBlockType(_scripts_blocks_dajnato_cta_block_jsx__WEBPACK_IMPORTED_MODULE_1__["default"].name, _scripts_blocks_dajnato_cta_block_jsx__WEBPACK_IMPORTED_MODULE_1__["default"]);

// import roots from '@roots/sage'

/**
 * @see {@link https://bud.js.org/extensions/bud-preset-wordpress/editor-integration/filters}
 */
// roots.register.blocks('@scripts/blocks');
// roots.register.filters('@scripts/filters');

/**
 * @see {@link https://webpack.js.org/api/hot-module-replacement/}
 */
// if (import.meta.webpackHot) {
//     import.meta.webpackHot.accept(console.error);
// }
}();
/******/ })()
;
//# sourceMappingURL=data:application/json;charset=utf-8;base64,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aUI7QUFFeEJBLGlCQUFpQixDQUFDRCw2RUFBUSxDQUFDdkMsSUFBSSxFQUFFdUMsNkVBQVEsQ0FBQzs7QUFFMUM7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsSSIsInNvdXJjZXMiOlsid2VicGFjazovL3NhZ2UvLi9yZXNvdXJjZXMvc2NyaXB0cy9ibG9ja3MvZGFqbmF0by1jdGEuYmxvY2suanN4Iiwid2VicGFjazovL3NhZ2UvLi9yZXNvdXJjZXMvc2NyaXB0cy9tZXRhYm94ZXMvQ2FtcGFpZ25NZXRhYm94LmpzeCIsIndlYnBhY2s6Ly9zYWdlLy4vcmVzb3VyY2VzL3N0eWxlcy9lZGl0b3Iuc2Nzcz8wNzNjIiwid2VicGFjazovL3NhZ2Uvd2VicGFjay9ib290c3RyYXAiLCJ3ZWJwYWNrOi8vc2FnZS93ZWJwYWNrL3J1bnRpbWUvbWFrZSBuYW1lc3BhY2Ugb2JqZWN0Iiwid2VicGFjazovL3NhZ2UvLi9yZXNvdXJjZXMvZWRpdG9yLmpzIl0sInNvdXJjZXNDb250ZW50IjpbImltcG9ydCBUZXh0YXJlYUF1dG9zaXplIGZyb20gJ3JlYWN0LXRleHRhcmVhLWF1dG9zaXplJztcblxuZXhwb3J0IGRlZmF1bHQge1xuICAgIG5hbWU6ICd0aGVtZS9kYWpuYXRvLWN0YS1ibG9jaycsXG4gICAgdGl0bGU6ICdEYWogbmEgdG8gQ1RBJyxcbiAgICBjYXRlZ29yeTogJ3RoZW1lJyxcbiAgICBlZGl0OiAocHJvcHMpID0+XG4gICAgICAgICAgICA8ZGl2IGNsYXNzTmFtZT17J2Rham5hdG8tY3RhLWJsb2NrLWVkaXRvcid9PlxuICAgICAgICAgICAgICAgIDx0ZXh0YXJlYVxuICAgICAgICAgICAgICAgICAgICAgICAgY2xhc3NOYW1lPXsncmVndWxhci10ZXh0IGRham5hdG8tdGl0bGUnfVxuICAgICAgICAgICAgICAgICAgICAgICAgb25DaGFuZ2U9e2V2ZW50ID0+IHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBwcm9wcy5zZXRBdHRyaWJ1dGVzKFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIC4uLnByb3BzLmF0dHJpYnV0ZXMsXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgdGl0bGU6IGV2ZW50LnRhcmdldC52YWx1ZVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgfSk7XG4gICAgICAgICAgICAgICAgICAgICAgICB9fVxuICAgICAgICAgICAgICAgICAgICAgICAgdmFsdWU9e3Byb3BzLmF0dHJpYnV0ZXMudGl0bGV9XG4gICAgICAgICAgICAgICAgLz5cbiAgICAgICAgICAgICAgICA8ZGl2IGNsYXNzTmFtZT17J2Rham5hdG8tdmFsdWVzJ30+XG4gICAgICAgICAgICAgICAgICAgIDxzZWxlY3Qgb25DaGFuZ2U9e2V2ZW50ID0+IHtcbiAgICAgICAgICAgICAgICAgICAgICAgIHByb3BzLnNldEF0dHJpYnV0ZXMoXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIC4uLnByb3BzLmF0dHJpYnV0ZXMsXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBjYW1wYWlnbl9pZDogZXZlbnQudGFyZ2V0LnZhbHVlXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIH0pO1xuICAgICAgICAgICAgICAgICAgICB9fSB2YWx1ZT17cHJvcHMuYXR0cmlidXRlcy5jYW1wYWlnbl9pZH0+XG4gICAgICAgICAgICAgICAgICAgICAgICA8b3B0aW9uPmF1dG9tYXRpY2t5IHp2b2xlbsOhIGthbXBhxYg8L29wdGlvbj5cbiAgICAgICAgICAgICAgICAgICAgICAgIDxvcHRpb24gdmFsdWU9eydidXR0b24nfT5sZW4gQ1RBIHRsYcSNaWRsbzwvb3B0aW9uPlxuICAgICAgICAgICAgICAgICAgICAgICAge3Byb3BzLmF0dHJpYnV0ZXMuY2FtcGFpZ25zLm1hcChcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgKGNhbXBhaWduLFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGluZGV4KSA9PlxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIDxvcHRpb24ga2V5PXtpbmRleH0gdmFsdWU9e2NhbXBhaWduWydpZCddfT57Y2FtcGFpZ25bJ3RpdGxlJ119PC9vcHRpb24+KX1cbiAgICAgICAgICAgICAgICAgICAgPC9zZWxlY3Q+XG4gICAgICAgICAgICAgICAgPC9kaXY+XG4gICAgICAgICAgICAgICAgeydidXR0b24nID09PSBwcm9wcy5hdHRyaWJ1dGVzLmNhbXBhaWduX2lkICYmIDxkaXYgY2xhc3NOYW1lPXsnYnV0dG9uLXVybCd9PlxuICAgICAgICAgICAgICAgICAgICBVcmwgdGxhxI1pZGxhOiA8aW5wdXRcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICB0eXBlPVwidGV4dFwiXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgY2xhc3NOYW1lPXsncmVndWxhci10ZXh0J31cbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBvbkNoYW5nZT17ZXZlbnQgPT4ge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBwcm9wcy5zZXRBdHRyaWJ1dGVzKFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgLi4ucHJvcHMuYXR0cmlidXRlcyxcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgYnV0dG9uX3VybDogZXZlbnQudGFyZ2V0LnZhbHVlXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgfSk7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgfX1cbiAgICAgICAgICAgICAgICAgICAgICAgICAgICB2YWx1ZT17cHJvcHMuYXR0cmlidXRlcy5idXR0b25fdXJsfVxuICAgICAgICAgICAgICAgICAgICAvPlxuICAgICAgICAgICAgICAgIDwvZGl2Pn1cbiAgICAgICAgICAgICAgICA8aW5wdXRcbiAgICAgICAgICAgICAgICAgICAgICAgIHR5cGU9XCJ0ZXh0XCJcbiAgICAgICAgICAgICAgICAgICAgICAgIGNsYXNzTmFtZT17J3JlZ3VsYXItdGV4dCBkYWpuYXRvLWJ1dHRvbid9XG4gICAgICAgICAgICAgICAgICAgICAgICBvbkNoYW5nZT17ZXZlbnQgPT4ge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIHByb3BzLnNldEF0dHJpYnV0ZXMoXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgLi4ucHJvcHMuYXR0cmlidXRlcyxcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBidXR0b246IGV2ZW50LnRhcmdldC52YWx1ZVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgfSk7XG4gICAgICAgICAgICAgICAgICAgICAgICB9fVxuICAgICAgICAgICAgICAgICAgICAgICAgdmFsdWU9e3Byb3BzLmF0dHJpYnV0ZXMuYnV0dG9ufVxuICAgICAgICAgICAgICAgIC8+XG4gICAgICAgICAgICA8L2Rpdj5cbn07XG4iLCJjb25zdCB7IHJlbmRlciB9ID0gd3AuZWxlbWVudDtcbmNvbnN0IHsgdXNlU2VsZWN0LCB1c2VEaXNwYXRjaCB9ID0gd3AuZGF0YTtcblxuY29uc3QgTXlNZXRhQm94ID0gKCkgPT4ge1xuICAgIGNvbnN0IG1ldGEgPSB1c2VTZWxlY3QoZnVuY3Rpb24gKHNlbGVjdCkge1xuICAgICAgICBjb25zdCBkYXRhID0gc2VsZWN0KFwiY29yZS9lZGl0b3JcIikuZ2V0RWRpdGVkUG9zdEF0dHJpYnV0ZShcIm1ldGFcIik7XG4gICAgICAgIHJldHVybiBkYXRhOyAvLyA/IGRhdGFbJ19iZXR0ZXJfbWV0YV9ib3hfdmFsdWUnXSA6IGZhbHNlO1xuICAgIH0sIFtdKTtcblxuICAgIGNvbnNvbGUubG9nKG1ldGEpO1xuXG4gICAgY29uc3QgeyBlZGl0UG9zdCB9ID0gdXNlRGlzcGF0Y2goXCJjb3JlL2VkaXRvclwiKTtcblxuICAgIHJldHVybiAoXG4gICAgICAgIDxkaXY+XG4gICAgICAgICAgICA8cD5UaGlzIGlzIGEgYmV0dGVyIE1ldGEgQm94LjwvcD5cbiAgICAgICAgPC9kaXY+XG4gICAgKTtcbn07XG5cbi8vIHJlbmRlcig8TXlNZXRhQm94IC8+LCBkb2N1bWVudC5nZXRFbGVtZW50QnlJZChcIkFwcF9NZXRhYm94X0NhbXBhaWduTWV0YWJveFwiKSk7XG4iLCIvLyBleHRyYWN0ZWQgYnkgbWluaS1jc3MtZXh0cmFjdC1wbHVnaW5cbmV4cG9ydCB7fTsiLCIvLyBUaGUgbW9kdWxlIGNhY2hlXG52YXIgX193ZWJwYWNrX21vZHVsZV9jYWNoZV9fID0ge307XG5cbi8vIFRoZSByZXF1aXJlIGZ1bmN0aW9uXG5mdW5jdGlvbiBfX3dlYnBhY2tfcmVxdWlyZV9fKG1vZHVsZUlkKSB7XG5cdC8vIENoZWNrIGlmIG1vZHVsZSBpcyBpbiBjYWNoZVxuXHR2YXIgY2FjaGVkTW9kdWxlID0gX193ZWJwYWNrX21vZHVsZV9jYWNoZV9fW21vZHVsZUlkXTtcblx0aWYgKGNhY2hlZE1vZHVsZSAhPT0gdW5kZWZpbmVkKSB7XG5cdFx0cmV0dXJuIGNhY2hlZE1vZHVsZS5leHBvcnRzO1xuXHR9XG5cdC8vIENyZWF0ZSBhIG5ldyBtb2R1bGUgKGFuZCBwdXQgaXQgaW50byB0aGUgY2FjaGUpXG5cdHZhciBtb2R1bGUgPSBfX3dlYnBhY2tfbW9kdWxlX2NhY2hlX19bbW9kdWxlSWRdID0ge1xuXHRcdC8vIG5vIG1vZHVsZS5pZCBuZWVkZWRcblx0XHQvLyBubyBtb2R1bGUubG9hZGVkIG5lZWRlZFxuXHRcdGV4cG9ydHM6IHt9XG5cdH07XG5cblx0Ly8gRXhlY3V0ZSB0aGUgbW9kdWxlIGZ1bmN0aW9uXG5cdF9fd2VicGFja19tb2R1bGVzX19bbW9kdWxlSWRdKG1vZHVsZSwgbW9kdWxlLmV4cG9ydHMsIF9fd2VicGFja19yZXF1aXJlX18pO1xuXG5cdC8vIFJldHVybiB0aGUgZXhwb3J0cyBvZiB0aGUgbW9kdWxlXG5cdHJldHVybiBtb2R1bGUuZXhwb3J0cztcbn1cblxuIiwiLy8gZGVmaW5lIF9fZXNNb2R1bGUgb24gZXhwb3J0c1xuX193ZWJwYWNrX3JlcXVpcmVfXy5yID0gZnVuY3Rpb24oZXhwb3J0cykge1xuXHRpZih0eXBlb2YgU3ltYm9sICE9PSAndW5kZWZpbmVkJyAmJiBTeW1ib2wudG9TdHJpbmdUYWcpIHtcblx0XHRPYmplY3QuZGVmaW5lUHJvcGVydHkoZXhwb3J0cywgU3ltYm9sLnRvU3RyaW5nVGFnLCB7IHZhbHVlOiAnTW9kdWxlJyB9KTtcblx0fVxuXHRPYmplY3QuZGVmaW5lUHJvcGVydHkoZXhwb3J0cywgJ19fZXNNb2R1bGUnLCB7IHZhbHVlOiB0cnVlIH0pO1xufTsiLCJpbXBvcnQgJy4vc3R5bGVzL2VkaXRvci5zY3NzJ1xuaW1wb3J0IGN0YUJsb2NrIGZyb20gJy4vc2NyaXB0cy9ibG9ja3MvZGFqbmF0by1jdGEuYmxvY2suanN4J1xuaW1wb3J0ICcuL3NjcmlwdHMvbWV0YWJveGVzL0NhbXBhaWduTWV0YWJveC5qc3gnXG5cbmNvbnN0IHtyZWdpc3RlckJsb2NrVHlwZX0gPSB3aW5kb3cud3AuYmxvY2tzO1xuXG5yZWdpc3RlckJsb2NrVHlwZShjdGFCbG9jay5uYW1lLCBjdGFCbG9jayk7XG5cbi8vIGltcG9ydCByb290cyBmcm9tICdAcm9vdHMvc2FnZSdcblxuLyoqXG4gKiBAc2VlIHtAbGluayBodHRwczovL2J1ZC5qcy5vcmcvZXh0ZW5zaW9ucy9idWQtcHJlc2V0LXdvcmRwcmVzcy9lZGl0b3ItaW50ZWdyYXRpb24vZmlsdGVyc31cbiAqL1xuLy8gcm9vdHMucmVnaXN0ZXIuYmxvY2tzKCdAc2NyaXB0cy9ibG9ja3MnKTtcbi8vIHJvb3RzLnJlZ2lzdGVyLmZpbHRlcnMoJ0BzY3JpcHRzL2ZpbHRlcnMnKTtcblxuLyoqXG4gKiBAc2VlIHtAbGluayBodHRwczovL3dlYnBhY2suanMub3JnL2FwaS9ob3QtbW9kdWxlLXJlcGxhY2VtZW50L31cbiAqL1xuLy8gaWYgKGltcG9ydC5tZXRhLndlYnBhY2tIb3QpIHtcbi8vICAgICBpbXBvcnQubWV0YS53ZWJwYWNrSG90LmFjY2VwdChjb25zb2xlLmVycm9yKTtcbi8vIH1cbiJdLCJuYW1lcyI6WyJUZXh0YXJlYUF1dG9zaXplIiwibmFtZSIsInRpdGxlIiwiY2F0ZWdvcnkiLCJlZGl0IiwicHJvcHMiLCJSZWFjdCIsImNyZWF0ZUVsZW1lbnQiLCJjbGFzc05hbWUiLCJvbkNoYW5nZSIsImV2ZW50Iiwic2V0QXR0cmlidXRlcyIsIl9vYmplY3RTcHJlYWQiLCJhdHRyaWJ1dGVzIiwidGFyZ2V0IiwidmFsdWUiLCJjYW1wYWlnbl9pZCIsImNhbXBhaWducyIsIm1hcCIsImNhbXBhaWduIiwiaW5kZXgiLCJrZXkiLCJ0eXBlIiwiYnV0dG9uX3VybCIsImJ1dHRvbiIsInJlbmRlciIsIndwIiwiZWxlbWVudCIsIl93cCRkYXRhIiwiZGF0YSIsInVzZVNlbGVjdCIsInVzZURpc3BhdGNoIiwiTXlNZXRhQm94IiwibWV0YSIsInNlbGVjdCIsImdldEVkaXRlZFBvc3RBdHRyaWJ1dGUiLCJjb25zb2xlIiwibG9nIiwiX3VzZURpc3BhdGNoIiwiZWRpdFBvc3QiLCJjdGFCbG9jayIsInJlZ2lzdGVyQmxvY2tUeXBlIiwid2luZG93IiwiYmxvY2tzIl0sInNvdXJjZVJvb3QiOiIifQ==