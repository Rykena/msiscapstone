function buildingauto() {
	var min_length = 2;
	var keyword = $('#building_id').val();
	setTimeout(function() {
		if($('#building_id').val() == keyword){	
			if (keyword.length >= min_length) {
				$.ajax({
					url: './common/buildingauto.php',
					type: 'POST',
					data: {keyword:keyword},
					success:function(data){
						$('#building_list_id').show();
						$('#building_list_id').html(data);
					}
				});
			} else {
				$('#building_list_id').hide();
			}
		}
	}, 1000);
}

// set_item : this function will be executed when we select an item
function set_building_item(item) {
	// change input value
	$('#building_id').val(item);
	// hide proposition list
	$('#building_list_id').hide();
}

function coreauto() {
	var min_length = 2;
	var keyword = $('#core_id').val();
	setTimeout(function() {
		if($('#core_id').val() == keyword){
			if (keyword.length >= min_length) {
				$.ajax({
					url: './common/coreauto.php',
					type: 'POST',
					data: {keyword:keyword},
					success:function(data){
						$('#core_list_id').show();
						$('#core_list_id').html(data);
					}
				});
			} else {
				$('#core_list_id').hide();
			}
		}
	}, 1000);
}

// set_item : this function will be executed when we select an item
function set_core_item(item) {
	// change input value
	$('#core_id').val(item);
	// hide proposition list
	$('#core_list_id').hide();
}