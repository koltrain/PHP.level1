<?php

function show_images()
{
    $files = scandir (UPLOAD_DIR);
    if ($files === FALSE || count($files) == 3) {
	echo 'Загруженные изображения отсутствуют';
	return false;
    }
    foreach ($files as $file) {
	if (is_dir (UPLOAD_DIR . $file)) continue;
	if (file_exists (THUMB_DIR . $file)) 	echo '<a href="uploads/'.$file.'" target="_blank"><img src="/uploads/thumbs/'.$file.'"></a>';
	else					echo '<a href="uploads/'.$file.'" target="_blank"><img src="/uploads/'.$file.'" width="320"></a>';
    }
}

function upload_image()
{
    foreach ($_FILES as $file) {
	if ($file['error'] != 0) {
	    echo '<b><font color="red">Ошибка при загрузке файла - загружаемый файл отсутствует!</font></b>';
	    return false;
	}
	if ($file['size'] == 0) {
	    echo '<b><font color="red">Ошибка при загрузке файла - загружаемый файл имеет нулевой размер!</font></b>';
	    return false;
	}
	$filename = hash('sha256', $file['name']) . '_' . time();
	$thumb = create_thumbnail($file['tmp_name'], THUMB_DIR . $filename, 320, 240);
	if ($thumb === FALSE) {
	    echo '<b><font color="red">Ошибка при загрузке файла - файл не является изображением или не удалось сохранить уменьшенную копию!</font></b>';
	    return false;
	}
	if (move_uploaded_file ($file['tmp_name'], UPLOAD_DIR . $filename) === FALSE) {
	    echo '<b><font color="red">Ошибка при загрузке файла - файл не является изображением или не удалось сохранить оригинал!</font></b>';
	    return false;
	}
    }
}

function create_thumbnail($path, $save, $width, $height) 
{
        $info = getimagesize($path); //получаем размеры картинки и ее тип
        $size = array($info[0], $info[1]); //закидываем размеры в массив

        //В зависимости от расширения картинки вызываем соответствующую функцию
        if ($info['mime'] == 'image/png') {
                $src = imagecreatefrompng($path); //создаём новое изображение из файла
        } else if ($info['mime'] == 'image/jpeg') {
                $src = imagecreatefromjpeg($path);
        } else if ($info['mime'] == 'image/gif') {
                $src = imagecreatefromgif($path);
        } else {
                return false;
        }

        $thumb = imagecreatetruecolor($width, $height); //возвращает идентификатор изображения, представляющий черное изображение заданного размера
        $src_aspect = $size[0] / $size[1]; //отношение ширины к высоте исходника
        $thumb_aspect = $width / $height; //отношение ширины к высоте аватарки

        if($src_aspect < $thumb_aspect) {               //узкий вариант (фиксированная ширина)
		if ($size[1] <= $height) return true;
		$scale = $width / $size[0];
                $new_size = array($width, $width / $src_aspect);
                $src_pos = array(0, ($size[1] * $scale - $height) / $scale / 2); //Ищем расстояние по высоте от края картинки до начала картины после обрезки
	} else if ($src_aspect > $thumb_aspect) {
		if ($size[0] <= $width) return true;
                //широкий вариант (фиксированная высота)
                $scale = $height / $size[1];
                $new_size = array($height * $src_aspect, $height);
                $src_pos = array(($size[0] * $scale - $width) / $scale / 2, 0); //Ищем расстояние по ширине от края картинки до начала картины после обрезки
        } else {
                //другое
                $new_size = array($width, $height);
                $src_pos = array(0,0);
        }

        $new_size[0] = max($new_size[0], 1);
        $new_size[1] = max($new_size[1], 1);

        imagecopyresampled($thumb, $src, 0, 0, $src_pos[0], $src_pos[1], $new_size[0], $new_size[1], $size[0], $size[1]);
        //Копирование и изменение размера изображения с ресемплированием

        if($save === false) {
                return imagepng($thumb); //Выводит JPEG/PNG/GIF изображение
        } else {
                return imagepng($thumb, $save);//Сохраняет JPEG/PNG/GIF изображение
        }

}

function render_files($dir = NULL, $param = NULL)
{
    if ($dir != NULL) {
	$scanning_folder = DOCUMENT_ROOT . $dir . '/';
	if ($param == 1) {
	    $dir = substr ($dir, 0, strripos ($dir, '/'));
	    $scanning_folder = DOCUMENT_ROOT . $dir . '/';
	}
	if ($scanning_folder != DOCUMENT_ROOT . '/') $back = true;
    } else {
	$scanning_folder = DOCUMENT_ROOT . '/';
    }
    $files = scandir ($scanning_folder);
    $html = '';
    $i = 1;
    foreach ($files as $file) {
	$file_path = $scanning_folder . $file;
        if (in_array($file, ['.','..'])) continue;
        $info = stat($file_path);
	if (isset ($back) && $i == 1) {
	    $html .= '<tr class="back">';
    	    $html .= '<td align="right"><i class="fas fa-level-up-alt" style="color: blue;"></i></td>';
	    $html .= '<td colspan="5"><a class="folder" data-back=1 data-folder="'.$dir.'" href="javascript:void(0);">..</a></td>';
	    $html .= '</tr>';
	}
        $html .= '<tr>';
        $html .= '<td>'.$i.'</td>';
    	if (is_dir ($file_path)) {
    	    $html .= '<td><i class="fas fa-folder" style="color:grey;"></i> <a class="folder" data-folder="'.$dir . '/' . $file.'" href="javascript:void(0);">'.$file.'</a></td>';
    	    $html .= '<td>Папка</td>';
    	} else {
	    $html .= '<td><i class="fas fa-file" style="color: black;"></i> '.$file.'</td>';
	    $html .= '<td>'.$info['size'].'</td>';
	}
	$html .= '<td>'.date('d.m.Y H:i',$info['mtime']).'</td>';
	$html .= '<td>'.substr(sprintf('%o', $info['mode']), -4).'</td>';

	$html .= '<td><a class="btn-edit" data-name="'.$file.'" href="javascript:void(0);" title="Переименовать"><i class="fas fa-edit"></i></a></td>';
	$html .= '</tr>';
        $i++;
    }
    return $html;
}

function rename_file($path, $newname)
{
    $rename_file = DOCUMENT_ROOT . $path;
    $newname =  DOCUMENT_ROOT . $newname;
    return rename($rename_file, $newname);
}