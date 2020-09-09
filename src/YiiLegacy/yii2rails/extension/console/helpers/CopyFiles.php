<?php

namespace yii2rails\extension\console\helpers;

use yii2rails\extension\console\helpers\input\Question;
use yii2rails\extension\yii\helpers\FileHelper;

class CopyFiles {
	
	public $dirAccess = 0777;
	public $skipFiles = [];
	public $isCopyAll = false;
	public $ignoreNames = [
		'.',
		'..',
	];
	
	public function copyAllFiles($pathFrom, $pathTo = '')
	{
		$files = $this->getFileList(FileHelper::rootPath() . "/$pathFrom");
		$files = $this->filterSkipFiles($files);
		foreach ($files as $file) {
			$source = trim("$pathFrom/$file", '/');
			$to = trim("$pathTo/$file", '/');
			if (!$this->copyFile($source, $to)) {
				break;
			}
		}
	}
	
	public function getFileList($root, $basePath = '')
	{
		$files = [];
		$root = FileHelper::normalizePath($root);
		if(!is_dir($root)) {
			return [];
		}
		$handle = opendir($root);
		if(empty($handle)) {
			return [];
		}
		while (($path = readdir($handle)) !== false) {
			if (in_array($path, $this->ignoreNames)) {
				continue;
			}
			$fullPath = "$root/$path";
			$relativePath = $basePath === '' ? $path : "$basePath/$path";
			if (is_dir($fullPath)) {
				$files = array_merge($files, $this->getFileList($fullPath, $relativePath));
			} else {
				$files[] = $relativePath;
			}
		}
		closedir($handle);
		$files = FileHelper::normalizePathList($files);
		return $files;
	}

	private function filterSkipFiles($files)
	{
		if (!empty($this->skipFiles)) {
			$files = array_diff($files, $this->skipFiles);
		}
		return $files;
	}
	
	private function copyFile($source, $target)
	{
		$source = FileHelper::normalizePath($source);
		$target = FileHelper::normalizePath($target);
		$sourceFile = FileHelper::rootPath() . DIRECTORY_SEPARATOR . $source;
		$targetFile = FileHelper::rootPath() . DIRECTORY_SEPARATOR . $target;
		
		if (!is_file($sourceFile)) {
			Output::line("     skip $target ($source not exist)");
			return true;
		}
		if (is_file($targetFile)) {
			if (FileHelper::isEqualContent($sourceFile, $targetFile)) {
				Output::line("unchanged $target");
				return true;
			}
			if($this->runOverwriteDialog($target)) {
				return true;
			}
			FileHelper::copy($sourceFile, $targetFile, $this->dirAccess);
			return true;
		}
		Output::line("generate $target");
		FileHelper::copy($sourceFile, $targetFile, $this->dirAccess);
		return true;
	}

	private function runOverwriteDialog($target) {
		Output::line("exist $target");
		if ($this->isOverwrite()) {
			Output::line("overwrite $target");
		} else {
			Output::line("skip $target");
			return true;
		}
		return false;
	}

	private function isOverwrite() {
		if($this->isCopyAll) {
			return true;
		}
		$answer = ArgHelper::one('overwrite');
		if(empty($answer)) {
			$answer = Question::display('    ...overwrite?', [
				'y' => 'Yes',
				'n' => 'No',
				'a' => 'All',
				'q' => 'Quit',
			], 'n');
		}
		if($answer == 'q') {
			Output::quit();
		} elseif($answer == 'a') {
			$this->isCopyAll = true;
		}
		return $answer != 'n';
	}
	
}
