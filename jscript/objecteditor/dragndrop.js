/* jshint -W100 */
/* jshint undef: true, unused: true */
/* globals ymaps, confirm, style_src, usermap, style_paths, yandex_styles, yandex_markers, style_circles, style_polygons, styleAddToStorage */
var file,
	dropZone,
	maxFileSize = 2000000,
	xhr,
	percent;

$(document).ready(function () {
	dropZone = $('#dropZone');
	if (window.FileReader === undefined) {
		$("#DnDStatus").empty().html('Не поддерживается браузером!');
		dropZone.addClass('error');
	}
	dropZone[0].ondragover = function () {
		dropZone.addClass('hover');
		return false;
	};
	dropZone[0].ondragleave = function () {
		dropZone.removeClass('hover');
		return false;
	};
	dropZone[0].ondrop = function (event) {
		var fd,
			xhr,
			formData,
			file = event.dataTransfer.files[0];
		event.preventDefault();
		dropZone.removeClass('hover');
		dropZone.addClass('drop');
		if (file.size > maxFileSize) {
			$("#DnDStatus").empty().html('Файл слишком большой!');
			//alert('Файл слишком большой!');
			dropZone.addClass('error');
			return false;
		}
		xhr = new XMLHttpRequest();
		xhr.upload.addEventListener('progress', uploadProgress, false);
		xhr.onreadystatechange = stateChange;
		xhr.open('POST', '/upload/loadimage');
		xhr.setRequestHeader('X-FILE-NAME', file.name);
		formData = new FormData;
		formData.append("userfile", file);
		formData.append("lid", $("#uploadLID").val());
		xhr.send(formData);
	}

	function uploadProgress(event) {
		percent = (event.loaded / event.total * 100).toFixed(0);
		$("#DnDStatus").empty().html('Загрузка: ' + percent + '%');
	}

	function stateChange(event) {
		var text,
			data;
		if (event.target.readyState === 4) {
			if (event.target.status === 200) {
				eval(event.target.response)
				if(data.message === "OK") {
					dropZone.removeClass('drop');
					$(".imageGallery").append(data.image);
					set_deleter();
					return true;
				}
				$("#DnDStatus").empty().html(data.message);
				return false;
			}
			$("#DnDStatus").empty().html('Произошла ошибка!');
			dropZone.addClass('error');
		}
	}
});

$(function () {
	$( ".imageGallery" ).sortable({
		stop : function ( event, ui ) {
			$.ajax({
				url       : "/editor/save_image_order",
				type      : "POST",
				data      : {
					order : $( ".imageGallery" ).sortable( "toArray", { attribute: "ref" } )
				},
				dataType  : 'script',
				success   : function () {},
				error     : function (data, stat, err) {
					console.log([ data, stat, err ].join("\n"));
				}
			});
		}
	});
	$( ".imageGallery" ).disableSelection();
});

function set_deleter() {
	$(".locationImg .icon-remove").click(function () {
		var ref = $(this).parent().attr("ref");
		$.ajax({
			url       : "/editor/delete_image",
			type      : "POST",
			data      : {
				image : ref,
				lid   : prop.ttl
			},
			dataType  : 'script',
			success   : function () {
				$(".locationImg[ref=" + ref + "]").remove();
			},
			error     : function (data, stat, err) {
				console.log([ data, stat, err ].join("\n"));
			}
		});
	});
}

set_deleter();