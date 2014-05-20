var __bt_Flag = false;
var __bt_Busy = false;

__bt_showhidePriceTD = function() {
	var __TD = $_('#__bt_totalPriceTD');
	if ($_.ie) {
		__TD.style.backgroundColor = $('__bt_Content').currentStyle.backgroundColor;
		if (__TD.style.backgroundColor == 'transparent') __TD.style.backgroundColor = '#FFFFFF';
	}
	if (__boughtTogetherAnimation) {
			__TD.mutate({opacity: 1 * (__bt_Flag ? 0 : 1)}, {opacity: 0}, __bt_AnimSpeed,
				function() {
					__bt_calculatePrice();
					if (!__bt_Flag) {
						__TD.style.display = '';
						__TD.mutate({opacity: 0}, {opacity: 1}, __bt_AnimSpeed,
							function() {
								__bt_Busy = false;
							}
						);
					}
					else {
						__TD.style.display = 'none';
						__bt_Busy = false;
					}
				}
			);
	}
	else {
		__TD.style.display = 'none';
		__bt_calculatePrice();
		if (!__bt_Flag) __TD.style.display = '';
		__bt_Busy = false;
	}
};

__bt_showhideTDs = function(TDObjs, show) {
	for (var i = 0; i < TDObjs.length; i++) {
		var __TD = $_(TDObjs[i]);
		if (__TD) {
			if (__boughtTogetherAnimation) {
				if (show) {
					__TD.mutate({opacity: 0.5}, {opacity: 0.5}, __bt_AnimSpeed,
						function(TD) {
							return function() {
								//TD.style.display = '';
								TD.mutate({opacity: 0.5}, {opacity: 1}, __bt_AnimSpeed);
							}
						}
						(__TD)
					);
				}
				else {
					__TD.mutate({opacity: 1}, {opacity: 0.5}, __bt_AnimSpeed,
						function(TD) {
							return function() {
								//TD.style.display = 'none';
								//TD.style.opacity = '0.5';
							}
						}
						(__TD)
					);
				}
			}
			//else __TD.style.display = show ? '' : 'none';
			//else __TD.style.opacity = show ? '1' : '0.5';
			
		}
	}
};

__bt_nearestTD = function(TDObj, show) {
	var __nearestTD = TDObj;
	do __nearestTD = __nearestTD.nextSibling; while ((__nearestTD) && ((__nearestTD.tagName != 'TD') || ((__nearestTD.style.display == 'none') != show)));
	if (__nearestTD) {
		var __nearestTDnext = __nearestTD;
		do __nearestTDnext = __nearestTDnext.nextSibling; while ((__nearestTDnext) && ((__nearestTDnext.tagName != 'TD') || (__nearestTDnext.style.display == 'none')));
		if (!__nearestTDnext) __nearestTD = null;
	}
	if (!__nearestTD) {
		__nearestTD = TDObj;
		do __nearestTD = __nearestTD.previousSibling; while ((__nearestTD) && ((__nearestTD.tagName != 'TD') || ((__nearestTD.style.display == 'none') != show)));
		if (__nearestTD) {
			__nearestTDnext = __nearestTD;
			do __nearestTDnext = __nearestTDnext.previousSibling; while ((__nearestTDnext) && ((__nearestTDnext.tagName != 'TD') || (__nearestTDnext.style.display == 'none')));
			if (!__nearestTDnext) __nearestTD = null;
		}
	}
	return __nearestTD;
};


__bt_calculatePrice = function() {
	var __price = 0;
	var __showed = 0;
	var __principal = parseFloat($('price_principal').value);
	var __discount = parseFloat($('tax_discount').value);
	var __parcelas = parseInt($('qty_quotes').value);
	var __tax = parseFloat($('tax_quotes').value);
	for (var i = 1; i < bt_IDs.length; i++) {
		var __cB = $('related-checkbox' + bt_IDs[i]);
		if ((__cB) && (__cB.checked)) {
			__price += bt_Prices[i];
			__disconto = __price * __discount/100;
			__showed++;
		}
	}

	__price = __principal + (__price - __disconto) ;
	if (__tax == '0') {
		__parcela = __price/__parcelas;	
	}
		
	__bt_Flag = (__showed == 0) ? true : false;
	$('__bt_totalPrice').innerHTML = $('__bt_totalPrice').innerHTML.replace(/\d+([\s\.,]\d+)*/, __price.toFixed(2).toString());
	$('__teste').innerHTML = $('__teste').innerHTML.replace(/\d+([\s\.,]\d+)*/, __disconto.toFixed(2).toString());
	$('__parcela').innerHTML = $('__parcela').innerHTML.replace(/\d+([\s\.,]\d+)*/, __parcela.toFixed(2).toString());
	return __price;
};

bt_itemClick = function(productID) {
	if (__bt_Busy) return false;
	__bt_Busy = true;
	var __show = $('related-checkbox' + productID).checked;
	var __TD = $('__bt_product_' + productID + '_TD');
	var __A = $('__bt_product_' + productID + '_Name');
	__bt_showhidePriceTD();
	__bt_showhideTDs([__TD, __bt_nearestTD(__TD, __show)], __show);
	if (__show) __A.style.color = '';
	else __A.style.color = '#BBBBBB';
};

bt_addToCart = function() {
	var checkboxes = $$('.related-checkbox');
	var values = [];
	for (var i = 0; i < checkboxes.length; i++) if(checkboxes[i].checked) values.push(checkboxes[i].value);
	var primaryProductID = values.shift();
	var s = productAddToCartForm.form.action;
	s = s.substr(0, s.lastIndexOf('/') - 1);
	productAddToCartForm.form.action = s.substr(0, s.lastIndexOf('/')) + '/' + primaryProductID + '/';
	productAddToCartForm.form.product.value = primaryProductID;
	if ($('related-products-field')) $('related-products-field').value = values.join(',');
	productAddToCartForm.submit();
};

Product.OptionsPrice.prototype.formatPrice = function (price){
    if (typeof(bt_Prices) != 'undefined'){
        var configPrice = 0;
        if (typeof(this.optionPrices) != 'undefined' && this.optionPrices.config){
            configPrice = this.optionPrices.config;
        }
        bt_Prices[0] = this.productPrice + configPrice;
        __bt_calculatePrice();
    }
	return formatCurrency(price, this.priceFormat);
};
