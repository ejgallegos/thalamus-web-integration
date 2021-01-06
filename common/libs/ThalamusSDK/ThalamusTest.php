<?php

namespace ThalamusSDK;

class ThalamusTest {
	
	const MIN_PHP_V = 530; //5.3.0
	
	const MIN_cURL_V = 7350; //7.35.0
	
	const MIN_LIBZ_V = 128; //1.2.8
	
	private $phpVersion = 'PHP 5.3+ is needed';
	
	private $phpPass = false;
	
	private $cURLVersion = 'cURL 7.35+ is recommended';
	
	private $curlPass = false;
	
	private $libzPass = false;
	
	private $isAlive;
	
	private $out_isalive;
	
	private $serviceCheck;
	
	private $out_service;
	
	/**
	 * 
	 */
	public static function run() {
		$test = new ThalamusTest();
		echo $test->generateHtml();
	}

	/**
	 * 
	 */
	public function __construct() {
		$this->PHPTest();
		$this->cURLTest();
		$this->isAliveTest();
		$this->serviceTest();
	}
	
	/**
	 * 
	 */
	public function PHPTest() {
		
		$version = (int) str_replace('.', "", phpversion());
		
		if ( $version >= self::MIN_PHP_V ) {
			$this->phpPass = true;
			$this->phpVersion = $version;
		}
		
	}

	/**
	 * 
	 */
	public function cURLTest() {
		
		if ( function_exists('curl_version') ) {
			$arr = curl_version();
			$this->cURLVersion = $arr['version'];
			$this->libzVersion = $arr['libz_version'];
			if ( ((int) str_replace('.', "", $this->cURLVersion))  >= self::MIN_cURL_V ) {
				$this->curlPass = true;
			} else {
				$this->cURLVersion = "current $this->cURLVersion, cURL 7.35+ is recommended";
			}
			if ( ((int) str_replace('.', "", $this->libzVersion))  >= self::MIN_LIBZ_V ) {
				$this->libzPass = true;
			} else {
				$this->libzVersion = 'libz 1.2.8+ is recommended';
			}
		}
		
	}

	/**
	 * 
	 */
	public function isAliveTest() {
		
		try {
			
			$start_time = microtime ( true );
			$this->isAlive = Thalamus::isAlive();
		
		} catch ( ThalamusSDKException $e ) {
			
			$this->isAlive = $e->getMessage();
			
		}
		
		$this->out_isalive = number_format ( microtime ( true ) - $start_time, 3 );

	}	
		
	/**
	 * 
	 */
	public function serviceTest() {
		
		$start_time = microtime ( true );
		
		try {
			
			$response = ThalamusRequest::get( '/referencedata/brands' )->execute();
			$this->serviceCheck = true;
			
		} catch ( ThalamusSDKException $e ) {

			$this->serviceCheck = $e->getMessage();
			
		}
		
		$this->out_service = number_format ( microtime ( true ) - $start_time, 3 );
		
	}
	
	/**
	 * 
	 * @return string
	 */
	public function generateHtml() {
		$html = '<html>
					<style>
						.green {
							color: green;
							font-weight: bold;
						}
						.red {
							color: red;
							font-weight: bold;
						}
					</style>
				
					<body>
						<p>SDK Version: <span class="green">' . Thalamus::VERSION_SDK . '</span></p>
						<p>Client: <span class="green">' . Thalamus::THALAMUS_CLIENT . '</span></p>
						<p>Environment: <span class="green">' . Thalamus::THALAMUS_ENVIRONMENT . '</span></p>
						<p>Touchpoint: <span class="green">' . Thalamus::THALAMUS_TOUCHPOINT . '</span></p>
						<p>Token: <span class="green">' . Thalamus::THALAMUS_TOKEN . '</span></p>
						<p>API Version: <span class="green">' . Thalamus::VERSION_API . '</span></p>
				
						<table border="1">
					
							<tr>
								<td>PHP Version:</td>
								<td>' . $this->phpVersion . '</td>';
								if ($this->phpPass) {
									$html.= '<td><span class="green">&#10004;</span></td>';
								} else {
									$html.= '<td><span class="red">&#10006;</span></td>';
								}	
		$html.=			   '</tr>
							
							<tr>	
								<td>cURL Version:</td>
								<td>' . $this->cURLVersion . '</td>';
								if ($this->curlPass) {
									$html.= '<td><span class="green">&#10004;</span></td>';
								} else {
									$html.= '<td><span class="red">&#10006;</span></td>';
								}
		
		$html.=			   '</tr>
						
							<tr>	
								<td>libz Version:</td>
								<td>' . $this->libzVersion . '</td>';
								if ($this->libzPass) {
									$html.= '<td><span class="green">&#10004;</span></td>';
								} else {
									$html.= '<td><span class="red">&#10006;</span></td>';
								}
		$html.=			   '</tr>
							
							<tr>
								<td>SERVER Status:</td>';
								if ($this->isAlive === true) {
									$html.= '<td>Ok (' . $this->out_isalive . 'ms)</td>';
									$html.= '<td><span class="green">&#10004;</span></td>';
								} else {
									$html.= '<td>' . $this->isAlive . '</td>';
									$html.= '<td><span class="red">&#10006;</span></td>';
								}			
		$html.=				'</tr>
					
							<tr>
								<td>API Response:</td>';
								if ($this->serviceCheck === true) {
									$html.= '<td>Ok (' . $this->out_service . 'ms)</td>';
									$html.= '<td><span class="green">&#10004;</span></td>';
								} else {
									$html.= '<td>' . $this->serviceCheck . '</td>';
									$html.= '<td><span class="red">&#10006;</span></td>';
								}
		$html.=			   '</tr>
				
						</table>
			
					</body>
				</html>';
		
		return $html;
		
	}
	
}