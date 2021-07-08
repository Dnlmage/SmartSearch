define([
    'jquery'
], function ($) {
    'use strict';
    return function (widget) {
        $.widget('mage.quickSearch', widget, {
            _create: function (){
                if(parseInt(window.isSmartSearchEnable)) {
                    this.options.template = '<li data-txt="txt" class="smartsearch <%- data.row_class %>" id="qs-option-<%- data.index %>" role="option">' +
                        '<span class="qs-option-name">' +
                        '<%- data.title %>' +
                        '</span>' +
                        '<% if (parseInt(window.isSmartSearchShowPrice)) { %>' +
                            '<% if (data.special_price != "0") { %>' +
                            '<div class="final-price"><s><span><%- data.currency_symbol %></span><%- data.price %></s></div>' +
                            '<% } %>' +
                            '<% if (data.special_price == "0") { %>' +
                            '<div class="final-price"><span><%- data.currency_symbol %></span><%- data.price %></div>' +
                            '<% } %>' +
                            '<% if (data.special_price != "0") { %>' +
                            '<div class="special-price"><span><%- data.currency_symbol %></span><%- data.special_price %></div>' +
                            '<% } %>' +
                        '<% } %>' +
                        '<span aria-hidden="true" class="amount">' +
                        '<img src="<%- data.image %>">' +
                        '</span>' +
                        '</li>';
                }
                this._super();
            },
            _onPropertyChange: function (){
                if(parseInt(window.isSmartSearchEnable)) {
                    var oldValue = this.element.val();
                    this.element.val(this.element.val() + ';' + jQuery('#category-search-select').val());
                }
                this._super();
                if(parseInt(window.isSmartSearchEnable)) {
                    this.element.val(oldValue);
                }
            }
        });
        return $.mage.quickSearch;
    };
});
