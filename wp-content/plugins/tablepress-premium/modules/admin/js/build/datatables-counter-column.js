(()=>{"use strict";const t=window.wp.hooks,e=t=>"#"===t[0]?document.getElementById(t.slice(1)):document.querySelectorAll(t);(0,t.addAction)("tablepress.optionsCheckDependencies","tp/datatables-counter-column/handle-options-check-dependencies",(()=>{const t=tp.table.options.use_datatables&&tp.table.options.table_head&&(tp.table.options.datatables_sort||tp.table.options.datatables_filter);e("#option-datatables_counter_column").disabled=!t,e("#notice-datatables-counter-column-requirements").style.display=t?"none":"block"})),(0,t.addFilter)("tablepress.optionsMetaBoxes","tp/datatables-counter-column/add-meta-box",(t=>(t.push("#tablepress_edit-datatables-counter-column"),t)))})();