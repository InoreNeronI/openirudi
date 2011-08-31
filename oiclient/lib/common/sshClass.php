<?

define ('PAQUETSIZE',8192);
class sshClass{

	private function connect($remoteFile){
		if($a=strpos($remoteFile,'@')!==false &&  $b=strpos($remoteFile,':',$a)!==false ){
			$a1=explode('@',$remoteFile);
			$user=explode(':',$a1[0]);
			$host=explode(':',$a1[1]);

			$conn = ssh2_connect($host[0], 22);
			if(!$conn){
				exceptionHandlerClass::saveError("error connecting to ".$host[0]);
			}
			if(!ssh2_auth_password($conn, $user[0], $user[1])){
				exceptionHandlerClass::saveError("error authenticating to ".$host[0]);

			}
			$sftp = ssh2_sftp($conn);

			return array('conn'=>$conn, 'sftp'=> $sftp, 'path' => 'ssh2.sftp://'.$sftp.$host[1],'remotePath'=>$host[1]);
		}
		return array('path' => $remoteFile);
	}

	static function listFiles($src){

		$result=array('files'=>array(),'dir'=>array());
		if(is_file($src['path'])){
			//exceptionHandlerClass::saveError(" '$srcFile' is not valid file");
			$result['files'][]=$src['path'];
			return $result;
		}
		if (is_dir($src['path']) && $gd = opendir($src['path'])) {

			if(isset($src['conn'])){
				$result['dir'][]=$src['remotePath'];
			}else{
				$result['dir'][]=$src['path'];
			}

			while (($archivo = readdir($gd)) !== false) {
				if(strpos($archivo,'.')===0)continue;
				if(is_dir($src['path'])){
					$src2=$src;
					$src2['path']=$src['path'].'/'. $archivo;
					if(isset($src['remotePath'])) $src2['remotePath']=$src['remotePath'].'/'. $archivo;
					$r=sshClass::listFiles($src2);
					$result['files']= array_merge($result['files'],$r['files']);
					$result['dir']= array_merge($result['dir'],$r['dir']);
				}else{
					if(isset($src['conn'])){
						$result['files'][]=$src['remotePath'].'/'. $archivo;
					}else{
						$result['files'][]=$src['path'].'/'. $archivo;
					}
				}
			}
			closedir($gd);
		}
		return $result;
	}
	
	function copyFile($src,$dst){
		
		//$sftpStream = @fopen('ssh2.sftp://'.$sftp.$dstFile, 'w');
		$sourceFile = fopen($src['path'],'r');
		$destFile = fopen($dst['path'],'w');
				
		$content = '';
		while (!feof($sourceFile)) {
			if( $content = fread($sourceFile, PAQUETSIZE) === false){
				echo "Could not read data from file: {$src['path']}.";
			}
			if (fwrite($destFile, $content) === false) {
				echo "Could not send data from file: {$dst['path']}.";
			}
		}
		fclose($sourceFile);
		fclose($destFile);
		
	}

	static function copy($srcFile, $dstFile){
		$src=sshClass::connect($srcFile);
		$dst=sshClass::connect($dstFile);

		$srcFiles=sshClass::listFiles($src);
		$dstFiles=sshClass::listFiles($dst);


		if(is_file($src['path']) ){
			//case1:org file dest dir
			if(is_dir($dst['path'])){
				//copyFile($src,$dst);
			//case2: org file dest file
			}elseif(is_file()){
				copyFile($src,$dst);
			}
		}elseif(is_dir($src['path']) && !is_file($dst['path'])){
			foreach($srcFiles['dir'] as $dir ){
				if(isset($dst['conn'])){
					echo "\nnew remote dir  {$dst['path']}/{$dir}";
				}else{
					echo "\nnew remote dir  {$dst['path']}/{$dir}";
				}
			}
		}else{
			echo "\n error ".print_r($src['path'],1);
		}

		return;
	}
	
}
?>