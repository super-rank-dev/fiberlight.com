(()=>{"use strict";const e=window.wp.hooks,t=e=>"#"===e[0]?document.getElementById(e.slice(1)):document.querySelectorAll(e);(0,e.addAction)("tablepress.optionsCheckDependencies","tp/datatables-searchpanes/handle-options-check-dependencies",(()=>{const e=tp.table.options.use_datatables&&tp.table.options.table_head&&tp.table.options.datatables_filter;t("#option-datatables_searchpanes").disabled=!e,t("#notice-datatables-searchpanes-requirements").style.display=e?"none":"block"})),(0,e.addFilter)("tablepress.optionsMetaBoxes","tp/datatables-searchpanes/add-meta-box",(e=>(e.push("#tablepress_edit-datatables-searchpanes"),e)))})();