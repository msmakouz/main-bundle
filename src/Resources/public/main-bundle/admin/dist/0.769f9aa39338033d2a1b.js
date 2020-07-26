(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[0],{

/***/ "./node_modules/ngx-bootstrap/buttons/fesm5/ngx-bootstrap-buttons.js":
/*!***************************************************************************!*\
  !*** ./node_modules/ngx-bootstrap/buttons/fesm5/ngx-bootstrap-buttons.js ***!
  \***************************************************************************/
/*! exports provided: ButtonCheckboxDirective, ButtonRadioDirective, ButtonRadioGroupDirective, ButtonsModule, ɵa, ɵb, ɵc */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "ButtonCheckboxDirective", function() { return ButtonCheckboxDirective; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "ButtonRadioDirective", function() { return ButtonRadioDirective; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "ButtonRadioGroupDirective", function() { return ButtonRadioGroupDirective; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "ButtonsModule", function() { return ButtonsModule; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "ɵa", function() { return CHECKBOX_CONTROL_VALUE_ACCESSOR; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "ɵb", function() { return RADIO_CONTROL_VALUE_ACCESSOR; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "ɵc", function() { return RADIO_CONTROL_VALUE_ACCESSOR$1; });
/* harmony import */ var _angular_core__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @angular/core */ "./node_modules/@angular/core/fesm5/core.js");
/* harmony import */ var _angular_forms__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @angular/forms */ "./node_modules/@angular/forms/fesm5/forms.js");


/**
 * @fileoverview added by tsickle
 * @suppress {checkTypes,extraRequire,missingOverride,missingReturn,unusedPrivateMembers,uselessCode} checked by tsc
 */
// TODO: config: activeClass - Class to apply to the checked buttons
/** @type {?} */
var CHECKBOX_CONTROL_VALUE_ACCESSOR = {
    provide: _angular_forms__WEBPACK_IMPORTED_MODULE_1__["NG_VALUE_ACCESSOR"],
    /* tslint:disable-next-line: no-use-before-declare */
    useExisting: Object(_angular_core__WEBPACK_IMPORTED_MODULE_0__["forwardRef"])(( /**
     * @return {?}
     */function () { return ButtonCheckboxDirective; })),
    multi: true
};
/**
 * Add checkbox functionality to any element
 */
var ButtonCheckboxDirective = /** @class */ /*@__PURE__*/ (function () {
    function ButtonCheckboxDirective() {
        /**
         * Truthy value, will be set to ngModel
         */
        this.btnCheckboxTrue = true;
        /**
         * Falsy value, will be set to ngModel
         */
        this.btnCheckboxFalse = false;
        this.state = false;
        this.onChange = Function.prototype;
        this.onTouched = Function.prototype;
    }
    // view -> model
    // view -> model
    /**
     * @return {?}
     */
    ButtonCheckboxDirective.prototype.onClick =
        // view -> model
        /**
         * @return {?}
         */
        function () {
            if (this.isDisabled) {
                return;
            }
            this.toggle(!this.state);
            this.onChange(this.value);
        };
    /**
     * @return {?}
     */
    ButtonCheckboxDirective.prototype.ngOnInit = /**
     * @return {?}
     */
        function () {
            this.toggle(this.trueValue === this.value);
        };
    Object.defineProperty(ButtonCheckboxDirective.prototype, "trueValue", {
        get: /**
         * @protected
         * @return {?}
         */ function () {
            return typeof this.btnCheckboxTrue !== 'undefined'
                ? this.btnCheckboxTrue
                : true;
        },
        enumerable: true,
        configurable: true
    });
    Object.defineProperty(ButtonCheckboxDirective.prototype, "falseValue", {
        get: /**
         * @protected
         * @return {?}
         */ function () {
            return typeof this.btnCheckboxFalse !== 'undefined'
                ? this.btnCheckboxFalse
                : false;
        },
        enumerable: true,
        configurable: true
    });
    /**
     * @param {?} state
     * @return {?}
     */
    ButtonCheckboxDirective.prototype.toggle = /**
     * @param {?} state
     * @return {?}
     */
        function (state) {
            this.state = state;
            this.value = this.state ? this.trueValue : this.falseValue;
        };
    // ControlValueAccessor
    // model -> view
    // ControlValueAccessor
    // model -> view
    /**
     * @param {?} value
     * @return {?}
     */
    ButtonCheckboxDirective.prototype.writeValue =
        // ControlValueAccessor
        // model -> view
        /**
         * @param {?} value
         * @return {?}
         */
        function (value) {
            this.state = this.trueValue === value;
            this.value = value ? this.trueValue : this.falseValue;
        };
    /**
     * @param {?} isDisabled
     * @return {?}
     */
    ButtonCheckboxDirective.prototype.setDisabledState = /**
     * @param {?} isDisabled
     * @return {?}
     */
        function (isDisabled) {
            this.isDisabled = isDisabled;
        };
    /**
     * @param {?} fn
     * @return {?}
     */
    ButtonCheckboxDirective.prototype.registerOnChange = /**
     * @param {?} fn
     * @return {?}
     */
        function (fn) {
            this.onChange = fn;
        };
    /**
     * @param {?} fn
     * @return {?}
     */
    ButtonCheckboxDirective.prototype.registerOnTouched = /**
     * @param {?} fn
     * @return {?}
     */
        function (fn) {
            this.onTouched = fn;
        };
    return ButtonCheckboxDirective;
}());
/**
 * @fileoverview added by tsickle
 * @suppress {checkTypes,extraRequire,missingOverride,missingReturn,unusedPrivateMembers,uselessCode} checked by tsc
 */
/** @type {?} */
var RADIO_CONTROL_VALUE_ACCESSOR = {
    provide: _angular_forms__WEBPACK_IMPORTED_MODULE_1__["NG_VALUE_ACCESSOR"],
    /* tslint:disable-next-line: no-use-before-declare */
    useExisting: Object(_angular_core__WEBPACK_IMPORTED_MODULE_0__["forwardRef"])(( /**
     * @return {?}
     */function () { return ButtonRadioGroupDirective; })),
    multi: true
};
/**
 * A group of radio buttons.
 * A value of a selected button is bound to a variable specified via ngModel.
 */
var ButtonRadioGroupDirective = /** @class */ /*@__PURE__*/ (function () {
    function ButtonRadioGroupDirective(cdr) {
        this.cdr = cdr;
        this.onChange = Function.prototype;
        this.onTouched = Function.prototype;
    }
    Object.defineProperty(ButtonRadioGroupDirective.prototype, "value", {
        get: /**
         * @return {?}
         */ function () {
            return this._value;
        },
        set: /**
         * @param {?} value
         * @return {?}
         */ function (value) {
            this._value = value;
        },
        enumerable: true,
        configurable: true
    });
    /**
     * @param {?} value
     * @return {?}
     */
    ButtonRadioGroupDirective.prototype.writeValue = /**
     * @param {?} value
     * @return {?}
     */
        function (value) {
            this._value = value;
            this.cdr.markForCheck();
        };
    /**
     * @param {?} fn
     * @return {?}
     */
    ButtonRadioGroupDirective.prototype.registerOnChange = /**
     * @param {?} fn
     * @return {?}
     */
        function (fn) {
            this.onChange = fn;
        };
    /**
     * @param {?} fn
     * @return {?}
     */
    ButtonRadioGroupDirective.prototype.registerOnTouched = /**
     * @param {?} fn
     * @return {?}
     */
        function (fn) {
            this.onTouched = fn;
        };
    return ButtonRadioGroupDirective;
}());
/**
 * @fileoverview added by tsickle
 * @suppress {checkTypes,extraRequire,missingOverride,missingReturn,unusedPrivateMembers,uselessCode} checked by tsc
 */
/** @type {?} */
var RADIO_CONTROL_VALUE_ACCESSOR$1 = {
    provide: _angular_forms__WEBPACK_IMPORTED_MODULE_1__["NG_VALUE_ACCESSOR"],
    /* tslint:disable-next-line: no-use-before-declare */
    useExisting: Object(_angular_core__WEBPACK_IMPORTED_MODULE_0__["forwardRef"])(( /**
     * @return {?}
     */function () { return ButtonRadioDirective; })),
    multi: true
};
/**
 * Create radio buttons or groups of buttons.
 * A value of a selected button is bound to a variable specified via ngModel.
 */
var ButtonRadioDirective = /** @class */ /*@__PURE__*/ (function () {
    function ButtonRadioDirective(el, cdr, group, renderer) {
        this.el = el;
        this.cdr = cdr;
        this.group = group;
        this.renderer = renderer;
        this.onChange = Function.prototype;
        this.onTouched = Function.prototype;
    }
    Object.defineProperty(ButtonRadioDirective.prototype, "value", {
        /** Current value of radio component or group */
        get: /**
         * Current value of radio component or group
         * @return {?}
         */ function () {
            return this.group ? this.group.value : this._value;
        },
        set: /**
         * @param {?} value
         * @return {?}
         */ function (value) {
            if (this.group) {
                this.group.value = value;
                return;
            }
            this._value = value;
        },
        enumerable: true,
        configurable: true
    });
    Object.defineProperty(ButtonRadioDirective.prototype, "disabled", {
        /** If `true` — radio button is disabled */
        get: /**
         * If `true` — radio button is disabled
         * @return {?}
         */ function () {
            return this._disabled;
        },
        set: /**
         * @param {?} disabled
         * @return {?}
         */ function (disabled) {
            this._disabled = disabled;
            this.setDisabledState(disabled);
        },
        enumerable: true,
        configurable: true
    });
    Object.defineProperty(ButtonRadioDirective.prototype, "isActive", {
        get: /**
         * @return {?}
         */ function () {
            return this.btnRadio === this.value;
        },
        enumerable: true,
        configurable: true
    });
    /**
     * @return {?}
     */
    ButtonRadioDirective.prototype.onClick = /**
     * @return {?}
     */
        function () {
            if (this.el.nativeElement.attributes.disabled || !this.uncheckable && this.btnRadio === this.value) {
                return;
            }
            this.value = this.uncheckable && this.btnRadio === this.value ? undefined : this.btnRadio;
            this._onChange(this.value);
        };
    /**
     * @return {?}
     */
    ButtonRadioDirective.prototype.ngOnInit = /**
     * @return {?}
     */
        function () {
            this.uncheckable = typeof this.uncheckable !== 'undefined';
        };
    /**
     * @return {?}
     */
    ButtonRadioDirective.prototype.onBlur = /**
     * @return {?}
     */
        function () {
            this.onTouched();
        };
    /**
     * @param {?} value
     * @return {?}
     */
    ButtonRadioDirective.prototype._onChange = /**
     * @param {?} value
     * @return {?}
     */
        function (value) {
            if (this.group) {
                this.group.onTouched();
                this.group.onChange(value);
                return;
            }
            this.onTouched();
            this.onChange(value);
        };
    // ControlValueAccessor
    // model -> view
    // ControlValueAccessor
    // model -> view
    /**
     * @param {?} value
     * @return {?}
     */
    ButtonRadioDirective.prototype.writeValue =
        // ControlValueAccessor
        // model -> view
        /**
         * @param {?} value
         * @return {?}
         */
        function (value) {
            this.value = value;
            this.cdr.markForCheck();
        };
    /**
     * @param {?} fn
     * @return {?}
     */
    ButtonRadioDirective.prototype.registerOnChange = /**
     * @param {?} fn
     * @return {?}
     */
        function (fn) {
            this.onChange = fn;
        };
    /**
     * @param {?} fn
     * @return {?}
     */
    ButtonRadioDirective.prototype.registerOnTouched = /**
     * @param {?} fn
     * @return {?}
     */
        function (fn) {
            this.onTouched = fn;
        };
    /**
     * @param {?} disabled
     * @return {?}
     */
    ButtonRadioDirective.prototype.setDisabledState = /**
     * @param {?} disabled
     * @return {?}
     */
        function (disabled) {
            if (disabled) {
                this.renderer.setAttribute(this.el.nativeElement, 'disabled', 'disabled');
                return;
            }
            this.renderer.removeAttribute(this.el.nativeElement, 'disabled');
        };
    return ButtonRadioDirective;
}());
/**
 * @fileoverview added by tsickle
 * @suppress {checkTypes,extraRequire,missingOverride,missingReturn,unusedPrivateMembers,uselessCode} checked by tsc
 */
var ButtonsModule = /** @class */ /*@__PURE__*/ (function () {
    function ButtonsModule() {
    }
    /**
     * @return {?}
     */
    ButtonsModule.forRoot = /**
     * @return {?}
     */
        function () {
            return { ngModule: ButtonsModule, providers: [] };
        };
    return ButtonsModule;
}());






/***/ }),

/***/ "./src/app/dashboard/components/dashboard.component.ngfactory.js":
/*!***********************************************************************!*\
  !*** ./src/app/dashboard/components/dashboard.component.ngfactory.js ***!
  \***********************************************************************/
/*! exports provided: RenderType_DashboardComponent, View_DashboardComponent_0, View_DashboardComponent_Host_0, DashboardComponentNgFactory */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "RenderType_DashboardComponent", function() { return RenderType_DashboardComponent; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "View_DashboardComponent_0", function() { return View_DashboardComponent_0; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "View_DashboardComponent_Host_0", function() { return View_DashboardComponent_Host_0; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "DashboardComponentNgFactory", function() { return DashboardComponentNgFactory; });
/* harmony import */ var _angular_core__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @angular/core */ "./node_modules/@angular/core/fesm5/core.js");
/* harmony import */ var _widgets_card_progressbar_component_ngfactory__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./widgets/card-progressbar.component.ngfactory */ "./src/app/dashboard/components/widgets/card-progressbar.component.ngfactory.js");
/* harmony import */ var _shared_widgets_service__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../shared/widgets.service */ "./src/app/dashboard/shared/widgets.service.ts");
/* harmony import */ var _widgets_card_progressbar_component__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./widgets/card-progressbar.component */ "./src/app/dashboard/components/widgets/card-progressbar.component.ts");
/* harmony import */ var _widgets_table_component_ngfactory__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./widgets/table.component.ngfactory */ "./src/app/dashboard/components/widgets/table.component.ngfactory.js");
/* harmony import */ var _widgets_table_component__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./widgets/table.component */ "./src/app/dashboard/components/widgets/table.component.ts");
/* harmony import */ var _angular_common__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! @angular/common */ "./node_modules/@angular/common/fesm5/common.js");
/* harmony import */ var _dashboard_component__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ./dashboard.component */ "./src/app/dashboard/components/dashboard.component.ts");
/* harmony import */ var _ngneat_transloco__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! @ngneat/transloco */ "./node_modules/@ngneat/transloco/fesm5/ngneat-transloco.js");
/* harmony import */ var _angular_common_http__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! @angular/common/http */ "./node_modules/@angular/common/fesm5/http.js");
/* harmony import */ var _angular_platform_browser__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! @angular/platform-browser */ "./node_modules/@angular/platform-browser/fesm5/platform-browser.js");
/* harmony import */ var _angular_router__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! @angular/router */ "./node_modules/@angular/router/fesm5/router.js");
/**
 * @fileoverview This file was generated by the Angular template compiler. Do not edit.
 *
 * @suppress {suspiciousCode,uselessCode,missingProperties,missingOverride,checkTypes}
 * tslint:disable
 */












var styles_DashboardComponent = [];
var RenderType_DashboardComponent = /*@__PURE__*/ _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵcrt"]({ encapsulation: 2, styles: styles_DashboardComponent, data: {} });

function View_DashboardComponent_2(_l) { return _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵvid"](0, [(_l()(), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵeld"](0, 0, null, null, 3, "div", [["class", "card"]], null, null, null, null, null)), (_l()(), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵeld"](1, 0, null, null, 2, "app-card-progressbar-widget", [], null, null, null, _widgets_card_progressbar_component_ngfactory__WEBPACK_IMPORTED_MODULE_1__["View_CardProgressbarComponent_0"], _widgets_card_progressbar_component_ngfactory__WEBPACK_IMPORTED_MODULE_1__["RenderType_CardProgressbarComponent"])), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵprd"](512, null, _shared_widgets_service__WEBPACK_IMPORTED_MODULE_2__["WidgetsService"], _shared_widgets_service__WEBPACK_IMPORTED_MODULE_2__["WidgetsService"], []), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵdid"](3, 49152, null, 0, _widgets_card_progressbar_component__WEBPACK_IMPORTED_MODULE_3__["CardProgressbarComponent"], [_shared_widgets_service__WEBPACK_IMPORTED_MODULE_2__["WidgetsService"]], { widget: [0, "widget"] }, null)], function (_ck, _v) { var currVal_0 = _v.parent.context.$implicit; _ck(_v, 3, 0, currVal_0); }, null); }
function View_DashboardComponent_3(_l) { return _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵvid"](0, [(_l()(), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵeld"](0, 0, null, null, 3, "div", [["class", "card"]], null, null, null, null, null)), (_l()(), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵeld"](1, 0, null, null, 2, "app-table-widget", [], null, null, null, _widgets_table_component_ngfactory__WEBPACK_IMPORTED_MODULE_4__["View_TableComponent_0"], _widgets_table_component_ngfactory__WEBPACK_IMPORTED_MODULE_4__["RenderType_TableComponent"])), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵprd"](512, null, _shared_widgets_service__WEBPACK_IMPORTED_MODULE_2__["WidgetsService"], _shared_widgets_service__WEBPACK_IMPORTED_MODULE_2__["WidgetsService"], []), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵdid"](3, 49152, null, 0, _widgets_table_component__WEBPACK_IMPORTED_MODULE_5__["TableComponent"], [_shared_widgets_service__WEBPACK_IMPORTED_MODULE_2__["WidgetsService"]], { widget: [0, "widget"] }, null)], function (_ck, _v) { var currVal_0 = _v.parent.context.$implicit; _ck(_v, 3, 0, currVal_0); }, null); }
function View_DashboardComponent_1(_l) { return _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵvid"](0, [(_l()(), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵeld"](0, 0, null, null, 7, "div", [], null, null, null, null, null)), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵdid"](1, 278528, null, 0, _angular_common__WEBPACK_IMPORTED_MODULE_6__["NgClass"], [_angular_core__WEBPACK_IMPORTED_MODULE_0__["IterableDiffers"], _angular_core__WEBPACK_IMPORTED_MODULE_0__["KeyValueDiffers"], _angular_core__WEBPACK_IMPORTED_MODULE_0__["ElementRef"], _angular_core__WEBPACK_IMPORTED_MODULE_0__["Renderer2"]], { ngClass: [0, "ngClass"] }, null), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵpod"](2, { "col-sm-6 col-lg-3": 0, "col-sm-12": 1 }), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵdid"](3, 16384, null, 0, _angular_common__WEBPACK_IMPORTED_MODULE_6__["NgSwitch"], [], { ngSwitch: [0, "ngSwitch"] }, null), (_l()(), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵand"](16777216, null, null, 1, null, View_DashboardComponent_2)), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵdid"](5, 278528, null, 0, _angular_common__WEBPACK_IMPORTED_MODULE_6__["NgSwitchCase"], [_angular_core__WEBPACK_IMPORTED_MODULE_0__["ViewContainerRef"], _angular_core__WEBPACK_IMPORTED_MODULE_0__["TemplateRef"], _angular_common__WEBPACK_IMPORTED_MODULE_6__["NgSwitch"]], { ngSwitchCase: [0, "ngSwitchCase"] }, null), (_l()(), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵand"](16777216, null, null, 1, null, View_DashboardComponent_3)), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵdid"](7, 278528, null, 0, _angular_common__WEBPACK_IMPORTED_MODULE_6__["NgSwitchCase"], [_angular_core__WEBPACK_IMPORTED_MODULE_0__["ViewContainerRef"], _angular_core__WEBPACK_IMPORTED_MODULE_0__["TemplateRef"], _angular_common__WEBPACK_IMPORTED_MODULE_6__["NgSwitch"]], { ngSwitchCase: [0, "ngSwitchCase"] }, null)], function (_ck, _v) { var _co = _v.component; var currVal_0 = _ck(_v, 2, 0, _co.widgetsService.isCard(_v.context.$implicit.type), !_co.widgetsService.isCard(_v.context.$implicit.type)); _ck(_v, 1, 0, currVal_0); var currVal_1 = _v.context.$implicit.type; _ck(_v, 3, 0, currVal_1); var currVal_2 = "card-progressbar"; _ck(_v, 5, 0, currVal_2); var currVal_3 = "table"; _ck(_v, 7, 0, currVal_3); }, null); }
function View_DashboardComponent_0(_l) { return _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵvid"](0, [(_l()(), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵeld"](0, 0, null, null, 3, "div", [["class", "animated fadeIn"]], null, null, null, null, null)), (_l()(), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵeld"](1, 0, null, null, 2, "div", [["class", "row"]], null, null, null, null, null)), (_l()(), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵand"](16777216, null, null, 1, null, View_DashboardComponent_1)), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵdid"](3, 278528, null, 0, _angular_common__WEBPACK_IMPORTED_MODULE_6__["NgForOf"], [_angular_core__WEBPACK_IMPORTED_MODULE_0__["ViewContainerRef"], _angular_core__WEBPACK_IMPORTED_MODULE_0__["TemplateRef"], _angular_core__WEBPACK_IMPORTED_MODULE_0__["IterableDiffers"]], { ngForOf: [0, "ngForOf"] }, null)], function (_ck, _v) { var _co = _v.component; var currVal_0 = _co.widgets; _ck(_v, 3, 0, currVal_0); }, null); }
function View_DashboardComponent_Host_0(_l) { return _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵvid"](0, [(_l()(), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵeld"](0, 0, null, null, 2, "ng-component", [], null, null, null, View_DashboardComponent_0, RenderType_DashboardComponent)), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵprd"](512, null, _shared_widgets_service__WEBPACK_IMPORTED_MODULE_2__["WidgetsService"], _shared_widgets_service__WEBPACK_IMPORTED_MODULE_2__["WidgetsService"], []), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵdid"](2, 114688, null, 0, _dashboard_component__WEBPACK_IMPORTED_MODULE_7__["DashboardComponent"], [_ngneat_transloco__WEBPACK_IMPORTED_MODULE_8__["TranslocoService"], _angular_common_http__WEBPACK_IMPORTED_MODULE_9__["HttpClient"], _angular_platform_browser__WEBPACK_IMPORTED_MODULE_10__["Title"], _angular_router__WEBPACK_IMPORTED_MODULE_11__["ActivatedRoute"], _shared_widgets_service__WEBPACK_IMPORTED_MODULE_2__["WidgetsService"]], null, null)], function (_ck, _v) { _ck(_v, 2, 0); }, null); }
var DashboardComponentNgFactory = /*@__PURE__*/ _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵccf"]("ng-component", _dashboard_component__WEBPACK_IMPORTED_MODULE_7__["DashboardComponent"], View_DashboardComponent_Host_0, {}, {}, []);




/***/ }),

/***/ "./src/app/dashboard/components/widgets/card-progressbar.component.ngfactory.js":
/*!**************************************************************************************!*\
  !*** ./src/app/dashboard/components/widgets/card-progressbar.component.ngfactory.js ***!
  \**************************************************************************************/
/*! exports provided: RenderType_CardProgressbarComponent, View_CardProgressbarComponent_0, View_CardProgressbarComponent_Host_0, CardProgressbarComponentNgFactory */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "RenderType_CardProgressbarComponent", function() { return RenderType_CardProgressbarComponent; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "View_CardProgressbarComponent_0", function() { return View_CardProgressbarComponent_0; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "View_CardProgressbarComponent_Host_0", function() { return View_CardProgressbarComponent_Host_0; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "CardProgressbarComponentNgFactory", function() { return CardProgressbarComponentNgFactory; });
/* harmony import */ var _angular_core__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @angular/core */ "./node_modules/@angular/core/fesm5/core.js");
/* harmony import */ var _ngneat_transloco__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @ngneat/transloco */ "./node_modules/@ngneat/transloco/fesm5/ngneat-transloco.js");
/* harmony import */ var _shared_widgets_service__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../shared/widgets.service */ "./src/app/dashboard/shared/widgets.service.ts");
/* harmony import */ var _card_progressbar_component__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./card-progressbar.component */ "./src/app/dashboard/components/widgets/card-progressbar.component.ts");
/**
 * @fileoverview This file was generated by the Angular template compiler. Do not edit.
 *
 * @suppress {suspiciousCode,uselessCode,missingProperties,missingOverride,checkTypes}
 * tslint:disable
 */




var styles_CardProgressbarComponent = [];
var RenderType_CardProgressbarComponent = /*@__PURE__*/ _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵcrt"]({ encapsulation: 2, styles: styles_CardProgressbarComponent, data: {} });

function View_CardProgressbarComponent_0(_l) { return _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵvid"](0, [(_l()(), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵeld"](0, 0, null, null, 10, "div", [["class", "card-body"]], [[4, "color", null], [4, "background", null], [4, "border-color", null]], null, null, null, null)), (_l()(), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵeld"](1, 0, null, null, 1, "div", [["class", "text-value-lg"]], null, null, null, null, null)), (_l()(), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵted"](2, null, ["", ""])), (_l()(), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵeld"](3, 0, null, null, 2, "div", [], null, null, null, null, null)), (_l()(), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵted"](4, null, ["", ""])), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵpid"](131072, _ngneat_transloco__WEBPACK_IMPORTED_MODULE_1__["TranslocoPipe"], [_ngneat_transloco__WEBPACK_IMPORTED_MODULE_1__["TranslocoService"], [2, _ngneat_transloco__WEBPACK_IMPORTED_MODULE_1__["TRANSLOCO_SCOPE"]], [2, _ngneat_transloco__WEBPACK_IMPORTED_MODULE_1__["TRANSLOCO_LANG"]], _angular_core__WEBPACK_IMPORTED_MODULE_0__["ChangeDetectorRef"]]), (_l()(), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵeld"](6, 0, null, null, 1, "div", [["class", "progress progress-xs my-2"]], null, null, null, null, null)), (_l()(), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵeld"](7, 0, null, null, 0, "div", [["aria-valuemax", "100"], ["aria-valuemin", "0"], ["class", "progress-bar"], ["role", "progressbar"]], [[4, "width", null], [1, "aria-valuenow", 0], [4, "background", null], [4, "border-color", null]], null, null, null, null)), (_l()(), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵeld"](8, 0, null, null, 2, "small", [], [[4, "color", null]], null, null, null, null)), (_l()(), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵted"](9, null, ["", ""])), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵpid"](131072, _ngneat_transloco__WEBPACK_IMPORTED_MODULE_1__["TranslocoPipe"], [_ngneat_transloco__WEBPACK_IMPORTED_MODULE_1__["TranslocoService"], [2, _ngneat_transloco__WEBPACK_IMPORTED_MODULE_1__["TRANSLOCO_SCOPE"]], [2, _ngneat_transloco__WEBPACK_IMPORTED_MODULE_1__["TRANSLOCO_LANG"]], _angular_core__WEBPACK_IMPORTED_MODULE_0__["ChangeDetectorRef"]])], null, function (_ck, _v) { var _co = _v.component; var currVal_0 = _co.widget.color; var currVal_1 = _co.widgetsService.getCardBgColor(_co.widget); var currVal_2 = _co.widget.backgroundColor; _ck(_v, 0, 0, currVal_0, currVal_1, currVal_2); var currVal_3 = _co.widget.value; _ck(_v, 2, 0, currVal_3); var currVal_4 = _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵunv"](_v, 4, 0, _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵnov"](_v, 5).transform(_co.widget.text)); _ck(_v, 4, 0, currVal_4); var currVal_5 = (_co.widget.progressbarPercent + "%"); var currVal_6 = _co.widget.progressbarPercent; var currVal_7 = _co.widgetsService.getCardProgressbarColor(_co.widget); var currVal_8 = _co.widget.progressbarBackgroundColor; _ck(_v, 7, 0, currVal_5, currVal_6, currVal_7, currVal_8); var currVal_9 = _co.widget.helpTextColor; _ck(_v, 8, 0, currVal_9); var currVal_10 = _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵunv"](_v, 9, 0, _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵnov"](_v, 10).transform(_co.widget.helpText)); _ck(_v, 9, 0, currVal_10); }); }
function View_CardProgressbarComponent_Host_0(_l) { return _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵvid"](0, [(_l()(), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵeld"](0, 0, null, null, 2, "app-card-progressbar-widget", [], null, null, null, View_CardProgressbarComponent_0, RenderType_CardProgressbarComponent)), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵprd"](512, null, _shared_widgets_service__WEBPACK_IMPORTED_MODULE_2__["WidgetsService"], _shared_widgets_service__WEBPACK_IMPORTED_MODULE_2__["WidgetsService"], []), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵdid"](2, 49152, null, 0, _card_progressbar_component__WEBPACK_IMPORTED_MODULE_3__["CardProgressbarComponent"], [_shared_widgets_service__WEBPACK_IMPORTED_MODULE_2__["WidgetsService"]], null, null)], null, null); }
var CardProgressbarComponentNgFactory = /*@__PURE__*/ _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵccf"]("app-card-progressbar-widget", _card_progressbar_component__WEBPACK_IMPORTED_MODULE_3__["CardProgressbarComponent"], View_CardProgressbarComponent_Host_0, { widget: "widget" }, {}, []);




/***/ }),

/***/ "./src/app/dashboard/components/widgets/card-progressbar.component.ts":
/*!****************************************************************************!*\
  !*** ./src/app/dashboard/components/widgets/card-progressbar.component.ts ***!
  \****************************************************************************/
/*! exports provided: CardProgressbarComponent */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "CardProgressbarComponent", function() { return CardProgressbarComponent; });
var CardProgressbarComponent = /** @class */ /*@__PURE__*/ (function () {
    function CardProgressbarComponent(widgetsService) {
        this.widgetsService = widgetsService;
    }
    return CardProgressbarComponent;
}());




/***/ }),

/***/ "./src/app/dashboard/components/widgets/table.component.ngfactory.js":
/*!***************************************************************************!*\
  !*** ./src/app/dashboard/components/widgets/table.component.ngfactory.js ***!
  \***************************************************************************/
/*! exports provided: RenderType_TableComponent, View_TableComponent_0, View_TableComponent_Host_0, TableComponentNgFactory */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "RenderType_TableComponent", function() { return RenderType_TableComponent; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "View_TableComponent_0", function() { return View_TableComponent_0; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "View_TableComponent_Host_0", function() { return View_TableComponent_Host_0; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "TableComponentNgFactory", function() { return TableComponentNgFactory; });
/* harmony import */ var _angular_core__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @angular/core */ "./node_modules/@angular/core/fesm5/core.js");
/* harmony import */ var _ngneat_transloco__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @ngneat/transloco */ "./node_modules/@ngneat/transloco/fesm5/ngneat-transloco.js");
/* harmony import */ var _core_directives_routeTransformer_directive__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../core/directives/routeTransformer.directive */ "./src/app/core/directives/routeTransformer.directive.ts");
/* harmony import */ var _angular_router__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @angular/router */ "./node_modules/@angular/router/fesm5/router.js");
/* harmony import */ var _angular_common__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @angular/common */ "./node_modules/@angular/common/fesm5/common.js");
/* harmony import */ var _shared_widgets_service__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ../../shared/widgets.service */ "./src/app/dashboard/shared/widgets.service.ts");
/* harmony import */ var _table_component__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./table.component */ "./src/app/dashboard/components/widgets/table.component.ts");
/**
 * @fileoverview This file was generated by the Angular template compiler. Do not edit.
 *
 * @suppress {suspiciousCode,uselessCode,missingProperties,missingOverride,checkTypes}
 * tslint:disable
 */







var styles_TableComponent = [];
var RenderType_TableComponent = /*@__PURE__*/ _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵcrt"]({ encapsulation: 2, styles: styles_TableComponent, data: {} });

function View_TableComponent_1(_l) { return _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵvid"](0, [(_l()(), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵeld"](0, 0, null, null, 2, "th", [], null, null, null, null, null)), (_l()(), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵted"](1, null, ["", ""])), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵpid"](131072, _ngneat_transloco__WEBPACK_IMPORTED_MODULE_1__["TranslocoPipe"], [_ngneat_transloco__WEBPACK_IMPORTED_MODULE_1__["TranslocoService"], [2, _ngneat_transloco__WEBPACK_IMPORTED_MODULE_1__["TRANSLOCO_SCOPE"]], [2, _ngneat_transloco__WEBPACK_IMPORTED_MODULE_1__["TRANSLOCO_LANG"]], _angular_core__WEBPACK_IMPORTED_MODULE_0__["ChangeDetectorRef"]])], null, function (_ck, _v) { var currVal_0 = _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵunv"](_v, 1, 0, _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵnov"](_v, 2).transform(_v.context.$implicit)); _ck(_v, 1, 0, currVal_0); }); }
function View_TableComponent_3(_l) {
    return _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵvid"](0, [(_l()(), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵeld"](0, 0, null, null, 1, "td", [["routeTransformer", ""]], [[8, "innerHTML", 1]], [[null, "click"]], function (_v, en, $event) {
            var ad = true;
            if (("click" === en)) {
                var pd_0 = (_angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵnov"](_v, 1).onClick($event) !== false);
                ad = (pd_0 && ad);
            }
            return ad;
        }, null, null)), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵdid"](1, 16384, null, 0, _core_directives_routeTransformer_directive__WEBPACK_IMPORTED_MODULE_2__["RouteTransformerDirective"], [_angular_core__WEBPACK_IMPORTED_MODULE_0__["ElementRef"], _angular_router__WEBPACK_IMPORTED_MODULE_3__["Router"]], null, null)], null, function (_ck, _v) { var currVal_0 = _v.context.$implicit; _ck(_v, 0, 0, currVal_0); });
}
function View_TableComponent_2(_l) { return _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵvid"](0, [(_l()(), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵeld"](0, 0, null, null, 2, "tr", [], null, null, null, null, null)), (_l()(), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵand"](16777216, null, null, 1, null, View_TableComponent_3)), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵdid"](2, 278528, null, 0, _angular_common__WEBPACK_IMPORTED_MODULE_4__["NgForOf"], [_angular_core__WEBPACK_IMPORTED_MODULE_0__["ViewContainerRef"], _angular_core__WEBPACK_IMPORTED_MODULE_0__["TemplateRef"], _angular_core__WEBPACK_IMPORTED_MODULE_0__["IterableDiffers"]], { ngForOf: [0, "ngForOf"] }, null)], function (_ck, _v) { var currVal_0 = _v.context.$implicit; _ck(_v, 2, 0, currVal_0); }, null); }
function View_TableComponent_0(_l) { return _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵvid"](0, [(_l()(), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵeld"](0, 0, null, null, 2, "div", [["class", "card-header"]], null, null, null, null, null)), (_l()(), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵted"](1, null, ["", ""])), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵpid"](131072, _ngneat_transloco__WEBPACK_IMPORTED_MODULE_1__["TranslocoPipe"], [_ngneat_transloco__WEBPACK_IMPORTED_MODULE_1__["TranslocoService"], [2, _ngneat_transloco__WEBPACK_IMPORTED_MODULE_1__["TRANSLOCO_SCOPE"]], [2, _ngneat_transloco__WEBPACK_IMPORTED_MODULE_1__["TRANSLOCO_LANG"]], _angular_core__WEBPACK_IMPORTED_MODULE_0__["ChangeDetectorRef"]]), (_l()(), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵeld"](3, 0, null, null, 8, "div", [["class", "card-body"]], null, null, null, null, null)), (_l()(), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵeld"](4, 0, null, null, 7, "table", [["class", "table table-responsive-sm"]], null, null, null, null, null)), (_l()(), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵeld"](5, 0, null, null, 3, "thead", [], null, null, null, null, null)), (_l()(), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵeld"](6, 0, null, null, 2, "tr", [], null, null, null, null, null)), (_l()(), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵand"](16777216, null, null, 1, null, View_TableComponent_1)), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵdid"](8, 278528, null, 0, _angular_common__WEBPACK_IMPORTED_MODULE_4__["NgForOf"], [_angular_core__WEBPACK_IMPORTED_MODULE_0__["ViewContainerRef"], _angular_core__WEBPACK_IMPORTED_MODULE_0__["TemplateRef"], _angular_core__WEBPACK_IMPORTED_MODULE_0__["IterableDiffers"]], { ngForOf: [0, "ngForOf"] }, null), (_l()(), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵeld"](9, 0, null, null, 2, "tbody", [], null, null, null, null, null)), (_l()(), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵand"](16777216, null, null, 1, null, View_TableComponent_2)), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵdid"](11, 278528, null, 0, _angular_common__WEBPACK_IMPORTED_MODULE_4__["NgForOf"], [_angular_core__WEBPACK_IMPORTED_MODULE_0__["ViewContainerRef"], _angular_core__WEBPACK_IMPORTED_MODULE_0__["TemplateRef"], _angular_core__WEBPACK_IMPORTED_MODULE_0__["IterableDiffers"]], { ngForOf: [0, "ngForOf"] }, null)], function (_ck, _v) { var _co = _v.component; var currVal_1 = _co.widget.headers; _ck(_v, 8, 0, currVal_1); var currVal_2 = _co.widget.data; _ck(_v, 11, 0, currVal_2); }, function (_ck, _v) { var _co = _v.component; var currVal_0 = _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵunv"](_v, 1, 0, _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵnov"](_v, 2).transform(_co.widget.title)); _ck(_v, 1, 0, currVal_0); }); }
function View_TableComponent_Host_0(_l) { return _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵvid"](0, [(_l()(), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵeld"](0, 0, null, null, 2, "app-table-widget", [], null, null, null, View_TableComponent_0, RenderType_TableComponent)), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵprd"](512, null, _shared_widgets_service__WEBPACK_IMPORTED_MODULE_5__["WidgetsService"], _shared_widgets_service__WEBPACK_IMPORTED_MODULE_5__["WidgetsService"], []), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵdid"](2, 49152, null, 0, _table_component__WEBPACK_IMPORTED_MODULE_6__["TableComponent"], [_shared_widgets_service__WEBPACK_IMPORTED_MODULE_5__["WidgetsService"]], null, null)], null, null); }
var TableComponentNgFactory = /*@__PURE__*/ _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵccf"]("app-table-widget", _table_component__WEBPACK_IMPORTED_MODULE_6__["TableComponent"], View_TableComponent_Host_0, { widget: "widget" }, {}, []);




/***/ }),

/***/ "./src/app/dashboard/components/widgets/table.component.ts":
/*!*****************************************************************!*\
  !*** ./src/app/dashboard/components/widgets/table.component.ts ***!
  \*****************************************************************/
/*! exports provided: TableComponent */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "TableComponent", function() { return TableComponent; });
var TableComponent = /** @class */ /*@__PURE__*/ (function () {
    function TableComponent(widgetsService) {
        this.widgetsService = widgetsService;
    }
    return TableComponent;
}());




/***/ }),

/***/ "./src/app/dashboard/dashboard-routing.module.ts":
/*!*******************************************************!*\
  !*** ./src/app/dashboard/dashboard-routing.module.ts ***!
  \*******************************************************/
/*! exports provided: DashboardRoutingModule */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "DashboardRoutingModule", function() { return DashboardRoutingModule; });
/* harmony import */ var _components_dashboard_component__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./components/dashboard.component */ "./src/app/dashboard/components/dashboard.component.ts");

var routes = [
    {
        path: '',
        component: _components_dashboard_component__WEBPACK_IMPORTED_MODULE_0__["DashboardComponent"]
    }
];
var DashboardRoutingModule = /** @class */ /*@__PURE__*/ (function () {
    function DashboardRoutingModule() {
    }
    return DashboardRoutingModule;
}());




/***/ }),

/***/ "./src/app/dashboard/dashboard.module.ngfactory.js":
/*!*********************************************************!*\
  !*** ./src/app/dashboard/dashboard.module.ngfactory.js ***!
  \*********************************************************/
/*! exports provided: DashboardModuleNgFactory */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "DashboardModuleNgFactory", function() { return DashboardModuleNgFactory; });
/* harmony import */ var _angular_core__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @angular/core */ "./node_modules/@angular/core/fesm5/core.js");
/* harmony import */ var _dashboard_module__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./dashboard.module */ "./src/app/dashboard/dashboard.module.ts");
/* harmony import */ var _node_modules_angular_router_router_ngfactory__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/@angular/router/router.ngfactory */ "./node_modules/@angular/router/router.ngfactory.js");
/* harmony import */ var _components_dashboard_component_ngfactory__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./components/dashboard.component.ngfactory */ "./src/app/dashboard/components/dashboard.component.ngfactory.js");
/* harmony import */ var _node_modules_ngx_bootstrap_dropdown_ngx_bootstrap_dropdown_ngfactory__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../../../node_modules/ngx-bootstrap/dropdown/ngx-bootstrap-dropdown.ngfactory */ "./node_modules/ngx-bootstrap/dropdown/ngx-bootstrap-dropdown.ngfactory.js");
/* harmony import */ var _node_modules_ngneat_transloco_ngneat_transloco_ngfactory__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ../../../node_modules/@ngneat/transloco/ngneat-transloco.ngfactory */ "./node_modules/@ngneat/transloco/ngneat-transloco.ngfactory.js");
/* harmony import */ var _angular_forms__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! @angular/forms */ "./node_modules/@angular/forms/fesm5/forms.js");
/* harmony import */ var _angular_common__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! @angular/common */ "./node_modules/@angular/common/fesm5/common.js");
/* harmony import */ var _ngneat_transloco__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! @ngneat/transloco */ "./node_modules/@ngneat/transloco/fesm5/ngneat-transloco.js");
/* harmony import */ var _angular_router__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! @angular/router */ "./node_modules/@angular/router/fesm5/router.js");
/* harmony import */ var _dashboard_routing_module__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! ./dashboard-routing.module */ "./src/app/dashboard/dashboard-routing.module.ts");
/* harmony import */ var ng2_charts__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! ng2-charts */ "./node_modules/ng2-charts/fesm5/ng2-charts.js");
/* harmony import */ var ngx_bootstrap_dropdown__WEBPACK_IMPORTED_MODULE_12__ = __webpack_require__(/*! ngx-bootstrap/dropdown */ "./node_modules/ngx-bootstrap/dropdown/fesm5/ngx-bootstrap-dropdown.js");
/* harmony import */ var ngx_bootstrap_buttons__WEBPACK_IMPORTED_MODULE_13__ = __webpack_require__(/*! ngx-bootstrap/buttons */ "./node_modules/ngx-bootstrap/buttons/fesm5/ngx-bootstrap-buttons.js");
/* harmony import */ var _core_directives_directives_module__WEBPACK_IMPORTED_MODULE_14__ = __webpack_require__(/*! ../core/directives/directives.module */ "./src/app/core/directives/directives.module.ts");
/* harmony import */ var _components_dashboard_component__WEBPACK_IMPORTED_MODULE_15__ = __webpack_require__(/*! ./components/dashboard.component */ "./src/app/dashboard/components/dashboard.component.ts");
/**
 * @fileoverview This file was generated by the Angular template compiler. Do not edit.
 *
 * @suppress {suspiciousCode,uselessCode,missingProperties,missingOverride,checkTypes}
 * tslint:disable
 */
















var DashboardModuleNgFactory = /*@__PURE__*/ _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵcmf"](_dashboard_module__WEBPACK_IMPORTED_MODULE_1__["DashboardModule"], [], function (_l) { return _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵmod"]([_angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵmpd"](512, _angular_core__WEBPACK_IMPORTED_MODULE_0__["ComponentFactoryResolver"], _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵCodegenComponentFactoryResolver"], [[8, [_node_modules_angular_router_router_ngfactory__WEBPACK_IMPORTED_MODULE_2__["ɵangular_packages_router_router_lNgFactory"], _components_dashboard_component_ngfactory__WEBPACK_IMPORTED_MODULE_3__["DashboardComponentNgFactory"], _node_modules_ngx_bootstrap_dropdown_ngx_bootstrap_dropdown_ngfactory__WEBPACK_IMPORTED_MODULE_4__["BsDropdownContainerComponentNgFactory"], _node_modules_ngneat_transloco_ngneat_transloco_ngfactory__WEBPACK_IMPORTED_MODULE_5__["ɵcNgFactory"]]], [3, _angular_core__WEBPACK_IMPORTED_MODULE_0__["ComponentFactoryResolver"]], _angular_core__WEBPACK_IMPORTED_MODULE_0__["NgModuleRef"]]), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵmpd"](4608, _angular_forms__WEBPACK_IMPORTED_MODULE_6__["ɵangular_packages_forms_forms_n"], _angular_forms__WEBPACK_IMPORTED_MODULE_6__["ɵangular_packages_forms_forms_n"], []), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵmpd"](4608, _angular_common__WEBPACK_IMPORTED_MODULE_7__["NgLocalization"], _angular_common__WEBPACK_IMPORTED_MODULE_7__["NgLocaleLocalization"], [_angular_core__WEBPACK_IMPORTED_MODULE_0__["LOCALE_ID"]]), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵmpd"](4608, _ngneat_transloco__WEBPACK_IMPORTED_MODULE_8__["TRANSLOCO_TRANSPILER"], _ngneat_transloco__WEBPACK_IMPORTED_MODULE_8__["DefaultTranspiler"], []), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵmpd"](4608, _ngneat_transloco__WEBPACK_IMPORTED_MODULE_8__["TRANSLOCO_MISSING_HANDLER"], _ngneat_transloco__WEBPACK_IMPORTED_MODULE_8__["ɵb"], []), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵmpd"](4608, _ngneat_transloco__WEBPACK_IMPORTED_MODULE_8__["TRANSLOCO_INTERCEPTOR"], _ngneat_transloco__WEBPACK_IMPORTED_MODULE_8__["ɵa"], []), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵmpd"](4608, _ngneat_transloco__WEBPACK_IMPORTED_MODULE_8__["TRANSLOCO_FALLBACK_STRATEGY"], _ngneat_transloco__WEBPACK_IMPORTED_MODULE_8__["DefaultFallbackStrategy"], [_ngneat_transloco__WEBPACK_IMPORTED_MODULE_8__["TRANSLOCO_CONFIG"]]), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵmpd"](1073742336, _angular_forms__WEBPACK_IMPORTED_MODULE_6__["ɵangular_packages_forms_forms_d"], _angular_forms__WEBPACK_IMPORTED_MODULE_6__["ɵangular_packages_forms_forms_d"], []), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵmpd"](1073742336, _angular_forms__WEBPACK_IMPORTED_MODULE_6__["FormsModule"], _angular_forms__WEBPACK_IMPORTED_MODULE_6__["FormsModule"], []), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵmpd"](1073742336, _angular_router__WEBPACK_IMPORTED_MODULE_9__["RouterModule"], _angular_router__WEBPACK_IMPORTED_MODULE_9__["RouterModule"], [[2, _angular_router__WEBPACK_IMPORTED_MODULE_9__["ɵangular_packages_router_router_a"]], [2, _angular_router__WEBPACK_IMPORTED_MODULE_9__["Router"]]]), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵmpd"](1073742336, _dashboard_routing_module__WEBPACK_IMPORTED_MODULE_10__["DashboardRoutingModule"], _dashboard_routing_module__WEBPACK_IMPORTED_MODULE_10__["DashboardRoutingModule"], []), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵmpd"](1073742336, ng2_charts__WEBPACK_IMPORTED_MODULE_11__["ChartsModule"], ng2_charts__WEBPACK_IMPORTED_MODULE_11__["ChartsModule"], []), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵmpd"](1073742336, ngx_bootstrap_dropdown__WEBPACK_IMPORTED_MODULE_12__["BsDropdownModule"], ngx_bootstrap_dropdown__WEBPACK_IMPORTED_MODULE_12__["BsDropdownModule"], []), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵmpd"](1073742336, ngx_bootstrap_buttons__WEBPACK_IMPORTED_MODULE_13__["ButtonsModule"], ngx_bootstrap_buttons__WEBPACK_IMPORTED_MODULE_13__["ButtonsModule"], []), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵmpd"](1073742336, _angular_common__WEBPACK_IMPORTED_MODULE_7__["CommonModule"], _angular_common__WEBPACK_IMPORTED_MODULE_7__["CommonModule"], []), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵmpd"](1073742336, _ngneat_transloco__WEBPACK_IMPORTED_MODULE_8__["TranslocoModule"], _ngneat_transloco__WEBPACK_IMPORTED_MODULE_8__["TranslocoModule"], []), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵmpd"](1073742336, _core_directives_directives_module__WEBPACK_IMPORTED_MODULE_14__["DirectivesModule"], _core_directives_directives_module__WEBPACK_IMPORTED_MODULE_14__["DirectivesModule"], []), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵmpd"](1073742336, _dashboard_module__WEBPACK_IMPORTED_MODULE_1__["DashboardModule"], _dashboard_module__WEBPACK_IMPORTED_MODULE_1__["DashboardModule"], []), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵmpd"](1024, _angular_router__WEBPACK_IMPORTED_MODULE_9__["ROUTES"], function () { return [[{ path: "", component: _components_dashboard_component__WEBPACK_IMPORTED_MODULE_15__["DashboardComponent"] }]]; }, [])]); });




/***/ }),

/***/ "./src/app/dashboard/dashboard.module.ts":
/*!***********************************************!*\
  !*** ./src/app/dashboard/dashboard.module.ts ***!
  \***********************************************/
/*! exports provided: DashboardModule */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "DashboardModule", function() { return DashboardModule; });
var DashboardModule = /** @class */ /*@__PURE__*/ (function () {
    function DashboardModule() {
    }
    return DashboardModule;
}());




/***/ }),

/***/ "./src/app/dashboard/shared/widgets.service.ts":
/*!*****************************************************!*\
  !*** ./src/app/dashboard/shared/widgets.service.ts ***!
  \*****************************************************/
/*! exports provided: WidgetsService */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "WidgetsService", function() { return WidgetsService; });
var WidgetsService = /** @class */ /*@__PURE__*/ (function () {
    function WidgetsService() {
    }
    WidgetsService.prototype.isCard = function (type) {
        if (type === 'card-progressbar') {
            return true;
        }
        return false;
    };
    WidgetsService.prototype.getCardBgColor = function (widget) {
        if (widget.backgroundGradient) {
            return widget.backgroundGradient;
        }
        return widget.backgroundColor;
    };
    WidgetsService.prototype.getCardProgressbarColor = function (widget) {
        if (widget.progressbarBackgroundGradient) {
            return widget.progressbarBackgroundGradient;
        }
        return widget.progressbarBackgroundColor;
    };
    return WidgetsService;
}());




/***/ })

}]);
//# sourceMappingURL=0.769f9aa39338033d2a1b.js.map