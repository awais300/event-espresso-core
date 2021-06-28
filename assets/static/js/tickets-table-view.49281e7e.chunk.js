(this.webpackJsonproot=this.webpackJsonproot||[]).push([[26],{1705:function(e,t,n){"use strict";var i=n(3),c=n(5),a=n(10),s=n(1);t.a=function(e){var t=e.ticket,n=Object(a.useRegistrationsLink)({ticket_id:t.dbId}),r=Object(i.__)("total registrations."),l=Object(i.__)("view ALL registrations for this ticket.");return Object(s.jsx)(c.ItemCount,{count:t.registrationCount,emphasizeZero:!1,title:r,children:Object(s.jsx)(c.RegistrationsLink,{href:n,tooltip:l})})}},1706:function(e,t,n){"use strict";var i=n(0),c=n(3),a=n(11),s=n(5),r=n(10),l=n(1);t.a=function(e){var t=e.entity,n=Object(r.useTicketMutator)(t.id).updateEntity,o=Object(i.useCallback)((function(e){var i=Object(a.parseInfinity)(e);i!==t.quantity&&n({quantity:i})}),[t.quantity,n]);return Object(l.jsx)(s.InlineEditInfinity,{"data-testid":"ee-ticket-inline-qty",onChange:o,tooltip:Object(c.__)("edit quantity of tickets available\u2026"),value:"".concat(t.quantity)})}},1707:function(e,t,n){"use strict";n.d(t,"a",(function(){return l})),n.d(t,"b",(function(){return v}));var i=n(0),c=n(3),a=n(10),s=n(5),r=n(1),l=function(e){var t=e.className,n=e["data-testid"],l=e.entity,o=e.view,u=void 0===o?"card":o,b=Object(a.useTicketMutator)(l.id).updateEntity,j="card"===u&&2,O=Object(i.useCallback)((function(e){e!==l.name&&b({name:e})}),[l.name,b]),d=Object(c.__)("edit title\u2026"),f=l.name||d;return Object(r.jsx)(s.InlineEditText,{className:t,"data-testid":n,lineCount:j,onChange:O,tag:"table"===u?"div":"h4",tooltip:d,value:f})},o=n(24),u=n(57),b=n(23),j=n(20),O=n(9),d=n(82),f=n(26),m=n(2),p=n(40),k=n(29),y=n.n(k),_=function(e){var t=Object(a.useLazyTicket)(),n=Object(a.useTicketPrices)(),c=Object(d.useInitialState)({ticketId:e,getTicket:t,getTicketPrices:n}),s=Object(d.useDefaultBasePrice)(),r=Object(d.useMutatePrices)(),l=Object(a.useTicketMutator)(e).updateEntity;return Object(i.useCallback)(function(){var e=Object(p.a)(y.a.mark((function e(t){var n,i,a,o,u,b,j,p,k;return y.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return i=c(null),a=Object(m.a)(Object(m.a)({},i.ticket),{},{price:t}),i=Object(m.a)(Object(m.a)({},i),{},{ticket:a}),o=Object(O.getBasePrice)(i.prices),u=Object(O.getPriceModifiers)(i.prices),b=Object(d.calculateBasePrice)(null===(n=i.ticket)||void 0===n?void 0:n.price,i.prices),j=o?Object(m.a)(Object(m.a)({},o),{},{isModified:!0}):Object(m.a)(Object(m.a)({},s),{},{order:1,isNew:!0}),p=[Object(m.a)(Object(m.a)({},j),{},{amount:b})].concat(Object(f.a)(u)),e.next=10,r(p);case 10:return k=e.sent,e.next=13,l({price:t,reverseCalculate:!0,prices:k});case 13:case"end":return e.stop()}}),e)})));return function(t){return e.apply(this,arguments)}}(),[s,c,r,l])},v=function(e){var t=e.entity,n=e.className,a=Object(j.useMoneyDisplay)(),l=a.afterAmount,f=a.beforeAmount,m=a.formatAmount,p=_(t.id),k=Object(i.useCallback)((function(e){var n=e.amount,i=Math.abs(n);i!==t.price&&p(i)}),[p,t.price]),y=Object(d.useLockedTicketAction)(t,"COPY/TRASH"),v=y.alertContainer,x=y.showAlert,h=Object(b.useMemoStringify)({className:n}),T=Object(O.isLocked)(t),g=Object(c.__)("edit ticket total\u2026");return T?Object(r.jsxs)(o.Clickable,{as:"div",className:"ee-ticket-editable-price",onClick:x,children:[Object(r.jsx)(u.CurrencyDisplay,{className:n,value:t.price}),v]}):Object(r.jsx)(s.InlineEditCurrency,{afterAmount:l,amount:t.price,beforeAmount:f,formatAmount:m,id:t.id,placeholder:Object(c.__)("set price\u2026"),wrapperProps:h,onChange:k,tag:"h3",tooltip:g})}},1710:function(e,t,n){"use strict";var i=n(2),c=n(6),a=n(5),s=n(422),r=function(e){return Object(s.b)("ticket",e)},l=n(1);t.a=function(e){var t=e.entity,n=Object(c.a)(e,["entity"]),s=r(t);return Object(l.jsx)(a.EntityActionsMenu,Object(i.a)(Object(i.a)({},n),{},{menuItems:s}))}},1711:function(e,t,n){"use strict";n.r(t);var i=n(3),c=n(57),a=n(0),s=n(10),r=n(2),l=n(7),o=n(20),u=n(1),b=Object(o.withFeature)("use_bulk_edit")((function(e){var t=Object(s.useVisibleTicketIds)(),n=Object(l.a)(t,1)[0];return Object(u.jsx)(c.ActionCheckbox,Object(r.a)(Object(r.a)({},e),{},{visibleEntityIds:n}))})),j=function(){var e=Object(a.useMemo)((function(){return{className:"ee-entity-list-status-stripe",key:"stripe",size:"nano",textAlign:"center",value:""}}),[]),t=Object(a.useMemo)((function(){return{key:"id",size:"micro",textAlign:"end",value:Object(i.__)("ID")}}),[]),n=Object(a.useMemo)((function(){return{key:"name",size:"huge",value:Object(i.__)("Name")}}),[]),c=Object(a.useMemo)((function(){return{key:"start",size:"default",value:Object(u.jsxs)(u.Fragment,{children:[Object(u.jsx)("span",{className:"ee-rspnsv-table-long-label",children:Object(i.__)("Goes on Sale")}),Object(u.jsx)("span",{className:"ee-rspnsv-table-short-label",children:Object(i.__)("On Sale")})]})}}),[]),r=Object(a.useMemo)((function(){return{key:"end",size:"default",value:Object(u.jsxs)(u.Fragment,{children:[Object(u.jsx)("span",{className:"ee-rspnsv-table-long-label",children:Object(i.__)("Sale Ends")}),Object(u.jsx)("span",{className:"ee-rspnsv-table-short-label",children:Object(i.__)("Ends")})]})}}),[]),l=Object(a.useMemo)((function(){return{key:"price",size:"tiny",textAlign:"end",value:Object(i.__)("Price")}}),[]),o=Object(a.useMemo)((function(){return{key:"quantity",size:"tiny",textAlign:"end",value:Object(i.__)("Quantity")}}),[]),j=Object(a.useMemo)((function(){return{key:"sold",size:"tiny",textAlign:"end",value:Object(i.__)("Sold")}}),[]),O=Object(a.useMemo)((function(){return{key:"registrations",size:"smaller",textAlign:"center",value:Object(u.jsxs)(u.Fragment,{children:[Object(u.jsx)("span",{className:"ee-rspnsv-table-long-label",children:Object(i.__)("Registrations")}),Object(u.jsx)("span",{className:"ee-rspnsv-table-short-label",children:Object(i.__)("Regs")})]})}}),[]),d=Object(a.useMemo)((function(){return{key:"actions",size:"big",textAlign:"center",value:Object(u.jsxs)(u.Fragment,{children:[Object(u.jsx)("span",{className:"ee-rspnsv-table-long-label",children:Object(i.__)("Actions")}),Object(u.jsx)("span",{className:"ee-rspnsv-table-short-label",children:Object(i.__)("Actions")})]})}}),[]);return Object(a.useCallback)((function(i){var a=i.displayStartOrEndDate,f=i.showBulkActions;return{cells:[e,f&&{key:"checkbox",size:"micro",textAlign:"center",value:Object(u.jsx)("div",{className:"ee-rspnsv-table-hide-on-mobile",children:Object(u.jsx)(b,{})})},t,n,c,r,l,o,j,O,d].filter(Boolean).filter(Object(s.filterCellByStartOrEndDate)(a)),className:"ee-editor-ticket-list-items-header-row",key:"ticket-header-row",primary:!0,type:"row"}}),[t,d,r,n,l,o,O,j,c,e])},O=n(8),d=n.n(O),f=n(101),m=n(4),p=n(5),k=n(28),y=n(303),_=n(9),v=n(1710),x=n(1706),h=n(1707),T=n(1705),g=function(){var e=Object(s.useTickets)(),t=Object(a.useCallback)((function(t){return Object(_.findEntityByGuid)(e)(t)}),[e]),n=Object(s.useLazyTicket)(),i=Object(o.useTimeZoneTime)().formatForSite;return Object(a.useCallback)((function(e){var a=e.entityId,r=e.filterState,l=t(a)||n(a),o=r.displayStartOrEndDate,j=r.showBulkActions,O=Object(y.getTicketBackgroundColorClassName)(l),_=l.dbId||0,g=Object(y.ticketStatus)(l),C={className:d()("ee-entity-list-status-stripe",O),key:"stripe",showValueOnMobile:!0,textAlign:"center",value:l.name},w=j&&{key:"cell",size:"micro",textAlign:"center",value:Object(u.jsx)(b,{dbId:l.dbId,id:l.id})},A={key:"id",size:"micro",textAlign:"end",value:_},S={className:"ee-col-name ee-rspnsv-table-hide-on-mobile",key:"name",size:"huge",value:Object(u.jsx)(h.a,{className:"ee-entity-name ee-entity-list-text ee-focus-priority-5","data-testid":"ee-entity-list-view-row-editable-".concat(l.dbId),entity:l,view:"table"})},E={key:"start",size:"default",value:i(Object(f.default)(l.startDate),k.ENTITY_LIST_DATE_TIME_FORMAT)},I={key:"end",size:"default",value:i(Object(f.default)(l.endDate),k.ENTITY_LIST_DATE_TIME_FORMAT)},M={key:"price",size:"tiny",textAlign:"end",value:Object(u.jsx)(c.CurrencyDisplay,{value:l.price})},B={key:"sold",size:"tiny",textAlign:"end",value:l.sold},N=[C,w,A,S,E,I,M,{className:"ee-col__inline-edit",key:"quantity",size:"tiny",textAlign:"end",value:Object(u.jsx)(x.a,{entity:l})},B,{key:"registrations",size:"smaller",textAlign:"center",value:Object(u.jsx)(T.a,{ticket:l})},{key:"actions",size:"big",textAlign:"center",value:Object(u.jsx)(v.a,{entity:l})}].filter(Boolean);return{cells:m.pipe(m.filter(Object(s.filterCellByStartOrEndDate)(o)),Object(p.addZebraStripesOnMobile)(["row","stripe","name","actions"]))(N),className:"ee-editor-ticket-list-view-row ".concat(g),"data-testid":"ee-ticket-list-view-row-".concat(l.dbId),id:"ee-editor-ticket-list-view-row-".concat(l.id),key:"row-".concat(l.id),rowClassName:"ee-entity-list-item",type:"row"}}),[i,n,t])},C=n(23),w=n(82),A=n(1691),S=n(1596),E=n(1692),I=n(44),M=n(40),B=n(29),N=n.n(B),D=n(206),P=n(73),z=function(){var e=Object(M.a)(N.a.mark((function e(t){return N.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,Object(P.yupToFinalFormErrors)(R,t);case 2:return e.abrupt("return",e.sent);case 3:case"end":return e.stop()}}),e)})));return function(t){return e.apply(this,arguments)}}(),R=D.b({name:D.c().min(3,(function(){return Object(i.__)("Name must be at least three characters")}))}),F=Object(I.intervalsToOptions)(m.pick(["months","weeks","days","hours","minutes"],I.DATE_INTERVALS),!0),L=function(e){var t=e.onSubmit,n=Object(a.useCallback)((function(e,n){for(var i=arguments.length,c=new Array(i>2?i-2:0),a=2;a<i;a++)c[a-2]=arguments[a];return t.apply(void 0,[e,n].concat(c))}),[t]),c=Object(C.useMemoStringify)({className:"ee-form-item-pair"});return Object(a.useMemo)((function(){return Object(r.a)(Object(r.a)({},e),{},{onSubmit:n,validate:z,layout:"horizontal",debugFields:["values","errors"],sections:[{name:"basics",icon:A.a,title:Object(i.__)("Basics"),fields:[{name:"name",label:Object(i.__)("Name"),fieldType:"text",min:3},{name:"description",label:Object(i.__)("Description"),fieldType:"simple-text-editor"}]},{name:"dates",icon:S.a,title:Object(i.__)("Dates"),fields:[{name:"shiftDates",label:Object(i.__)("Shift dates"),fieldType:"group",formControlProps:{className:"shift-dates"},subFields:[{name:"value",fieldType:"number",min:1},{name:"unit",fieldType:"select",options:F},{name:"type",fieldType:"select",options:[{label:"",value:""},{label:Object(i.__)("earlier"),value:"earlier"},{label:Object(i.__)("later"),value:"later"}]}]}]},{name:"details",icon:E.a,title:Object(i.__)("Details"),fields:[{name:"quantity",label:Object(i.__)("Quantity For Sale"),fieldType:"number",formControlProps:c,parseAsInfinity:!0,max:1e6,min:-1},{name:"uses",label:Object(i.__)("Number of Uses"),fieldType:"number",parseAsInfinity:!0,formControlProps:c,min:0},{name:"min",label:Object(i.__)("Minimum Quantity"),fieldType:"number",formControlProps:c,max:1e6,min:0},{name:"max",label:Object(i.__)("Maximum Quantity"),fieldType:"number",parseAsInfinity:!0,formControlProps:c,max:1e6,min:-1},{name:"isRequired",label:Object(i.__)("Required Ticket"),fieldType:"switch",formControlProps:c}]}]})}),[c,e,n])},q=function(e){var t=Object(o.useBulkEdit)(),n=t.getSelected,i=t.unSelectAll,c=Object(s.useTickets)(),r=Object(s.useBulkEditTickets)().updateEntities;return Object(a.useCallback)((function(t){e(),i();var a=Object(s.formToBulkUpdateInput)(t,c,n());r(a)}),[c,n,e,i,r])},G=function(e){var t=e.onClose,n=e.isOpen,a=q(t),s=L({onSubmit:a});return Object(u.jsx)(c.BulkEditDetails,{formConfig:s,isOpen:n,onClose:t,title:Object(i.__)("Bulk edit ticket details"),warning:Object(i.__)("any changes will be applied to ALL of the selected tickets.")})},Q=function(e){var t=e.areTrashedTickets,n=e.onClose,i=Object(o.useBulkEdit)(),c=i.getSelected,r=i.unSelectAll,l=Object(s.useBulkDeleteTickets)();return Object(a.useCallback)((function(){n(),r(),l({entityIds:c(),deletePermanently:t})}),[t,l,c,n,r])},Y=function(e){var t=e.areTrashedTickets,n=e.onClose,c=Q({areTrashedTickets:t,onClose:n}),s=Object(p.useConfirmationDialog)({message:t?Object(i.__)("Are you sure you want to permanently delete these tickets? This action can NOT be undone!"):Object(i.__)("Are you sure you want to trash these tickets?"),title:t?Object(i.__)("Delete tickets permanently"):Object(i.__)("Trash tickets"),onConfirm:c,onCancel:n}),r=s.confirmationDialog,l=s.onOpen;return Object(a.useEffect)((function(){return l()}),[]),Object(u.jsx)(u.Fragment,{children:r})},V=n(24),Z=function(e){var t=e.setEditMode,n=Object(a.useCallback)((function(){return t("together")}),[t]),c=Object(a.useCallback)((function(){return t("separate")}),[t]);return Object(u.jsxs)(V.Box,{display:"flex",alignItems:"center",justifyContent:"center",height:"100%",children:[Object(u.jsxs)(V.Box,{children:[Object(u.jsx)(p.Button,{onClick:n,buttonText:Object(i.__)("Edit all prices together")}),Object(u.jsx)("p",{children:Object(i.__)("Edit all the selected ticket prices dynamically")})]}),Object(u.jsx)(p.Divider,{orientation:"vertical"}),Object(u.jsxs)(V.Box,{children:[Object(u.jsx)(p.Button,{onClick:c,buttonText:Object(i.__)("Edit prices individually")}),Object(u.jsx)("p",{children:Object(i.__)("Edit prices for each ticket individually")})]})]})},J=function(e){var t=e.onSubmit,n=e.onReset,c=e.onCancel;return Object(u.jsxs)(p.ButtonRow,{fullWidth:!0,horizontalAlign:"right",topBordered:!0,children:[n&&Object(u.jsx)(p.Button,{buttonText:Object(i.__)("Reset"),onClick:n,type:"reset"}),c&&Object(u.jsx)(p.Button,{buttonText:Object(i.__)("Cancel"),onClick:c}),Object(u.jsx)(p.Button,{buttonText:Object(i.__)("Submit"),buttonType:p.ButtonType.PRIMARY,onClick:t,type:"submit"})]})},U=n(26),W=function(e){var t=Object(w.useDataState)(),n=t.prices,i=t.ticket,c=Object(o.useBulkEdit)().getSelected,l=Object(w.useMutateTicket)(),u=Object(s.useTicketPrices)(),b=Object(s.useBulkDeletePrices)();return Object(a.useCallback)(Object(M.a)(N.a.mark((function t(){var a,s;return N.a.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return e(),a=c().reduce((function(e,t){return[].concat(Object(U.a)(e),Object(U.a)(u(t)))}),[]),s=a.filter(_.isNotDefault),t.next=5,b(Object(_.getGuids)(s));case 5:return t.next=7,Promise.all(c().map(function(){var e=Object(M.a)(N.a.mark((function e(t){return N.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,l(Object(r.a)(Object(r.a)({},i),{},{id:t,isModified:!0,prices:n}));case 2:case"end":return e.stop()}}),e)})));return function(t){return e.apply(this,arguments)}}()));case 7:case"end":return t.stop()}}),t)}))),[b,c,u,l,e,n,i])},H=Object(w.withContext)((function(e){var t=e.onClose,n=Object(w.useAddDefaultPrices)();Object(a.useEffect)((function(){n()}),[]);var i=W(t);return Object(u.jsxs)(u.Fragment,{children:[Object(u.jsx)(w.TicketPriceCalculator,{}),Object(u.jsx)(J,{onSubmit:i,onReset:n})]})}),{ticketId:""}),K=function(e){var t=e.setTPCState,n=Object(w.useDataState)(),c=n.ticket,s=n.getData;return Object(a.useEffect)((function(){t(s())}),[s]),Object(u.jsxs)(u.Fragment,{children:[Object(u.jsx)("header",{children:Object(i.sprintf)(Object(i.__)("Edit prices for Ticket: %s"),c.name)}),Object(u.jsx)(w.TicketPriceCalculator,{})]})},X=n(16),$=function(e,t){var n=Object(w.useOnSubmitPrices)();return Object(a.useCallback)(Object(M.a)(N.a.mark((function i(){return N.a.wrap((function(i){for(;;)switch(i.prev=i.next){case 0:return e(),i.next=3,Promise.all(Object.values(t()).map(function(){var e=Object(M.a)(N.a.mark((function e(t){return N.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,n(t);case 2:case"end":return e.stop()}}),e)})));return function(t){return e.apply(this,arguments)}}()));case 3:case"end":return i.stop()}}),i)}))),[t,e,n])},ee=function(e){var t=e.onClose,n=Object(o.useBulkEdit)().getSelected,i=function(){var e=Object(a.useRef)({}),t=Object(a.useCallback)((function(t){var n;e.current=Object(r.a)(Object(r.a)({},e.current),{},Object(X.a)({},null===t||void 0===t||null===(n=t.ticket)||void 0===n?void 0:n.id,t))}),[e]),n=Object(a.useCallback)((function(){return e.current}),[e]);return Object(a.useMemo)((function(){return{setTPCState:t,getDataStates:n}}),[t,n])}(),c=i.getDataStates,s=i.setTPCState,l=$(t,c),b=n();return Object(u.jsxs)(u.Fragment,{children:[b.map((function(e){var t=Object(w.withContext)(K,{ticketId:e});return Object(u.jsx)(t,{setTPCState:s},e)})),Object(u.jsx)(J,{onSubmit:l,onCancel:t})]})},te=function(e){var t=e.onClose,n=e.isOpen,c=Object(a.useState)(),s=Object(l.a)(c,2),r=s[0],o=s[1];return Object(u.jsxs)(p.EntityEditModal,{isOpen:n,onClose:t,closeOnOverlayClick:!0,title:Object(i.__)("Bulk edit ticket prices"),children:[!r&&Object(u.jsx)(Z,{setEditMode:o}),"together"===r&&Object(u.jsx)(H,{onClose:t}),"separate"===r&&Object(u.jsx)(ee,{onClose:t})]})},ne=Object(o.withFeature)("use_bulk_edit")((function(){var e=Object(a.useState)(""),t=Object(l.a)(e,2),n=t[0],r=t[1],j=Object(C.useDisclosure)(),O=j.isOpen,d=j.onOpen,f=j.onClose,m=Object(s.useTicketsListFilterState)(),k=m.status,y=m.showBulkActions,v=Object(o.useBulkEdit)().getSelected,x=Object(s.useTickets)(),h=Object(a.useMemo)((function(){return Object(_.entitiesWithGuIdInArray)(x,v()).some((function(e){return Boolean(e.sold)}))}),[x,v]),T=k===_.TicketsStatus.trashedOnly,g=Object(C.useMemoStringify)([{value:"",label:Object(i.__)("bulk actions")},{value:"edit-details",label:Object(i.__)("edit ticket details")},{value:"delete",label:T?Object(i.__)("delete tickets"):Object(i.__)("trash tickets")},{value:"edit-prices",label:Object(i.__)("edit ticket prices"),disabled:h}]),A=Object(a.useCallback)((function(e){r(e),d()}),[d]);return Object(u.jsxs)(p.Collapsible,{show:y,children:[Object(u.jsx)(c.BulkActions,{Checkbox:b,defaultAction:"",id:"ee-bulk-edit-tickets-actions",onApply:h?null:A,options:g}),O&&Object(u.jsxs)(u.Fragment,{children:["edit-details"===n&&Object(u.jsx)(G,{isOpen:!0,onClose:f}),"delete"===n&&Object(u.jsx)(Y,{areTrashedTickets:T,onClose:f}),"edit-prices"===n&&Object(u.jsx)(te,{isOpen:!0,onClose:f})]}),Object(u.jsx)(p.ErrorMessage,{message:h&&w.SOLD_TICKET_ERROR_MESSAGE,variant:"subtle"})]})}));t.default=Object(o.withBulkEdit)((function(){var e=Object(s.useTicketsListFilterState)(),t=Object(s.useFilteredTicketIds)(),n=Object(s.useReorderTickets)(t).sortResponder,a=g(),r=j();return Object(u.jsxs)(u.Fragment,{children:[Object(u.jsx)(ne,{}),Object(u.jsx)(c.EntityTable,{bodyRowGenerator:a,domain:s.domain,entityIds:t,filterState:e,headerRowGenerator:r,listId:s.ticketsList,onSort:n,tableCaption:Object(i.__)("Tickets"),tableId:"ticket-entities-table-view"})]})}))}}]);
//# sourceMappingURL=tickets-table-view.49281e7e.chunk.js.map