(this.webpackJsonproot=this.webpackJsonproot||[]).push([[23],{2925:function(e,t,n){"use strict";var i=n(0),c=n(5),a=n(10),r=n(13),s={placement:"top"};t.a=function(e){var t=e.ticket,n=Object(r.useRegistrationsLink)({ticket_id:t.dbId}),l=Object(c.__)("total registrations."),o=Object(c.__)("view ALL registrations for this ticket.");return Object(i.jsx)(a.ItemCount,{count:t.registrationCount,emphasizeZero:!1,title:l,children:Object(i.jsx)(a.RegistrationsLink,{href:n,tooltip:o,tooltipProps:s})})}},2926:function(e,t,n){"use strict";var i=n(0),c=n(2),a=n(5),r=n(18),s=n(10),l=n(13);t.a=function(e){var t=e.entity,n=Object(l.useTicketMutator)(t.id).updateEntity,o=Object(c.useCallback)((function(e){var i=Object(r.parseInfinity)(e);i!==t.quantity&&n({quantity:i})}),[t.quantity,n]);return Object(i.jsx)(s.InlineEditInfinity,{onChange:o,value:"".concat(t.quantity),tooltip:Object(a.__)("edit quantity of tickets available\u2026")})}},2927:function(e,t,n){"use strict";n.d(t,"a",(function(){return l})),n.d(t,"b",(function(){return f}));var i=n(0),c=n(2),a=n(5),r=n(13),s=n(10),l=function(e){var t=e.className,n=e.entity,l=e.view,o=void 0===l?"card":l,u=Object(r.useTicketMutator)(n.id).updateEntity,b="card"===o&&2,j=Object(c.useCallback)((function(e){e!==n.name&&u({name:e})}),[n.name,u]),O=Object(a.__)("edit title\u2026"),d=n.name||O;return Object(i.jsx)(s.InlineEditText,{className:t,lineCount:b,onChange:j,tag:"table"===o?"div":"h4",tooltip:O,value:d})},o=n(25),u=n(22),b=n(221),j=n(46),O=n(3),d=n(12),p=function(e){var t=Object(b.useInitialState)({ticketId:e}),n=Object(b.useDefaultBasePrice)(),i=Object(b.useMutatePrices)(),a=Object(r.useTicketMutator)(e).updateEntity;return Object(c.useCallback)((function(e){var c,r,s=t(null),l=Object(O.a)(Object(O.a)({},null===(c=s)||void 0===c?void 0:c.ticket),{},{price:e});if(s=Object(O.a)(Object(O.a)({},s),{},{ticket:l}),!Object(d.getBasePrice)(null===(r=s)||void 0===r?void 0:r.prices)){var o,u=[Object(O.a)(Object(O.a)({},n),{},{order:1,isNew:!0})].concat(Object(j.a)(null===(o=s)||void 0===o?void 0:o.prices));s=Object(O.a)(Object(O.a)({},s),{},{prices:u})}var p=Object(b.calculateBasePrice)(s);i(p).then((function(t){a({price:e,reverseCalculate:!0,prices:t})}))}),[n,t,i,a])},f=function(e){var t=e.entity,n=e.className,r=Object(u.useMoneyDisplay)(),l=r.afterAmount,j=r.beforeAmount,O=r.formatAmount,d=p(t.id),f=Object(c.useCallback)((function(e){var n=e.amount,i=parseFloat(n);i!==t.price&&d(i)}),[d,t.price]),m=Object(o.useMemoStringify)({className:n}),k=Boolean(t.sold),y=k?b.SOLD_TICKET_ERROR_MESSAGE:Object(a.__)("edit ticket total\u2026");return Object(i.jsx)(s.InlineEditCurrency,{afterAmount:l,amount:t.price,beforeAmount:j,formatAmount:O,id:t.id,isEditDisabled:k,placeholder:Object(a.__)("set price\u2026"),wrapperProps:m,onChange:f,tag:"h3",tooltip:y})}},2930:function(e,t,n){"use strict";var i=n(3),c=n(0),a=n(7),r=n(10),s=n(541),l=function(e){return Object(s.b)("ticket",e)};t.a=function(e){var t=e.entity,n=Object(a.a)(e,["entity"]),s=l(t);return Object(c.jsx)(r.EntityActionsMenu,Object(i.a)(Object(i.a)({},n),{},{menuItems:s}))}},2931:function(e,t,n){"use strict";n.r(t);var i=n(0),c=n(5),a=n(182),r=n(21),s=n(2),l=n(13),o=n(3),u=n(22),b=Object(u.withFeature)("use_bulk_edit")((function(e){var t=Object(l.useVisibleTicketIds)(),n=Object(r.a)(t,1)[0];return Object(i.jsx)(a.ActionCheckbox,Object(o.a)(Object(o.a)({},e),{},{visibleEntityIds:n}))})),j=function(){var e=Object(l.useShowTicketBA)(),t=Object(r.a)(e,1)[0],n=Object(s.useMemo)((function(){return{className:"ee-entity-list-status-stripe",key:"stripe",size:"nano",textAlign:"center",value:""}}),[]),a=Object(s.useMemo)((function(){return t&&{key:"checkbox",size:"micro",textAlign:"center",value:Object(i.jsx)("div",{className:"ee-rspnsv-table-hide-on-mobile",children:Object(i.jsx)(b,{})})}}),[t]),o=Object(s.useMemo)((function(){return{key:"id",size:"micro",textAlign:"end",value:Object(c.__)("ID")}}),[]),u=Object(s.useMemo)((function(){return{key:"name",size:"huge",value:Object(c.__)("Name")}}),[]),j=Object(s.useMemo)((function(){return{key:"start",size:"default",value:Object(i.jsxs)(i.Fragment,{children:[Object(i.jsx)("span",{className:"ee-rspnsv-table-long-label",children:Object(c.__)("Goes on Sale")}),Object(i.jsx)("span",{className:"ee-rspnsv-table-short-label",children:Object(c.__)("On Sale")})]})}}),[]),O=Object(s.useMemo)((function(){return{key:"end",size:"default",value:Object(i.jsxs)(i.Fragment,{children:[Object(i.jsx)("span",{className:"ee-rspnsv-table-long-label",children:Object(c.__)("Sale Ends")}),Object(i.jsx)("span",{className:"ee-rspnsv-table-short-label",children:Object(c.__)("Ends")})]})}}),[]),d=Object(s.useMemo)((function(){return{key:"price",size:"tiny",textAlign:"end",value:Object(c.__)("Price")}}),[]),p=Object(s.useMemo)((function(){return{key:"quantity",size:"tiny",textAlign:"end",value:Object(c.__)("Quantity")}}),[]),f=Object(s.useMemo)((function(){return{key:"sold",size:"tiny",textAlign:"end",value:Object(c.__)("Sold")}}),[]),m=Object(s.useMemo)((function(){return{key:"registrations",size:"smaller",textAlign:"center",value:Object(i.jsxs)(i.Fragment,{children:[Object(i.jsx)("span",{className:"ee-rspnsv-table-long-label",children:Object(c.__)("Registrations")}),Object(i.jsx)("span",{className:"ee-rspnsv-table-short-label",children:Object(c.__)("Regs")})]})}}),[]),k=Object(s.useMemo)((function(){return{key:"actions",size:"big",textAlign:"center",value:Object(i.jsxs)(i.Fragment,{children:[Object(i.jsx)("span",{className:"ee-rspnsv-table-long-label",children:Object(c.__)("Actions")}),Object(i.jsx)("span",{className:"ee-rspnsv-table-short-label",children:Object(c.__)("Actions")})]})}}),[]);return Object(s.useCallback)((function(e){var t=e.displayStartOrEndDate;return{cells:[n,a,o,u,j,O,d,p,f,m,k].filter(Boolean).filter(Object(l.filterCellByStartOrEndDate)(t)),className:"ee-editor-ticket-list-items-header-row",key:"ticket-header-row",primary:!0,type:"row"}}),[o,k,a,O,u,d,p,m,f,j,n])},O=n(11),d=n.n(O),p=n(23),f=n(523),m=n.n(f),k=n(218),y=n.n(k),v=n(10),_=n(32),x=n(528),h=n(18),g=n(2930),T=n(2926),C=n(2927),S=n(2925),E=function(){var e=Object(l.useLazyTicket)(),t=Object(l.useShowTicketBA)(),n=Object(r.a)(t,1)[0];return Object(s.useCallback)((function(t){var c=t.entityId,r=t.filterState,s=e(c),o=r.displayStartOrEndDate,u=r.sortingEnabled,j=Object(x.getTicketBackgroundColorClassName)(s),O=s.dbId||Object(h.shortenGuid)(s.id),f=Object(x.ticketStatus)(s),k={className:d()("ee-entity-list-status-stripe",j),key:"stripe",showValueOnMobile:!0,textAlign:"center",value:s.name},E=n&&{key:"cell",size:"micro",textAlign:"center",value:Object(i.jsx)(b,{dbId:s.dbId,id:s.id})},A={key:"id",size:"micro",textAlign:"end",value:O},w={className:"ee-col-name ee-rspnsv-table-hide-on-mobile",key:"name",size:"huge",value:u?s.name:Object(i.jsx)(C.a,{className:"ee-entity-list-text ee-focus-priority-5",entity:s,view:"table"})},B={key:"start",size:"default",value:Object(p.format)(new Date(s.startDate),_.ENTITY_LIST_DATE_TIME_FORMAT)},I={key:"end",size:"default",value:Object(p.format)(new Date(s.endDate),_.ENTITY_LIST_DATE_TIME_FORMAT)},M={key:"price",size:"tiny",textAlign:"end",value:Object(i.jsx)(a.CurrencyDisplay,{value:s.price})},D={key:"sold",size:"tiny",textAlign:"end",value:s.sold},N=[k,E,A,w,B,I,M,{className:"ee-col__inline-edit",key:"quantity",size:"tiny",textAlign:"end",value:u?s.quantity:Object(i.jsx)(T.a,{entity:s})},D,{key:"registrations",size:"smaller",textAlign:"center",value:u?"-":Object(i.jsx)(S.a,{ticket:s})},{key:"actions",size:"big",textAlign:"center",value:u?"-":Object(i.jsx)(g.a,{entity:s})}].filter(Boolean);return{cells:m()(y()(Object(l.filterCellByStartOrEndDate)(o)),Object(v.addZebraStripesOnMobile)(["row","stripe","name","actions"]))(N),className:"ee-editor-date-list-view-row ".concat(f),id:"ee-editor-date-list-view-row-".concat(s.id),key:"row-".concat(s.id),type:"row"}}),[e,n])},A=n(25),w=n(221),B=n(12),I=n(650),M=n.n(I),D=n(2920),N=n(2854),P=n(2921),R=n(58),z=n(65),F=n.n(z),L=n(91),q=n(423),G=n(192),Q=function(){var e=Object(L.a)(F.a.mark((function e(t){return F.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,Object(G.yupToFinalFormErrors)(V,t);case 2:return e.abrupt("return",e.sent);case 3:case"end":return e.stop()}}),e)})));return function(t){return e.apply(this,arguments)}}(),V=q.object({name:q.string().min(3,(function(){return Object(c.__)("Name must be at least three characters")}))}),Y=Object(R.intervalsToOptions)(M()(["months","weeks","days","hours","minutes"],R.DATE_INTERVALS),!0),J=function(e){var t=e.onSubmit,n=Object(s.useCallback)((function(e,n){for(var i=arguments.length,c=new Array(i>2?i-2:0),a=2;a<i;a++)c[a-2]=arguments[a];return t.apply(void 0,[e,n].concat(c))}),[t]),i=Object(A.useMemoStringify)({className:"ee-form-item-pair"});return Object(s.useMemo)((function(){return Object(o.a)(Object(o.a)({},e),{},{onSubmit:n,validate:Q,layout:"horizontal",debugFields:["values","errors"],sections:[{name:"basics",icon:D.a,title:Object(c.__)("Basics"),fields:[{name:"name",label:Object(c.__)("Name"),fieldType:"text",min:3},{name:"description",label:Object(c.__)("Description"),fieldType:"simple-text-editor"}]},{name:"dates",icon:N.a,title:Object(c.__)("Dates"),fields:[{name:"shiftDates",label:Object(c.__)("Shift dates"),fieldType:"group",formControlProps:{className:"shift-dates"},subFields:[{name:"value",fieldType:"number",min:1},{name:"unit",fieldType:"select",options:Y},{name:"type",fieldType:"select",options:[{label:"",value:""},{label:Object(c.__)("earlier"),value:"earlier"},{label:Object(c.__)("later"),value:"later"}]}]}]},{name:"details",icon:P.a,title:Object(c.__)("Details"),fields:[{name:"quantity",label:Object(c.__)("Quantity For Sale"),fieldType:"number",formControlProps:i,parseAsInfinity:!0,max:1e6,min:-1},{name:"uses",label:Object(c.__)("Number of Uses"),fieldType:"number",parseAsInfinity:!0,formControlProps:i,min:0},{name:"min",label:Object(c.__)("Minimum Quantity"),fieldType:"number",formControlProps:i,max:1e6,min:0},{name:"max",label:Object(c.__)("Maximum Quantity"),fieldType:"number",parseAsInfinity:!0,formControlProps:i,max:1e6,min:-1},{name:"isRequired",label:Object(c.__)("Required Ticket"),fieldType:"switch",formControlProps:i}]}]})}),[i,e,n])},K=function(e){var t=Object(u.useBulkEdit)(),n=t.getSelected,i=t.unSelectAll,c=Object(l.useTickets)(),a=Object(l.useBulkEditTickets)().updateEntities;return Object(s.useCallback)((function(t){e(),i();var r=Object(l.formToBulkUpdateInput)(t,c,n());a(r)}),[c,n,e,i,a])},U=function(e){var t=e.onClose,n=e.isOpen,r=K(t),s=J({onSubmit:r});return Object(i.jsx)(a.BulkEditDetails,{formConfig:s,isOpen:n,onClose:t,title:Object(c.__)("Bulk edit ticket details"),warning:Object(c.__)("any changes will be applied to ALL of the selected tickets.")})},W=function(e){var t=e.areTrashedTickets,n=e.onClose,i=Object(u.useBulkEdit)(),c=i.getSelected,a=i.unSelectAll,r=Object(l.useBulkDeleteTickets)();return Object(s.useCallback)((function(){n(),a(),r({entityIds:c(),deletePermanently:t})}),[t,r,c,n,a])},Z=function(e){var t=e.areTrashedTickets,n=e.onClose,a=W({areTrashedTickets:t,onClose:n}),r=Object(v.useConfirmationDialog)({message:t?Object(c.__)("Are you sure you want to permanently delete these tickets? This action can NOT be undone!"):Object(c.__)("Are you sure you want to trash these tickets?"),title:t?Object(c.__)("Delete tickets permanently"):Object(c.__)("Trash tickets"),onConfirm:a,onCancel:n}),l=r.confirmationDialog,o=r.onOpen;return Object(s.useEffect)((function(){return o()}),[]),Object(i.jsx)(i.Fragment,{children:l})},H=n(28),X=function(e){var t=e.setEditMode,n=Object(s.useCallback)((function(){return t("together")}),[t]),a=Object(s.useCallback)((function(){return t("separate")}),[t]);return Object(i.jsxs)(H.Box,{display:"flex",alignItems:"center",justifyContent:"center",height:"100%",children:[Object(i.jsxs)(H.Box,{children:[Object(i.jsx)(v.Button,{onClick:n,buttonText:Object(c.__)("Edit all prices together")}),Object(i.jsx)("p",{children:Object(c.__)("Edit all the selected ticket prices dynamically")})]}),Object(i.jsx)(v.Divider,{orientation:"vertical"}),Object(i.jsxs)(H.Box,{children:[Object(i.jsx)(v.Button,{onClick:a,buttonText:Object(c.__)("Edit prices individually")}),Object(i.jsx)("p",{children:Object(c.__)("Edit prices for each ticket individually")})]})]})},$=function(e){var t=e.onSubmit,n=e.onReset,a=e.onCancel;return Object(i.jsxs)(v.ButtonRow,{fullWidth:!0,horizontalAlign:"right",topBordered:!0,children:[n&&Object(i.jsx)(v.Button,{buttonText:Object(c.__)("Reset"),onClick:n,type:"reset"}),a&&Object(i.jsx)(v.Button,{buttonText:Object(c.__)("Cancel"),onClick:a}),Object(i.jsx)(v.Button,{buttonText:Object(c.__)("Submit"),buttonType:v.ButtonType.PRIMARY,onClick:t,type:"submit"})]})},ee=function(e){var t=Object(w.useDataState)(),n=t.prices,i=t.ticket,c=Object(u.useBulkEdit)().getSelected,a=Object(l.useTicketMutator)().updateEntity,r=Object(w.useMutatePrices)(),o=Object(l.useTicketPrices)(c()),b=Object(l.useBulkDeletePrices)(),j=o.filter(B.isNotDefault);return Object(s.useCallback)(Object(L.a)(F.a.mark((function t(){return F.a.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return e(),t.next=3,b(Object(B.getGuids)(j));case 3:return t.next=5,Promise.all(c().map(function(){var e=Object(L.a)(F.a.mark((function e(t){var c;return F.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,r(n);case 2:return c=e.sent,e.next=5,a({id:t,price:Object(h.parsedAmount)(i.price||0),reverseCalculate:Object(h.toBoolean)(i.reverseCalculate),isTaxable:Object(h.toBoolean)(i.isTaxable),prices:c});case 5:case"end":return e.stop()}}),e)})));return function(t){return e.apply(this,arguments)}}()));case 5:case"end":return t.stop()}}),t)}))),[b,c,r,j,e,n,i,a])},te=Object(w.withContext)((function(e){var t=e.onClose,n=Object(w.useAddDefaultPrices)();Object(s.useEffect)((function(){n()}),[]);var c=ee(t);return Object(i.jsxs)(i.Fragment,{children:[Object(i.jsx)(w.TicketPriceCalculator,{}),Object(i.jsx)($,{onSubmit:c,onReset:n})]})}),{ticketId:""}),ne=function(e){var t=e.setTPCState,n=Object(w.useDataState)(),a=n.ticket,r=n.getData;return Object(s.useEffect)((function(){t(r())}),[r]),Object(i.jsxs)(i.Fragment,{children:[Object(i.jsx)("header",{children:Object(c.sprintf)(Object(c.__)("Edit prices for Ticket: %s"),a.name)}),Object(i.jsx)(w.TicketPriceCalculator,{})]})},ie=n(15),ce=function(e,t){var n=Object(w.useOnSubmitPrices)();return Object(s.useCallback)(Object(L.a)(F.a.mark((function i(){return F.a.wrap((function(i){for(;;)switch(i.prev=i.next){case 0:return e(),i.next=3,Promise.all(Object.values(t()).map(function(){var e=Object(L.a)(F.a.mark((function e(t){return F.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,n(t);case 2:case"end":return e.stop()}}),e)})));return function(t){return e.apply(this,arguments)}}()));case 3:case"end":return i.stop()}}),i)}))),[t,e,n])},ae=function(e){var t=e.onClose,n=Object(u.useBulkEdit)().getSelected,c=function(){var e=Object(s.useRef)({}),t=Object(s.useCallback)((function(t){var n;e.current=Object(o.a)(Object(o.a)({},e.current),{},Object(ie.a)({},null===t||void 0===t||null===(n=t.ticket)||void 0===n?void 0:n.id,t))}),[e]),n=Object(s.useCallback)((function(){return e.current}),[e]);return Object(s.useMemo)((function(){return{setTPCState:t,getDataStates:n}}),[t,n])}(),a=c.getDataStates,r=c.setTPCState,l=ce(t,a),b=n();return Object(i.jsxs)(i.Fragment,{children:[b.map((function(e){var t=Object(w.withContext)(ne,{ticketId:e});return Object(i.jsx)(t,{setTPCState:r},e)})),Object(i.jsx)($,{onSubmit:l,onCancel:t})]})},re=function(e){var t=e.onClose,n=e.isOpen,a=Object(s.useState)(),l=Object(r.a)(a,2),o=l[0],u=l[1];return Object(i.jsxs)(v.EntityEditModal,{isOpen:n,onClose:t,closeOnOverlayClick:!0,title:Object(c.__)("Bulk edit ticket prices"),children:[!o&&Object(i.jsx)(X,{setEditMode:u}),"together"===o&&Object(i.jsx)(te,{onClose:t}),"separate"===o&&Object(i.jsx)(ae,{onClose:t})]})},se=Object(u.withFeature)("use_bulk_edit")((function(){var e=Object(s.useState)(""),t=Object(r.a)(e,2),n=t[0],o=t[1],j=Object(A.useDisclosure)(),O=j.isOpen,d=j.onOpen,p=j.onClose,f=Object(l.useShowTicketBA)(),m=Object(r.a)(f,1)[0],k=Object(l.useTicketsListFilterState)().status,y=Object(u.useBulkEdit)().getSelected,_=Object(l.useTickets)(),x=Object(s.useMemo)((function(){return Object(B.entitiesWithGuIdInArray)(_,y()).some((function(e){return Boolean(e.sold)}))}),[_,y]),h=k===B.TicketsStatus.trashedOnly,g=Object(A.useMemoStringify)([{value:"",label:Object(c.__)("bulk actions")},{value:"edit-details",label:Object(c.__)("edit ticket details")},{value:"delete",label:h?Object(c.__)("delete tickets"):Object(c.__)("trash tickets")},{value:"edit-prices",label:Object(c.__)("edit ticket prices"),disabled:x}]),T=Object(s.useCallback)((function(e){o(e),d()}),[d]);return Object(i.jsxs)(v.Collapsible,{show:m,children:[Object(i.jsx)(a.BulkActions,{Checkbox:b,defaultAction:"",id:"ee-bulk-edit-tickets-actions",onApply:x?null:T,options:g}),O&&Object(i.jsxs)(i.Fragment,{children:["edit-details"===n&&Object(i.jsx)(U,{isOpen:!0,onClose:p}),"delete"===n&&Object(i.jsx)(Z,{areTrashedTickets:h,onClose:p}),"edit-prices"===n&&Object(i.jsx)(re,{isOpen:!0,onClose:p})]}),Object(i.jsx)(v.ErrorMessage,{message:x&&w.SOLD_TICKET_ERROR_MESSAGE,variant:"subtle"})]})}));t.default=Object(u.withBulkEdit)((function(){var e=Object(l.useTicketsListFilterState)(),t=Object(l.useFilteredTicketIds)(),n=Object(l.useReorderTickets)(t).sortResponder,r=E(),s=j();return Object(i.jsxs)(i.Fragment,{children:[Object(i.jsx)(se,{}),Object(i.jsx)(a.EntityTable,{bodyRowGenerator:r,domain:l.domain,entityIds:t,filterState:e,headerRowGenerator:s,listId:l.ticketsList,onSort:n,tableCaption:Object(c.__)("Tickets"),tableId:"ticket-entities-table-view"})]})}))},389:function(e,t,n){var i=n(53)(n(117));e.exports=i},523:function(e,t,n){var i=n(94),c=n(785),a=n(389),r=n(786);e.exports=function(){if(0===arguments.length)throw new Error("pipe requires at least one argument");return i(arguments[0].length,a(c,arguments[0],r(arguments)))}},570:function(e,t,n){var i=n(72);e.exports=function(e,t){return function(){var n=arguments.length;if(0===n)return t();var c=arguments[n-1];return i(c)||"function"!==typeof c[e]?t.apply(this,arguments):c[e].apply(c,Array.prototype.slice.call(arguments,0,n-1))}}},785:function(e,t){e.exports=function(e,t){return function(){return t.call(this,e.apply(this,arguments))}}},786:function(e,t,n){var i=n(570),c=n(29)(i("tail",n(787)(1,1/0)));e.exports=c},787:function(e,t,n){var i=n(570),c=n(53)(i("slice",(function(e,t,n){return Array.prototype.slice.call(n,e,t)})));e.exports=c}}]);
//# sourceMappingURL=tickets-table-view.bc7c02c2.chunk.js.map