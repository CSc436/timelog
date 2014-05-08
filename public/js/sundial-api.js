// $(function(){

// 	window.Sundial = {}

// 	var _categories = [];

// 	_setCategories = function(data){
// 		_categories = data;
// 	}

// 	_getCategories = function(){
// 		$.getJSON("/api/log/categories", function(data){
// 			_setCategories(data);
// 		})
// 	}

// 	getCategories = function(){
// 		console.log(_categories);
// 		return _categories;
// 	}

// 	Sundial.initCategories = function(){
// 		_getCategories();
// 		return _categories;
// 	}
// })

$(function(){
	
	window.Sundial = {};

	$.ajaxSetup({ async: false});

	var cats;

	function getCategoriesAjax(){
		
		$.getJSON('/api/log/categories', function(data){
			cats = data;
		});
	}

	Sundial.initCategories = function () {
		getCategoriesAjax();
		console.log(cats);
		return cats;
	}

});