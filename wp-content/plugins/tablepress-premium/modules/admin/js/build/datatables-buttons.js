(()=>{"use strict";const t=window.wp.hooks,e=t=>"#"===t[0]?document.getElementById(t.slice(1)):document.querySelectorAll(t),a=e("#datatables-buttons-drag-box-wrapper-active"),o=e("#datatables-buttons-drag-box-wrapper-inactive"),s=()=>{const t=[...a.querySelectorAll(":scope input")].map((t=>t.value));tp.table.options.datatables_buttons=t.join(","),tp.helpers.options.check_dependencies(),tp.helpers.unsaved_changes.set()},n=function(t){if(!t.target)return;const e=tp.table.options.use_datatables&&tp.table.options.table_head,n=tp.table.options.datatables_custom_commands.includes('"buttons":');if(!e||n)return;const l=t.target.closest(".drag-box");(l.closest(".drag-box-wrapper")===a?o:a).appendChild(l),s()};a.addEventListener("dblclick",n),o.addEventListener("dblclick",n),(0,t.addFilter)("tablepress.optionsLoad","tp/datatables-buttons/load-option-value",(t=>"datatables_buttons"!==t?t:(""!==tp.table.options.datatables_buttons&&tp.table.options.datatables_buttons.split(",").forEach((t=>a.appendChild(e(`#option-datatables_buttons-${t}`).parentNode))),""))),(0,t.addAction)("tablepress.optionsCheckDependencies","tp/datatables-buttons/handle-options-check-dependencies",(()=>{const t=tp.table.options.datatables_custom_commands.includes('"buttons":'),s=tp.table.options.use_datatables&&tp.table.options.table_head,n=s&&!t;a.querySelectorAll(":scope input").forEach((t=>t.disabled=!n)),o.querySelectorAll(":scope input").forEach((t=>t.disabled=!n)),e("#notice-datatables-buttons-requirements").style.display=s?"none":"block",e("#notice-datatables-buttons-custom-commands").style.display=s&&t?"block":"none",jQuery((function(t){t(a).sortable("option","disabled",!n),t(o).sortable("option","disabled",!n)}))})),(0,t.addFilter)("tablepress.optionsMetaBoxes","tp/datatables-buttons/add-meta-box",(t=>(t.push("#tablepress_edit-datatables-buttons"),t))),jQuery((function(t){t(a).sortable({containment:"#tablepress_edit-datatables-buttons",cursor:"move",placeholder:"drag-box-placeholder",connectWith:"#datatables-buttons-drag-box-wrapper-inactive",update:s}),t(o).sortable({containment:"#tablepress_edit-datatables-buttons",cursor:"move",placeholder:"drag-box-placeholder",connectWith:"#datatables-buttons-drag-box-wrapper-active"})}))})();