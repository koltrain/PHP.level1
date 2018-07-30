<html>
<head>
    <meta charset='utf-8' />
    <link rel="stylesheet" type="text/css" href="/css/styles.css">
    <script src="/js/jquery/jquery-3.3.1.min.js"></script>
    <script defer src="/js/fontawesome/all.js"></script>
</head>
<body>
    <div class="container">
	<div class="manager-window">
	    <div class="manager-wrapper">
		<H2>Файловый манагер своими руками</H2>
		<div class="folder-items">
		    <table width="100%" border="1" cellspacing=0>
			<thead>
			    <td>№</td>
			    <td>Имя</td>
			    <td>Размер</td>
			    <td>Изменён</td>
			    <td>Права</td>
			    <td>Действия</td>
			</thead>
			<tbody>
			</tbody>
		    </table>
		</div>
	    </div>
	</div>
    </div>
    <script language="JavaScript">
	function render(dir, back)
	{
	    if (typeof dir == "undefined") dir = '';
	    $.get({
		url: 'get-files.php',
		dataType: 'json',
		data: {
		    params: {
			'action': 'render_files',
			'current_dir': dir,
			'back': back,
		    }
		},
		success: function (data) {
		    $('tbody').html(data.html);
		}
	    });
	}

	function rename(path, newname)
	{
	    $.get({
		url: 'get-files.php',
		dataType: 'json',
		data: {
		    params: {
			'action': 'rename',
			'path': path,
			'newname': newname,
		    }
		},
		success: function (data) {
		    if (data.success === true) {
			alert ('Успешное переименование');
		    } else {
			alert ('Не удалось переименовать');
		    }
		}
	    });
	}

	render();

	$(document).on('click', '.folder', function (){
	    var dir = $(this).data('folder');
	    if ($(this).data('back') == 1) 	render (dir, 1);
	    else 				render (dir, 0);
	});

	$(document).on('click', '.btn-edit', function(){
	    var oldname = $(this).data('name');
	    var newname = prompt('Введите новое имя', oldname);
	    if (newname != null) {
		var back = $('tr').hasClass('back');
		if (back === true) {
		    var fullpath = $('.back a').data('folder') + '/' + oldname;
		    newname = $('.back a').data('folder') + '/' + newname;
		} else {
		    var fullpath = '/' + oldname;
		    newname = '/' + newname;
		}
		rename (fullpath, newname);
		if (back === true) {
		    render ($('.back a').data('folder'));
		
		} else {
		    render ();
		}
	    }
	});
    </script>
</body>
</html>