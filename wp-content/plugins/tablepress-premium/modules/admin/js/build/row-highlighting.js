(()=>{"use strict";const i=window.wp.hooks,e=i=>"#"===i[0]?document.getElementById(i.slice(1)):document.querySelectorAll(i);(0,i.addAction)("tablepress.optionsCheckDependencies","tp/row-highlighting/handle-options-check-dependencies",(()=>{const i=""===tp.table.options.row_highlight.trim();e("#option-row_highlight_full_cell_match").disabled=i,e("#option-row_highlight_case_sensitive").disabled=i,e("#option-row_highlight_columns").disabled=i,e("#option-row_highlight_rows").disabled=i})),(0,i.addFilter)("tablepress.optionsMetaBoxes","tp/row-highlighting/add-meta-box",(i=>(i.push("#tablepress_edit-row-highlighting"),i)))})();