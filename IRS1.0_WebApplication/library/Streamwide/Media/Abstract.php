<?php
/**
 * Abstract class for media conversion.
 *
 * $Rev: 2608 $
 * $LastChangedDate: 2010-05-18 10:01:35 +0800 (Tue, 18 May 2010) $
 * $LastChangedBy: kwu $
 *
 * @category   Streamwide
 * @package    Streamwide_Media
 * @copyright  Copyright (c) 2009 Streamwide SAS
 * @author     Cosmin STOICA <cstoica@streamwide.ro>
 * @version    $Id: Abstract.php 2608 2010-05-18 02:01:35Z kwu $
 */

require_once 'Streamwide/System/Command/Runner.php';

/**
 * Abstract media class.
 *
 * @category   Streamwide
 * @package    Streamwide_Media
 */
abstract class Streamwide_Media_Abstract
{
    /**
     * the file which will be converted
     */
    protected $_source = null;

    /**
     * the file where the result will be put
     */
    protected $_destination = null;

    /**
     * the file type
     */
    protected $_type = null;

    /**
     * set of options which can be used with the conversion methods
     */
    protected $_options = array(
        'tmpDirectory'         => '/tmp',
        'defaultDestination'   => '',
        'overwriteDestination' => false,
        'ffmpegPath'           => '/usr/bin',
        'soxPath'              => '/usr/bin'
        );

        /**
         * support types - to be overwritten
         */
        protected $_supportedTypes = array();

        /**
         * Class constructor
         *
         * @param string $source  (optional) The source file which need to be converted
         * @param array  $options (optional) An associative array containing the options
         * @throws Streamwide_Media_Exception
         */
        public function __construct($source = null, $options = null)
        {
            if (!is_null($source)) {
                $this->setSource($source);
            }

            // change the options
            if (!is_null($options)) {
                $this->setOptions($options);
            }
        }

        /**
         * Converts a file to the specified type and stores it in the given destination:
         * '' - same destination as the source, same file name, type changed
         * directory - provided directory, same file name, type changed
         * directory + file - provided directory, new file name, type changed
         * file - same destination as the source, new file name, type changed
         *
         * @param string $type        type
         * @param string $destination destination
         * @return string|boolean the name of the file obtained after conversion, in case of success;
         * 						  false if the conversion has failed
         */
        abstract public function convert($type, $destination = null);

        /**
         * Returns the file which will be converted.
         *
         * @return string the file path
         */
        public function getSource()
        {
            return $this->_source;
        }

        /**
         * Sets the source file which will be converted.
         *
         * @param string $source source file
         * @return string The source file path.
         */
        public function setSource($source)
        {
            $this->_checkFile($source);

            // set the file source
            $this->_source = $source;

            // try detecting the file type
            $this->_type = $this->_detectFileType($source);

            return true;
        }

        /**
         * Returns the type of the file which will be converted
         *
         * @return string File extension
         */
        public function getType()
        {
            return $this->_type;
        }

        /**
         * Returns the options set for file conversion
         *
         * @return array File conversion options
         */
        public function getOptions()
        {
            return $this->_options;
        }

        /**
         * Sets the destination where to store the result of the conversion
         *
         * @param string $type        The type of the file obtained after conversion
         * @param string $destination The destination file/folder
         * @return boolean true If the destination was set
         * @throws Streamwide_Media_Exception
         */
        protected function _setDestination($type, $destination)
        {
            $sourceDirectory = $this->_prepareDirectory(dirname($this->_source));
            $sourceFilename = basename($this->_source);

            // get the destination folder
            if (is_null($destination)) {
                // destination folder will be the one set as the default folder
                $destination = $this->_options['defaultDestination'];
            } else {
                $destination = trim($destination);
            }

            // if the destination is an empty string the destination file will have the same
            // name as the source file, with the extension changed, and it will be stored in the same directory
            if (0 == strlen($destination)) {
                $directory = $sourceDirectory;
                $filename = rtrim($sourceFilename, $this->_type) . $type;

                $this->_checkDirectory($directory);
                $this->_destination = $directory . $filename;

                return true;
            }

            // if the destination is a directory, the destination file will have the same
            // name as the source file, with the extension changed, and it will be stored in this directory
            if (is_dir($destination)) {
                $directory = $this->_prepareDirectory($destination);
                $filename = rtrim($sourceFilename, $this->_type) . $type;

                $this->_checkDirectory($directory);
                $this->_destination = $directory . $filename;

                return true;
            }

            // if the destination contains a filename then the conversion result will be stored under this name
            $filename = basename($destination);
            $extension = $this->_getFileExtension($filename);
            if (0 == strlen($extension)) {
                // no extension provided - it means that extracted filename is in fact a part
                // from the directories tree, which does not exist
                throw new Streamwide_Media_Exception('Provided destination directory does not exist.');
            } else {
                // check if the filename extension is the same as the file format to which we have to
                // do the conversion
                if ($extension != $type) {
                    throw new Streamwide_Media_Exception('Provided destination file extension is not compatible with the file format.');
                }

                $directory = dirname($destination);

                // check if only the destination filename was provided - the conversion result will be
                // stored inside the same directory as the source
                if ('.' == $directory) {
                    $directory = $sourceDirectory;

                    $this->_checkDirectory($directory);
                    $this->_destination = $directory . $filename;
                } else {
                    $directory = $this->_prepareDirectory($directory);
                    $this->_checkDirectory($directory);
                    $this->_destination = $destination;
                }
            }

            return true;
        }

        /**
         * Returns the destination where the file obtained after conversion will be stored
         *
         * @return string The converted file destination
         */
        public function getDestination()
        {
            return $this->_destination;
        }

        /**
         * Checks if provided directory exists and is writeable
         *
         * @param string $directoryPath directory path
         * @return boolean true in case of success
         * @throws Streamwide_Media_Exception
         */
        protected function _checkDirectory($directoryPath)
        {
            if (!is_dir($directoryPath) || !is_writeable($directoryPath)) {
                throw new Streamwide_Media_Exception('Provided directory does not exist or is not writeable: ' . $directoryPath);
            }

            return true;
        }

        /**
         * Checks if the provided file exists and is readable
         *
         * @param string $file file
         * @return boolean true in case of success
         * @throws Streamwide_Media_Exception
         */
        protected function _checkFile($file)
        {
            if (!file_exists($file) || !is_readable($file)) {
                throw new Streamwide_Media_Exception('Provided filename does not exist or is not readable.');
            }

            return true;
        }

        /**
         * Checks if the provided file type is between the supported types.
         *
         * @param string $type file type
         * @return boolean true in case of success or false otherwise
         */
        protected function _isSupportedType($type)
        {
            if (in_array($type, $this->_supportedTypes)) {
                return true;
            }

            return false;
        }

        /**
         * Checks if the destination file can be overwritten in case it exists
         *
         * @return boolean true in case of success
         * @throws Streamwide_Media_Exception
         */
        protected function _checkOverwriteState()
        {
            if (file_exists($this->_destination) && !$this->_options['overwriteDestination']) {
                throw new Streamwide_Media_Exception('The destination file already exists: '. $this->_destination);
            }

            return true;
        }

        /**
         * Changes the default options when new ones are provided
         *
         * @param array $options An associative array containing the options and their new values.
         * @return boolean true
         */
        public function setOptions($options)
        {
            if (isset($options['tmpDirectory']) && $this->_checkDirectory($options['tmpDirectory'])) {
                $this->_options['tmpDirectory'] = $options['tmpDirectory'];
            }

            if (isset($options['defaultDestination']) && $this->_checkDirectory($options['defaultDestination'])) {
                $this->_options['defaultDestination'] = $options['defaultDestination'];
            }

            if (isset($options['overwriteDestination']) && is_bool($options['overwriteDestination'])) {
                $this->_options['overwriteDestination'] = $options['overwriteDestination'];
            }

            if (isset($options['ffmpegPath']) && $this->_checkDirectory($options['ffmpegPath'])) {
                $this->_options['ffmpegPath'] = $options['ffmpegPath'];
            }

            if (isset($options['soxPath']) && $this->_checkDirectory($options['soxPath'])) {
                $this->_options['soxPath'] = $options['soxPath'];
            }

            return true;
        }

        /**
         * Returns the length of a media file
         *
         * @param string $file The media file whose length we want to determine
         * @return float The file length in secconds
         */
        public function getFileLength($file = null)
        {
            if (is_null($file)) {
                $file = $this->_source;
                $type = $this->_type;
            } else {
                $type = $this->_detectFileType($file);
            }

            switch ($type) {
                case 'al':
                    // Use sox for determining al file lenth
                    $command = $this->_getSoxPath() . 'sox ' . $file . ' -n stat 2>&1 | grep Length | cut -d : -f 2 | cut -f 1';
                    $length = (float) $this->_execute($command);
                    break;

                case 'wav':
                case 'wma':
                case 'mp3':
                case '3gp':
                    $command = $this->_getFfmpegPath() . 'ffmpeg -i ' . $file . ' 2>&1 | grep Duration | cut -d , -f 1 | cut -d " " -f 4';
                    $durationCounter = $this->_execute($command);
                    $durationCounter = trim($durationCounter);
                    $durationCounterParts = explode(':', $durationCounter);
                    $length = 60 * 60 * (int)$durationCounterParts[0] + 60 * (int)$durationCounterParts[1] + (float)$durationCounterParts[2];
                    break;

                default :
                    // do nothing
                    break;
            }

            return sprintf('%.2f', $length);
        }

        /**
         * Tries to detect the type of the file.
         *
         * @param string $file file path
         * @return string Detected file type in case of success
         * @throws Streamwide_Media_Exception
         */
        protected function _detectFileType($file)
        {
            $type = $this->_getFileExtension($file);



            return $type;
        }

        /**
         * Extracts a file extension.
         *
         * @param string $file file path
         * @return string file extension
         */
        protected function _getFileExtension($file)
        {
            // check if the file has an extension
            if (false === strpos($file, '.')) {
                $extension = '';
            } else {
                preg_match('/\w+$/', $file, $matches);
                $extension = strtolower($matches[0]);
            }

            return $extension;
        }

        /**
         * Executes the conversion command
         *
         * @param string $command The command which will be executed
         * @return boolean true in case of success, false otherwise.
         */
        protected function _executeConversion($command)
        {
            $this->_execute($command);

            if (!file_exists($this->_destination) || filesize($this->_destination) == 0) {
                return false;
            }

            return true;
        }

        /**
         * Checks if ffmpeg is installed
         *
         * @return string The path where the ffmpeg is installed
         * @throws Streamwide_Media_Exception
         */
        protected function _getFfmpegPath()
        {
            $ffmpegPath = $this->_prepareDirectory($this->_options['ffmpegPath']);
            if (!file_exists($ffmpegPath . 'ffmpeg')) {
                throw new Streamwide_Media_Exception('FFmpeg is not installed or the path to it is not correctly set.');
            }

            return $ffmpegPath;
        }

        /**
         * Checks if sox and soxmix are installed
         *
         * @return string The path where the sox and soxmix are installed
         * @throws Streamwide_Media_Exception
         * @todo Should check also if required version of sox is installed.
         */
        protected function _getSoxPath()
        {
            $soxPath = $this->_prepareDirectory($this->_options['soxPath']);
            if (!file_exists($soxPath . 'sox')) {
                throw new Streamwide_Media_Exception('SoX is not installed or the path to it is not correctly set.');
            }

            return $soxPath;
        }

        /**
         * Ensures that a directory is ended with a directory separator.
         *
         * @param string $directory A directory path
         * @return string $preparedDirectory The directory path ended with the directory separator
         */
        private function _prepareDirectory($directory)
        {
            return rtrim($directory, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
        }

        /**
         * Generates an unique filename having the provided extension
         *
         * @param string $extension The extension of the new file
         * @return string $fileName The generated file name
         */
        protected function _generateTmpFileName($extension)
        {
            $fileName = $this->_prepareDirectory($this->_options['tmpDirectory']) . uniqid('TMP_') . '.' . $extension;

            return $fileName;
        }

        /**
         * Method used for executing a shell command.
         *
         * @param string $command The command which will be executed
         * @return mixed $result  The command output
         * @todo should log this
         */
        protected function _execute($command)
        {
            Streamwide_System_Command_Runner::runCommand($command, null, $result, $stdout);

            return $stdout;
        }
}

/* EOF */