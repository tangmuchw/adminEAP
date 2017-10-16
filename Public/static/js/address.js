$(function() {
	initProvinceSelect();
	//			初始化Provinceselect
	function initProvinceSelect() {
		for(var i = 0; i < provinceList.length; i++) {
			var options = document.createElement("option");
			options.setAttribute("value", provinceList[i].name);
			var provinceSelect = document.getElementById("provinceSelect");
			options.innerHTML = provinceList[i].name;
			provinceSelect.appendChild(options);

		}
	}
	//创建选项
	//console.log(provinceList[0].cityList[0].areaList.length);
	//			console.log(provinceList[0].cityList[0].areaList[0]);
	var provinceSelect = document.getElementById("provinceSelect");
	var citySelect = document.getElementById("city");
	var areaSelect = document.getElementById("area");
	var countySelect = document.getElementById("county");
	//省连动区
	provinceSelect.addEventListener("change", function() {
		toPronvince();

	});

	function toPronvince() {

		var province = provinceSelect.value;
		citySelect.options.length = 1;
		//				获取provinceSelect所选的内容索引-1
		var provinceIndex = provinceSelect.selectedIndex - 1;
		switch(provinceIndex) {
			case 0:
			case 1:
			case 2:
			case 3:
				var options = document.createElement("option");
				options.setAttribute("value", provinceList[provinceIndex].name);
				options.innerHTML = provinceList[provinceIndex].name;
				citySelect.appendChild(options);
				break;
			default:
				for(var k = 0; k < provinceList[provinceIndex].cityList.length; k++) {
					var options = document.createElement("option");
					options.setAttribute("value", provinceList[provinceIndex].cityList[k].name);
					options.innerHTML = provinceList[provinceIndex].cityList[k].name;
					citySelect.appendChild(options);
				}
				break;

		}

	}
	//市连动
	citySelect.addEventListener("change", function() {
		toCity();

	});
	console.log()

	function toCity() {
		var cityName = citySelect.value;
		//				areaSelect.options.length = 1;
		areaSelect.options.length = 1;
		//				console.log(cityName);
		var pronvinceIndex = provinceSelect.selectedIndex - 1;
		var cityIndex = citySelect.selectedIndex - 1;
		//				console.log(cityIndex);
		switch(cityName) {
			case "北京":
			case "天津":
			case "上海":
			case "重庆":
				for(var i = 0; i < provinceList[pronvinceIndex].cityList.length; i++) {
					var options = document.createElement("option");
					options.setAttribute("value", provinceList[pronvinceIndex].cityList[i].name);
					options.innerHTML = provinceList[pronvinceIndex].cityList[i].name;
					areaSelect.appendChild(options);
				}

				break;
			default:
				var options = document.createElement("option");
				options.setAttribute("value", provinceList[pronvinceIndex].cityList[cityIndex].areaList[0]);
				options.innerHTML = provinceList[pronvinceIndex].cityList[cityIndex].areaList[0];
				areaSelect.appendChild(options);
				break;
		}

	}

	//			区连动
	areaSelect.addEventListener("change", function() {
		toArea();
	});

	function toArea() {
		var cityName = provinceSelect.value;
		//				areaSelect.options.length = 1;
		countySelect.options.length = 1;
		//				console.log(areaName);
		var provinceIndex = provinceSelect.selectedIndex - 1;
		//areaIndex针对四个直辖市
		var areaIndex = areaSelect.selectedIndex - 1;
		//cityIndex针对其余省
		var cityIndex = citySelect.selectedIndex - 1;
		//				console.log(areaIndex);
		switch(cityName) {
			case "北京":
			case "天津":
			case "上海":
			case "重庆":
				for(var i = 0; i < provinceList[provinceIndex].cityList[areaIndex].areaList.length; i++) {
					var options = document.createElement("option");
					options.setAttribute("value", provinceList[provinceIndex].cityList[areaIndex].areaList[i]);
					options.innerHTML = provinceList[provinceIndex].cityList[areaIndex].areaList[i];
					countySelect.appendChild(options);
				}

				break;
			default:
				for(var i = 1; i < provinceList[provinceIndex].cityList[cityIndex].areaList.length; i++) {
					var options = document.createElement("option");
					options.setAttribute("value", provinceList[provinceIndex].cityList[cityIndex].areaList[i]);
					options.innerHTML = provinceList[provinceIndex].cityList[cityIndex].areaList[i];
					countySelect.appendChild(options);
				}

				break;
		}

	}
});