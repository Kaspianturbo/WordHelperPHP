<?php
class Word {	
	/*
	ПРИМЕНЕНИЕ:
	$word=new Word();
	$word->generate($data);
	*/
	public function generate($data)
	{		
		//шлях до шаблону
    	$tmp_patch=realpath(__DIR__."/../templates/".$data['template']);
		
		//перевірка наявності шаблону
		if ($tmp_patch == false) 
		{
			echo "Шаблон договора не найден.";
			return false;
		}
		
		$this->document = $this->phpword->loadTemplate($tmp_patch);		
		
		$title = "Коммерческое предложение";
    	$subject = "Коммерческое предложение";
    	$description = "Коммерческое предложение";
		
		$this->properties = $this->phpword->getDocInfo();			
		$this->properties->setCreator($_SERVER['HTTP_HOST']); 
		$this->properties->setCompany($_SERVER['HTTP_HOST']);
		$this->properties->setTitle($this->rus2translit($title));
		$this->properties->setDescription($this->rus2translit($description));
		$this->properties->setLastModifiedBy($_SERVER['HTTP_HOST']);
		$this->properties->setCreated(time()); //time()
		$this->properties->setModified(time());
		$this->properties->setSubject($this->rus2translit($subject));
				
		//вираховуємо поля
		$data['created'] = date("d.m.Y");

		$data['id_document'] = uniqid();
		
		//заміна в відкритому шаблоні
		foreach($data as $field=>$value)  $this->document->setValue($field, $value);		

		 
		if (!empty($data['server'])) 
		{
			$temp_file="finish/".$data['name']."_".$data['id_document'].".docx";
			//збереження в папку на сервері 
      		$this->document->saveAs($temp_file); 
		} 
		else 
		{
			//збереження в тимчасову папку
      		$temp_file = tempnam(sys_get_temp_dir(), 'PHPWord'); 
			$this->document->saveAs($temp_file); 	  
			    
      		//заголовки для скачування
      		header ( "Expires: Mon, 1 Apr 1974 05:00:00 GMT" );
      		header ( "Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT" );
      		header ( "Cache-Control: no-cache, must-revalidate" );
      		header ( "Pragma: no-cache" );
      		header ( "Content-type: application/vnd.openxmlformats-officedocument.wordprocessingml.document" );
			header("Content-Disposition: attachment; filename=Document_".$data['id_document'].".docx");
			
			//скачати файл
			readfile($temp_file); 
			//видалити файл з сервера
      		unlink($temp_file);
		} 		
	}
	
	private function rus2translit($string)
	{ 
		//перевод русского текста в транслит
		$converter = array(
			'а' => 'a',   'б' => 'b',   'в' => 'v',
			'г' => 'g',   'д' => 'd',   'е' => 'e',
			'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
			'и' => 'i',   'й' => 'y',   'к' => 'k',
			'л' => 'l',   'м' => 'm',   'н' => 'n',
			'о' => 'o',   'п' => 'p',   'р' => 'r',
			'с' => 's',   'т' => 't',   'у' => 'u',
			'ф' => 'f',   'х' => 'h',   'ц' => 'c',
			'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
			'ь' => "'",  'ы' => 'y',   'ъ' => "'",
			'э' => 'e',   'ю' => 'yu',  'я' => 'ya',
			'і' => 'i',   'ї' => 'yi',  'ґ' => 'g',
			'є' => 'e',

			'А' => 'A',   'Б' => 'B',   'В' => 'V',
			'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
			'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
			'И' => 'I',   'Й' => 'Y',   'К' => 'K',
			'Л' => 'L',   'М' => 'M',   'Н' => 'N',
			'О' => 'O',   'П' => 'P',   'Р' => 'R',
			'С' => 'S',   'Т' => 'T',   'У' => 'U',
			'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
			'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
			'Ь' => "'",  'Ы' => 'Y',   'Ъ' => "'",
			'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
			'І' => 'i',   'Ї' => 'Yi',  'Ґ' => 'G',
			'Є' => 'E',   ' ' => '_'
		);
		return strtr($string, $converter);
	}

	public function readAllPatterns($template)
	{
		$vars = null;
		$io = \PhpOffice\PhpWord\IOFactory::load(realpath(__DIR__."/../templates/".$template));
		$sections = $io->getSections();
		foreach ($sections as $key => $value) {
			$sectionElement = $value->getElements();	
			$text = '';
			foreach ($sectionElement as $elementKey => $elementValue) {
				if ($elementValue instanceof \PhpOffice\PhpWord\Element\TextRun) {
					$secondSectionElement = $elementValue->getElements();
					
					foreach ($secondSectionElement as $secondSectionElementKey => $secondSectionElementValue) {
						if ($secondSectionElementValue instanceof \PhpOffice\PhpWord\Element\Text) {
							$text = $text.$secondSectionElementValue->getText();
							
						}
					}
					
				}
			}
			$pattern_var = '/\${([a-zA-Z0-9]+)}/';
			$vars = array();
			preg_match_all($pattern_var, $text, $vars);
		}
		return $vars;
	}
	
	public function __construct() {			
		//подключаем PHPWord для работы с вордовскими файлами
		require_once (realpath(__DIR__."/phpword/Autoloader.php"));
		require_once (realpath(__DIR__."/phpword/Autoloader.php"));
		\PhpOffice\PhpWord\Autoloader::register();
		$this->phpword = new  \PhpOffice\PhpWord\PhpWord();
	}
}//class