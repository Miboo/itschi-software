<?php
	/**
	*
	* @package com.Itschi.base.MySQL
	* @since 2007/05/25
	*
	*/

	namespace Itschi\lib;

	class mysql {
		var $debug = false;

		function mysql($host, $username, $pw, $database) {
	//		$this->debug = (isset($_GET['explain'])) ? true : false;

			$connect = @mysql_connect($host, $username, $pw) or die('Verbindung zur Datenbank fehlgeschlagen');
			@mysql_select_db($database, $connect) or die('Datenbank konnte nicht ausgew&auml;hlt werden');

			mysql_query("SET NAMES 'utf8'");
		}

		function error($sql)
		{
			exit('
				<title>SQL Error</title>
				<link rel="stylesheet" href="./styles/error.css" />
				<div id="fatalError">
					<div class="title"><h2>SQL-Error <span>(' . mysql_errno() . ')</span></h2></div>

					<div class="error MySQL">
						' . mysql_error() . '

						<div class="code"><code>' . htmlspecialchars($sql) . '</code></div>
					</div>
				</div>
			');
		}

		function query($sql) {
			if (($result = @mysql_query($sql)) === false)
			{
				$this->error($sql);
			}
	/*
			if ($this->debug)
			{
				$this->debug($sql);
			}
	*/
			$this->sql = $sql;

			return $result;
		}

		function unbuffered_query($sql) {
			if (($result = @mysql_query($sql)) === false) {
				$this->error($sql);
			}

			$this->sql = $sql;
			return true;
		}

		function debug($sql) {
			echo '<hr /><pre>' . preg_replace('/	/', '', trim($sql)) . '</pre>';

			$res = @mysql_query('EXPLAIN ' . $sql);
			while ($row = @mysql_fetch_assoc($res)) {
				foreach ($row as $k => $v) {
					echo strtoupper($k) . ': <span>' . $v . '</span> ';
				}

				echo '<br />';
			}

			$this->free_result($res);
		}

		function fetch_array($result) {
			return mysql_fetch_assoc($result);
		}

		function fetch_object($result) {
			return mysql_fetch_object($result);
		}

		function num_rows($result) {
			return mysql_num_rows($result);
		}

		function result($result, $int) {
			return mysql_result($result, $int);
		}

		function insert_id() {
			return mysql_insert_id();
		}

		function free_result($res) {
			@mysql_free_result($res);
		}

		function chars($var) {
			return mysql_real_escape_string($var);
		}

		function affected_rows() {
			return mysql_affected_rows();
		}
	}
?>