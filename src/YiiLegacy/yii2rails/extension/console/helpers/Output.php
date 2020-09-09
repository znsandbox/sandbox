<?php

namespace yii2rails\extension\console\helpers;

use yii\helpers\Console;
use yii2rails\extension\common\helpers\StringHelper;
use yii2rails\extension\yii\helpers\ArrayHelper;

class Output {
	
	const LINE_LEN = 78;
	
	static function render($text) {
		Console::clearScreen();
		echo $text;
	}
	
	static function generateMatrix($matrixResult, $replace = []) {
		$lineArr = [];
		foreach($matrixResult as $row => $cols) {
			$line = [];
			foreach($cols as $col) {
				$value = ArrayHelper::getValue($replace, $col, $col);
				$line[] = Output::wrap(SPC . SPC, $value);
			}
			$lineArr[] = $line;
		}
		$text = Output::generateArray($lineArr);
		return $text;
	}
	
	static function generateArray($rows, $args = []) {
		$line = '';
		foreach($rows as $cols) {
			$rowStr = '';
			foreach($cols as $col) {
				$rowStr .= $col;
			}
			$line .= $rowStr . PHP_EOL;
		}
		$text = Output::wrap($line, $args);
		return $text;
	}
	
	static function generateLoading($text) {
		//$line = '[' . str_repeat('=', ($k) * $count) . str_repeat(' ', ($count - 1 - $k) * $count) . ']';
	}
	
	static function getDots($text, $reservedLength, $char = DOT) {
		$packageNameLen = strlen($text);
		$dots = str_repeat($char, $reservedLength - $packageNameLen);
		return $dots;
	}
	
	static function autoWrap($text, $maxLineLength = self::LINE_LEN) {
		$words = StringHelper::textToArray($text);
		$line = [];
		foreach($words as $word) {
			$lineStr = trim(implode(SPC, $line));
			$lenWithNewWord = strlen($lineStr) + strlen(SPC) + strlen($word);
			if($lenWithNewWord > $maxLineLength) {
				$a[] = $lineStr;
				$line = [];
			}
			$line[] = $word;
		}
		if(!empty($line)) {
			$a[] = implode(SPC, $line);
		}
		self::line(implode(PHP_EOL, $a));
	}
	
	static function quit() {
		self::pipe('Quit');
		exit;
	}
	
	static function wrap($text, $args = []) {
		if(empty($args) || ! param('test.console.is_enable_args', true)) {
			return $text;
		}
		$args = ArrayHelper::toArray($args);
		$text = Console::ansiFormat($text, $args);
		return $text;
	}
	
	static function title($text) {
		Output::line();
		Output::line("  === $text ===");
	}
	
	static function line($data = '', $newLine = 'after', $args = null) {
		if($newLine == 'before' || $newLine == 'both') {
			echo PHP_EOL;
		}
		echo self::wrap($data, $args);
		if($newLine == 'after' || $newLine == 'both') {
			echo PHP_EOL;
		}
	}

	static function pipe($title = '', $charBorder = '-', $args = null) {
		$title = trim($title);
		$title = mb_substr($title, 0, 72);
		$titleLen = mb_strlen($title);
		if($titleLen > 0) {
			$lenForPipe = self::LINE_LEN - $titleLen - 2;
			$pipeLen = intval($lenForPipe / 2);
			$pipe = str_repeat($charBorder, $pipeLen) . ' ' . $title . ' ' . str_repeat($charBorder, $pipeLen);
			if(mb_strlen($pipe) < self::LINE_LEN) {
				$pipe .= $charBorder;
			}
		} else {
			$pipe = str_repeat($charBorder, self::LINE_LEN);
		}
		echo self::wrap($pipe, $args);
		echo PHP_EOL;
	}

	static function block($data, $title = '', $charBorder = '-', $charWrap = '') {
		$consoleLen = self::LINE_LEN - 2 - (mb_strlen($charWrap) * 2);
		$dataArr = str_split($data, $consoleLen);
		$tmp = '';
		foreach($dataArr as $str) {
			$tmp .= self::_item($str, $charWrap);
		}
		echo PHP_EOL;
		self::pipe($title, $charBorder);
		//echo PHP_EOL;
		echo $tmp;
		echo PHP_EOL;
		self::pipe('', $charBorder);
	}

	private static function list_item($data) {
		$data = trim($data);
		$data = mb_substr($data, 0, 72);
		echo ' * ' . $data . PHP_EOL;
	}

	private static function item($data) {
		$data = trim($data);
		$data = mb_substr($data, 0, 76);
		echo ' ' . $data . PHP_EOL;
	}

	static function items($data, $title = '', $charBorder = '-') {
		self::pipe($title, $charBorder);
		//echo PHP_EOL;
		if(!empty($data)) {
			foreach($data as $item) {
				self::list_item($item);
			}
		}
		self::pipe('', $charBorder);
	}

	static function arr($data, $title = '', $charBorder = '-') {
		self::pipe($title, $charBorder);
		//echo PHP_EOL;
		foreach($data as $key => $item) {
		    $item = is_scalar($item) ? $item : '{' . gettype($item) . '}';
			self::item($key . ': ' . $item);
		}
		self::pipe('', $charBorder);
	}

	private static function _item($str, $charWrap = '|') {
		$consoleLen = self::LINE_LEN - 2 - (mb_strlen($charWrap) * 2);
		$len = mb_strlen($str);
		$spacesLen = $consoleLen - $len;
		$spaces = '';
		if($spacesLen > 0) {
			$spaces = str_repeat(' ', abs($spacesLen));
		}
		return $charWrap . ' ' . $str . $spaces . ' ' . $charWrap;
	}

}
