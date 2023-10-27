(()=>{"use strict";var e={n:t=>{var r=t&&t.__esModule?()=>t.default:()=>t;return e.d(r,{a:r}),r},d:(t,r)=>{for(var l in r)e.o(r,l)&&!e.o(t,l)&&Object.defineProperty(t,l,{enumerable:!0,get:r[l]})},o:(e,t)=>Object.prototype.hasOwnProperty.call(e,t)};const t=window.wp.element,r=window.wp.i18n,l=window.wp.hooks,n=window.wp.compose,a=window.wp.blockEditor,s=window.wp.components,o=window.wp.shortcode;var i=e.n(o);const h=JSON.parse('{"u2":"tablepress/table"}'),c=e=>{let t=Object.entries(e.named).map((([e,t])=>{let r="";return t=t.replace(/“([^”]*)”/g,"$1"),(/\s/.test(t)||""===t)&&(r='"'),t.includes('"')&&(r="'"),`${e}=${r}${t}${r}`})).join(" ");return e.numeric.forEach((e=>{/\s/.test(e)?t+=' "'+e+'"':t+=" "+e})),t},m=function(e){const{tableOption:r,shortcodeAttrs:l,setAttributes:n,...a}=e;return(0,t.createElement)(s.CheckboxControl,{checked:"string"==typeof l.named[r]&&"true"===l.named[r].toLowerCase(),indeterminate:void 0===l.named[r],onChange:e=>{l.named[r]=e?"true":"false";const t=c(l);n({parameters:t})},...a})},p=function(e){const{tableOption:r,shortcodeAttrs:l,setAttributes:n,...a}=e;return(0,t.createElement)(s.TextControl,{value:l.named[r]||tp.table.template[r],onChange:e=>{tp.table.template[r]===e?delete l.named[r]:l.named[r]=e;const t=c(l);n({parameters:t})},...a})},d=(0,n.createHigherOrderComponent)((e=>l=>{if(h.u2!==l.name)return(0,t.createElement)(e,{...l});const{attributes:n,setAttributes:o}=l;if(!n.id||!tp.tables.hasOwnProperty(n.id))return(0,t.createElement)(e,{...l});let c=i().attrs(n.parameters);c={named:{...c.named},numeric:[...c.numeric]};const d={shortcodeAttrs:c,setAttributes:o};return(0,t.createElement)(t.Fragment,null,(0,t.createElement)(e,{...l}),(0,t.createElement)(a.InspectorControls,null,(0,t.createElement)(s.PanelBody,{title:(0,r.__)("Row Highlighting","tablepress"),initialOpen:!1,className:"wp-block-tablepress-table-inspector-panel"},(0,t.createElement)(p,{label:(0,r.__)("Row Highlight term","tablepress")+":",help:(0,r.__)("Rows that contain this term will be highlighted.","tablepress")+" "+(0,r.__)(" You can combine multiple highlight terms with an OR operator, e.g. “term1||term2”.","tablepress"),tableOption:"row_highlight",...d}),c.named.row_highlight&&(0,t.createElement)(t.Fragment,null,(0,t.createElement)(m,{label:(0,r.__)("Full cell matching","tablepress"),help:(0,r.__)("If this is turned on, the full cell content has to match the highlight term.","tablepress"),tableOption:"row_highlight_full_cell_match",...d}),(0,t.createElement)(m,{label:(0,r.__)("Case-sensitive matching","tablepress"),help:(0,r.__)("If this is turned on, the case sensitivity of the highlight term has to match the content in the cell.","tablepress"),tableOption:"row_highlight_case_sensitive",...d}),(0,t.createElement)(p,{label:(0,r.__)("Highlight columns:","tablepress"),help:(0,r.__)("Enter a comma-separated list of the columns which should be searched for the highlight terms, e.g. “1,3-5,7”.","tablepress"),tableOption:"row_highlight_columns",...d}),(0,t.createElement)(p,{label:(0,r.__)("Highlight rows:","tablepress"),help:(0,r.__)("Enter a comma-separated list of the rows which should be searched for the highlight terms, e.g. “1,3-5,7”.","tablepress"),tableOption:"row_highlight_rows",...d})))))}),"addTableBlockSidebarControls");(0,l.addFilter)("editor.BlockEdit","tp/row-highlighting/add-table-block-sidebar-controls",d)})();