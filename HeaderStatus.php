<?php
namespace Coercive\Utility\HeaderStatus;

/**
 * HeaderStatus
 * PHP Version 	5
 *
 * @version		1
 * @package 	Coercive\Utility\HeaderStatus
 * @link		@link https://github.com/Coercive/HeaderStatus
 *
 * @author  	Anthony Moral <contact@coercive.fr>
 * @copyright   2016 - 2017 Anthony Moral
 * @license 	http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License
 */
class HeaderStatus {

	/** @var string Default SERVER_PROTOCOL */
	static private $_sDefaultServerProtocol = 'HTTP/1.0';

	/** @var int CODE */
	static private $_iCode = NULL;
	static private $_iDefaultCode = 200;

	/** @var array List of header status code */
	static private $_aStatusCodes = [
		100 => 'Continue',
		101 => 'Switching Protocols',
		102 => 'Processing',

		200 => 'OK',
		201 => 'Created',
		202 => 'Accepted',
		203 => 'Non-Authoritative Information',
		204 => 'No Content',
		205 => 'Reset Content',
		206 => 'Partial Content',
		207 => 'Multi-Status',
		208 => 'Already Reported',
		226 => 'IM Used',

		300 => 'Multiple Choices',
		301 => 'Moved Permanently',
		302 => 'Found',
		303 => 'See Other',
		304 => 'Not Modified',
		305 => 'Use Proxy',
		306 => 'Reserved',
		307 => 'Temporary Redirect',
		308 => 'Permanent Redirect',

		400 => 'Bad Request',
		401 => 'Unauthorized',
		402 => 'Payment Required',
		403 => 'Forbidden',
		404 => 'Not Found',
		405 => 'Method Not Allowed',
		406 => 'Not Acceptable',
		407 => 'Proxy Authentication Required',
		408 => 'Request Timeout',
		409 => 'Conflict',
		410 => 'Gone',
		411 => 'Length Required',
		412 => 'Precondition Failed',
		413 => 'Request Entity Too Large',
		414 => 'Request-URI Too Long',
		415 => 'Unsupported Media Type',
		416 => 'Requested Range Not Satisfiable',
		417 => 'Expectation Failed',
		418 => 'I\'m a teapot',
		422 => 'Unprocessable Entity',
		423 => 'Locked',
		424 => 'Failed Dependency',
		426 => 'Upgrade Required',
		428 => 'Precondition Required',
		429 => 'Too Many Requests',
		431 => 'Request Header Fields Too Large',

		500 => 'Internal Server Error',
		501 => 'Not Implemented',
		502 => 'Bad Gateway',
		503 => 'Service Unavailable',
		504 => 'Gateway Timeout',
		505 => 'HTTP Version Not Supported',
		506 => 'Variant Also Negotiates',
		507 => 'Insufficient Storage',
		508 => 'Loop Detected',
		509 => 'Bandwidth Limit Exceeded',
		510 => 'Not Extended',
		511 => 'Network Authentication Required'
	];

	/**
	 * Test Function Exist
	 *
	 * @param string $sName : Function name
	 * @return bool
	 */
	static private function _isFunctionExists($sName) {
		return function_exists($sName);
	}

	/**
	 * SEND HEADER STATUS
	 *
	 * @param int $iCode
	 * @param bool $bForcePolyfill
	 */
	static public function send($iCode = NULL, $bForcePolyfill = FALSE) {

		# SET
		self::$_iCode = $iCode ? $iCode : self::$_iDefaultCode;

		# ALIAS POLYFILL
		if(self::_isFunctionExists('http_response_code') && !$bForcePolyfill) {
			self::_http_response_code();
		}
		else {
			self::_polyfill();
		}

	}

	/**
	 * SERVER _ PROTOCOL
	 *
	 * @return mixed|string
	 */
	static private function _getServerProtocol() {
		$sInputServProt = filter_input(INPUT_SERVER, 'SERVER_PROTOCOL', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		return $sInputServProt ? self::$_sDefaultServerProtocol : $sInputServProt;
	}

	/**
	 * POLYFILL FOR http_response_code
	 *
	 * @return void
	 */
	static private function _polyfill() {
		if(!isset(self::$_aStatusCodes[self::$_iCode])) { return; }
		header(self::_getServerProtocol() . ' ' . self::$_iCode . ' ' . self::$_aStatusCodes[self::$_iCode], true, self::$_iCode);
	}

	/**
	 * DIRECT FUNCTION http_response_code
	 * PHP > 5.4 ONLY
	 */
	static private function _http_response_code() {
		http_response_code(self::$_iCode);
	}

}