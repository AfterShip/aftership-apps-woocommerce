function sort_couriers(data){
	var n = data.length;
	for (var i = 0; i < n - 1; i++) {
		var find = false;
		for (var j = i+1; j < n; j++) {
			if (data[i].name.toLowerCase() > data[j].name.toLowerCase()) {
				var tmp = data[i];
				data[i] = data[j];
				data[j] = tmp;
				find = true;
			}
		}
		if (!find) {
			break;
		}
	}
	return data;
}