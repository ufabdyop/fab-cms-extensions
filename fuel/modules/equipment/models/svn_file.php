<?php
class svn_file extends CI_Model {

	var $repo; //URI of svn repo
	var $tmpconfigdir; //the local directory to use for authentication
	var $tmpconfigdir_anonymous; //the local directory to use for authentication
	var $tmpstoragedir; //the local directory to use for checkout
	var $tmpstoragedir_anonymous; //the local directory to use for checkout as anonymous
	var $username; //the local directory to use for checkout
	var $password; //the local directory to use for checkout
	var $executable = 'svn'; //the svn command

	/**
	 * Connects to repo
	 * params: 
	 * $repo_url: The url of the repo to connect
	 * $tmpstoragedir: local directory for temporary repo file storage
	 * $tmpconfigdir: local directory for temporary repo configuration
	 * $user: username for connecting to repo
	 * $pass: password for connecting to repo
	 * returns: 
	 * True on success, false on failure
	 * 
	 **/
	public function connect($repo_url, $tmpconfigdir, $user, $pass, $tmpstoragedir, $tmpstorage_anonymous = null, $tmpconfigdir_anonymous = null) {
		$this->repo = $repo_url;
		$this->tmpconfigdir = $tmpconfigdir;
		$this->tmpstoragedir = $tmpstoragedir;
		$this->tmpstoragedir_anonymous = $tmpstorage_anonymous;
		if ($tmpstorage_anonymous == null) {
			$this->tmpstoragedir_anonymous = $tmpstoragedir;
		}
		$this->tmpconfigdir_anonymous = $tmpconfigdir_anonymous;
		if ($tmpconfigdir_anonymous == null) {
			$this->tmpconfigdir_anonymous = $tmpconfigdir;
		}
		if (file_exists($tmpstoragedir)) {
			//`rm -r $tmpstoragedir/*`;
		}
		$this->username = $user;
		$this->password = $pass;
		try {
			$this->get_files();
		} catch (Exception $e) {
			return false;
		}
		return true;
	}

	/**
	 * Builds an svn client command to be run on the command line
	 **/
	private function get_command($command, $path = '/', $extra_arguments = '' ) {
		$repo_url_string  = "'$this->repo" . $path . "'";

		//don't use repo url in commits
		if (strpos($command, 'commit') === 0) {
			$repo_url_string = '';
		}
		if (strpos($command, 'update ') === 0) {
			$repo_url_string = '';
		}
		if (strpos($command, 'up ') === 0) {
			$repo_url_string = '';
		}

		$config_segment = ' --config-dir ' . $this->tmpconfigdir;

		$cmd = $this->executable . ' --non-interactive';
		if ($this->username && $this->password) {
			$cmd .= ' --username ' . "'$this->username' --password '$this->password' " ;
		} else {
			$config_segment = ' --config-dir ' . $this->tmpconfigdir_anonymous;
			//$config_segment = '';
		}

		$cmd .= " $config_segment $command $repo_url_string $extra_arguments 2>&1";
		return $cmd;
	}

	/*
	private function debug($output) {
		$fh = fopen( '/tmp/svncommands.txt', 'a' );
		fwrite( $fh, $output . "\n" );
		$stacktrace = debug_backtrace();
		foreach($stacktrace as $function) {
			fwrite($fh, 
					(isset($function['class'] ) ? $function['class'] : "" )
					. ' : ' . 
					(isset($function['function'] ) ? $function['function'] : "" )
					. ' : ' . 
					(isset($function['line'] ) ? $function['line'] : "" )
					. "\n");
			//fwrite($fh, print_r($function, true) . "\n");
		}
		//fwrite( $fh, print_r(debug_backtrace(), true) . "\n" );
		fclose($fh);
	}
	*/

	/**
	 * Executes an svn command, captures the stdout and exit code.  Throws an exception if 
	 * exit code is not 0
	 **/
	private function execute(&$cmd, &$output, &$exit_code) {
		//$this->debug( "Command: " .  print_r($cmd, true) . "\n" );
		exec($cmd, $output, $exit_code);
		if (is_array($output)) {
			$output = implode("\n", $output);
		}
		//$this->debug(  "Output: " .  print_r($output, true) . "\n" );

		if ($exit_code != 0 ) {
			throw new Exception("Command could not execute (return code $exit_code): " . $output);
		}
	}

	/**
	 * Returns an indexed array of files and directories.
	 **/
	public function get_directory_listing($path = '/') {
		$return_value = array('directories' => array(),
								'files' => array() );
		$cmd = $this->get_command('list --xml ', $path);
		$this->execute($cmd, $output, $exit_code);
		$listings = new SimpleXMLElement($output);

		foreach ($listings->list[0]->entry as $entry) {
			if ($entry['kind'] == 'file') {
				$return_value['files'][] = (string)$entry->name;
			} else if ($entry['kind'] == 'dir') {
				$return_value['directories'][] = (string)$entry->name;
			}
		} 
		return $return_value;
	}

	/**
	 * Returns true if the directory is empty
	 **/
	public function is_empty($path = '/')
	{
		$listing = $this->get_directory_listing($path);
		return (sizeof($listing['directories']) == 0) && (sizeof($listing['files']) == 0);
	} 

	/**
	 * Returns an array of directory names at $path
	 **/
	public function get_directories($path = '/')
	{
		$listing = $this->get_directory_listing($path);
		return $listing['directories'];
	} 

	/**
	 * Returns an array of file names at $path
	 **/
	public function get_files($path = '/')
	{
		$listing = $this->get_directory_listing($path);
		return $listing['files'];
	}

	/**
	 * Returns an array of file names at $path, this is done recursively 
	 **/
	public function get_files_recursively($path = '/')
	{
		$cmd = $this->get_command('list --depth infinity --verbose ', $path, " |  awk '{if ($3 ~ /[0-9]/) print $7}'" );
		//var_dump($cmd);
	}


	/**
	 * Adds a file to the repository (must not exist already)
	 * params: 
	 * $path: The path in the repo relative to the base. Includes file name
	 * $file: The local path to the file to add to the repo
	 * 
	 **/
	public function add_file($path, $file, $message = '') {
		if (file_exists($file) && is_file($file)) {
			if (!is_readable($file)) {
				throw new Exception("$file is not readable");
			}
			$command = $this->get_command("import '$file' -m '$message' ", $path );
			$this->execute($command, $output, $exit_code);
		} else {
			throw new Exception("Failed test: (file_exists($file) && is_file($file))") ;
		}
	}

	/**
	 * Adds a directory to the repository (must not exist already)
	 * params:
	 * $path:  The path in the repo relative to the base. All parent directories must exist already. 
	 **/
	public function add_directory($path, $message = '' ) {
		if (! file_exists($path)) {
			//make sure checked out repo is up to date
			exec("mkdir -p '$this->tmpstoragedir/$path'");
			$command = $this->get_command("import '$this->tmpstoragedir/$path' -m '$message' ", $path );
			$this->execute($command, $output, $exit_code);
		} else {
			throw new Exception("Failed test: (file_exists($path) )") ;
		}
	}
	
	/**
	 * Removes a directory from the repository 
	 * params:
	 * $path:  The path in the repo relative to the base.  Directory must be empty.
	 **/
	public function remove_directory($path ) {
	}

	/**
	 * Removes a file from the repository 
	 * params:
	 * $path:  The path in the repo relative to the base.  
	 **/
	public function delete_file($path , $msg = '') {
			$command = $this->get_command("delete -m '$msg' ", $path );
			$this->execute($command, $output, $exit_code);
	}

	/**
	 * Commits a file to the repository (must exist already)
	 * params: 
	 * $path: The path in the repo relative to the base. Includes file name
	 * $file: The local path to the file to add to the repo
	 * 
	 **/
	public function commit_file($path, $file, $msg = '') {
			$directory = pathinfo($path, PATHINFO_DIRNAME) ;

			//check out from svn
			$command = $this->get_command("co --depth=empty ", $directory, $this->tmpstoragedir . '/' . $directory );
			$this->execute($command, $output, $exit_code);

			//update file
			$command = $this->get_command("up '$this->tmpstoragedir/$path'", $path );
			$this->execute($command, $output, $exit_code);

			//copy file to local svn repo
			$command = "cp '$file' '$this->tmpstoragedir/$path'";
			$this->execute($command, $output, $exit_code);
			
			//commit file 
			$command = $this->get_command("commit '$this->tmpstoragedir/$path' -m '$msg'" );
			$this->execute($command, $output, $exit_code);
	}

	/**
	 * Returns true if the file exists in the repo, false otherwise
	 * params: 
	 * $path: The path in the repo relative to the base. Includes file name
	 * 
	 **/
	public function file_exists($path) {
		try {
			$this->get_directory_listing($path ) ;
			return true;
		} catch (Exception $e) {
			if (strpos($e->getMessage(), 'non-existent') === false) {
				throw $e;
			}
			return false;
		}
	}

	/**
	 * Returns local path to file, given the path relative to the base of the repo
	 * params: 
	 * $path: The path in the repo relative to the base. Includes file name
	 * 
	 **/
	public function get_file($path) {
			$directory = pathinfo($path, PATHINFO_DIRNAME) ;
			//$this->debug("Path: $path\n");

			$storagedir = $this->tmpstoragedir;
			//reconnect to svn
			if ($this->username) {
				$this->connect($this->repo, $this->tmpconfigdir, $this->username, $this->password, $this->tmpstoragedir);
			} else {
				$storagedir = $this->tmpstoragedir_anonymous;
			}

			//check out from svn
			$command = $this->get_command("co --depth=empty ", $directory, $storagedir . '/' . $directory );
			$this->execute($command, $output, $exit_code);

			//update file
			$command = $this->get_command("up '$storagedir/$path'", $path );
			$this->execute($command, $output, $exit_code);

			//return the path to the file
			return $storagedir . '/' . $path;
	}

	public function isDirEmpty($dir){
		     return (($files = @scandir($dir)) && count($files) <= 2);
	}
}
?>
