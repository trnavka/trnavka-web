!function(){"use strict";require("core-js/modules/es6.array.map.js"),require("core-js/modules/es6.date.to-json.js"),jQuery("body").on("click",".media-selector",(function(e){e.preventDefault();var t="true"===e.target.dataset.multiple,r=wp.media({multiple:t}).open().on("select",(function(){document.querySelector(e.target.dataset.inputSelector).value=t?JSON.stringify(r.state().get("selection").map((function(e){return e.id}))):r.state().get("selection").first().toJSON().id}))}))}();