<?php

/*
 * Функции файлового менеджера
 */

/*
 * Функция формирования html контента для содержимого
 */

function render_files($dir = NULL, $param = NULL)
{
    if ($dir != NULL) { // если передан параметр директории
	$scanning_folder = DOCUMENT_ROOT . $dir . '/'; // устанавливаем сканируемую директорию
        
	if ($param == 1) { // данный параметр обозначает, что это возврат на уровень выше
	    $dir = substr ($dir, 0, strripos ($dir, '/')); // удаляем последнюю папку
	    $scanning_folder = DOCUMENT_ROOT . $dir . '/'; // новая сканируемая директория
	}

        // Если сканируемая директория не равно корневой, то устанавливаем 
        // флаг необходимости отрисовки ссылки для возврата на уровень выше
	if ($scanning_folder != DOCUMENT_ROOT . '/') {
            $back = true;
        }
    } else { // если директория не передана, то по умолчанию ставим корень
	$scanning_folder = DOCUMENT_ROOT . '/';
    }

    $files = scandir ($scanning_folder); // получаем список файлов и папок
    $html = '';
    $i = 1; // счётчик

    foreach ($files as $file) { // перебираем каждый файл

	$file_path = $scanning_folder . $file; // полный путь до файла

        if (in_array($file, ['.','..'])) { // пропускаем лишнее
            continue;
        }

        $info = stat($file_path); // информация о файле

	if (isset ($back) && $i == 1) { // отрисовываем ссылку перехода на уровень выше
	    $html .= '<tr class="back">';
    	    $html .= '<td align="right"><i class="fas fa-level-up-alt" style="color: blue;"></i></td>';
	    $html .= '<td colspan="5"><a class="folder" data-back=1 data-folder="'.$dir.'" href="javascript:void(0);">..</a></td>';
	    $html .= '</tr>';
	}

        $html .= '<tr>';
        $html .= '<td>'.$i.'</td>';

    	if (is_dir ($file_path)) { // Если директория
    	    $html .= '<td><i class="fas fa-folder" style="color:grey;"></i> <a class="folder" data-folder="'.$dir . '/' . $file.'" href="javascript:void(0);">'.$file.'</a></td>';
    	    $html .= '<td>Папка</td>';
    	} else { // Если файл
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

/*
 * Функция переименования директории или файла
 */

function rename_file($path, $newname)
{
    $rename_file = DOCUMENT_ROOT . $path;
    $newname =  DOCUMENT_ROOT . $newname;

    return rename($rename_file, $newname);
}