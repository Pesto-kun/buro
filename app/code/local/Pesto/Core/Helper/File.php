<?php
/**
 * File: File.php
 * Date: 28.05.15 - 13:14
 *
 * @author pest (pest11s@gmail.com)
 */

class Pesto_Core_Helper_File extends Mage_Core_Helper_Abstract {

    /**
     * Создание директории
     *
     * @param $path
     * @param int $mode
     *
     * @throws Mage_Core_Exception
     */
    public function createDir($path, $mode = 0755) {

        //Проверка существования директории
        if(!file_exists($path)) {

            try {

                //Создаем директорию, если не существует
                mkdir($path, $mode, TRUE);

            } catch(Exception $e) {
                Mage::throwException($e->getMessage());
            }
        }

    }

    /**
     * Сканирование папки
     *
     * @param $directoryPath
     * @param bool $onlyFiles
     *
     * @return array|null
     */
    public function scanDirectory($directoryPath, $onlyFiles = TRUE) {

        //Проверяем наличие папки
        if(file_exists($directoryPath) && is_dir($directoryPath)) {

            //Получение списка файлов в директории
            $files = scandir($directoryPath);

            //Убираем ссылку на текущую директорию и директорию выше (. и ..)
            unset($files[0], $files[1]);

            //Если следует выбрать только файлы
            if($onlyFiles) {

                //Удаляем директории
                foreach($files as $key => $_fileName) {
                    if(is_dir($directoryPath . DS . $_fileName)) {
                        unset($files[$key]);
                    }
                }
            }

            return $files;
        }

        return NULL;
    }
}