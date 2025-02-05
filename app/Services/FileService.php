<?php

namespace App\Services;

use Storage;

class FileService
{

	private $storage;

	public function __construct(Storage $storage)
	{
		$this->storage = $storage;
	}

	static public function base64Store(
								string $base64,
								string $disk,
								string $path,
								string $fileName)
	{
		$filePath = Storage::disk('upload')->makeDirectory($path);

		if ($filePath){
			$fileCont		= substr($base64,strpos($base64,",") + 1);
			$decodedData	= base64_decode($fileCont);

			Storage::disk($disk)->put($path.'/'.$fileName,$decodedData);
			// 设置目录权限
			$directory = Storage::disk($disk)->path($path);
			chmod($directory, 0755);

			return ['status' => '200'];
		}else{
			return ['status' => '400', 'message' => 'path does not exist'];
		}
	}//function base64Store


	public function delete(string $disk,
						   string $path,
						   string $fileName)
	{
		Storage::disk($disk)->delete($path.'/'.$fileName);
	}


	public function sha1TimeName($fileName){
		$ext = explode('.', $fileName);
		$ext = end($ext);

		$fileName = sha1(uniqid(time(), true)).'.'.$ext;

		return $fileName;
	}//public function sha1TimeName()


	/**
	 * example:
	 * Here you specify how many characters the returning string must have
	 * echo GeraHash(30);
	 */
	public function geraHash(int $qtd){

		//Under the string $Caracteres you write all the characters you want to be used to randomly generate the code.

		$Caracteres = 'ABCDEFGHIJKLMOPQRSTUVXWYZ0123456789';
		$QuantidadeCaracteres = strlen($Caracteres);
		$QuantidadeCaracteres--;

		$Hash=NULL;
		for($x=1;$x<=$qtd;$x++){
			$Posicao = rand(0,$QuantidadeCaracteres);
			$Hash .= substr($Caracteres,$Posicao,1);
		}

		return $Hash;
	}//function GeraHash()

}